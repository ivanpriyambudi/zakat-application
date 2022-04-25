<template>
  <AdminLayout
    :title="'Edit Status Mustahik'"
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
          :rule-form="mustahikStatus"
          :method="'PUT'"
          :url="`/mustahik-status/${mustahikStatus.id}`"
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
    mustahikStatus: {
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
          title: 'Edit Status Mustahik',
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
