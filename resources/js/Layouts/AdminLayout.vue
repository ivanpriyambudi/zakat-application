<template>
  <Head :title="title" />
  <el-scrollbar
    :always="true"
    height="100%"
  >
    <el-container>
      <div
        class="tw-fixed tw-h-full tw-flex tw-z-10 tw-transition-all sm:tw-left-0"
        :class="{'tw-left-0': sidebarShow, 'tw--left-96': sidebarHidden}"
      >
        <!--          menu second-->
        <el-aside
          class="second-sidebar"
          width="auto"
          style="background-color: #5865F2"
        >
          <el-menu
            style="background-color: #5865F2"
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
            style="background-color: #5865F2"
            :collapse="true"
            class="tw-border-r-0 tw-absolute tw-bottom-0"
          >
            <el-sub-menu index="1">
              <template #title>
                <i class="el-icon-setting tw-text-white" />
                <span>Setting Akun</span>
              </template>
              <el-menu-item-group>
                <template #title>
                  <span>Setting Akun</span>
                </template>
                <el-menu-item index="1-1">
                  Tahun (2022)
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
          style="background-color: #5865F2"
        >
          <el-menu
            text-color="#fff"
            active-text-color="#fff"
            class="tw-border-r-0"
            style="background-color: #5865F2"
            :default-active="`${getSelectedKey}`"
          >
            <template
              v-for="(data, index) in menus"
              :key="`list-menus-${index}`"
            >
              <Link
                v-if="data.children.length === 0"
                :href="data.to"
                method="get"
              >
                <el-menu-item
                  :index="`${index}`"
                >
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
                    v-for="(childMenu, indexs) in data.children"
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
        :class="{'tw-block': sidebarShow, 'tw-hidden': sidebarHidden}"
        @click="closeSidebar()"
      />
      <el-container class="md:tw-pl-60 sm:tw-pl-60">
        <el-header class="tw-bg-primary tw-block sm:tw-hidden">
          <el-button
            icon="el-icon-menu"
            circle
            @click="openSidebar()"
          />
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
</template>

<script>
import menusJson from '../Components/menus.json'
import Breadcumb from '../Components/Commons/Breadcumb'
import PageHeader from '../Components/Commons/PageHeader'
import {Head} from '@inertiajs/inertia-vue3'
import AddComponents from '../Components/Drawer/AddComponents'
import PrintSection from '../Components/Drawer/PrintSection'
import {Inertia} from '@inertiajs/inertia'
import { Link, usePage } from '@inertiajs/inertia-vue3'
import print from 'vue3-print-nb'

export default {
  components: { 
    AddComponents, 
    Breadcumb, 
    PageHeader,
    
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
    }
  },
  computed: {
    getSelectedKey() {
      let b = this.menus.findIndex(x => usePage().url.value.includes(x.to))
      return b
    },
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
  },
}
</script>

<style lang="scss" scoped>
@import '/assets/layout/admin';
</style>
