<template>
  <AdminLayout
    :title="'Tambah Status Mustahik'"
    :breadcumb="breadcumb"
  >
    <el-row :gutter="10">
      <el-col
        :xs="24"
        :sm="24"
        :md="8"
        :lg="8"
        :xl="8"
      >
        <MustahikStatus
          :rule-form="ruleForm"
          :method="'POST'"
          :url="`/mustahik-status`"
          :loading="submitLoading"
          :satuan="satuan"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import {defineComponent} from 'vue'
import MustahikStatus from '../../Components/MustahikStatus/Form'
import AdminLayout from '../../Layouts/AdminLayout'

export default defineComponent({
  components: {MustahikStatus, AdminLayout},
  props: {
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Status Mustahik',
          to: '/backoffice/mustahik-status',
        },
        {
          title: 'Tambah Status Mustahik',
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
