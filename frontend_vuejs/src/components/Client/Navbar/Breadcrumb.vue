<template>
  <nav
    class="flex truncate rounded-md border border-zinc-900 bg-[#181818] px-3 py-2 text-gray-700 shadow-lg"
    aria-label="Breadcrumb"
  >
    <ol class="inline-flex flex-wrap items-center space-x-1 md:space-x-3">
      <li class="inline-flex items-center">
        <router-link
          title="Linhphim"
          :to="{ name: 'trangchu' }"
          class="inline-flex items-center whitespace-nowrap text-sm font-medium text-zinc-400 hover:text-red-500"
        >
          <i class="fa-solid fa-house mr-2 fa-xs"></i>
          Linhphim
        </router-link>
      </li>
      <li class="inline-flex items-center">
        <span
          class="inline-flex items-center whitespace-nowrap text-sm font-medium text-gray-200 hover:text-white"
        >
          <i class="fa-solid fa-chevron-right fa-xs mr-2"></i>
          {{ itemTitle }}
        </span>
      </li>
    </ol>
  </nav>
  <h1 class="py-2 text-center text-2xl font-normal uppercase text-gray-200 border-b border-gray-500">
    {{ itemTitle }}
  </h1>
</template>

<script setup>
import { useBreadcrumbStore } from "@/stores/breadcrumbStore";
import { ref, watch } from "vue";
import { useRoute } from "vue-router";

const breadcrumbStore = useBreadcrumbStore();
const route = useRoute();
const itemTitle = ref("");

watch(
  () => route.params.slug,
  (newSlug) => {
    if (!newSlug) {
      breadcrumbStore.clearItemTitle();
    }
    itemTitle.value = breadcrumbStore.itemTitle;
  },
);

itemTitle.value = breadcrumbStore.itemTitle;
</script>
