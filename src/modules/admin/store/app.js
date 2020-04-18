import auth from './auth'
import tabs from './tabs'

const app = {
  strict: process.env.NODE_ENV !== 'production',
  modules: {
    auth: auth,
    tabs: tabs,
  },
  state: {
    error: {
      message: '',
      historyBack: false,
    },
    sidebar: {
      collapsed: window.matchMedia('(max-width: 991px)').matches,
      hidden: false,
    },
  },
  getters: {
    isSidebarCollapsed: (state) => {
      return state.sidebar.collapsed
    },
  },
  mutations: {
    TOGGLE_SIDEBAR: (state) => {
      state.sidebar.collapsed = !state.sidebar.collapsed
    },
    TOGGLE_ERROR: (state, error) => {
      state.error = error
    },
  },
  actions: {
    toggleSidebar({ commit }) {
      commit('TOGGLE_SIDEBAR')
    },
    setError({ commit }, error) {
      commit('TOGGLE_ERROR', error)
    },
    clearError({ commit }) {
      commit('TOGGLE_ERROR', { message: '', routeBack: false })
    },
  },
}

export default app
