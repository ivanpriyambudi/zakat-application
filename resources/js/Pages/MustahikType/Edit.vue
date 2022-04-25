<template>
  <AdminLayout
    :title="'Tambah Tipe Mustahik'"
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
        <MustahikTypeForm
          :rule-form="mustahikType"
          :method="'PUT'"
          :url="`/mustahik-type/${mustahikType.id}`"
          :loading="submitLoading"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import {defineComponent} from 'vue'
import MustahikTypeForm from '../../Components/MustahikType/Form'
import AdminLayout from '../../Layouts/AdminLayout'

export default defineComponent({
  components: {MustahikTypeForm, AdminLayout},
  props: {
    mustahikType: {
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
