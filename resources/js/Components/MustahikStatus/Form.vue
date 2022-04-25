<template>
  <!-- eslint-disable vue/no-mutating-props -->
  <div id="form_mustahik_type">
    <el-form
      ref="ruleForm"
      :model="ruleForm"
      :rules="rules"
      :label-position="'top'"
      @submit.prevent="onSubmit('ruleForm')"
    >
      <el-form-item
        label="Status Mustahik"
        prop="name"
      >
        <el-input v-model="ruleForm.name" />
      </el-form-item>
      <el-form-item
        label="Jumlah Pembagian"
        prop="distribution"
      >
        <el-input-number
          v-model="ruleForm.distribution"
          :min="1"
        />
      </el-form-item>
      <div
        v-if="ruleForm.distribution"
        class="tw-mb-4"
      >
        <el-card shadow="never">
          Jumlah akan dikalkulasi menjadi {{ ruleForm.distribution }} <b>{{ satuan.name }}</b> ( {{ ruleForm.distribution * satuan.kilo }} Kg)
        </el-card>
      </div>
      <el-form-item class="tw-text-right">
        <el-button
          type="primary"
          native-type="submit"
          :loading="submitLoading"
        >
          Submit
        </el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'

export default {
  props: {
    method: {
      type: String,
      default: '',
    },
    ruleForm: {
      type: Object,
      default: () => ({}),
    },
    url: {
      type: String,
      default: '',
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      submitLoading: false,
      rules: {
        name: [
          {
            required: true,
            message: 'Status Mustahik tidak boleh kosong',
            trigger: 'blur',
          },
        ],
        distribution: [
          {
            required: true,
            message: 'Jumlah Pembagian tidak boleh kosong',
            trigger: 'blur',
          },
        ],
      },
    }
  },
  methods: {
    onSubmit(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          var message = 'mengubah'
          if (this.method === 'POST') {
            message = 'membuat'
          }
          Inertia.visit(`${window.baseUrl}${this.url}`, {
            method: this.method,
            data: this.ruleForm,
            onStart: () => this.submitLoading = true,
            onFinish: () => this.submitLoading = false,
            onSuccess: () => this.$notify({
              title: 'Sukses',
              message: `Berhasil ${message} Tipe Mustahik`,
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: `Gagal ${message} Tipe Mustahik`,
              type: 'error',
            }),
          })
        } else {
          return false
        }
      })
    },
  },
}
</script>

<style scoped>

</style>
