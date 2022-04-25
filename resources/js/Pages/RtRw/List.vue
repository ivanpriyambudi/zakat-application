<template>
  <AdminLayout
    :title="'RT/RW'"
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
        label="RT"
        align="left"
      >
        <template #default="scope">
          <el-tag
            v-for="(tag, index) in scope.row.rt"
            :key="`list-rt-${index}`"
            class="tw-mr-2"
            closable
            @close="onDeleteRt(tag.id)"
          >
            {{ tag.name }}
          </el-tag>
        </template>
      </el-table-column>
      <el-table-column align="right">
        <template #header />
        <template #default="scope">
          <el-button
            size="mini"
            icon="el-icon-add"
            round
            type="primary"
            plain
            @click="onOpenModalAddRt('POST', scope.row.id)"
          >
            Tambah RT
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

    <el-dialog
      v-model="openModalRt"
      title="Tambahkan RT (Rukun Tetangga)"
      width="30%"
      :before-close="handleClose"
      :footer="false"
    >
      <RtForm
        :rule-form="ruleForm"
        :method="rtMethod"
        :url="`/rw-rt/rt`"
        :loading="submitLoading"
      />
    </el-dialog>
  </AdminLayout>
</template>

<script>
import Pagination from '../../Components/Commons/Pagination'
import AdminLayout from '../../Layouts/AdminLayout'
import {Inertia} from '@inertiajs/inertia'
import RtForm from '../../Components/RtRw/FormRt'

export default {
  components: {AdminLayout, RtForm, Pagination},
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
      openModalRt: false,
      ruleForm: {
        name: '',
      },
      rtMethod: '',
      submitLoading: false,
    }
  },
  methods: {
    onDelete(id) {
      this.$confirm(
        'Anda akan menghapus RW (Rukun Warga). Lanjutkan?',
        'Hapus Data',
        {
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/rw-rt/${id}`, {
            method: 'delete',
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil menghapus RW (Rukun Warga)',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal menghapus RW (Rukun Warga)',
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
        `${window.baseUrl}/rw-rt/${id}/edit`,
      )
    },
    onOpenModalAddRt(method, id) {
      this.ruleForm.rw_id = id
      this.rtMethod = method
      this.$nextTick(() => {
        this.openModalRt = true
      })
    },
    onDeleteRt(id) {
      this.$confirm(
        'Anda akan menghapus RT (Rukun Tetangga). Lanjutkan?',
        'Hapus Data',
        {
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/rw-rt/rt/${id}`, {
            method: 'delete',
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil menghapus RT (Rukun Tetangga)',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal menghapus RT (Rukun Warga)',
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
  },
}
</script>
