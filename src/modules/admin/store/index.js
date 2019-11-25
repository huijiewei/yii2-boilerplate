import Vue from 'vue'
import Vuex from 'vuex'
import app from './app'

Vue.use(Vuex)

const store = new Vuex.Store(app)

export default store
