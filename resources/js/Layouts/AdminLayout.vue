<template>
  <Head :title="title" />
  <el-scrollbar
    :always="true"
    height="100%"
  >
    <el-container>
      <div
        class="tw-fixed tw-h-full tw-flex tw-z-10 tw-transition-all sm:tw-left-0"
        :class="{
          'tw-left-0': sidebarShow,
          'tw--left-96': sidebarHidden,
        }"
      >
        <!--          menu second-->
        <el-aside
          class="second-sidebar"
          width="auto"
          style="background-color: #5865f2"
        >
          <el-menu
            style="background-color: #5865f2"
            :collapse="true"
            class="tw-border-r-0"
          >
            <Link
              href="/backoffice/dashboard"
              method="get"
            >
              <el-menu-item index="1">
                <i class="el-icon-house tw-text-white" />
                <template #title>
                  Dashboard
                </template>
              </el-menu-item>
            </Link>
            <el-menu-item
              index="2"
              @click="drawer = true"
            >
              <i class="el-icon-plus tw-text-white" />
              <template #title>
                Tambah
              </template>
            </el-menu-item>
            <Link
              href="/backoffice/recapt"
              method="get"
            >
              <el-menu-item index="1">
                <i class="el-icon-document tw-text-white" />
                <template #title>
                  Rekap
                </template>
              </el-menu-item>
            </Link>
            <el-menu-item
              index="2"
              @click="drawerCetak = true"
            >
              <i class="el-icon-printer tw-text-white" />
              <template #title>
                Cetak
              </template>
            </el-menu-item>
          </el-menu>

          <el-menu
            style="background-color: #5865f2"
            :collapse="true"
            class="tw-border-r-0 tw-absolute tw-bottom-0"
          >
            <el-sub-menu index="1">
              <template #title>
                <i class="el-icon-setting tw-text-white" />
                <span>Setting</span>
              </template>
              <el-menu-item-group>
                <template #title>
                  <span>Setting</span>
                </template>
                <el-menu-item
                  v-for="(item, index) in years"
                  :key="index"
                  v-loading.fullscreen.lock="submitLoadingYear"
                  :index="`1-1-${index}`"
                  @click="switchYear(item)"
                >
                  {{ item.year }}
                  <span
                    v-if="item.is_active"
                    class="tw-text-primary"
                  >
                    Aktif
                  </span>
                </el-menu-item>
                <el-menu-item
                  index="1-2"
                  @click="handleAddYear()"
                >
                  Tambah Tahun
                </el-menu-item>
                <el-menu-item
                  index="1-2"
                  @click="logout()"
                >
                  Keluar
                </el-menu-item>
              </el-menu-item-group>
            </el-sub-menu>
          </el-menu>
        </el-aside>
        <!--          menu primary-->
        <el-aside
          class="first-sidebar"
          width="180px"
          style="background-color: #5865f2"
        >
          <el-menu
            text-color="#fff"
            active-text-color="#fff"
            class="tw-border-r-0"
            style="background-color: #5865f2"
            :default-active="`${getSelectedKey}`"
          >
            <template
              v-for="(data, index) in menuUsed"
              :key="`list-menus-${index}`"
            >
              <Link
                v-if="data.children.length === 0"
                :href="data.to"
                method="get"
              >
                <el-menu-item :index="`${index}`">
                  <i :class="data.icon" />
                  <span>{{ data.title }}</span>
                </el-menu-item>
              </Link>
              <el-sub-menu
                v-else
                :index="`${index}`"
              >
                <template #title>
                  <i :class="data.icon" />{{ data.title }}
                </template>
                <el-menu-item-group>
                  <Link
                    v-for="(
                      childMenu, indexs
                    ) in data.children"
                    :key="`list-child-menu-${indexs}`"
                    :href="childMenu.to"
                    method="get"
                  >
                    <el-menu-item index="1-1">
                      {{ childMenu.title }}
                    </el-menu-item>
                  </Link>
                </el-menu-item-group>
              </el-sub-menu>
            </template>
          </el-menu>
        </el-aside>
      </div>
      <div
        class="sidebar-overlay"
        :class="{ 'tw-block': sidebarShow, 'tw-hidden': sidebarHidden }"
        @click="closeSidebar()"
      />
      <el-container class="md:tw-pl-60 sm:tw-pl-60">
        <el-header
          class="tw-bg-primary tw-block sm:tw-hidden header-nav"
        >
          <el-button
            icon="el-icon-menu"
            class="menu-navbar"
            circle
            @click="openSidebar()"
          />
          <div class="title-header">
            Zakat Application
          </div>
        </el-header>

        <el-main>
          <PageHeader :title="title" />
          <Breadcumb :breadcumb="breadcumb" />
          <div class="tw-mt-8">
            <slot />
          </div>
        </el-main>
      </el-container>
    </el-container>
  </el-scrollbar>

  <el-drawer
    v-model="drawer"
    title="Tambah Komponen"
    :with-header="true"
    direction="ltr"
  >
    <AddComponents />
  </el-drawer>

  <el-drawer
    v-model="drawerCetak"
    :with-header="true"
    direction="ltr"
  >
    <PrintSection />
  </el-drawer>

  <el-dialog
    v-model="showFormYear"
    title="Tambahan Tahun"
    width="30%"
  >
    <YearForm
      :rule-form="ruleForm"
      :method="'POST'"
      :url="`/year`"
      :loading="submitLoading"
      @success="() => showFormYear = false"
    />
  </el-dialog>
