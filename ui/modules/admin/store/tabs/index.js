const viewedTabsKey = 'ag:admin-viewed-tabs'

const tabs = {
  namespaced: true,
  state: {
    viewed: [],
    cached: [],
    current: null,
  },
  getters: {
    getViewed: (state) => {
      return state.viewed
    },
    getCurrent: (state) => {
      return state.current
    },
    getNext: (state) => (tab) => {
      const matchIndex = state.viewed.findIndex(
        (view) => view.path === tab.path
      )

      let next = null

      if (matchIndex - 1 in state.viewed) {
        next = state.viewed[matchIndex - 1]
      } else if (matchIndex + 1 in state.viewed) {
        next = state.viewed[matchIndex + 1]
      } else {
        next = state.viewed.find((view) => view.affix)
      }

      return next
    },
  },
  mutations: {
    UPDATE_VIEWED: (state, tab) => {
      const matchIndex = state.viewed.findIndex(
        (view) => view.path === tab.path
      )

      if (matchIndex > -1) {
        state.viewed[matchIndex].query = tab.query
      } else {
        const currentIndex = state.viewed.findIndex(
          (view) => view.path === (state.current ? state.current.path : '')
        )

        state.viewed.splice(currentIndex + 1, 0, tab)
      }

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    DELETE_VIEWED: (state, tab) => {
      for (const [index, view] of state.viewed.entries()) {
        if (view.path === tab.path) {
          state.viewed.splice(index, 1)
          break
        }
      }

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    INIT_VIEWED: (state) => {
      const viewedTabs = window.localStorage.getItem(viewedTabsKey)

      if (viewedTabs && viewedTabs.length > 0) {
        state.viewed = JSON.parse(viewedTabs)
      }
    },
    UPDATE_CURRENT: (state, tab) => {
      state.current = tab
    },
    DELETE_OTHER_VIEWED: (state, tab) => {
      state.viewed = state.viewed.filter((view) => {
        return view.affix || view.path === tab.path
      })

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
    DELETE_ALL_VIEWED: (state) => {
      state.viewed = state.viewed.filter((view) => {
        return view.affix
      })

      window.localStorage.setItem(viewedTabsKey, JSON.stringify(state.viewed))
    },
  },
  actions: {
    init({ commit }) {
      commit('INIT_VIEWED')
    },
    current({ commit }, tab) {
      commit('UPDATE_CURRENT', tab)
    },
    open({ commit }, tab) {
      commit('UPDATE_VIEWED', tab)
      commit('UPDATE_CURRENT', tab)
    },
    closeOther({ commit }, tab) {
      commit('DELETE_OTHER_VIEWED', tab)
    },
    closeAll({ commit, state }) {
      commit('DELETE_ALL_VIEWED')

      const next = state.viewed.find((view) => view.affix)

      return new Promise((resolve) => {
        resolve(next)
      })
    },
    close({ commit, state, getters }, tab) {
      const next = getters.getNext(tab)

      commit('DELETE_VIEWED', tab)

      return new Promise((resolve) => {
        resolve(next)
      })
    },
  },
}

export default tabs
