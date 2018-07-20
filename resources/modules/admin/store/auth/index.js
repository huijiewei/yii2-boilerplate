import AuthService from '@admin/services/AuthService'
import Auth from '@admin/utils/auth'
import { deepSearch, formatUrl } from '@admin/utils/util'

const auth = {
  namespaced: true,
  state: {
    loginModal: false,
    currentUser: {
      displayName: '',
      displayIcon: ''
    },
    currentUserInit: false,
    currentUserAcl: [],
    currentUserMenus: [],
    flattenMenus: []
  },
  getters: {
    isCurrentUserInit: state => {
      return state.currentUserInit
    },
    isLoginModalVisible: state => {
      return state.loginModal
    },
    getCurrentUser: state => {
      return state.currentUser
    },
    getCurrentUserMenus: state => {
      return state.currentUserMenus
    },
    isRouteInAcl: state => (route) => {
      return state.currentUserAcl.includes(route)
    },
    isRouteInMenus: state => (route) => {
      const path = route.startsWith('/') ? route.substr(1) : route

      return state.flattenMenus.map(menu => formatUrl(menu)).includes(path)
    }
  },
  mutations: {
    TOGGLE_LOGIN_MODAL: (state, visible) => {
      if (state.loginModal === visible) {
        return
      }

      state.loginModal = visible
    },
    UPDATE_CURRENT_USER: (state, user) => {
      if (user == null) {
        state.currentUserInit = false
        state.currentUserAcl = []
        state.currentUserMenus = []
        state.flattenMenus = []

        state.currentUser.displayName = ''
        state.currentUser.displayIcon = ''
      } else {
        state.currentUser.displayName = user.displayName
        state.currentUser.displayIcon = user.displayIcon

        state.currentUserInit = true
        state.currentUserAcl = user.groupAcl
        state.currentUserMenus = user.groupMenus
        state.flattenMenus = deepSearch('url', user.groupMenus)
      }
    }
  },
  actions: {
    initClientId() {
      if (Auth.getClientId() == null) {
        Auth.setClientId(Math.random().toString(36).substr(2))
      }
    },
    showLoginModal({ commit }) {
      commit('TOGGLE_LOGIN_MODAL', true)
    },
    login({ commit }, loginForm) {
      return AuthService.login(loginForm).then(data => {
        commit('TOGGLE_LOGIN_MODAL', false)
        commit('UPDATE_CURRENT_USER', data.currentUser)

        Auth.setAccessToken(data.accessToken)

        return data
      })
    },
    logout({ commit }) {
      return AuthService.logout().then(data => {
        commit('UPDATE_CURRENT_USER', null)

        Auth.setAccessToken(null)

        return data
      })
    },
    updateCurrentUser({ commit }) {
      return AuthService.getCurrentUser().then(data => {
        commit('UPDATE_CURRENT_USER', data)

        return data
      })
    }
  }
}

export default auth
