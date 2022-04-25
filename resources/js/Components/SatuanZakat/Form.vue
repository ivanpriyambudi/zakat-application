<template>
  <!-- eslint-disable vue/no-mutating-props -->
  <div id="form_satuan_zakat">
    <el-form
      ref="ruleForm"
      :model="ruleForm"
      :rules="rules"
      :label-position="'top'"
      @submit.prevent="onSubmit('ruleForm')"
    >
      <el-form-item
        label="Satuan Zakat"
        prop="name"
      >
        <el-input v-model="ruleForm.name" />
      </el-form-item>
      <el-form-item
        label="Kilo"
        prop="kilo"
      >
        <el-input-number
          v-model="ruleForm.kilo"
          :precision="2"
          :step="0.1"
          :min="0"
        />
      </el-form-item>
      <div class="tw-mb-4">
        <el-card shadow="never"> 
          <el-row :gutter="20">
            <el-col :span="18">
              <p>Sebagai pembagian Zakat</p>
            </el-col>
            <el-col :span="6">
              <el-switch
                v-model="ruleForm.is_primary"
                :active-value="1"
                :inactive-value="0"
                :disabled="method === 'PUT' && status === 1"
              />
            </el-col>
          </el-row>
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
  },
  data() {
    return {
      submitLoading: false,
      rules: {
        name: [
          {
            required: true,
            message: 'Satuan Zakat tidak boleh kosong',
            trigger: 'blur',
          },
        ],
        kilo: [
          {
            required: true,
            message: 'Ukuran Kilo tidak boleh kosong',
            trigger: 'blur',
          },
        ],
      },
      status: this.ruleForm.is_primary,
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
              message: `Berhasil ${message} Satuan Barang`,
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: `Gagal ${message} Satuan Barang`,
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
