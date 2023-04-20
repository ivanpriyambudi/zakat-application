<template>
  <AdminLayout
    :title="'Satuan Zakat'"
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
        property="kilo"
        label="Kilo"
      />
      <el-table-column
        label="Satuan Pembagian"
        width="150"
      >
        <template #default="scope">
          {{ scope.row.is_primary }}
          {{ scope.row.is_primary !== 0 ? 'Utama' : '-' }}
          <!-- <el-switch
            v-model="scope.row.is_primary"
            :active-value="1"
            :inactive-value="0"
            :disabled="scope.row.is_primary === 1"
            @change="() => onWillChangeStatus(scope)"
          /> -->
        </template>
      </el-table-column>
      <el-table-column
        width="500"
        align="right"
      >
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
          <el-button
            v-if="!scope.row.is_primary"
            size="mini"
            icon="el-icon-delete"
            round
            type="primary"
            plain
            @click="onWillChangeStatus(scope)"
          >
            Jadikan Utama
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
  props: {
    list: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Satuan Barang',
          to: '#',
        },
      ],
      tableData: this.list.data,
      willChangeData: '',
    }
  },
  methods: {
    onDelete(id) {
      this.$confirm(
        'Anda akan menghapus Satuan Zakat. Lanjutkan?',
        'Hapus Data',
        {
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/satuan-zakat/${id}`, {
            method: 'delete',
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil menghapus Satuan Zakat',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal menghapus Satuan Zakat',
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
        `${window.baseUrl}/satuan-zakat/${id}/edit`,
      )
    },
    onWillChangeStatus(data) {
      this.tableData[data.$index].is_primary = 0
      const datas = data.row

      this.$confirm(
        'Anda akan Mengubah Satuan Pembagian. Lanjutkan?',
        'Tetapkan Pembagian',
        {
          confirmButtonText: 'Simpan',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/satuan-zakat/change-primary/${datas.id}`, {
            method: 'PUT',
            onStart: () => this.submitLoading = true,
            onFinish: () => this.submitLoading = false,
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil Mengubah Satuan Pembagian',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal Mengubah Satuan Pembagian',
              type: 'error',
            }),
          })
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Batal Mengubah Satuan Pembagian',
          })
        })
    },
  },
}
</script>
