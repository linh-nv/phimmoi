<template>
  <div class="my-2 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 text-white">
    <div class="relative">
      <!-- Nút dropdown hiển thị tùy chọn hiện tại -->
      <button
        @click="isOpenDropdown = !isOpenDropdown"
        class="w-full rounded-md border-none bg-neutral-800 pl-4 pr-1 py-2 text-white text-nowrap flex items-center justify-between"
      >
        {{ sortOptions[currentSort] }}
        <i class="fa-solid fa-chevron-down fa-2xs"></i>
      </button>

      <!-- Danh sách các tùy chọn trong dropdown -->
      <ul
        v-if="isOpenDropdown"
        class="absolute z-10 mt-2 w-full rounded-md bg-neutral-800 shadow-lg overflow-hidden"
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
    <div>
      <select
        name=""
        class="w-full rounded-md border-none bg-neutral-800 px-4 py-2"
        v-model="filters.category_id"
      >
        <option value="">Thể loại</option>
        <option value="123" >Thể </option>
        <option v-for="[id, title] in categories" :key="id" :value="id">
          {{ title }}
        </option>
      </select>
    </div>
    <div>
      <select
        name=""
        class="w-full rounded-md border-none bg-neutral-800 px-4 py-2"
        v-model="filters.genre_id"
      >
        <option value="" disabled>Danh mục</option>
        <option v-for="[id, title] in genres" :key="id" :value="id">
          {{ title }}
        </option>
      </select>
    </div>
    <div>
      <select
        name=""
        class="w-full rounded-md border-none bg-neutral-800 px-4 py-2"
        v-model="filters.country_id"
      >
        <option value="" disabled>Quốc gia</option>
        <option v-for="[id, title] in countries" :key="id" :value="id">
          {{ title }}
        </option>
      </select>
    </div>
    <div>
      <fieldset class="h-full text-gray-100">
        <legend class="hidden">Search</legend>
        <input
          value=""
          type="search"
          placeholder="Từ Khóa..."
          class="h-full w-full rounded-md border-none bg-zinc-800 py-2 pl-4 text-sm text-gray-100 focus:bg-zinc-800 focus:outline-none"
        />
      </fieldset>
    </div>
  </div>
  <div class="mb-5 border-b border-gray-500 pb-2 pt-1 text-center">
    <button
      type="button"
      class="mb-2 translate-y-1 rounded-full bg-[#A3765D] px-5 py-2 text-sm font-medium text-gray-300 hover:opacity-90"
    >
      Tìm Kiếm
    </button>
  </div>
</template>
<script setup>
import { onMounted, reactive, ref } from "vue";

const isOpenDropdown = ref(false);

const currentSort = ref('update');

const sortOptions = {
  update: 'Mới cập nhật',
  view: 'Lượt xem cao nhất',
};

const handleSortChange = (value) => {
  currentSort.value = value;
  isOpenDropdown.value = false;
};

const filters = reactive({
  update: null,
  view: null,
  year: null,
  category_id: null,
  genre_id: null,
  country_id: null,
  keyword: null,
});

const categories = ref({});
const genres = ref({});
const countries = ref({});

// onMounted(async () => {
//   const response = await clientService.getHeader();
//   categories.value = response.data.categories;
//   genres.value = response.data.genres;
//   countries.value = response.data.countries;
// });
</script>
<style scoped>
select {
  color: #fff;
}
</style>