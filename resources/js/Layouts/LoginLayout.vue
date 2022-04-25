<template>
  <Head :title="title" />
  <div id="login-layout">
    <el-row
      class="tw-mt-10"
    >
      <el-col
        :xs="1"
        :sm="6"
        :md="6"
        :lg="9"
        :xl="9"
      />
      <el-col
        :xs="23"
        :sm="12"
        :md="12"
        :lg="6"
        :xl="6"
      >
        <slot />
      </el-col>
      <el-col
        :xs="1"
        :sm="6"
        :md="6"
        :lg="9"
        :xl="9"
      />
    </el-row>
  </div>
</template>

<script>
import {Head} from '@inertiajs/inertia-vue3'

export default {
  components: {Head},
  props: {
    title: {
      type: String,
      default: '',
    },
  },
}
</script>
