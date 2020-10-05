import Vue from 'vue'

const DistrictService = {
  create(district) {
    return Vue.http.post('districts', district)
  },

  view(id) {
    return Vue.http.get('districts/' + id, { withParents: true })
  },

  edit(district) {
    return Vue.http.put('districts/' + district.id, district)
  },

  delete(id) {
    return Vue.http.delete('districts/' + id)
  },
}

export default DistrictService
