<template>
  <div id="quick-recapt">
    <el-card
      shadow="always"
      class="tw-border-0"
    >
      <el-row
        :gutter="20"
      >
        <el-col
          :span="11"
        >
          <div v-if="satuan && pembagian.length">
            <div class="tw-mb-2 tw-flex tw-w-full tw-justify-between">
              <span>Pembagian</span> 
              <span>{{ satuan.name }}</span>
            </div>
            <el-scrollbar height="120px">
              <div class="tw-pr-4">
                <div
                  v-for="(item, index) in pembagian"
                  :key="`list-item-pembagian-${index}`"
                  class="list-content"
                >
                  <div>{{ item.name }}</div>
                  <div>{{ item.distribution }}</div>
                </div>
              </div>
            </el-scrollbar>
          </div>

          <el-empty
            v-else
            description="Belum ada data"
          />
        </el-col>
        <el-col :span="2">
          <el-divider
            direction="vertical"
            class="tw-h-full tw-opacity-60"
          />
        </el-col>
        <el-col :span="11">
          <div>
            Daftar Penerima
          </div>
          <div v-if="mustahik.length">
            <el-scrollbar>
              <div class="scrollbar-flex-content">
                <div
                  v-for="(item, index) in mustahik"
                  :key="`list-mustahik-${index}`"
                  class="scrollbar-demo-item tw-shadow-md tw-cursor-pointer"
                  @click="toDetailMustahik(item)"
                >
                  <div class="tw-capitalize tw-text-sm">
                    {{ item.name }}
                  </div>
                  <div class="tw-font-bold tw-text-2xl">
                    {{ item.count_mustahik_count }}
                  </div>
                </div>
              </div>
            </el-scrollbar>
          </div>

          <el-empty
            v-else
            description="Belum ada data"
          />
        </el-col>
      </el-row>
    </el-card>
  </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia'

export default {
  props: {
    mustahik: {
      type: Array,
      default: () => ([]),
    },
    pembagian: {
      type: Array,
      default: () => ([]),
    },
    satuan: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
    }
  },
  methods: {
    toDetailMustahik(data) {
      const filter = {
        filter: {
          mustahik_type_id: data.id,
        },
      }
      return Inertia.get('/backoffice/mustahik', filter, { replace: true })
    },
  },
}
</script>

<style lang="scss" scoped>
#quick-recapt {
    // text-align: center;

    .scrollbar-flex-content {
        display: flex;
    }
    .scrollbar-demo-item {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        margin: 10px;
        text-align: center;
        border-radius: 4px;
        flex-direction: column;
    }

    .list-content {
        display: flex;
        justify-content: space-between;
        width: 100%;
        padding: 0.5rem 0;
        border-top: 1px solid #eee;
    }
}
</style>