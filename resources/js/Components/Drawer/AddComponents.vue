<template>
  <el-scrollbar height="600px">
    <div class="tw-px-4 md:tw-px-16 lg:tw-px-16">
      <el-row :gutter="20">
        <el-col
          v-for="(data, index) in komponens"
          :key="`list-item-komponen-${index}`"
          :span="24"
        >
          <Link
            :href="data.to"
            method="get"
          >
            <el-card
              shadow="hover"
              class="tw-cursor-pointer"
            >
              <i :class="`icon-komponen ${data.icon}`" />
              {{ data.title }}
            </el-card>
          </Link>
        </el-col>
      </el-row>
    </div>
  </el-scrollbar>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
  components: {Link},
  data() {
    return {
      komponens: [
        {
          title: 'Zakat',
          icon: 'el-icon-notebook-2',
          to: '/backoffice/zakat/create',
        },
        {
          title: 'Satuan Zakat',
          icon: 'el-icon-set-up',
          to: '/backoffice/satuan-zakat/create',
        },
        {
          title: 'Tipe Mustahik',
          icon: 'el-icon-box',
          to: '/backoffice/mustahik-type/create',
        },
        {
          title: 'Status Mustahik',
          icon: 'el-icon-news',
          to: '/backoffice/mustahik-status/create',
        },
        {
          title: 'RW (Rukun Warga)',
          icon: 'el-icon-collection-tag',
          to: '/backoffice/rw-rt/create',
        },
        {
          title: 'Mustahik',
          icon: 'el-icon-coordinate',
          to: '/backoffice/mustahik/create',
        },
      ],
    }
  },
}
</script>

<style lang="scss" scoped>
.el-row {
    margin-bottom: 20px;

    &:last-child {
        margin-bottom: 0;
    }

    .el-col {
        margin-bottom: 20px;
    }
}

.icon-komponen {
    padding: 10px;
    background: #5865F2;
    border-radius: 50%;
    color: #fff;
    margin-right: 10px;
}
</style>
