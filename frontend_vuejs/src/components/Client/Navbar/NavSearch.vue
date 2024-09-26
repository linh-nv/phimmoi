<template>
  <nav
    class="fixed right-0 top-0 z-50 flex h-screen w-full flex-col justify-start bg-black px-5 py-3 transition-transform duration-300 md:absolute md:-right-8 md:-top-full md:h-max md:min-h-96 md:w-[40vw] md:rounded-lg md:bg-[#000000ee] md:py-3 md:shadow-lg lg:w-[30vw] xl:w-[20vw]"
    :class="{
      'translate-x-full md:invisible': !isSearchOpen,
      'translate-x-0 md:visible': isSearchOpen,
    }"
  >
    <div class="flex w-full items-center gap-2">
      <button @click="$emit('closeSearch')" class="h-full px-4">
        <i class="fa-solid fa-angle-left fa-xl"></i>
      </button>
      <div class="flex w-full border border-white text-white">
        <input
          v-model="searchQuery"
          @input="onSearchInput"
          class="search-field w-full border-none bg-black"
          type="text"
          placeholder="Tên phim, diễn viên ...."
        />
        <button class="search-button px-4">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </div>
    </div>
    <div class="search-result mt-3">
      <router-link
        v-for="item in searchResults"
        :to="{
          name: 'phim',
          params: { slug: item.slug },
          query: { title: item.name },
        }"
        class="search__item flex gap-4 border-t border-gray-600 py-2"
      >
        <div class="item-image w-1/5">
          <img
            loading="lazy"
            :src="item.poster_url"
            alt="item_poster"
            class="object-contain"
          />
        </div>
        <div class="item-name">
          <strong>{{ item.name }}</strong>
          <p>{{ item.origin_name }}</p>
        </div>
      </router-link>
    </div>
  </nav>
</template>
<script setup>
import { clientService } from "@/services/Client";
import _ from "lodash";
import { ref } from "vue";
const props = defineProps({
  isSearchOpen: {
    type: Boolean,
    required: true,
  },
});

const searchQuery = ref("");
const searchResults = ref([]);
const search = _.debounce(async () => {
  if (!searchQuery.value) {
    searchResults.value = [];
    return;
  }

  const response = await clientService.search(searchQuery.value);

  searchResults.value = response.data;
}, 1000);

const onSearchInput = () => {
  search();
};
</script>
<style scoped>
.search-field {
  color: white;
}
</style>
