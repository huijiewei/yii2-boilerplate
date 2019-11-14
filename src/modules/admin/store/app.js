import auth from './auth'

const app = {
  strict: process.env.NODE_ENV !== 'production',
  modules: {
    auth: auth
  },
  state: {
    error: {
      message: '',
      routeBack: false
    },
    sidebar: {
      collapsed: window.matchMedia('(max-width: 991px)'),
      hidden: false
    }
  },
  getters: {
    isSidebarCollapsed: state => {
      return state.sidebar.collapsed
    }
  },
  mutations: {
    TOGGLE_SIDEBAR: state => {
      state.sidebar.collapsed = !state.sidebar.collapsed
    },
    TOGGLE_ERROR: (state, error) => {
      state.error = error
    }
  },
  actions: {
    toggleSidebar ({ commit }) {
      commit('TOGGLE_SIDEBAR')
    },
    setError ({ commit }, error) {
      commit('TOGGLE_ERROR', error)
    },
    clearError ({ commit }) {
      commit('TOGGLE_ERROR', { message: '', routeBack: false })
    }
  }
}

export default app
