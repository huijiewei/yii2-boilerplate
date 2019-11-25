import Vue from "vue";

const OpenService = {
  adminFaker(count) {
    return Vue.http.get("open/admin-faker", { count: count });
  }
};

export default OpenService;
