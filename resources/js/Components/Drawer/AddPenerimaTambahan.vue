<template>
  <div
    id="add-penerima-tambahan"
    class="tw-px-10"
  >
    <el-form
      label-position="left"
      label-width="200px"
    >
      <el-form-item label="RW">
        <el-select
          v-model="rw_id"
          class="m-2"
          placeholder="Select RW"
          size="large"
        >
          <el-option
            v-for="(item, index) in rw"
            :key="`list-rw-${index}`"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="RT">
        <el-select
          v-model="rt_id"
          class="m-2"
          placeholder="Select RT"
          size="large"
          :disabled="!rw_id"
        >
          <el-option
            v-for="(item, index) in rtList"
            :key="`list-rt-${index}`"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Tipe Mustahik">
        <el-select
          v-model="mustahik_type"
          class="m-2"
          placeholder="Select Tipe"
          size="large"
        >
          <el-option
            v-for="(item, index) in mustahikType"
            :key="`list-mustahikType-${index}`"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-form-item label="Status Mustahik">
        <el-select
          v-model="mustahik_status"
          class="m-2"
          placeholder="Select Tipe Penerima"
          size="large"
        >
          <el-option
            v-for="(item, index) in mustahikStatus"
            :key="`list-mustahikStatus-${index}`"
            :label="item.name"
            :value="item.id"
          />
        </el-select>
      </el-form-item>
      <el-divider />
      <el-form-item class="tw-text-right">
        <el-button
          type="primary"
          @click="onSubmit(false)"
        >
          Terapkan Filter
        </el-button>
      </el-form-item>
    </el-form>

    <el-drawer
      v-model="innerDrawer"
      title="Hasil Pencarian"
      :append-to-body="true"
    >
      <ListAddPenerimaTambahan
        v-loading="loadingMusthaikList"
        :filters="filter"
        :filter-detail="filterDetail"
        :data="mustahikList"
        :on-search-name="onSubmit"
      />
    </el-drawer>
  </div>
</template>

<script>
import ListAddPenerimaTambahan from './ListAddPenerimaTambahan.vue'
import axios from 'axios'

export default {
  components: {
    ListAddPenerimaTambahan,
  },
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
  },
  data() {
    return {
      innerDrawer: false,
      loadingMusthaikList: false,
      filter: {
        rw_id: '', 
        rt_id: '',
        name: '',
        mustahik_status_id: '',
        mustahik_type_id: '',
      },
      filterDetail: {},
      mustahikList: [],
    }
  },
  computed: {
    rtList() {
      if (this.filter.rw_id) {
        const rw = this.rw.filter(el => el.id === parseInt(this.filter.rw_id))
        return rw[0].rt
      }
      return []
    },
    rw_id: {
      get() {
        return _.get(this.filter, 'rw_id') ? parseInt(_.get(this.filter, 'rw_id')) : ''
      },
      set(value) {
        this.filter['rw_id'] = value
        this.filterDetail['rw'] = this.rw.filter(el => el.id === value)[0]
        this.filter['rt_id'] = null
      },
    },
    rt_id: {
      get() {
        return _.get(this.filter, 'rt_id') ? parseInt(_.get(this.filter, 'rt_id')) : ''
      },
      set(value) {
        this.filter['rt_id'] = value
        this.filterDetail['rt'] = this.rtList.filter(el => el.id === value)[0]
      },
    },
    mustahik_type: {
      get() {
        return _.get(this.filter, 'mustahik_type_id') ? parseInt(_.get(this.filter, 'mustahik_type_id')) : ''
      },
      set(value) {
        this.filter['mustahik_type_id'] = value
        this.filterDetail['tipe'] = this.mustahikType.filter(el => el.id === value)[0]
      },
    },
    mustahik_status: {
      get() {
        return _.get(this.filter, 'mustahik_status_id') ? parseInt(_.get(this.filter, 'mustahik_status_id')) : ''
      },
      set(value) {
        this.filter['mustahik_status_id'] = value
        this.filterDetail['status'] = this.mustahikStatus.filter(el => el.id === value)[0]
      },
    },
  },
  methods: {
    onSubmit(data) {
      this.innerDrawer = true

      if (data) {
        this.filter.name = data
      } else {
        this.filter.name = ''
      }

      this.loadingMusthaikList = true
      axios.get('/api/backoffice/mustahik/search', {
        params: {
          'filter[name]': this.filter.name,
          'filter[rt_id]': this.filter.rt_id,
          'filter[rw_id]': this.filter.rw_id,
          'filter[mustahik_type_id]': this.filter.mustahik_type_id,
          'filter[mustahik_status_id]': this.filter.mustahik_status_id,
        },
      })
        .then(res => {
          this.mustahikList = res.data.data
          this.loadingMusthaikList = false
        })
    },
  },
}
</script>