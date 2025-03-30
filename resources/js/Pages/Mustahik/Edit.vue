<template>
  <AdminLayout
    :title="'Edit Mustahik'"
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
        <MustahikForm
          :rule-form="ruleForm"
          :method="'PUT'"
          :url="`/mustahik/${mustahik.id}`"
          :loading="submitLoading"
          :rw="rw.data"
          :mustahik-type="mustahikType.data"
          :mustahik-status="mustahikStatus.data"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import {defineComponent} from 'vue'
import MustahikForm from '../../Components/Mustahik/Form'
import AdminLayout from '../../Layouts/AdminLayout'

export default defineComponent({
  components: {MustahikForm, AdminLayout},
  props: {
    rw: {
      type: Object,
      default: () => ({}),
    },
    mustahikType: {
      type: Object,
      default: () => ({}),
    },
    mustahikStatus: {
      type: Object,
      default: () => ({}),
    },
    mustahik: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Mustahik',
          to: '/backoffice/mustahik',
        },
        {
          title: 'Edit Mustahik',
          to: '#!',
        },
      ],
      ruleForm: {
        rw_id: this.mustahik.rw_id,
        rt_id: this.mustahik.rt_id,
        mustahik_type_id: this.mustahik.mustahik_type_id,
        mustahik_status_id: this.mustahik.mustahik_status_id,
        name: this.mustahik.name,
      },
    }
  },
})
</script>

<style scoped>

</style>
