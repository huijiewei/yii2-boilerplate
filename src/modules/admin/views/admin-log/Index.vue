<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-search">
        <search-form v-if="searchFields" :search-fields="searchFields" />
      </div>
      <div class="box-toolbar-button"></div>
    </div>
    <el-table v-loading="loading" :data="adminLogs">
      <el-table-column
        fixed
        width="90"
        class-name="text-mono"
        prop="id"
        label="Id"
      />
      <el-table-column width="130" label="管理员">
        <template slot-scope="scope">
          <span>{{ scope.row.admin.name || scope.row.admin.phone }}</span>
        </template>
      </el-table-column>
      <el-table-column width="62" align="center" label="状态">
        <template slot-scope="scope">
          <el-tag
            size="small"
            :type="scope.row.status.value === 1 ? 'success' : 'danger'"
            >{{ scope.row.status.description }}</el-tag
          >
        </template>
      </el-table-column>
      <el-table-column
        prop="type.description"
        align="center"
        width="90"
        label="类型"
      />
      <el-table-column prop="method" width="79" align="center" label="方法" />
      <el-table-column prop="action" width="300" label="操作" />
      <el-table-column prop="params" label="参数" />
      <el-table-column
        width="150"
        class-name="text-mono"
        prop="remoteAddr"
        label="IP 地址"
      />
      <el-table-column
        class-name="text-mono"
        prop="createdAt"
        label="创建时间"
        width="160"
      />
      <el-table-column width="75" label="操作" fixed="right" align="right">
        <template slot-scope="scope">
          <el-button
            plain
            type="primary"
            size="mini"
            @click="handleView(scope.row)"
          >
            详情
          </el-button>
        </template>
      </el-table-column>
    </el-table>
    <pagination :pages="pages"></pagination>
    <el-dialog
      title="日志详情"
      :visible.sync="dialogVisible"
      :before-close="handleClose"
    >
      <el-table :data="viewAdminLog" :show-header="false">
        <el-table-column property="name" width="150" />
        <el-table-column property="value" />
      </el-table>
    </el-dialog>
  </div>
</template>

<script>
import flatry from '@core/utils/flatry'
import AdminService from '@admin/services/AdminService'
import SearchForm from '@admin/components/SearchForm'
import SearchFormFieldsMixin from '@admin/mixins/SearchFormFieldsMixin'
import { tabledObject } from '@core/utils/util'
import Pagination from '@admin/components/Pagination'

export default {
  name: 'AdminLog',
  components: { SearchForm, Pagination },
  mixins: [SearchFormFieldsMixin],
  data() {
    return {
      loading: true,
      adminLogs: [],
      pages: null,
      dialogVisible: false,
      viewAdminLog: [],
    }
  },
  beforeRouteUpdate(to, from, next) {
    this.getAdminLogs(to.query)
    next()
  },
  created() {
    this.getAdminLogs(this.$route.query)
  },
  methods: {
    handleView(adminLog) {
      this.dialogVisible = true
      this.viewAdminLog = tabledObject(adminLog, [
        {
          name: 'Id',
          property: 'id',
        },
        {
          name: '管理员',
          property: 'admin',
          callback: (admin) => {
            return admin.name || admin.phone
          },
        },
        {
          name: '状态',
          property: 'status',
          callback: (status) => {
            return status.description
          },
        },
        {
          name: '类型',
          property: 'type',
          callback: (type) => {
            return type.description
          },
        },
        {
          name: '方法',
          property: 'method',
        },
        {
          name: '操作',
          property: 'action',
        },
        {
          name: '参数',
          property: 'params',
        },
        {
          name: '异常信息',
          property: 'exception',
        },
        {
          name: 'IP 地址',
          property: 'remoteAddr',
        },
        {
          name: '浏览器',
          property: 'userAgent',
        },
        {
          name: '创建时间',
          property: 'createdAt',
        },
      ])
    },
    handleClose() {
      this.dialogVisible = false
      this.viewAdminLog = []
    },
    async getAdminLogs(query) {
      this.loading = true

      const { data } = await flatry(
        AdminService.log(this.buildRouteQuery(query))
      )

      if (data) {
        this.adminLogs = data.items
        this.pages = data.pages

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    },
  },
}
</script>
