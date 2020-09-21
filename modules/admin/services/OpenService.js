import Vue from 'vue'

const OpenService = {
  adminFaker(count) {
    return Vue.http.get('open/admin-faker', { count: count })
  },
  captcha(uuid) {
    return Vue.http.get('open/captcha', { uuid: uuid }, false)
  },
}

export default OpenService
