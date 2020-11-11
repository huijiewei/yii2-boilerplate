import Vue from 'vue'

const CmsCategoryService = {
  create(cmsCategory) {
    return Vue.http.post('cms-categories', cmsCategory)
  },

  view(id) {
    return Vue.http.get('cms-categories/' + id, { withParents: true })
  },

  edit(cmsCategory) {
    return Vue.http.put('cms-categories/' + cmsCategory.id, cmsCategory)
  },

  delete(id) {
    return Vue.http.delete('cms-categories/' + id)
  },
}

export default CmsCategoryService
