<template>
  <AdminLayout
    :title="'Tambah RW (Rukun Warga)'"
    :breadcumb="breadcumb"
  >
    <el-row :gutter="10">
      <el-col
        :xs="24"
        :sm="24"
        :md="6"
        :lg="6"
        :xl="6"
      >
        <RwForm
          :rule-form="ruleForm"
          :method="'POST'"
          :url="`/rw-rt`"
          :loading="submitLoading"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import {defineComponent} from 'vue'
import RwForm from '../../Components/RtRw/FormRw'
import AdminLayout from '../../Layouts/AdminLayout'

export default defineComponent({
  components: {RwForm, AdminLayout},
  data() {
    return {
      breadcumb: [
        {
          title: 'RT/RW',
          to: '/backoffice/rw-rt',
        },
        {
          title: 'Tambah RW',
          to: '#!',
        },
      ],
      ruleForm: {
        nama: '',
      },
    }
  },
})
</script>

<style scoped>

</style>
