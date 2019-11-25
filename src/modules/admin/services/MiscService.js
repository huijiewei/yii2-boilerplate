import Vue from "vue";

const MiscService = {
  adminGroupAcl() {
    return Vue.http.get("misc/admin-group-acl");
  },

  adminGroupMap() {
    return Vue.http.get("misc/admin-group-map");
  }
};

export default MiscService;
