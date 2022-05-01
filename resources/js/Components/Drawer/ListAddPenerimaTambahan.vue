<template>
  <div
    id="list-penerima-tambahan"
    class="tw-px-6"
  >
    <div class="tw-mb-4">
      <form @submit.prevent="onSearch">
        <el-input
          v-model="filter.name"
          size="large"
          placeholder="Cari Nama Mustahik"
        >
          <template #prefix>
            <i class="tw-ml-1 el-icon-search" />
          </template>
        </el-input>
      </form>
    </div>

    <div class="tw-mb-2">
      <el-tag
        v-for="(item, index) in filterDetail"
        :key="`list-filter-${index}`"
        class="tw-mr-2"
      >
        {{ index }} {{ item.name }}
      </el-tag>
    </div>

    <el-scrollbar height="500px">
      <div>
        <el-table
          :data="data"
          style="width: 100%"
        >
          <el-table-column
            prop="name"
            label="Nama"
          />
          <el-table-column
            prop="distribution"
            label="Tambahan"
          >
            <template #default="scope">
              {{ scope.row.distribution ? scope.row.distribution : 0 }}
            </template>
          </el-table-column>
          <el-table-column
            label=""
          >
            <template #default="scope">
              <div class="tw-text-right">
                <el-button
                  type="text"
                  @click="onOpenAddValue(scope.row)"
                >
                  Tambah
                </el-button>
              </div>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </el-scrollbar>

    <el-dialog
      v-model="modalAddValue"
      title="Tambahan Zakat Mustahik"
      width="30%"
    >
      <el-descriptions
        direction="vertical"
        :column="2"
        border
      >
        <el-descriptions-item label="Nama">
          {{ dataToAddValue.name }}
        </el-descriptions-item>
        <el-descriptions-item label="RT/RW">
          {{ dataToAddValue.rt.name }}/{{ dataToAddValue.rw.name }}
        </el-descriptions-item>
        <el-descriptions-item label="Tipe">
          {{ dataToAddValue.mustahik_type.name }}
        </el-descriptions-item>
        <el-descriptions-item label="Status">
          {{ dataToAddValue.mustahik_status.name }}
        </el-descriptions-item>
        <el-descriptions-item label="Tambahan Zakat">
          <el-input-number
            v-model="dataToAddValue.distribution"
            :min="0"
          />
        </el-descriptions-item>
      </el-descriptions>

      <template #footer>
        <span class="dialog-footer">
          <el-button @click="modalAddValue = false">Batal</el-button>
          <el-button
            type="primary"
            @click="onSubmit"
          >Simpan</el-button>
        </span>
      </template>
    </el-dialog>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: {
    filters: {
      type: Object,
      default: () => ({}),
    },
    filterDetail: {
      type: Object,
      default: () => ({}),
    },
    data: {
      type: Array,
      default: () => ([]),
    },
    onSearchName: {
      type: Function,
      default: () => ({}),
    },
  },
  data() {
    return {
      filter: {
        name: '',
      },
      modalAddValue: false,
      loadingAddDistribution: false,
      dataToAddValue: '',
    }
  },
  methods: {
    onSearch() {
      let data = ''
      if (this.filter.name) {
        data = this.filter.name
      }
      this.onSearchName(data)
    },
    onOpenAddValue(data) {
      this.dataToAddValue = data
      this.modalAddValue = true
    },
    onSubmit() {
      this.loadingAddDistribution = true
      axios.post(`/api/backoffice/mustahik/update-distribution/${this.dataToAddValue.id}`, {distribution: this.dataToAddValue.distribution})
        .then(() => {
          this.loadingAddDistribution = false
          this.modalAddValue = false
        })
    },
  },
}
</script>