<template>
  <AdminLayout
    :title="''"
    :breadcumb="breadcumb"
  >
    <el-row
      :gutter="24"
    >
      <el-col :span="17">
        <el-row
          :gutter="24"
          class="left-fit-section"
        >
          <el-col :span="8">
            <AmountBungkus
              :count-zakat="countZakat"
              :is-loading="isLoadingCountZakat"
              @click="getCountZakatOnYear"
            />
          </el-col>
          <el-col :span="16">
            <div class="tw-mb-6">
              <h1 class="tw-font-semibold tw-text-4xl tw-mb-2">
                Zakat Fitrah {{ year }}
              </h1>
              <p>Gendoh, Klontang, Masjid Mamba'ul Hayat</p>
            </div>

            <QuickRecapt
              v-loading="loadingQuickRecapt"
              :mustahik="mustahik"
              :pembagian="mustahikStatus"
              :satuan="satuan"
            />
          </el-col>
        </el-row>
        <el-divider />
        <CountZakatTable
          v-loading="loadingZakatTable"
          :data="zakatTable"
          class="tw-mb-6"
        />
      </el-col>
      <el-col :span="1">
        <el-divider
          direction="vertical"
          class="tw-h-full tw-opacity-60"
        />
      </el-col>
      <el-col :span="6">
        <RecentZakat
          v-loading="loadingRecentZakat"
          :data-all="recentZakat"
        />
      </el-col>
    </el-row>
  </AdminLayout>
</template>

<script>
import AdminLayout from '../Layouts/AdminLayout'
import RecentZakat from '../Components/Dashboard/RecentZakat.vue'
import AmountBungkus from '../Components/Dashboard/AmountBungkus.vue'
import QuickRecapt from '../Components/Dashboard/QuickRecapt.vue'
import CountZakatTable from '../Components/Dashboard/CountZakatTable.vue'
import axios from 'axios'

export default {
  title: 'Dashboard',
  components: {
    AdminLayout,
    RecentZakat,
    AmountBungkus,
    QuickRecapt,
    CountZakatTable,
  },
  props: {
    rw: {
      type: Object,
      default: () => ({}),
    },
    countAllMustahik: {
      type: String,
      default: '',
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      breadcumb: [],
      countZakat: 0,
      mustahik: [],
      zakatTable: [],
      recentZakat: [],
      mustahikStatus: [],
      isLoadingCountZakat: false,
      loadingZakatTable: false,
      loadingQuickRecapt: false,
      loadingRecentZakat: false,
      year: new Date().getFullYear(),
    }
  },
  mounted() {
    this.getCountZakatOnYear()
    this.getCountMustahik()
    this.getZakatDataRt()
    this.getRecentZakat()
    this.getStatusMustahik()
  },
  methods: {
    getCountZakatOnYear() {
      this.isLoadingCountZakat = true
      axios.get('/api/backoffice/count-zakat-year')
        .then(res => {
          this.countZakat = res.data
          this.isLoadingCountZakat = false
        })
    },
    getCountMustahik() {
      this.loadingQuickRecapt = true
      axios.get('/api/backoffice/count-mustahik-year')
        .then(res => {
          this.mustahik = res.data
          this.loadingQuickRecapt = false
        })
    },
    getZakatDataRt() {
      this.loadingZakatTable = true
      axios.get('/api/backoffice/zakat-rt')
        .then(res => {
          this.zakatTable = res.data
          this.loadingZakatTable = false
        })
    },
    getRecentZakat() {
      this.loadingRecentZakat = true
      axios.get('/api/backoffice/recent-zakat')
        .then(res => {
          this.recentZakat = res.data
          this.loadingRecentZakat = false
        })
    },
    getStatusMustahik() {
      this.loadingQuickRecapt = true
      axios.get('/api/backoffice/mustahik-status/pembagian')
        .then(res => {
          this.mustahikStatus = res.data
          this.loadingQuickRecapt = false
        })
    },
  },
}
</script>

<style lang="scss" scoped>
.left-fit-section {
  position: relative;
  left: -4rem;
}
</style>