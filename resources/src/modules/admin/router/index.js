import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const Foo = { template: '<div>foo</div>' }
const Bar = { template: '<div>bar</div>' }

const routes = [
  { path: '/foo', component: Foo },
  { path: '/bar', component: Bar }
]

const router = new Router({
  mode: 'history',
  routes
})

export { router }
