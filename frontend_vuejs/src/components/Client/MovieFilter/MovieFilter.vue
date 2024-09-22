<template>
  <div
    class="my-2 grid grid-cols-2 gap-4 text-white md:grid-cols-3 lg:grid-cols-4"
  >
    <div class="relative">
      <button
        @click="isOpenDropdown = !isOpenDropdown"
        class="flex w-full items-center justify-between text-nowrap rounded-md border-none bg-neutral-800 py-2 pl-4 pr-1 text-white"
      >
        {{ sortOptions[currentSort] }}
        <i class="fa-solid fa-chevron-down fa-2xs"></i>
      </button>
      <ul
        v-if="isOpenDropdown"
        class="absolute z-10 mt-2 w-full overflow-hidden rounded-md bg-neutral-800 shadow-lg"
      >
        <li
          v-for="(label, value) in sortOptions"
          :key="value"
          @click="handleSortChange(value)"
          class="cursor-pointer px-4 py-2 hover:bg-neutral-700"
        >
          {{ label }}
        </li>
      </ul>
    </div>
    <!-- Category -->
    <div>
      <select
        name=""
        class="w-full rounded-md border-none bg-neutral-800 px-4 py-2"
        v-model="filters.category_id"
      >
        <option class="max-w-full truncate" value="">Thể loại</option>
        <option
          class="max-w-full truncate"
          v-for="(title, id) in categories"
          :key="id"
          :value="id"
        >
          {{ title }}
        </option>
      </select>
    </div>
    <!-- Genre -->
    <div>
      <select
        name=""
        class="w-full rounded-md border-none bg-neutral-800 px-4 py-2"
        v-model="filters.genre_id"
      >
        <option class="max-w-full truncate" value="">Danh mục</option>
        <option
          class="max-w-full truncate"
          v-for="(title, id) in genres"
          :key="id"
          :value="id"
        >
          {{ title }}
        </option>
      </select>
    </div>
    <!-- Country -->
    <div>
      <select
        name=""
        class="w-full rounded-md border-none bg-neutral-800 px-4 py-2"
        v-model="filters.country_id"
      >
        <option class="max-w-full truncate" value="">Quốc gia</option>
        <option
          class="max-w-full truncate"
          v-for="(title, id) in countries"
          :value="id"
        >
          {{ title }}
        </option>
      </select>
    </div>
    <div>
      <fieldset class="h-full text-gray-100">
        <legend class="hidden">Search</legend>
        <input
          v-model="filters.keyword"
          type="search"
          placeholder="Từ Khóa..."
          class="h-full w-full rounded-md border-none bg-zinc-800 py-2 pl-4 text-sm text-gray-100 focus:bg-zinc-800 focus:outline-none"
        />
      </fieldset>
    </div>
  </div>
  <div class="mb-5 border-b border-gray-500 pb-2 pt-1 text-center">
    <button
      @click="movieFilter"
      type="button"
      class="mb-2 translate-y-1 rounded-full bg-red-800 px-6 py-3 text-sm font-medium text-white hover:opacity-90"
    >
      Tìm Kiếm
    </button>
  </div>
</template>
<script setup>
import { clientService } from "@/services/Client";
import { onMounted, reactive, ref } from "vue";

const isOpenDropdown = ref(false);

const currentSort = ref("update");

const sortOptions = {
  update: "Mới cập nhật",
  view: "Lượt xem cao nhất",
};

const handleSortChange = (value) => {
  currentSort.value = value;

  if (value === "update") {
    filters.update = true;
    filters.view = null;
  } else if (value === "view") {
    filters.view = true;
    filters.update = null;
  }

  isOpenDropdown.value = false;
};

// Filter
const emit = defineEmits(["update:movies"]);
const filters = reactive({
  update: null,
  view: null,
  year: null,
  category_id: "",
  genre_id: "",
  country_id: "",
  keyword: null,
});

const cleanFilters = (filters) => {
  return Object.fromEntries(
    Object.entries(filters).filter(([_, v]) => v !== null && v !== ""),
  );
};

const movieFilter = async () => {
  try {
    const response = await clientService.getMovieFilter(cleanFilters(filters));

    emit("update:movies", response.data);
  } catch (error) {
    console.error("Error:", error);
  }
};

// Filter option
const categories = ref({});
const genres = ref({});
const countries = ref({});

onMounted(async () => {
  try {
    const response = await clientService.getFilterOption();
    categories.value = response.data.categories;
    genres.value = response.data.genres;
    countries.value = response.data.countries;
  } catch (error) {
    console.error("Error:", error);
  }
});
</script>
<style scoped>
select {
  color: #fff;
}
</style>
