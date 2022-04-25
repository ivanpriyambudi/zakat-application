<template>
  <AdminLayout
    :title="'Tipe Mustahik'"
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
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Tipe Mustahik',
          to: '#',
        },
      ],
      tableData: this.list.data,
    }
  },
  methods: {
    onDelete(id) {
      this.$confirm(
        'Anda akan menghapus Tipe Mustahik. Lanjutkan?',
        'Hapus Data',
        {
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/mustahik-type/${id}`, {
            method: 'delete',
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil menghapus Tipe Mustahik',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal menghapus Tipe Mustahik',
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
        `${window.baseUrl}/mustahik-type/${id}/edit`,
      )
    },
  },
}
</script>
