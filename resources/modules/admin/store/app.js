import auth from './auth'

const app = {
  strict: process.env.NODE_ENV !== 'production',
  modules: {
    auth: auth
  },
  state: {
    device: 'desktop',
    sidebar: {
      collapsed: false,
      hidden: false
    }
  },
  getters: {
    isSidebarCollapsed: state => {
      return state.sidebar.collapsed
    },
  },
  mutations: {
    TOGGLE_DEVICE: (state, device) => {
      state.device = device
    },
    TOGGLE_SIDEBAR: state => {
      state.sidebar.collapsed = !state.sidebar.collapsed
    }
  },
  actions: {
    toggleSidebar({ commit }) {
      commit('TOGGLE_SIDEBAR')
    },
    toggleDevice({ commit }, device) {
      commit('TOGGLE_DEVICE', device)
    }
  }
}

export default app
