<template>
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside
      :class="isSidebarCollapsed ? 'w-24' : 'w-64'"
      class="shadow-lg transition-all duration-300"
    >
      <TheSidebar
        :collapsed="isSidebarCollapsed"
        @toggleSidebar="toggleSidebar"
      />
    </aside>
    <!-- Main Content -->
    <main class="flex-1 overflow-auto bg-gray-100">
      <TheHeader :collapsed="isSidebarCollapsed" />
      <div id="content" class="flex flex-col gap-6 px-20">
        <router-view></router-view>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from "vue";
import TheHeader from "@/components/TheHeader.vue";
import TheSidebar from "@/components/TheSidebar.vue";

const isSidebarCollapsed = ref(false);

const toggleSidebar = () => {
  isSidebarCollapsed.value = !isSidebarCollapsed.value;
};
</script>

<style scope>
#content {
  height: calc(100vh - 4rem);
  padding-top: 6rem;
}
</style>
