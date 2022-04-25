<template>
  <div class="tw-mb-4">
    <h1 class="tw-text-3xl">
      {{ title }}
    </h1>
  </div>
</template>

<script>
export default {
  name: 'PageHeader',
  props: {
    title: {
      type: String,
      default: '',
    },
  },
}
</script>
