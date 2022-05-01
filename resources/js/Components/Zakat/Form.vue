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
      <el-row :gutter="10">
        <el-col>
          <el-card
            shadow="never"
            class="tw-mb-10"
          >
            <template #header>
              <div class="card-header">
                <span>Data Muzzaki</span>
              </div>
            </template>
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
              <el-input
                v-model="ruleForm.name"
                v-loading="loadingRecomendation"
                @change="onSearchPeople"
              />
            </el-form-item>

            <el-row v-if="listRecomendation.length">
              <el-button
                v-for="(item, index) in listRecomendation"
                :key="`list-recomendation-${index}`"
                size="small"
                @click="initValueRecomendation(item)"
              >
                {{ item.name }} ({{ item.rw.name }} / {{ item.rt.name }})
              </el-button>
            </el-row>
          </el-card>
        </el-col>
      </el-row>

      <el-row :gutter="10">
        <el-col>
          <el-card
            shadow="never"
            class="tw-mb-10"
          >
            <template #header>
              <div class="card-header">
                <span>Data Zakat</span>
              </div>
            </template>
            <el-form-item
              label="Tipe Zakat"
              prop="type"
            >
              <el-radio-group v-model="ruleForm.type">
                <el-radio label="Donasi">
                  Donasi
                </el-radio>
                <el-radio label="Fitrah">
                  Zakat Fitrah
                </el-radio>
              </el-radio-group>
            </el-form-item>

            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item
                  label="Satuan Zakat"
                  prop="amount_type_id"
                >
                  <el-select
                    v-model="ruleForm.amount_type_id"
                    class="m-2"
                    placeholder="Pilih Satuan Zakat"
                    size="large"
                  >
                    <el-option
                      v-for="(item, index) in satuan"
                      :key="`list-satuan-${index}`"
                      :label="item.name"
                      :value="item.id"
                    />
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item
                  label="Jumlah"
                  prop="amount"
                >
                  <el-input-number
                    v-model="ruleForm.amount"
                    :min="0"
                    :disabled="!ruleForm.amount_type_id"
                  />
                </el-form-item>
              </el-col>
            </el-row>
          </el-card>
        </el-col>
      </el-row>

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
import axios from 'axios'

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
    satuan: {
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
      listRecomendation: [],
      loadingRecomendation: false,
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
            onSuccess: () => {
              this.$notify({
                title: 'Sukses',
                message: `Berhasil ${message} Satuan Barang`,
                type: 'success',
              })

              this.$nextTick(() => {
                // let data = []
                // if (process.browser && localStorage.getItem('recentZakat')) {
                //   data = JSON.parse(localStorage.getItem('recentZakat'))
                // }

                // if (process.browser) {
                //   localStorage.setItem('recentZakat', JSON.stringify({ ...this.selectedOngkir }))
                // }
              })
            },
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
    onGetLast() {
      
    },
    onChange() {
      this.rt = null
    },
    onSearchPeople() {
      this.listRecomendation = []
      this.loadingRecomendation = true

      const data = {
        keyword: this.ruleForm.name,
      }

      axios.post('/api/backoffice/people/search', data)
        .then(res => {
          this.listRecomendation = res.data
          this.loadingRecomendation = false
        })
    },
    initValueRecomendation(value) {
      // eslint-disable-next-line vue/no-mutating-props
      this.ruleForm.name = value.name
      // eslint-disable-next-line vue/no-mutating-props
      this.ruleForm.rw_id = value.rw_id
      // eslint-disable-next-line vue/no-mutating-props
      this.ruleForm.rt_id = value.rt_id
    },
  },
}
</script>

<style scoped>

</style>
