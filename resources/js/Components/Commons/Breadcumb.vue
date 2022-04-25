<template>
  <el-breadcrumb separator-class="el-icon-arrow-right">
    <el-breadcrumb-item
      v-for="(data, index) in breadcumb"
      :key="`list-breadcumb-${index}`"
      :to="{ path: `${data.to}` }"
    >
      <Link
        :href="data.to"
        method="get"
      >
        {{ data.title }}
      </Link>
    </el-breadcrumb-item>
  </el-breadcrumb>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
  name: 'Breadcumb',
  components: {Link},
  props: {
    breadcumb: {
      type: Object,
      default: () => ({}),
    },
  },
}
</script>
