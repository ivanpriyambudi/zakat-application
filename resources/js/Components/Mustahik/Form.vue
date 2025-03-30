<template>
  <!-- eslint-disable vue/no-mutating-props -->
  <div id="form_mustahik">
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
                <span>Data Alamat</span>
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
                <span>Data Mustahik</span>
              </div>
            </template>
            <el-row :gutter="20">
              <el-col :span="12">
                <el-form-item
                  label="Tipe"
                  prop="nama"
                >
                  <el-select
                    v-model="ruleForm.mustahik_type_id"
                    class="m-2"
                    placeholder="Pilih Jenis Mustahik"
                    size="large"
                  >
                    <el-option
                      v-for="(item, index) in mustahikType"
                      :key="`list-rw-${index}`"
                      :label="item.name"
                      :value="item.id"
                    />
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="12">
                <el-form-item
                  label="Status"
                  prop="nama"
                >
                  <el-select
                    v-model="ruleForm.mustahik_status_id"
                    class="m-2"
                    placeholder="Pilih Status Mustahik"
                    size="large"
                  >
                    <el-option
                      v-for="(item, index) in mustahikStatus"
                      :key="`list-rw-${index}`"
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
                :disabled="method === 'POST' && Array.isArray(ruleForm.names) && ruleForm.names.length && ruleForm.names.length > 0"
              />
            </el-form-item>
            <el-form-item
              v-if="method === 'POST'"
              label="Nama Banyak"
              prop="names"
            >
              <el-select
                v-model="ruleForm.names"
                :disabled="ruleForm.name !== ''"
                multiple
                filterable
                allow-create
                default-first-option
                :reserve-keyword="false"
                placeholder="Input names"
                style="width: 100%"
                @change="(val) => $emit(`change:${'names'}`, val)"
              />
              <label>
                Gunakan "," jika ingin paste data secara banyak. Contoh: "Ivan, Mario, Handi"
              </label>
            </el-form-item>
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
    mustahikType: {
      type: Array,
      default: () => ([]),
    },
    mustahikStatus: {
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
        rw_id: '',
        rt_id: '',
        name: '',
        mustahik_type_id: '',
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
    onChange() {
      this.form.rt_id = ''
    },
  },
}
</script>

<style scoped>

</style>
