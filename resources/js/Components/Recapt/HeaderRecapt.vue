<template>
  <div id="header-recapt">
    <el-row :gutter="20">
      <el-col
        :xs="24"
        :sm="24"
        :md="12"
        :lg="12"
        :xl="12"
      >
        <el-card shadow="never">
          <el-row :gutter="20">
            <el-col
              :span="10"
              class="tw-text-center"
            >
              <div class="tw-mb-2">
                Zakat
              </div>
              <div class="tw-text-3xl tw-font-semibold">
                {{ totalZakat }}
              </div>
            </el-col>
            <el-col :span="2">
              <el-divider
                direction="vertical"
                class="tw-h-full tw-opacity-60"
              />
            </el-col>
            <el-col
              :span="10"
              class="tw-text-center"
            >
              <div class="tw-mb-2">
                Donasi
              </div>
              <div class="tw-text-3xl tw-font-semibold">
                {{ totalDonasi }}
              </div>
            </el-col>
          </el-row>
          <el-divider class="tw-mb-4" />
          <div class="tw-text-center">
            Total: <span class="tw-font-bold">{{ totalMasuk }}</span> {{ satuan.name }} ({{ satuan.kilo * totalMasuk }} Kg)
          </div>
          <el-divider class="tw-mb-4" />
          <div class="tw-text-center">
            Kebutuhan: <span class="tw-font-bold">{{ totalKebutuhan }}</span> {{ satuan.name }} ({{ satuan.kilo * totalKebutuhan }} Kg)
          </div>
        </el-card>
      </el-col>
      <el-col
        :span="12"
        class="illustration-section"
      >
        <img
          class="img-illustration"
          :src="illustration"
        >

        <el-card
          class="data-illustration tw-border-0"
          shadow="never"
        >
          <div class="content-min-plus">
            <div class="tw-font-bold">
              Kurang: {{ 0 > totalKurang ? totalKurang : 0 }}
            </div>
            <div class="tw-font-bold">
              Lebih: {{ totalKurang > 0 ? totalKurang : 0 }}
            </div>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>

<script>
export default {
  props: {
    satuan: {
      type: Object,
      default: () => ({}),
    },
    zakat: {
      type: Array,
      default: () => ([]),
    },
    tambahan: {
      type: Array,
      default: () => ([]),
    },
    amil: {
      type: Object,
      default: () => ({}),
    },
  },
  computed: {
    totalKebutuhanAmil() {
      if (this.amil) {
        return this.amil.amount * this.amil.distribution
      }
      return 0
    },
    totalZakat() {
      if (this.zakat.length) {
        return this.zakat.reduce((accumulator, object) => {
          return accumulator + object.amount
        }, 0)
      }
      return 0
    },
    totalDonasi() {
      if (this.zakat.length) {
        return this.zakat.reduce((accumulator, object) => {
          return accumulator + object.donasi
        }, 0)
      }
      return 0
    },
    totalMasuk() {
      return this.totalZakat + this.totalDonasi
    },
    totalKebutuhanZakat() {
      if (this.zakat.length) {
        return this.zakat.reduce((accumulator, object) => {
          return accumulator + object.kebutuhan
        }, 0)
      }
      return 0
    },
    totalKebutuhanTambahan() {
      if (this.tambahan.length) {
        return this.tambahan.reduce((accumulator, object) => {
          return accumulator + object.distribution
        }, 0)
      }
      return 0
    },
    totalKebutuhan() {
      return this.totalKebutuhanZakat + this.totalKebutuhanAmil + this.totalKebutuhanTambahan
    },
    totalKurang() {
      return this.totalMasuk - this.totalKebutuhan
    },
    illustration() {
      if (this.totalMasuk > this.totalKebutuhan) {
        return '/image/illustration-lebih.png'
      }

      if (this.totalMasuk < this.totalKebutuhan) {
        return '/image/illustration-kurang.png'
      }

      return '/image/illustration-pass.png'
    },
  },
}
</script>

<style lang="scss" scoped>
#header-recapt {
  .illustration-section {
    display: flex;
    flex-direction: column-reverse;

    @media only screen and (max-width: 600px) {
      display: contents;     
    }

    .img-illustration {
      width: 400px;
      position: absolute;
      top: -8rem;

      @media only screen and (max-width: 600px) {
        display: none !important;
      }
    }

    .data-illustration {
      width: 100%;

      .content-min-plus {
        display: flex;
        justify-content: space-between;
      }
    }
  }
}
</style>