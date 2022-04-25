<template>
  <div
    id="pagination"
    class="tw-mt-6 tw-text-right"
  >
    <el-pagination
      background
      layout="prev, pager, next"
      :page-count="lastPage"
      :default-current-page="currentPage"
      @prev-click="prev"
      @next-click="next"
      @current-change="change"
    />
  </div>
</template>

<script>
import { usePage } from '@inertiajs/inertia-vue3'
import { getQueryParams } from './utils'
import {Inertia} from '@inertiajs/inertia'

export default {
  props: {
    meta: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    const query = getQueryParams(window.location.search)

    return {
      currentQuery: query,
      currentPage: this.meta.current_page,
      lastPage: this.meta.last_page,
      url: usePage().url.value.split('?'),
    }
  },
  computed: {
    currentUrl() {
      return this.url[0]
    },
    query() {
      return this.url[1]
    },
  },
  methods: {
    next() {
      return Inertia.get(this.currentUrl, { ...this.currentQuery, 'page': this.currentPage + 1 }, { replace: true })
    },
    prev() {
      return Inertia.get(this.currentUrl, { ...this.currentQuery, 'page': this.currentPage - 1 }, { replace: true })
    },
    change(data) {
      return Inertia.get(this.currentUrl, { ...this.currentQuery, 'page': data }, { replace: true })
    },
  },
}
</script>