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
        label="Tipe Mustahik"
        prop="name"
      >
        <el-input v-model="ruleForm.name" />
      </el-form-item>
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
  },
  data() {
    return {
      submitLoading: false,
      rules: {
        name: [
          {
            required: true,
            message: 'Tipe Mustahik tidak boleh kosong',
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
