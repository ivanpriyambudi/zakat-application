<template>
  <div id="count-zakat-table">
    <el-table
      :data="data"
      style="width: 100%"
    >
      <el-table-column
        prop="data.rw.name"
        label="RW"
      />
      <el-table-column
        prop="data.name"
        label="RT"
      />
      <el-table-column
        label="Jumlah"
      >
        <template #default="scope">
          <div
            v-for="(item, index) in scope.row.amount"
            :key="`item-${index}`"
          >
            <el-tag
              class="tw-mb-2"
              type="info"
            >
              {{ item }} <span class="tw-capitalize">{{ index }}</span>
            </el-tag>
          </div>
        </template>
      </el-table-column>
      <el-table-column
        label=""
        align="right"
      >
        <template #default="scope">
          <el-button
            size="small"
            @click="onDetailZakat(scope.row)"
          >
            Detail
          </el-button>
          <el-button
            size="small"
            type="primary"
            plain
            @click="onAddZakat(scope.row)"
          >
            Tambah Zakat
          </el-button>
        </template>
      </el-table-column>
    </el-table>
  </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'

export default {
  props: {
    data: {
      type: Array,
      default: () => ([]),
    },
    year: {
      type: String,
      default: '',
    },
  },
  methods: {
    onAddZakat(data) {
      const rwId = data.data.rw_id
      const rtId = data.data.id

      Inertia.get('/backoffice/zakat/create', { rw_id: rwId, rt_id: rtId }, { replace: true })
    },
    onDetailZakat(data) {
      const rwId = data.data.rw_id
      const rtId = data.data.id

      Inertia.get('/backoffice/zakat', { 'filter[rw_id]': rwId, 'filter[rt_id]': rtId, 'filter[year]': this.year }, { replace: true })
    },
  },
}
</script>
