<template>
  <AdminLayout
    :title="'Tambah Satuan Zakat'"
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
        <SatuanZakatForm
          :rule-form="ruleForm"
          :method="'POST'"
          :url="`/satuan-zakat`"
          :loading="submitLoading"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import {defineComponent} from 'vue'
import SatuanZakatForm from '../../Components/SatuanZakat/Form'
import AdminLayout from '../../Layouts/AdminLayout'

export default defineComponent({
  components: {SatuanZakatForm, AdminLayout},
  data() {
    return {
      breadcumb: [
        {
          title: 'Satuan Zakat',
          to: '/backoffice/satuan-zakat',
        },
        {
          title: 'Tambah Satuan Zakat',
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
