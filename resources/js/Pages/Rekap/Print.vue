<template>
  <div id="printMe">
    <PrintLayout
      :title="'Rekap'"
    >
      <div>
        <button
          v-show="false"
          ref="printButton"
          v-print="printObj"
        >
          Print
        </button>

        <div class="tw-text-center tw-mb-8">
          <h1 class="tw-text-lg tw-font-semibold tw-mb-6">
            Data Zakat Masjid Mambaul Hayat 2022
          </h1>
        </div>

        <el-divider />

        <div
          class="tw-pb-8"
          style="margin-bottom: 50rem !important;"
        >
          <h1 class="tw-text-xl tw-font-semibold tw-mb-6">
            Tabel Data Penerimaan Zakat
          </h1>
          <PrintZakatTable
            :data="zakatTable"
            :satuan="satuan"
            :mustahik-status="mustahikStatus.data"
            class="tw-mb-8"
          />
        </div>

        <div style="margin-bottom: 40rem !important; padding-top: 5rem !important;">
          <h1 class="tw-text-xl tw-font-semibold tw-mb-6">
            Tabel Data Penggunaan Zakat
          </h1>
          <PrintPenerimaTable
            :data="zakatTable"
            :satuan="satuan"
            :mustahik-status="mustahikStatus.data"
            class="tw-mb-20"
          />
        </div>

        <div class="tw-mt-20 tw-pt-20">
          <h1 class="tw-text-xl tw-font-semibold tw-mb-6">
            Tabel Data Tambahan Penggunaan
          </h1>
          <PrintCustomPembagian
            :rw="rw.data"
            :mustahik-type="mustahikType.data"
            :mustahik-status="mustahikStatus.data"
            :data="zakatTambahan"
            :satuan="satuan"
            class="tw-mb-8"
          />
        </div>

        <div style="margin-bottom: 40rem !important; padding-top: 5rem !important;">
          <h1 class="tw-text-xl tw-font-semibold tw-mb-6">
            Tabel Amil
          </h1>
          <PrintAmil
            :amil="amil"
            :doa="doa"
            class="tw-mb-8"
          />
        </div>

        <div style="padding-top: 5rem !important;">
          <h1 class="tw-text-xl tw-font-semibold tw-mb-6">
            Data Rekap Hasil
          </h1>
          <PrintSummaryData
            :zakat="zakatTable"
            :amil="amil"
            :doa="doa"
            :tambahan="zakatTambahan"
            :mustahik-status="mustahikStatus.data"
            :mustahik-summary="mustahikListSummary"
            :satuan="satuan"
            class="tw-mb-8"
          />
        </div>
      </div>
    </PrintLayout>

    <!-- <el-empty
      v-else
      description="Belum ada data yang ditambahkan"
    /> -->
  </div>
</template>

<script>
import PrintZakatTable from '../../Components/Recapt/Print/PrintZakatTable.vue'
import PrintPenerimaTable from '../../Components/Recapt/Print/PrintPenerimaTable.vue'
import PrintCustomPembagian from '../../Components/Recapt/Print/PrintCustomPembagian.vue'
import PrintAmil from '../../Components/Recapt/Print/PrintAmil.vue'
import PrintSummaryData from '../../Components/Recapt/Print/PrintSummaryData.vue'
import PrintLayout from '../../Layouts/PrintLayout'

import axios from 'axios'

export default {
  components: {
    PrintLayout,
    PrintZakatTable,
    PrintPenerimaTable,
    PrintCustomPembagian,
    PrintAmil,
    PrintSummaryData,
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
      printObj: {
        id: 'printMe',
        popTitle: 'Cetak Rekap',
        extraHead: '<meta http-equiv="Content-Language"content="zh-cn"/>',
        beforeOpenCallback (vue) {
          vue.printLoading = true
        },
        openCallback (vue) {
          vue.printLoading = false
        },
        closeCallback () {
          window.close()
        },
      },
      zakatTable: [],
      zakatTambahan: [],
      mustahikListSummary: [],
    }
  },
  created() {
    // this.getData()
  },
  methods: {
    getData() {
      axios.all([
        axios.get('/api/backoffice/zakat-rt/recapt'),
        axios.get('/api/backoffice/zakat-tambahan-rt/recapt'),
        axios.get('/api/backoffice/mustahik/recapt'),
      ])
        .then(axios.spread((zakat, tambahan, summaryMustahik) => {
          this.zakatTable = zakat.data
          this.zakatTambahan = tambahan.data
          this.mustahikListSummary = summaryMustahik.data

          this.$nextTick(() => {
            this.$refs.printButton.click()
          })
        }))
    },
  },
}
</script>

<style lang="scss" scoped>
#print {}
</style>
