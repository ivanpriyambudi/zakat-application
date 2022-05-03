<template>
  <div id="drawer-print-section">
    <div class="tw-px-4 md:tw-px-16 lg:tw-px-16">
      <div class="tw-text-center tw-mb-8">
        <img
          src="/image/print.png"
          width="200"
          class="tw-m-auto"
        >
        <h1 class="tw-text-xl tw-font-semibold">
          Cetak rekap anda sekarang
        </h1>
        <p>
          Pastikan kertas anda ukuran A4
        </p>
      </div>
      <div>
        <a
          href="/backoffice/recapt/print"
          target="_BLANK"
        >
          <el-card
            shadow="hover"
            class="tw-cursor-pointer"
          >
            <el-row :gutter="20">
              <el-col :span="12">
                <span class="tw-font-semibold">Print Sekarang</span>
              </el-col>
              <el-col
                :span="12"
                class="tw-text-right"
              >
                <i class="el-icon-right" />
              </el-col>
            </el-row>
          </el-card>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {}
  },
  methods: {
    onPrint() {
    },
  },
}
</script>

<style lang="scss" scoped>
</style>