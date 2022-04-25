<template>
  <AdminLayout
    :title="'Edit Data Warga'"
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
        <DaftarWargaForm
          :rule-form="people"
          :method="'PUT'"
          :url="`/people/${people.id}`"
          :loading="submitLoading"
          :rw="rw.data"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import {defineComponent} from 'vue'
import DaftarWargaForm from '../../Components/DaftarWarga/Form'
import AdminLayout from '../../Layouts/AdminLayout'

export default defineComponent({
  components: {DaftarWargaForm, AdminLayout},
  props : {
    people: {
      type: Object,
      default: () => ({}),
    },
    rw: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Daftar Warga',
          to: '/backoffice/people',
        },
        {
          title: 'Edit Data Warga',
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
