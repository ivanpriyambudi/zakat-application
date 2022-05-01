<template>
  <div
    id="pagination"
    class="tw-mt-6 tw-text-right"
  >
    <el-pagination
      background
      layout="prev, pager, next"
      :page-count="meta.last_page"
      :default-current-page="meta.current_page"
      @prev-click="prev"
      @next-click="next"
      @current-change="change"
    />
  </div>
</template>

<script>
export default {
  props: {
    meta: {
      type: Object,
      default: () => ({}),
    },
    onChange: {
      type: Function,
      default: () => ({}),
    },
  },
  methods: {
    next() {
      return this.onChange(this.meta.current_page + 1)
    },
    prev() {
      return this.onChange(this.meta.current_page - 1)
    },
    change(data) {
      return this.onChange(data)
    },
  },
}
</script>