import Vue from 'vue'

const UserAddressService = {
  all(query) {
    return Vue.http.get('user-addresses', query)
  },

  delete(id) {
    return Vue.http.delete('user-addresses/' + id)
  },

  create(userAddress) {
    return Vue.http.post('user-addresses', userAddress)
  },

  view(id) {
    return Vue.http.get('user-addresses/' + id)
  },

  edit(userAddress) {
    return Vue.http.put('user-addresses/' + userAddress.id, userAddress)
  },
}

export default UserAddressService
