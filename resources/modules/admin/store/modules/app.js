const app = {
  state: {
    isMobile: false,
    isCollapsed: false
  },
  mutations: {
    TOGGLE_SIDER_MENU: state => {
      state.isCollapsed = !state.isCollapsed
    }
  },
  actions: {
    toggleSideMenu({ commit }) {
      commit('TOGGLE_SIDER_MENU')
    }
  }
}

export default app
