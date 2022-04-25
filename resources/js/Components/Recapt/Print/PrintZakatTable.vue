<template>
  <div id="count-zakat-table">
    <el-table
      :data="data"
      show-summary
      class="table-no-carret"
      header-cell-class-name="tw-bg-header"
      border
    >
      <el-table-column
        label="RT/RW"
        align="center"
      >
        <template #default="scope">
          {{ scope.row.data.name }}/{{ scope.row.data.rw.name }}
        </template>
      </el-table-column>

      <el-table-column
        sortable
        prop="amount"
        align="center"
      >
        <template #header>
          Zakat
        </template>
      </el-table-column>

      <el-table-column
        sortable
        prop="donasi"
        align="center"
      >
        <template #header>
          Donatur
        </template>
      </el-table-column>

      <el-table-column
        sortable
        prop="totalIn"
        align="center"
      >
        <template #header>
          Total
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Array,
      default: () => ([]),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
    mustahikStatus: {
      type: Array,
      default: () => ([]),
    },
  },
}
</script>
