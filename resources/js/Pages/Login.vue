<template>
  <LoginLayout :title="'Login'">
    <img
      src="/image/login.webp"
      width="250"
      class="tw-m-auto tw-mb-6"
    >
    <el-card shadow="never">
      <el-form
        ref="ruleForm"
        :model="ruleForm"
        :rules="rules"
        :label-position="'top'"
        label-width="100px"
        @submit.prevent="submitForm('ruleForm')"
      >
        <el-form-item
          prop="email"
          label="Email"
        >
          <el-input v-model="ruleForm.email" />
        </el-form-item>
        <el-form-item
          label="Password"
          prop="password"
        >
          <el-input
            v-model="ruleForm.password"
            type="password"
          />
        </el-form-item>
        <el-form-item class="tw-text-right">
          <el-button
            type="primary"
            :loading="submitLoading"
            native-type="submit"
          >
            Login
          </el-button>
        </el-form-item>
      </el-form>
    </el-card>
  </LoginLayout>
</template>

<script>
import {defineComponent} from 'vue'
import LoginLayout from '../Layouts/LoginLayout'
import { Inertia } from '@inertiajs/inertia'

export default defineComponent({
  title: 'Login',
  components: {
    LoginLayout,
  },
  data() {
    return {
      submitLoading: false,
      ruleForm: {
        email: '',
        password: '',
      },
      rules: {
        email: [
          {
            required: true,
            message: 'Email tidak boleh kosong',
            trigger: 'blur',
          },
        ],
        password: [
          {
            required: true,
            message: 'Password tidak boleh kosong',
            trigger: 'blur',
          },
        ],
      },
    }
  },
  methods: {
    submitForm(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          Inertia.post(`${window.baseUrl}/login`, {
            email: this.ruleForm.email,
            password: this.ruleForm.password,
            token: this.$page.props.csrf_token,
          },{
            onStart: () => this.submitLoading = true,
            onFinish: () => this.submitLoading = false,
            onSuccess: () => this.$notify({
              title: 'Login sukses',
              message: 'Selamat datang di Notalin',
              type: 'success',
            }),
            onError: () => this.$notify.error({
              title: 'Login gagal',
              message: 'Email atau Password tidak valid',
              type: 'error',
            }),
          })
        } else {
          this.submitLoading = false
          return false
        }
      })
    },
  },
})
</script>
