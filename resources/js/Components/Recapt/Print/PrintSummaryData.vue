<template>
  <div id="print-summary-data">
    <el-table
      :data="dataTable"
      class="table-no-carret"
      border
      :show-header="false"
    >
      <el-table-column
        prop="title"
        class-name="tw-bg-header"
      />
      <el-table-column
        prop="data"
        align="center"
      >
        <template #default="scope">
          {{ scope.row.data }} <b>{{ satuan.name }}</b>
        </template>
      </el-table-column>
      <el-table-column
        prop="kilo"
        align="center"
      >
        <template #default="scope">
          {{ scope.row.kilo }} <b>Kg</b>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
export default {
  props: {
    zakat: {
      type: Array,
      default: () => ([]),
    },
    mustahikStatus: {
      type: Array,
      default: () => ([]),
    },
    amil: {
      type: Object,
      default: () => ({}),
    },
    doa: {
      type: Object,
      default: () => ({}),
    },
    tambahan: {
      type: Array,
      default: () => ([]),
    },
    mustahikSummary: {
      type: Array,
      default: () => ([]),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      data: [],
    }
  },
  computed: {
    totalZakat() {
      if (this.zakat.length) {
        return this.zakat.reduce((accumulator, object) => {
          return accumulator + object.amount
        }, 0)
      }
      return 0
    },
    totalDonasi() {
      if (this.zakat.length) {
        return this.zakat.reduce((accumulator, object) => {
          return accumulator + object.donasi
        }, 0)
      }
      return 0
    },
    totalMasuk() {
      return this.totalZakat + this.totalDonasi
    },
    totalKebutuhanZakat() {
      if (this.zakat.length) {
        return this.zakat.reduce((accumulator, object) => {
          return accumulator + object.kebutuhan
        }, 0)
      }
      return 0
    },
    totalKebutuhanTambahan() {
      if (this.tambahan.length) {
        return this.tambahan.reduce((accumulator, object) => {
          return accumulator + object.totalDistribution
        }, 0)
      }
      return 0
    },
    totaKebutuhanAmil() {
      return this.amil.amount * this.amil.distribution
    },
    totaKebutuhanDoa() {
      return this.doa.amount * this.doa.distribution
    },
    totalKebutuhan() {
      return this.totalKebutuhanZakat + this.totalKebutuhanTambahan + this.totaKebutuhanAmil
    },
    dataZakat() {
      return {
        title: 'Total Zakat diterima',
        data: this.totalMasuk,
        kilo: this.totalMasuk * this.satuan.kilo,
      }
    },
    dataAmil() {
      return {
        title: 'Total Amil',
        data: this.totaKebutuhanAmil + this.totaKebutuhanDoa,
        kilo: (this.totaKebutuhanAmil * this.satuan.kilo) + (this.totaKebutuhanDoa * this.satuan.kilo),
      }
    },
    dataSisa() {
      return {
        title: 'Sisa',
        data: this.totalMasuk - this.totalKebutuhan,
        kilo: (this.totalMasuk - this.totalKebutuhan) * this.satuan.kilo,
      }
    },
    dataTable() {
      const data = []
      data.push(this.dataZakat)

      console.log(this.mustahikSummary)

      this.mustahikSummary.map(el => {
        const datas = {
          title: el.data.name,
          data: el.summary,
          kilo: el.summary * this.satuan.kilo,
        }
        data.push(datas)
      })

      data.push(this.dataAmil)
      data.push(this.dataSisa)
      return data
    },
  },
}
</script>