<template>
  <div id="count-zakat-table">
    <el-table
      :data="data"
      show-summary
      style="table-layout: fixed;"
      class="table-no-carret"
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
            {{ scope.row.listPenerima[item.name] ? scope.row.listPenerima[item.name] : 0 }}
          </template>
        </el-table-column>
        <el-table-column
          label="Total"
          sortable
          prop="countPenerima"
          align="center"
        />
      </el-table-column>

      <el-table-column
        label="Kebutuhan"
        sortable
        prop="kebutuhan"
        width="120"
        align="center"
      >
        <template #header>
          Kebutuhan
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
