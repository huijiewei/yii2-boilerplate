import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    show: false,
  },

  getters: {
    isShow: (state) => {
      return state.show
    },
  },
  mutations: {
    TOGGLE_SHOW: (state, show) => {
      state.show = show
    },
  },
  actions: {
    setShow({ commit }, show) {
      commit('TOGGLE_SHOW', show)
    },
  },
  modules: {},
})
