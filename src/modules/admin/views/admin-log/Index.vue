<template>
  <div class="box">
    <div class="box-toolbar">
      <div class="box-toolbar-search">
        <search-form v-if="searchFields" :search-fields="searchFields" />
      </div>
      <div class="box-toolbar-button"></div>
    </div>
    <el-table v-loading="loading" :data="logs">
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
      <el-table-column prop="status.description" width="50" label="状态" />
      <el-table-column prop="type.description" width="90" label="类型" />
      <el-table-column prop="method" width="70" label="方法" />
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
        min-width="160"
      />
      <el-table-column width="135" label="操作" fixed="right" align="right">
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
    <div v-if="pages" class="bp-pages">
      <el-pagination
        :background="true"
        :current-page="pages.currentPage"
        :page-size="pages.perPage"
        layout="total, prev, pager, next, jumper"
        :total="pages.totalCount"
        @current-change="handleCurrentChange"
      />
    </div>
    <el-dialog
      title="日志详情"
      :visible.sync="dialogVisible"
      width="30%"
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
import { convertObject } from '@core/utils/util'

export default {
  components: { SearchForm },
  mixins: [SearchFormFieldsMixin],
  data() {
    return {
      loading: true,
      logs: [],
      pages: null,
      dialogVisible: false,
      viewAdminLog: []
    }
  },
  watch: {
    $route: 'getLogs'
  },
  created() {
    this.getLogs()
  },
  methods: {
    handleView(adminLog) {
      this.dialogVisible = true
      this.viewAdminLog = convertObject(adminLog, [
        {
          name: 'Id',
          property: 'id'
        },
        {
          name: '管理员',
          property: 'admin',
          callback: admin => {
            return admin.name || admin.phone
          }
        },
        {
          name: '状态',
          property: 'status',
          callback: status => {
            return status.description
          }
        },
        {
          name: '类型',
          property: 'type',
          callback: type => {
            return type.description
          }
        },
        {
          name: '方法',
          property: 'method'
        },
        {
          name: '操作',
          property: 'action'
        },
        {
          name: '参数',
          property: 'params'
        },
        {
          name: 'IP 地址',
          property: 'remoteAddr'
        },
        {
          name: '浏览器',
          property: 'userAgent'
        },
        {
          name: '创建时间',
          property: 'createdAt'
        }
      ])
    },
    handleClose() {
      this.dialogVisible = false
      this.viewAdminLog = []
    },
    handleCurrentChange(page) {
      this.$router.push({
        path: this.$route.fullPath,
        query: { page: page }
      })
    },
    async getLogs() {
      this.loading = true

      const { data } = await flatry(
        AdminService.log(this.buildRouteQuery(this.$route.query))
      )

      if (data) {
        this.logs = data.items
        this.pages = data.pages

        this.setSearchFields(data.searchFields)
      }

      this.loading = false
    }
  }
}
</script>
