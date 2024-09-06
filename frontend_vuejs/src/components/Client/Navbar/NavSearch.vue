<template>
  <nav
    class="fixed right-0 top-0 h-full w-full transition-transform duration-300"
    :class="{
      'translate-x-full': !isSearchOpen,
      'translate-x-0': isSearchOpen,
    }"
  >
    <div class="nav__wrap flex h-full w-full gap-2 bg-black px-5 py-2">
      <button @click="$emit('closeSearch')" class="py-2 pl-2">
        <i class="fa-solid fa-angle-left fa-xl"></i>
      </button>
      <div class="flex">
        <input class="search-field" type="text" />
        <button class="search-button">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </div>
    </div>
  </nav>
</template>
<script setup>
const props = defineProps({
  isSearchOpen: {
    type: Boolean,
    required: true,
  },
});
</script>