</template>

<script>
import menusJson from '../Components/menus.json'
import Breadcumb from '../Components/Commons/Breadcumb'
import PageHeader from '../Components/Commons/PageHeader'
import { Head } from '@inertiajs/inertia-vue3'
import AddComponents from '../Components/Drawer/AddComponents'
import PrintSection from '../Components/Drawer/PrintSection'
import { Inertia } from '@inertiajs/inertia'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import print from 'vue3-print-nb'
import YearForm from '../Components/Year/Form.vue'

export default {
  components: {
    AddComponents,
    Breadcumb,
    PageHeader,
    YearForm,

    Head,
    Link,
    PrintSection,
  },
  directives: {
    print,
  },
  // eslint-disable-next-line vue/require-prop-types
  props: ['title', 'breadcumb'],
  data() {
    return {
      menus: menusJson,
      drawer: false,
      drawerCetak: false,
      sidebarShow: false,
      sidebarHidden: true,
      isLoadingYears: false,
      submitLoadingYear: false,
      submitLoading: false,
      years: [],
      showFormYear: false,
      ruleForm: {
        year: '',
      },
    }
  },
  computed: {
    getSelectedKey() {
      let b = this.menus.findIndex((x) =>
        usePage().url.value.includes(x.to),
      )
      return b
    },
    activeYear() {
      return this.years.find((el) => el.is_active)
    },
    menuUsed() {
      return this.menus.map((el) => {
        if (el.name === 'zakat') {
          return {
            ...el,
            to: `/backoffice/zakat?filter[year]=${this.activeYear ? this.activeYear.year : ''}`,
          }
        }

        return el
      })
    },
  },
  mounted() {
    this.getYears()
  },
  methods: {
    openSidebar() {
      this.sidebarShow = true
      this.sidebarHidden = false
    },
    closeSidebar() {
      this.sidebarShow = false
      this.sidebarHidden = true
    },
    logout() {
      Inertia.post(`${window.baseUrl}/logout`, {
        token: this.$page.props.csrf_token,
      })
    },
    getYears() {
      this.isLoadingYears = true
      axios.get('/api/backoffice/years').then((res) => {
        this.years = res.data
        this.isLoadingYears = false
      })
    },
    switchYear(year) {
      Inertia.visit(`${window.baseUrl}/switch-year`, {
        method: 'POST',
        data: {
          yearId: year.id,
        },
        onStart: () => (this.submitLoadingYear = true),
        onFinish: () => (this.submitLoadingYear = false),
        onSuccess: () =>
        {
          this.$notify({
            title: 'Sukses',
            message: 'Berhasil mengubah tahun aktif.',
            type: 'success',
          })
          this.years = this.years.map((el) => {
            if (el.id === year.id) {
              return {
                ...el,
                is_active: true,
              }
            }

            return {
              ...el,
              is_active: false,
            }
          })
        },
        onError: () =>
          this.$notify.error({
            title: 'Gagal',
            message: 'Gagal mengubah tahun aktif.',
            type: 'error',
          }),
      })
    },
    handleAddYear() {
      this.showFormYear = true
    },
  },
}
</script>

<style lang="scss" scoped>
@import "/assets/layout/admin";
</style>
