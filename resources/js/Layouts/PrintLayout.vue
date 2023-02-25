<template>
  <Head :title="title" />
  <div id="print-layout">
    <div class="book">
      <div class="page">
        <div class="subpage">
          <slot />
        </div>    
      </div>
    </div>
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

<style lang="scss" scoped>
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        font: 12pt "Tahoma";
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
    }
    .subpage {
        // padding: 1cm;
        height: 257mm;
        outline: 2cm #FFF solid;
    }
    
    @page {
        size: A3;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
</style>