const delay = require("mocker-api/utils/delay");
const { authLogin, authLogout, authAccount } = require("./auth/index");
const {
  adminList,
  adminItem,
  adminEdit,
  adminCreate,
  adminDelete
} = require("./admin/index");
const {
  adminGroupList,
  adminGroupItem,
  adminGroupEdit,
  adminGroupCreate,
  adminGroupDelete,
  adminGroupOptions,
  adminGroupAcl
} = require("./admin-group/index");
const { userList, userItem, userCreate, userDelete } = require("./user/index");

const noProxy = process.env.NO_PROXY === "true";

const proxy = {
  _proxy: {
    changeHost: true
  },
  "POST /admin/api/auth/login": authLogin,
  "POST /admin/api/auth/logout": authLogout,
  "GET /admin/api/auth/account": authAccount,
  "GET /admin/api/admins": adminList,
  "POST /admin/api/admins": adminCreate,
  "GET /admin/api/admins/:id(\\d+)": adminItem,
  "PUT /admin/api/admins/:id(\\d+)": adminEdit,
  "DELETE /admin/api/admins/:id(\\d+)": adminDelete,
  "GET /admin/api/admin-groups": adminGroupList,
  "POST /admin/api/admin-groups": adminGroupCreate,
  "GET /admin/api/admin-groups/:id(\\d+)": adminGroupItem,
  "PUT /admin/api/admin-groups/:id(\\d+)": adminGroupEdit,
  "DELETE /admin/api/admin-groups/:id(\\d+)": adminGroupDelete,
  "GET /admin/api/open/admin-group-acl": adminGroupAcl,
  "GET /admin/api/open/admin-group-options": adminGroupOptions,
  "GET /admin/api/users": userList,
  "POST /admin/api/users": userCreate,
  "GET /admin/api/users/:id(\\d+)": userItem,
  "DELETE /admin/api/users/:id(\\d+)": userDelete
};

module.exports = noProxy ? {} : delay(proxy, 500);
