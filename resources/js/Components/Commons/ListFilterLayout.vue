<template>
  <div id="list-filter-layout">
    <div class="tw-block tw-w-full tw-justify-between tw-mb-2 md:tw-flex lg:tw-flex">
      <div class="tw-mb-2 md:tw-mb-0 lg:tw-mb-0">
        <slot name="search" />
      </div>
      <div class="tw-block md:tw-flex lg:tw-flex">
        <slot name="filter" />
      </div>
    </div>
  </div>
</template>

<script>
export default {
}
</script>