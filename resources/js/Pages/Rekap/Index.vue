<template>
  <AdminLayout
    :title="'Rekap'"
    :breadcumb="breadcumb"
  >
    <div v-loading="loadingZakatTable">
      <el-row
        v-if="zakatTable.length && !loadingZakatTable"
        :gutter="20"
      >
        <el-col
          :xs="24"
          :sm="24"
          :md="16"
          :lg="16"
          :xl="16"
        >
          <div class="tw-mb-4">
            <div v-if="satuan">
              <HeaderRecapt
                :satuan="satuan"
                :zakat="zakatTable"
                :amil="amil"
                :tambahan="zakatTambahan"
                :doa="doa"
              />
            </div>
            <div v-else>
              <el-alert
                title="Satuan Zakat belum ditentukan"
                type="warning"
                :closable="false"
              />
            </div>
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
        <el-col
          :xs="24"
          :sm="24"
          :md="8"
          :lg="8"
          :xl="8"
        >
          <PembagianTable
            :status="status.data"
            :satuan="satuan"
          />
          <AmilConfig
            :data="amil"
            :satuan="satuan"
          />
          <DoaConfig
            :data="doa"
            :satuan="satuan"
          />
        </el-col>
      </el-row>
    </div>

    <el-empty
      v-if="!zakatTable.length && !loadingZakatTable"
      description="Belum ada data yang ditambahkan"
    />
  </AdminLayout>
</template>

<script>
import AdminLayout from '../../Layouts/AdminLayout'
import ZakatTable from '../../Components/Recapt/ZakatTable.vue'
import PembagianTable from '../../Components/Recapt/PembagianTable.vue'
import CustomPembagian from '../../Components/Recapt/CustomPembagian.vue'
import HeaderRecapt from '../../Components/Recapt/HeaderRecapt.vue'
import AmilConfig from '../../Components/Recapt/AmilConfig.vue'
import DoaConfig from '../../Components/Recapt/DoaConfig.vue'
import axios from 'axios'

export default {
  components: {
    AdminLayout,
    ZakatTable,
    PembagianTable,
    CustomPembagian,
    HeaderRecapt,
    AmilConfig,
    DoaConfig,
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
    doa: {
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