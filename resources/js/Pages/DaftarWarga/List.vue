<template>
  <AdminLayout
    :title="'Daftar Warga'"
    :breadcumb="breadcumb"
  >
    <div class="tw-flex tw-w-full tw-justify-between tw-mb-2">
      <div>
        <form @submit.prevent="onSearch">
          <el-input
            v-model="applyFilter.name"
            class="w-50 m-2"
            size="large"
            placeholder="Cari Nama Warga"
          >
            <template #prefix>
              <i class="tw-ml-1 el-icon-search" />
            </template>
          </el-input>
        </form>
      </div>
      <div class="tw-flex">
        <div class="tw-mr-4">
          <el-select
            v-model="rw_id"
            class="m-2"
            placeholder="Select RW"
            size="large"
          >
            <el-option
              v-for="(item, index) in rw.data"
              :key="`list-rw-${index}`"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
        </div>
        <div class="tw-mr-4">
          <el-select
            v-model="rt_id"
            class="m-2"
            placeholder="Select RT"
            size="large"
            :disabled="!rw_id"
          >
            <el-option
              v-for="(item, index) in rtList"
              :key="`list-rt-${index}`"
              :label="item.name"
              :value="item.id"
            />
          </el-select>
        </div>
      </div>
    </div>

    <el-divider class="tw-mb-0" />

    <el-table
      ref="multipleTable"
      :data="tableData"
      style="width: 100%"
      @selection-change="handleSelectionChange"
    >
      <el-table-column
        property="name"
        label="Nama Warga"
      />
      <el-table-column
        label="RT/RW"
      >
        <template #default="scope">
          {{ scope.row.rt.name }} / {{ scope.row.rw.name }}
        </template>
      </el-table-column>
      <el-table-column align="right">
        <template #header />
        <template #default="scope">
          <el-button
            size="mini"
            icon="el-icon-shopping-bag-2"
            round
            type="primary"
            plain
            @click="toZakat(scope.row)"
          >
            Lihat Zakat
          </el-button>
          <el-button
            size="mini"
            icon="el-icon-edit"
            round
            type="warning"
            plain
            @click="toEdit(scope.row.id)"
          >
            Edit
          </el-button>
          <el-button
            size="mini"
            icon="el-icon-delete"
            round
            type="danger"
            plain
            @click="onDelete(scope.row.id)"
          >
            Delete
          </el-button>
        </template>
      </el-table-column>
    </el-table>

    <Pagination :meta="list.meta" />
  </AdminLayout>
</template>

<script>
import Pagination from '../../Components/Commons/Pagination'
import AdminLayout from '../../Layouts/AdminLayout'
import {Inertia} from '@inertiajs/inertia'
import { getQueryParams, getFilter, toFilter } from '../../Components/Commons/utils'
import _ from 'lodash'

export default {
  components: {
    AdminLayout, 
    Pagination,
  },
  props : {
    list: {
      type: Object,
      default: () => ({}),
    },
    rw: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    const query = getQueryParams(window.location.search)
    return {
      breadcumb: [
        {
          title: 'Daftar Warga',
          to: '#',
        },
      ],
      currentQuery: query,
      tableData: this.list.data,
      applyFilter: {
        rw_id:  _.get(query, 'filter.rw_id'),
        rt_id: _.get(query, 'filter.rt_id'),
        name: _.get(query, 'filter.name'),
      },
    }
  },
  computed: {
    rtList() {
      if (this.applyFilter.rw_id) {
        const rw = this.rw.data.filter(el => el.id === parseInt(this.applyFilter.rw_id))
        return rw[0].rt
      }
      return []
    },
    rw_id: {
      get() {
        return getFilter(this.applyFilter, 'rw_id', true)
      },
      set(value) {
        return toFilter(this.currentQuery, value, 'rw_id', 'rt_id')
      },
    },
    rt_id: {
      get() {
        return getFilter(this.applyFilter, 'rt_id', true)
      },
      set(value) {
        return toFilter(this.currentQuery, value, 'rt_id')
      },
    },
  },
  methods: {
    onDelete(id) {
      this.$confirm(
        'Anda akan menghapus Data Warga. Lanjutkan?',
        'Hapus Data',
        {
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/people/${id}`, {
            method: 'delete',
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil menghapus Data Warga',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal menghapus Data Warga',
              type: 'error',
            }),
          })
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Batal menghapus data',
          })
        })
    },
    toEdit(id) {
      Inertia.visit(
        `${window.baseUrl}/people/${id}/edit`,
      )
    },
    toZakat(data) {
      const filter = {
        filter: {
          name: data.name,
          rw_id: data.rw_id,
          rt_id: data.rt_id,
        },
      }
      return Inertia.get('/backoffice/zakat', filter, { replace: true })
    },
    onSearch() {
      if (_.get(this.currentQuery, 'filter.name') !== undefined) {
        this.currentQuery.filter.name = this.applyFilter.name
        return Inertia.get('/backoffice/people', { ...this.currentQuery }, { replace: true })
      }
      return Inertia.get('/backoffice/people', { ...this.currentQuery, 'filter[name]': this.applyFilter.name }, { replace: true })
    },
  },
}
</script>
