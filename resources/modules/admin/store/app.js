const accessTokenItemKey = 'bp-admin-access-token'
const clientIdItemKey = 'bp-admin-client-id'

const app = {
  strict: process.env.NODE_ENV !== 'production',
  state: {
    device: 'desktop',
    sidebar: {
      collapsed: false,
      hidden: false
    },
    auth: {
      clientId: '',
      loginModal: false,
      accessToken: window.localStorage.getItem(accessTokenItemKey)
    }
  },
  mutations: {
    INIT_CLIENT_ID: (state) => {
      let clientId = window.localStorage.getItem(clientIdItemKey)

      if (clientId == null) {
        clientId = Math.random().toString(36).substr(2)

        window.localStorage.setItem(clientIdItemKey, clientId)
      }

      state.auth.clientId = clientId
    },
    CLEAR_CLIENT_ID: (state) => {
      state.auth.clientId = ''
      window.localStorage.removeItem(clientIdItemKey)
    },
    TOGGLE_DEVICE: (state, device) => {
      state.device = device
    },
    TOGGLE_SIDEBAR: state => {
      state.sidebar.collapsed = !state.sidebar.collapsed
    },
    TOGGLE_LOGIN_MODAL: (state) => {
      state.auth.loginModal = !state.auth.loginModal
    },
    UPDATE_ACCESS_TOKEN: (state, accessToken) => {
      state.auth.accessToken = accessToken
      window.localStorage.setItem('bp-admin-access-token', accessToken)
    }
  },
  actions: {
    toggleSidebar({ commit }) {
      commit('TOGGLE_SIDEBAR')
    },
    toggleDevice({ commit }, device) {
      commit('TOGGLE_DEVICE', device)
    },
    toggleLoginModal({ commit }) {
      commit('TOGGLE_LOGIN_MODAL')
    },
    updateAccessToken({ commit }, accessToken) {
      commit('UPDATE_ACCESS_TOKEN', accessToken)
    }
  }
}

export default app
