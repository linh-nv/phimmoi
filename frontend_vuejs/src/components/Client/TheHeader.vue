<template>
  <header
    class="container fixed top-0 z-50 flex h-16 w-full items-center justify-between border-b border-b-gray-500 bg-[#111111E6] px-4 text-white md:px-8"
  >
    <div class="top-bar-left flex h-full items-center gap-2">
      <!-- Button Menu -->
      <button @click="isNavOpen = true" class="button-menu py-2 pr-2 md:hidden">
        <i class="fa-solid fa-bars-staggered"></i>
      </button>
      <!-- Logo -->
      <router-link :to="{ name: 'trangchu' }" class="logo h-full">
        <img
          class="h-full object-contain"
          src="/src/assets/images/netflix-logo.png"
          alt="Logo"
        />
      </router-link>

      <!-- Navigation Menu -->
      <NavMenu :isNavOpen="isNavOpen" @closeNav="isNavOpen = false" />
    </div>

    <!-- Right Side -->
    <div class="top-bar-right relative flex">
      <div class="mobile-search">
        <button @click="isSearchOpen = true" class="button-search px-3">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        <NavSearch
          :isSearchOpen="isSearchOpen"
          @closeSearch="isSearchOpen = false"
        />
      </div>
      <!-- Logged button -->
      <button
        v-if="user"
        @click="toggleMenu"
        class="button-user relative aspect-square h-7 w-7 rounded-full bg-neutral-500 capitalize"
      >
        {{ user.name.charAt(0) }}

        <!-- User Menu -->
        <transition name="fade">
          <div
            v-show="isMenuOpen"
            class="user-menu absolute right-0 top-full mt-2 flex flex-col rounded-lg bg-neutral-800 pb-2 text-left shadow-sm shadow-neutral-800"
          >
            <div class="user-name border-b border-neutral-600 px-4 py-2">
              <strong>{{ user.name }}</strong>
            </div>
            <ul class="flex flex-col text-sm">
              <li class="text-nowrap px-4 py-2 hover:bg-neutral-700">
                Thông tin
              </li>
              <li class="text-nowrap px-4 py-2 hover:bg-neutral-700">
                Tủ phim
              </li>
              <li class="text-nowrap px-4 py-2 hover:bg-neutral-700">
                Đổi mật khẩu
              </li>
              <li class="text-nowrap px-4 py-2 hover:bg-neutral-700">
                Đăng xuất
              </li>
            </ul>
          </div>
        </transition>
      </button>

      <!-- Unlogged button -->
      <button v-else @click="isAuthOpen = true" class="button-user pl-3">
        <i class="fa-solid fa-user"></i>
      </button>
      <NavAuth :isAuthOpen="isAuthOpen" @closeAuth="isAuthOpen = false" />
    </div>
  </header>
</template>

<script setup>
import { ref } from "vue";
import NavMenu from "./Navbar/NavMenu.vue";
import NavSearch from "./Navbar/NavSearch.vue";
import NavAuth from "./Navbar/NavAuth.vue";
import { useClientStore } from "@/stores/clientStore";

const clientStore = useClientStore();

const isNavOpen = ref(false);
const isSearchOpen = ref(false);
const isAuthOpen = ref(false);
const isMenuOpen = ref(false);

const user = clientStore.getClient ?? null;

const toggleMenu = () => {
  isMenuOpen.value = !isMenuOpen.value;
};
</script>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
