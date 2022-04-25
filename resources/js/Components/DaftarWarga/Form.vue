<template>
  <!-- eslint-disable vue/no-mutating-props -->
  <div id="form_zakat">
    <el-form
      ref="ruleForm"
      :model="ruleForm"
      :rules="rules"
      :label-position="'top'"
      @submit.prevent="onSubmit('ruleForm')"
    >
      <el-row :gutter="20">
        <el-col :span="12">
          <el-form-item
            label="RW"
            prop="nama"
          >
            <el-select
              v-model="ruleForm.rw_id"
              class="m-2"
              placeholder="Pilih RW"
              size="large"
              @change="onChange"
            >
              <el-option
                v-for="(item, index) in rw"
                :key="`list-rw-${index}`"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item
            label="RT"
            prop="nama"
          >
            <el-select
              v-model="ruleForm.rt_id"
              :disabled="!ruleForm.rw_id"
              class="m-2"
              placeholder="Pilih RT"
              size="large"
            >
              <el-option
                v-for="(item, index) in rtList"
                :key="`list-rt-${index}`"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <el-form-item
        label="Nama"
        prop="nama"
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
    rw: {
      type: Array,
      default: () => ([]),
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
      form: {
        rt_id: '',
        rw_id: '',
        amount_type: '',
        type: '',
        amount_type_id: '',
        amount: '',
      },
    }
  },
  computed: {
    rtList() {
      if (this.ruleForm.rw_id) {
        const rw = this.rw.filter(el => el.id === this.ruleForm.rw_id)
        return rw[0].rt
      }
      return []
    },
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
              message: `Berhasil ${message} Daftar Warga`,
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Gagal',
              message: `Gagal ${message} Daftar Warga`,
              type: 'error',
            }),
          })
        } else {
          return false
        }
      })
    },
    onChange() {
      this.rt = null
    },
  },
}
</script>

<style scoped>

</style>
