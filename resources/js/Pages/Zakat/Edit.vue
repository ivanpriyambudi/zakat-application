<template>
  <AdminLayout
    :title="'Edit Data Zakat'"
    :breadcumb="breadcumb"
  >
    <el-row :gutter="10">
      <el-col
        :xs="24"
        :sm="24"
        :md="12"
        :lg="12"
        :xl="12"
      >
        <ZakatForm
          :rule-form="ruleForm"
          :method="'PUT'"
          :url="`/zakat/${zakat.id}`"
          :loading="submitLoading"
          :rw="rw.data"
          :satuan="satuan.data"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import {defineComponent} from 'vue'
import ZakatForm from '../../Components/Zakat/Form'
import AdminLayout from '../../Layouts/AdminLayout'

export default defineComponent({
  components: {ZakatForm, AdminLayout},
  props: {
    zakat: {
      type: Object,
      default: () => ({}),
    },
    rw: {
      type: Object,
      default: () => ({}),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Daftar Zakat',
          to: '/backoffice/zakat',
        },
        {
          title: 'Edit Data Zakat',
          to: '#!',
        },
      ],
      ruleForm: {
        rt_id: this.zakat.people.rt_id,
        rw_id: this.zakat.people.rw_id,
        type: this.zakat.type,
        amount_type_id: this.zakat.amount_type_id,
        amount: this.zakat.amount,
        name: this.zakat.people.name,
      },
    }
  },
})
</script>

<style scoped>

</style>
