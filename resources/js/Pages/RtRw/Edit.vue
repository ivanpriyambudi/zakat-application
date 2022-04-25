<template>
  <AdminLayout
    :title="'Edit RW (Rukun Warga)'"
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
          :rule-form="rw"
          :method="'PUT'"
          :url="`/rw-rt/${rw.id}`"
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
  props: {
    rw: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'RT/RW',
          to: '/backoffice/rw-rt',
        },
        {
          title: 'Edit RW',
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
