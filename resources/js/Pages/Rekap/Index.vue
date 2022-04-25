<template>
  <AdminLayout
    :title="'Rekap'"
    :breadcumb="breadcumb"
  >
    <el-row :gutter="20">
      <el-col :span="16">
        <div class="tw-mb-4">
          <HeaderRecapt
            :satuan="satuan"
            :zakat="zakatTable"
            :amil="amil"
            :tambahan="zakatTambahan"
          />
        </div>
        <ZakatTable
          v-loading="loadingZakatTable"
          :data="zakatTable"
          :satuan="satuan"
          :mustahik-status="mustahikStatus.data"
        />
        <CustomPembagian
          v-loading="loadingZakatTambahan"
          :rw="rw.data"
          :mustahik-type="mustahikType.data"
          :mustahik-status="mustahikStatus.data"
          :data="zakatTambahan"
          :satuan="satuan"
        />
      </el-col>
      <el-col :span="8">
        <PembagianTable
          :status="status.data"
          :satuan="satuan"
        />
        <AmilConfig :data="amil" />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../Layouts/AdminLayout'
import ZakatTable from '../../Components/Recapt/ZakatTable.vue'
import PembagianTable from '../../Components/Recapt/PembagianTable.vue'
import CustomPembagian from '../../Components/Recapt/CustomPembagian.vue'
import HeaderRecapt from '../../Components/Recapt/HeaderRecapt.vue'
import AmilConfig from '../../Components/Recapt/AmilConfig.vue'
import axios from 'axios'

export default {
  components: {
    AdminLayout,
    ZakatTable,
    PembagianTable,
    CustomPembagian,
    HeaderRecapt,
    AmilConfig,
  },
  props : {
    rw: {
      type: Object,
      default: () => ({}),
    },
    status: {
      type: Object,
      default: () => ({}),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
    mustahikStatus: {
      type: Object,
      default: () => ({}),
    },
    mustahikType: {
      type: Object,
      default: () => ({}),
    },
    amil: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [
        {
          title: 'Rekap Zakat',
          to: '#',
        },
      ],
      loadingZakatTable: false,
      loadingZakatTambahan: false,
      zakatTable: [],
      zakatTambahan: [],
    }
  },
  created() {
    this.getZakatDataRt()
    this.getZakatTambahan()
  },
  methods: {
    getZakatDataRt() {
      this.loadingZakatTable = true
      axios.get('/api/backoffice/zakat-rt/recapt')
        .then(res => {
          this.zakatTable = res.data
          this.loadingZakatTable = false
        })
    },
    getZakatTambahan() {
      this.loadingZakatTambahan = true
      axios.get('/api/backoffice/zakat-tambahan/recapt')
        .then(res => {
          this.zakatTambahan = res.data
          this.loadingZakatTambahan = false
        })
    },
  },
}
</script>