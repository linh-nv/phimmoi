<template>
  <header
    class="fixed top-0 z-50 flex h-12 w-full items-center justify-between border-b border-b-gray-500 bg-[#111111E6] p-4 text-white"
  >
    <div class="top-bar-left flex items-center gap-2">
      <!-- Button Menu -->
      <button @click="isNavOpen = true" class="button-menu py-2 pr-2">
        <i class="fa-solid fa-bars-staggered"></i>
      </button>
      <!-- Logo -->
      <router-link :to="{ name: 'trangchu' }" class="logo h-full">
        <img
          class="h-[20px] object-contain"
          src="https://cdn.imgbin.com/5/1/12/imgbin-graphics-logo-netflix-television-macbeth-2015-netflix-kPXbSVnavRXtmVvYLe7VMZHPk.jpg"
          alt="Logo"
        />
      </router-link>

      <!-- Navigation Menu -->
      <NavMenu 
        :isNavOpen="isNavOpen"
        @closeNav="isNavOpen = false"
      />
    </div>

    <!-- Right Side -->
    <div class="top-bar-right">
      <button @click="isSearchOpen = true" class="button-search px-3">
        <i class="fa-solid fa-magnifying-glass"></i>
      </button>
      <NavSearch
        :isSearchOpen="isSearchOpen"
        @closeSearch="isSearchOpen = false"
      />

      <button class="button-user pl-3">
        <i class="fa-solid fa-user"></i>
      </button>
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import NavMenu from "./Navbar/NavMenu.vue";
import NavSearch from "./Navbar/NavSearch.vue";

const isNavOpen = ref(false);
const isSearchOpen = ref(false);
</script>
