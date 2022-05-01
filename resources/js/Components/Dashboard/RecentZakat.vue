<template>
  <div id="recent-zakat">
    <el-card
      shadow="never"
      class="tw-border-0 tw-mb-8"
    >
      <template #header>
        <div class="card-header">
          <span>Zakat Terkini</span>
        </div>
      </template>
      <div class="line-section">
        <el-timeline v-if="dataAll.length">
          <el-timeline-item
            v-for="(item, index) in dataAll"
            :key="`list-recent-all-zakat-${index}`"
            :type="item.type === 'Fitrah' ? 'primary' : 'success'"
            :hollow="true"
            :timestamp="`Oleh ${item.people.name} (RT${item.people.rt.name}/RW${item.people.rw.name})`"
          >
            {{ `${item.type === 'Fitrah' ? 'Zakat Fitrah' : item.type} ${item.amount} ${item.amount_type.name}` }}
          </el-timeline-item>
        </el-timeline>

        <el-empty
          v-else
          description="Belum ada data"
        />
      </div>

      <!-- <el-divider />

      <div class="line-section">
        <div class="title">
          Perangkat Ini
        </div>
        <el-timeline>
          <el-timeline-item
            v-for="(activity, index) in activities"
            :key="index"
            :type="activity.type"
            :color="activity.color"
            :size="activity.size"
            :hollow="activity.hollow"
            :timestamp="activity.timestamp"
          >
            {{ activity.content }}
          </el-timeline-item>
        </el-timeline>
      </div> -->
    </el-card>
  </div>
</template>

<script>
export default {
  props: {
    dataAll: {
      type: Array,
      default: () => ([]),
    },
  },
  data() {
    return {
      activities: [
        {
          content: 'Custom color',
          timestamp: '2018-04-03 20:46',
          color: '#0bbd87',
        },
        {
          content: 'Custom size',
          timestamp: '2018-04-03 20:46',
          size: 'large',
        },
        {
          content: 'Custom hollow',
          timestamp: '2018-04-03 20:46',
          type: 'primary',
          hollow: true,
        },
        {
          content: 'Default node',
          timestamp: '2018-04-03 20:46',
        },
      ],
    }
  },
}
</script>

<style lang="scss" scoped>
#recent-zakat {
    .title {
        margin-bottom: 1rem;
    }
}
</style>
