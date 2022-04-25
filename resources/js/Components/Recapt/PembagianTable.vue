<template>
  <div id="pembagian-table">
    <el-card
      shadow="never"
      class="tw-mb-10"
    >
      <template #header>
        <div class="card-header">
          <span>Pembagian</span>
        </div>
      </template>
      <el-table
        :data="tableDatas"
        style="width: 100%"
      >
        <el-table-column
          prop="name"
          label="Status"
        />
        <el-table-column>
          <template #header>
            Jumlah ({{ satuan.name }})
          </template>
          <template #default="scope">
            <el-input-number
              v-model="scope.row.distribution"
              :min="1"
              size="small"
            />
          </template>
        </el-table-column>
      </el-table>

      <div class="tw-text-right tw-mt-4">
        <el-button
          :loading="submitLoading"
          type="primary"
          @click="onSubmit"
        >
          Simpan
        </el-button>
      </div>
    </el-card>
  </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'

export default {
  props: {
    status: {
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
      tableDatas: this.status,
      submitLoading: false,
    }
  },
  methods: {
    onSubmit() {
      Inertia.visit(`${window.baseUrl}/recapt/update-value-distribution`, {
        method: 'PUT',
        data: {
          data: this.tableDatas,
        },
        onStart: () => this.submitLoading = true,
        onFinish: () => this.submitLoading = false,
        onSuccess: () => this.$notify({
          title: 'Sukses',
          message: 'Berhasil mengubah Jumlah',
          type: 'success',
        }),
        onError: () => this.$notify.error({
          title: 'Gagal',
          message: 'Gagal mengubah Jumlah',
          type: 'error',
        }),
      })
    },
  },
}
</script>