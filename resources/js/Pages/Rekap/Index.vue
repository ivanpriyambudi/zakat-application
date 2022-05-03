<template>
  <AdminLayout
    :title="'Rekap'"
    :breadcumb="breadcumb"
  >
    <el-row
      :gutter="20"
    >
      <el-col
        :xs="24"
        :sm="24"
        :md="16"
        :lg="16"
        :xl="16"
      >
        <div
          v-loading="loadingZakatTable"
          class="tw-mb-4"
        >
          <div v-if="zakatTable.length && !loadingZakatTable && satuan">
            <HeaderRecapt
              :satuan="satuan"
              :zakat="zakatTable"
              :amil="amil"
              :tambahan="zakatTambahanSummary"
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
          :meta="metaZakatTambahan"
          :on-load="getZakatTambahan"
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
      metaZakatTambahan: {
        current_page: 1,
        last_page: 1,
      },
      zakatTambahanSummary: 0,
    }
  },
  mounted() {
    // console.log('lohh')
    // Echo.channel('zakats')
    //   .listen('ZakatRecapt', (e) => {
    //     console.log('websocket', e)
    //   })

    Echo.private('zakats')
      .listen('ZakatRecapt', (e) => {
        console.log(e)
        this.getZakatDataRt(false)
      })
  },
  created() {
    this.getZakatDataRt()
    this.getZakatTambahan()
    this.getZakatTambahanSummary()
  },
  methods: {
    getZakatDataRt(isloading = true) {
      if (isloading) {
        this.loadingZakatTable = true
      }
      axios.get('/api/backoffice/zakat-rt/recapt')
        .then(res => {
          this.zakatTable = res.data
          this.loadingZakatTable = false

          if (!isloading) {
            this.$notify({
              title: 'Zakat baru ditambahkan',
              message: 'Ada zakat baru ditambahkan',
              type: 'info',
            })
          }
        })
    },
    getZakatTambahan(page = 1) {
      this.loadingZakatTambahan = true
      axios.get('/api/backoffice/zakat-tambahan/recapt', {
        params: {
          page: page,
        },
      })
        .then(res => {
          this.zakatTambahan = res.data.data

          this.metaZakatTambahan.current_page = res.data.current_page
          this.metaZakatTambahan.last_page = res.data.last_page

          this.loadingZakatTambahan = false
        })
    },
    getZakatTambahanSummary() {
      this.loadingZakatTambahan = true
      axios.get('/api/backoffice/zakat-tambahan/summary')
        .then(res => {
          this.zakatTambahanSummary = res.data
          this.loadingZakatTambahan = false
        })
    },
  },
}
</script>