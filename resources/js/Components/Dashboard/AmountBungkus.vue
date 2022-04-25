<template>
  <div id="amount-bungkus">
    <el-row
      class="contain"
      :gutter="20"
    >
      <el-col
        :xs="12"
        :sm="8"
        :md="8"
        :lg="8"
        :xl="8"
      />
      <el-col
        :xs="12"
        :sm="16"
        :md="16"
        :lg="16"
        :xl="9"
      >
        <div
          v-loading="isLoading"
          element-loading-background="transparent"
          class="amount"
        >
          {{ countZakat }} <span class="title">Bungkus</span>
        </div>
      </el-col>
      <el-col
        :xs="12"
        :sm="8"
        :md="8"
        :lg="8"
        :xl="7"
      />
    </el-row>
    <!-- <div class="amount">
      1000
    </div> -->
  </div>
</template>

<script>
export default {
  props: {
    countZakat: {
      type: Number,
      default: 0,
    },
    isLoading: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style lang="scss" scoped>
#amount-bungkus {
    background-image: url('/image/zakat-3d.webp');
    height: 300px;
    background-repeat: no-repeat;
    background-size: contain;
    cursor: pointer;

    @media only screen and (max-width: 600px) {
        height: 400px;
    }

    .contain {
        top: 39%;
    }

    .amount {
        text-align: center;
        font-size: 2rem;
        color: #ffffff;
        text-shadow: 0px 0px 0 rgb(232,232,232),
                    0px 1px 0 rgb(208,208,208),
                    0px 2px  0 rgb(185,185,185),
                    0px 3px 2px rgba(0,0,0,0),
                    0px 3px 1px rgba(0,0,0,0.2),
                    0px 0px 2px rgba(0,0,0,.2);

        .title {
            font-size: 0.8rem;
            font-weight: 400;
            display: block;
            top: -5px;
            position: relative;
            left: 20px;
            text-shadow: none;
            color: #0000008a;
        }
    }
}
</style>