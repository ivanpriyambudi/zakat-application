<template>
  <AdminLayout
    :title="'Edit Satuan Barang'"
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
          :rule-form="satuanZakat"
          :method="'PUT'"
          :url="`/satuan-zakat/${satuanZakat.id}`"
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
  props: {
    satuanZakat: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Satuan Zakat',
          to: '/backoffice/satuan-zakat',
        },
        {
          title: 'Edit Satuan Zakat',
          to: '#!',
        },
      ],
    }
  },
})
</script>

<style scoped>

</style>
