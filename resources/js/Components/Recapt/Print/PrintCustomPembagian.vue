<template>
  <div id="custom-pembagian">
    <el-table
      :data="data"
      show-summary
      class="table-no-carret"
      border
    >
      <el-table-column
        label="RT/RW"
      >
        <template #default="scope">
          {{ scope.row.data.name }}/{{ scope.row.data.rw.name }}
        </template>
      </el-table-column>
      <el-table-column
        label="Penerima"
        align="center"
      >
        <el-table-column
          v-for="(item, index) in mustahikStatus"
          :key="`list-item-mustahik-${index}`"
          :label="item.name"
          align="center"
        >
          <template #default="scope">
            {{ scope.row.listPenerima[item.id] ? scope.row.listPenerima[item.id] : 0 }}
          </template>
        </el-table-column>
      </el-table-column>
      <el-table-column
        prop="totalDistribution"
        sortable
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
    rw: {
      type: Array,
      default: () => ([]),
    },
    mustahikType: {
      type: Array,
      default: () => ([]),
    },
    mustahikStatus: {
      type: Array,
      default: () => ([]),
    },
    data: {
      type: Array,
      default: () => ([]),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
}
</script>