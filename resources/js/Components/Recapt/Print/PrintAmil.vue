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
  },
  data() {
    return {
      data: [this.amil],
    }
  },
}
</script>