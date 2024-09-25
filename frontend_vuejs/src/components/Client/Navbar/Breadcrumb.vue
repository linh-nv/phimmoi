<template>
  <nav
    class="flex truncate rounded-md border border-zinc-900 bg-[#181818] px-3 py-2 text-gray-700 shadow-lg mb-5"
    aria-label="Breadcrumb"
  >
    <ol class="inline-flex flex-wrap items-center space-x-1 md:space-x-3">
      <li class="inline-flex items-center">
        <router-link
          title="Linhphim"
          :to="{ name: 'trangchu' }"
          class="inline-flex items-center whitespace-nowrap text-sm font-medium text-zinc-400 hover:text-red-500"
        >
          <i class="fa-solid fa-house fa-xs mr-2"></i>
          Linhphim
        </router-link>
      </li>
      <li class="inline-flex items-center">
        <span
          class="inline-flex items-center whitespace-nowrap text-sm font-medium text-gray-200 hover:text-white"
        >
          <i class="fa-solid fa-chevron-right fa-xs mr-2"></i>
          {{ title }}
        </span>
      </li>
    </ol>
  </nav>
</template>

<script setup>
import { useRoute } from "vue-router";
import { ref, watch } from "vue";

const route = useRoute();
const title = ref(route.query.title);

watch(route, (newRoute) => {
  title.value = newRoute.query.title;
});
</script>
