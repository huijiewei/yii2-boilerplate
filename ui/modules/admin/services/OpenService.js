import Vue from 'vue'

const OpenService = {
  captcha() {
    return Vue.http.get('open/captcha', null, false, true)
  },
}

export default OpenService
