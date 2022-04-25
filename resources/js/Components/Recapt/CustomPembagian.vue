<template>
  <div id="custom-pembagian">
    <el-card
      shadow="never"
      class="tw-mb-10"
    >
      <template #header>
        <div class="card-header tw-flex tw-w-full tw-justify-between tw-items-center">
          <div>Data Penerima Tambahan</div>
          <div>
            <el-button @click="drawer = true">
              Tambah
            </el-button>
          </div>
        </div>
      </template>
      <el-empty
        v-if="!data.length"
        description="Belum ada penerima tambahan"
      />
      <el-table
        v-else
        :data="data"
        style="width: 100%"
        show-summary
      >
        <el-table-column
          label="Mustahik"
        >
          <template #default="scope">
            <div>{{ scope.row.name }}</div>
            <div>{{ scope.row.mustahik_type.name }} / {{ scope.row.mustahik_status.name }}</div>
          </template>
        </el-table-column>
        <el-table-column
          label="RT/RW"
          align="center"
        >
          <template #default="scope">
            {{ scope.row.rt.name }}/{{ scope.row.rw.name }}
          </template>
        </el-table-column>
        <el-table-column
          prop="distribution"
          sortable
          align="center"
        >
          <template #header>
            Jumlah
            <br>
            ({{ satuan.name }})
          </template>
        </el-table-column>
        <el-table-column align="right">
          <template #default="scope">
            <el-button
              size="mini"
              icon="el-icon-edit"
              round
              type="warning"
              plain
              @click="toEdit(scope.row)"
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
    </el-card>

    <el-drawer
      v-model="drawer"
      title="Tambah Penerima Tambahan"
      :with-header="true"
      size="40%"
    >
      <AddPenerimaTambahan
        :rw="rw"
        :mustahik-type="mustahikType"
        :mustahik-status="mustahikStatus"
      />
    </el-drawer>

    <el-dialog
      v-model="modalAddValue"
      title="Tambahan Zakat Mustahik"
      width="30%"
    >
      <el-descriptions
        v-if="dataToAddValue"
        direction="vertical"
        :column="2"
        border
      >
        <el-descriptions-item label="Nama">
          {{ dataToAddValue.name }}
        </el-descriptions-item>
        <el-descriptions-item label="RT/RW">
          {{ dataToAddValue.rt.name }}/{{ dataToAddValue.rw.name }}
        </el-descriptions-item>
        <el-descriptions-item label="Tipe">
          {{ dataToAddValue.mustahik_type.name }}
        </el-descriptions-item>
        <el-descriptions-item label="Status">
          {{ dataToAddValue.mustahik_status.name }}
        </el-descriptions-item>
        <el-descriptions-item label="Tambahan Zakat">
          <el-input-number
            v-model="dataToAddValue.distribution"
            :min="0"
          />
        </el-descriptions-item>
      </el-descriptions>

      <template #footer>
        <span class="dialog-footer">
          <el-button @click="modalAddValue = false">Batal</el-button>
          <el-button
            :loading="isLoadingEdit"
            type="primary"
            @click="onSubmit"
          >Simpan</el-button>
        </span>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import AddPenerimaTambahan from '../Drawer/AddPenerimaTambahan.vue'
import {Inertia} from '@inertiajs/inertia'

export default {
  components: {
    AddPenerimaTambahan,
  },
  props: {
    rw: {
      type: Array,
      default: () => ([]),
    },
    mustahikType: {
      type: Array,
      default: () => ([]),
    },
    mustahikStatus: {
      type: Array,
      default: () => ([]),
    },
    data: {
      type: Array,
      default: () => ([]),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      drawer: false,
      modalAddValue: false,
      dataToAddValue: '',
      isLoadingEdit: false,
    }
  },
  methods: {
    toEdit(data) {
      this.dataToAddValue = data
      this.modalAddValue = true
    },
    onSubmit() {
      this.isLoadingEdit = true
      Inertia.visit(`${window.baseUrl}/mustahik/update-tambahan/${this.dataToAddValue.id}`, {
        method: 'post',
        data: this.dataToAddValue,
        onSuccess: () => this.$notify({
          title: 'Sukses',
          message: 'Berhasil mengubah Tambahan Pembagian Zakat',
          type: 'success',
        }),
        onError: () => this.$notify.error({
          title: 'Gagal',
          message: 'Gagal mengubah Tambahan Pembagian Zakat',
          type: 'error',
        }),
      })
      this.this.isLoadingEdit = false
    },
    onDelete(data) {
      this.$confirm(
        'Anda akan menghapus Tambahan Pembagian Zakat. Lanjutkan?',
        'Hapus Data',
        {
          confirmButtonText: 'Hapus',
          cancelButtonText: 'Batal',
          type: 'warning',
        },
      )
        .then(() => {
          Inertia.visit(`${window.baseUrl}/mustahik/delete-tambahan/${data}`, {
            method: 'get',
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: 'Berhasil menghapus Tambahan Pembagian Zakat',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: 'Gagal menghapus Tambahan Pembagian Zakat',
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