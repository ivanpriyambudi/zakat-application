<template>
  <div id="print-amil">
    <el-table
      :data="data"
      class="table-no-carret"
      border
      header-cell-class-name="tw-bg-header"
    >
      <el-table-column
        label="Jumlah"
        prop="amount"
        align="center"
      />
      <el-table-column
        label="Pembagian"
        prop="distribution"
        align="center"
      />
    </el-table>
  </div>
</template>

<script>
export default {
  props: {
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
    const amountAmil = this.amil ? this.amil.amount : 0
    const amountDoa = this.doa ? this.doa.amount : 0
    const amilDesc = this.amil ? this.amil.distribution : ''
    const doaDesc = this.doa ? this.doa.distribution : ''

    return {
      data: [
        {
          amount: amountAmil + amountDoa,
          distribution: `${amilDesc} (Amil Do'a ${doaDesc})`,
        },
      ],
    }
  },
}
</script>
