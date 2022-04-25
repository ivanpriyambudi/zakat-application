<template>
  <AdminLayout
    :title="'Tambah Data Zakat'"
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
          :method="'POST'"
          :url="`/zakat`"
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
import { getQueryParams } from '../../Components/Commons/utils'

export default defineComponent({
  components: {ZakatForm, AdminLayout},
  props: {
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
    const query = getQueryParams(window.location.search)
    return {
      breadcumb: [
        {
          title: 'Daftar Zakat',
          to: '/backoffice/zakat',
        },
        {
          title: 'Tambah Data Zakat',
          to: '#!',
        },
      ],
      ruleForm: {
        rw_id: query.rw_id ? parseInt(query.rw_id) : '',
        rt_id: query.rt_id ? parseInt(query.rt_id) : '',
      },
    }
  },
})
</script>

<style scoped>

</style>
