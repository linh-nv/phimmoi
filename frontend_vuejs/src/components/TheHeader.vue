<template>
  <header
    class="fixed right-0 top-0 z-50 flex w-full flex-1 items-center justify-between border-b border-b-gray-200 bg-white px-8 py-4"
  >
    <div class="flex">
      <!-- Logo -->
      <div class="flex items-center justify-center bg-transparent text-red-500">
        <h1>LINHFLIX</h1>
      </div>
    </div>
    <div class="flex items-center">
      <!-- Search box -->
      <div class="search-box relative mx-8">
        <i
          class="fa-solid fa-magnifying-glass absolute left-0 top-0 flex h-full cursor-pointer items-center p-4 text-gray-500"
        ></i>
        <input
          class="w-96 rounded-3xl border border-gray-200 bg-gray-100 px-12 py-2 outline-none placeholder:text-gray-500"
          type="text"
          placeholder="Search"
        />
      </div>
      <!-- Avatar -->
      <div class="flex cursor-pointer items-center gap-2">
        <span class="ml-2">Moni Roy</span>
        <div
          class="flex aspect-square h-5 w-5 items-center justify-center rounded-[50%] border border-gray-400"
        >
          <i
            class="fa-solid fa-chevron-down flex aspect-square items-center justify-center text-xs"
          ></i>
        </div>
      </div>
    </div>
  </header>
</template>
<script setup>
const props = defineProps({
  collapsed: Boolean,
});
</script>
<style scope></style>
