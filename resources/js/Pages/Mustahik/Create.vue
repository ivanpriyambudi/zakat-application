<template>
  <AdminLayout
    :title="'Tambah Mustahik'"
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
          :method="'POST'"
          :url="`/mustahik`"
          :loading="submitLoading"
          :rw="rw.data"
          :mustahik-type="mustahikType.data"
          :mustahik-status="mustahikStatus.data"
          @change:names="testChange"
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
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Mustahik',
          to: '/backoffice/mustahik',
        },
        {
          title: 'Tambah Mustahik',
          to: '#!',
        },
      ],
      ruleForm: {
        name: '',
        names: [],
      },
    }
  },
  methods: {
    testChange(val) {
      const length = val.length
      const lastName = val[length-1]

      if (lastName && lastName.includes(',')) {
        const newValue = lastName.split(', ')
        this.ruleForm.names.splice(length-1)
        const newValues = newValue.filter(el => !this.ruleForm.names.includes(el))
        this.ruleForm.names = this.ruleForm.names.concat(newValues)
      }
    },
  },
})
</script>

<style scoped>

</style>
