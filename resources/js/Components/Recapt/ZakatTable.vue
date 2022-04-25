<template>
  <div id="count-zakat-table">
    <el-card
      shadow="never"
      class="tw-mb-10"
    >
      <template #header>
        <div class="card-header">
          <span>Data Penerima</span>
        </div>
      </template>
      <el-table
        :data="data"
        style="width: 100%" 
        show-summary
      >
        <el-table-column
          label="RT/RW"
          width="120"
          fixed
          align="center"
        >
          <template #default="scope">
            {{ scope.row.data.name }}/{{ scope.row.data.rw.name }}
          </template>
        </el-table-column>

        <el-table-column
          sortable
          prop="amount"
          width="120"
          align="center"
        >
          <template #header>
            Total Zakat <br>({{ satuan.name }})
          </template>
        </el-table-column>

        <el-table-column
          sortable
          prop="donasi"
          width="120"
          align="center"
        >
          <template #header>
            Total Donasi <br>({{ satuan.name }})
          </template>
        </el-table-column>

        <el-table-column
          label="Penerima"
          header-align="center"
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
            Kebutuhan <br>({{ satuan.name }})
          </template>
        </el-table-column>
      </el-table>
    </el-card>
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