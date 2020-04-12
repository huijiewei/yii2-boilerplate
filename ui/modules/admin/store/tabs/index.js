const viewedTabsKey = 'ag:admin-viewed-tabs'

const tabs = {
  namespaced: true,
  state: {
    viewed: [],
    cached: [],
  },
  getters: {},
  mutations: {
    ADD_VIEWED_TAB: (state, tab) => {
      const matchIndex = state.viewed.findIndex(
        (view) => view.path === tab.path
      )

      if (matchIndex > -1) {
        state.viewed[matchIndex].query = tab.query
      } else {
        state.viewed.push(tab)
      }

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    DEL_VIEWED_TAB: (state, tab) => {
      for (const [index, view] of state.viewed.entries()) {
        if (view.path === tab.path) {
          state.viewed.splice(index, 1)
          break
        }
      }

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    INIT_VIEWED_TABS: (state) => {
      const viewedTabs = window.localStorage.getItem(viewedTabsKey)

      if (viewedTabs && viewedTabs.length > 0) {
        state.viewed = JSON.parse(viewedTabs)
      }
    },
  },
  actions: {
    initViewedTabs({ commit }) {
      commit('INIT_VIEWED_TABS')
    },
    addViewedTab({ commit }, tab) {
      commit('ADD_VIEWED_TAB', tab)
    },
    delViewedTab({ commit, state }, tab) {
      const matchIndex = state.viewed.findIndex(
        (view) => view.path === tab.path
      )

      let next = null

      if (matchIndex + 1 in state.viewed) {
        next = state.viewed[matchIndex + 1]
      } else if (matchIndex - 1 in state.viewed) {
        next = state.viewed[matchIndex - 1]
      }

      return new Promise((resolve) => {
        commit('DEL_VIEWED_TAB', tab)

        resolve(next)
      })
    },
  },
}

export default tabs
