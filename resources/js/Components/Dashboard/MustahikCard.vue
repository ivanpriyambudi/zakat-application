<template>
  <div id="mustahik-card">
    <el-card
      shadow="always"
      class="tw-border-0"
    >
      <template #header>
        <div class="card-header">
          <span>Mustahik</span>
          
          <el-dropdown>
            <el-button
              size="small"
            >
              All RW <i class="el-icon-arrow-down tw-text-dark" />
            </el-button>
            <template #dropdown>
              <el-dropdown-menu>
                <el-dropdown-item
                  v-for="(item, index) in rw.data"
                  :key="`item-rw-${index}`"
                >
                  RW {{ item.name }}
                </el-dropdown-item>
              </el-dropdown-menu>
            </template>
          </el-dropdown>
        </div>
      </template>

      <div v-if="filterMustahikRw">
        <el-tabs
          v-model="filterMustahikRt"
          class="demo-tabs"
          @tab-click="onFilterMustahikRt"
        >
          <el-tab-pane
            label="User"
            name="first"
          >
            User
          </el-tab-pane>
        </el-tabs>
      </div>
      <div v-else>
        <el-row
          :gutter="20"
          class="tw-items-center"
        >
          <el-col :span="6">
            <el-avatar
              :size="60"
            >
              <i class="el-icon-coordinate tw-text-white" />
            </el-avatar>
          </el-col>
          <el-col :span="12">
            <h2 class="tw-text-5xl">
              {{ countAllMustahik }}
            </h2>
          </el-col>
          <el-col
            :span="6"
            class="tw-text-right"
          >
            <el-button
              size="small"
              type="primary"
              class="tw-w-full"
            >
              Lihat
            </el-button>
          </el-col>
        </el-row>
      </div>
    </el-card>
  </div>
</template>

<script>
export default {
  props: {
    rw: {
      type: Object,
      default: () => ({}),
    },
    countAllMustahik: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      filterMustahikRt: 'first',
      filterMustahikRw: '',
    }
  },
}
</script>

<style lang="scss" scoped>
.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
</style>