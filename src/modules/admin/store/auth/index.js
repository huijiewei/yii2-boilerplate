import { deepSearch, formatUrl } from '@core/utils/util'
import AuthService from '@admin/services/AuthService'

const auth = {
  namespaced: true,
  state: {
    loginModal: false,
    accessToken: null,
    currentUser: null,
    groupAcl: [],
    groupMenus: [],
    groupMenusUrl: []
  },
  getters: {
    isLoginModalVisible: state => {
      return state.loginModal
    },
    getAccessToken: state => {
      let accessToken = state.accessToken

      if (!accessToken) {
        accessToken = window.localStorage.getItem('ag-admin-access-token')
      }

      return window.localStorage.getItem('ag-admin-client-id') + ' ' + accessToken
    },
    getCurrentUser: state => {
      return state.currentUser
    },
    getGroupMenus: state => {
      return state.groupMenus
    },
    isRouteInAcl: state => (route) => {
      return state.groupAcl.includes(route)
    },
    isRouteInMenus: state => (route) => {
      const path = route.startsWith('/') ? route.substr(1) : route

      return state.groupMenusUrl.map(menu => formatUrl(menu)).includes(path)
    }
  },
  mutations: {
    TOGGLE_LOGIN_MODAL: (state, visible) => {
      if (state.loginModal === visible) {
        return
      }

      state.loginModal = visible
    },
    UPDATE_ACCESS_TOKEN: (state, accessToken) => {
      state.accessToken = accessToken

      if (accessToken == null) {
        window.localStorage.removeItem('ag-admin-access-token')
      } else {
        window.localStorage.setItem('ag-admin-access-token', accessToken)
      }
    },
    UPDATE_CURRENT_USER: (state, user) => {
      state.currentUser = user
    },
    UPDATE_GROUP_ACL: (state, acl) => {
      state.groupAcl = acl
    },
    UPDATE_GROUP_MENUS: (state, menus) => {
      state.groupMenus = menus
      state.groupMenusUrl = deepSearch('url', menus)
    }
  },
  actions: {
    initClientId () {
      if (window.localStorage.getItem('ag-admin-client-id') == null) {
        window.localStorage.setItem('ag-admin-client-id', Math.random().toString(36).substr(2))
      }
    },
    showLoginModal ({ commit }) {
      commit('TOGGLE_LOGIN_MODAL', true)
    },
    hideLoginModal ({ commit }) {
      commit('TOGGLE_LOGIN_MODAL', false)
    },
    login ({ commit }, credentials) {
      return AuthService.login(credentials).then((data) => {
        commit('UPDATE_ACCESS_TOKEN', data.accessToken)
        commit('UPDATE_CURRENT_USER', data.currentUser)
        commit('UPDATE_GROUP_ACL', data.groupAcl)
        commit('UPDATE_GROUP_MENUS', data.groupMenus)

        return data
      })
    },
    logout ({ commit }) {
      return AuthService.logout().then((data) => {
        commit('UPDATE_ACCESS_TOKEN', null)
        commit('UPDATE_CURRENT_USER', null)
        commit('UPDATE_GROUP_ACL', [])
        commit('UPDATE_GROUP_MENUS', [])

        return data
      })
    },
    authentication ({ commit }) {
      return AuthService.authentication().then((data) => {
        commit('UPDATE_CURRENT_USER', data.currentUser)
        commit('UPDATE_GROUP_ACL', data.groupAcl)
        commit('UPDATE_GROUP_MENUS', data.groupMenus)

        return data
      })
    }
  }
}

export default auth
