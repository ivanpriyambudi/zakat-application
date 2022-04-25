<template>
  <AdminLayout
    :title="'Status Mustahik'"
    :breadcumb="breadcumb"
  >
    <el-table
      ref="multipleTable"
      :data="tableData"
      style="width: 100%"
      @selection-change="handleSelectionChange"
    >
      <el-table-column
        property="name"
        label="Nama"
      />
      <el-table-column
        label="Jumlah Pembagian"
      >
        <template #default="scope">
          {{ scope.row.distribution }} <b>{{ satuan.name }}</b>
        </template>
      </el-table-column>
      <el-table-column align="right">
        <template #header />
        <template #default="scope">
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

export default {
  components: {AdminLayout, Pagination},
  props : {
    list: {
      type: Object,
      default: () => ({}),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Status Mustahik',
          to: '#',
        },
      ],
      tableData: this.list.data,
    }
  },
  methods: {
    onDelete(id) {
      this.$confirm(
        'Anda akan menghapus Status Mustahik. Lanjutkan?',
        'Hapus Data',
        {
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/mustahik-status/${id}`, {
            method: 'delete',
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil menghapus Status Mustahik',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal menghapus Status Mustahik',
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
        `${window.baseUrl}/mustahik-status/${id}/edit`,
      )
    },
  },
}
</script>
