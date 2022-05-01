<template>
  <div id="doa-config">
    <el-card
      shadow="never"
      class="tw-mb-10"
    >
      <template #header>
        <div class="card-header">
          <span>Pengaturan Amil Do'a</span>
        </div>
      </template>
      <el-row
        class="tw-items-center"
        :gutter="20"
      >
        <el-col :span="12">
          Jumlah Amil Do'a
        </el-col>
        <el-col :span="12">
          <el-input-number
            v-model="amount"
            :min="0"
            size="small"
          />
        </el-col>
      </el-row>

      <el-divider />

      <el-row
        class="tw-items-center"
        :gutter="20"
      >
        <el-col :span="12">
          Pembagian
        </el-col>
        <el-col :span="12">
          <el-input-number
            v-model="distribution"
            :min="0"
            size="small"
          />
        </el-col>
      </el-row>

      <el-divider />

      <el-row
        class="tw-items-center"
        :gutter="20"
      >
        <el-col :span="12">
          Kebutuhan
        </el-col>
        <el-col :span="12">
          {{ distribution * amount }} {{ satuan.name }} ({{ satuan.kilo * distribution * amount }} Kg)
        </el-col>
      </el-row>

      <el-divider />

      <div class="tw-text-right">
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
import _ from 'lodash'

export default {
  props: {
    data: {
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
      amount: _.get(this.data, 'amount') ? this.data.amount : 0,
      distribution: _.get(this.data, 'distribution') ? this.data.distribution : 0,
      submitLoading: false,
    }
  },
  methods: {
    onSubmit() {
      Inertia.visit(`${window.baseUrl}/recapt/set-doa`, {
        method: 'POST',
        data: {
          amount: this.amount,
          distribution: this.distribution,
        },
        onStart: () => this.submitLoading = true,
        onFinish: () => this.submitLoading = false,
        onSuccess: () => this.$notify({
          title: 'Sukses',
          message: 'Berhasil mengubah Pengaturan Doa',
          type: 'success',
        }),
        onError: () => this.$notify.error({
          title: 'Gagal',
          message: 'Gagal mengubah Pengaturan Doa',
          type: 'error',
        }),
      })
    },
  },
}
</script>