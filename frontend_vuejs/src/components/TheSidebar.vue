<template>
  <nav
    :class="collapsed ? 'w-24' : 'w-64'"
    class="relative h-full pt-24 transition-all duration-300"
  >
    <!-- Menu btn -->
    <button
      @click="$emit('toggleSidebar')"
      class="absolute -right-12 top-24 aspect-square rounded-br-[50%] rounded-tr-[50%] bg-white p-4"
    >
      <i
        :class="collapsed ? 'fa-solid fa-left-right' : 'fa-solid fa-bars'"
        class="fa-xl flex cursor-pointer items-center text-gray-600"
      ></i>
    </button>
    <!-- Navigation items -->
    <ul class="flex flex-col items-center justify-center">
      <li
        v-for="item in menuItems"
        :key="item.name"
        :class="[
          'relative flex w-full pr-4',
          item.isActive ? 'text-white' : 'bg-white text-gray-700',
        ]"
        @click="selectItem(item)"
      >
        <router-link
          :to="item.link"
          class="ml-4 flex w-full flex-1 items-center gap-8 rounded-lg px-6 py-4"
          :class="item.isActive ? 'bg-blue-500' : 'hover:bg-blue-50'"
        >
          <i :class="item.icon"></i>
          <span v-if="!collapsed">
            {{ item.name }}
          </span>
          <span
            v-if="item.isActive"
            class="absolute bottom-0 left-0 top-0 w-1 rounded-r-lg bg-blue-700"
          ></span>
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  collapsed: Boolean,
});

const menuItems = ref([
  {
    name: "Dashboard",
    icon: "fa-solid fa-house",
    link: "/",
    isActive: true,
  },
  {
    name: "Movies",
    icon: "fa-solid fa-film",
    link: "/movies",
    isActive: false,
  },
  {
    name: "Episodes",
    icon: "fa-solid fa-video",
    link: "/episodes",
    isActive: false,
  },
  {
    name: "Categories",
    icon: "fa-solid fa-layer-group",
    link: "/categories",
    isActive: false,
  },
  {
    name: "Genres",
    icon: "fa-solid fa-list",
    link: "/genres",
    isActive: false,
  },
  {
    name: "Countries",
    icon: "fa-solid fa-globe",
    link: "/countries",
    isActive: false,
  },
]);

const selectItem = (selectedItem) => {
  menuItems.value.forEach((item) => {
    item.isActive = item === selectedItem;
  });
};
</script>
