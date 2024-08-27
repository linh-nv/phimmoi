<template>
  <section class="head flex items-center justify-between">
    <h1>List Genres</h1>
    <router-link
      :to="{ name: 'genre-create', query: { page: currentPage } }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
    >
      <i class="fa-solid fa-circle-plus"></i>
      <span>New genre</span>
    </router-link>
  </section>
  <div class="line border border-gray-200"></div>
  <section class="table">
    <table class="w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th class="long-space">Title</th>
          <th class="long-space">Slug</th>
          <th>Description</th>
          <th>Status</th>
          <th class="long-space">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="genre in genres" :key="genre.id">
          <td>{{ genre.id }}</td>
          <td class="long-space truncate">{{ genre.title }}</td>
          <td class="long-space truncate">{{ genre.slug }}</td>
          <td class="truncate">{{ genre.description ?? "" }}</td>
          <td>{{ genre.status }}</td>
          <td class="long-space">
            <div class="actions text-white">
              <router-link
                :to="{
                  name: 'genre-update',
                  params: { slug: genre.slug },
                }"
              >
                <button class="bg-orange-500">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
              </router-link>
              <button @click="deleteItem(genre.slug)" class="bg-red-500">
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
  <section class="paginate">
    <span>Showing {{ pageFrom }}-{{ pageTo }} of {{ pageTotal }}</span>
    <div class="paginate-button">
      <button
        class="left"
        @click="prevPage"
        :disabled="!linkPrev"
        :class="!linkPrev ? 'opacity-50' : ''"
      >
        <i class="fa-solid fa-caret-left"></i>
      </button>
      <button
        class="right"
        @click="nextPage"
        :disabled="!linkNext"
        :class="!linkNext ? 'opacity-50' : ''"
      >
        <i class="fa-solid fa-caret-right"></i>
      </button>
    </div>
  </section>
  <div class="line border border-gray-200"></div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { genreService } from "@/services/Genre/genre.js";
import { useRoute, useRouter } from "vue-router";

const genres = ref([]);
const linkNext = ref({});
const linkPrev = ref({});
const pageFrom = ref({});
const pageTo = ref({});
const pageTotal = ref({});
const currentPage = ref(1);

const route = useRoute();
const router = useRouter();

const fetchGenres = async (page) => {
  try {
    const response = await genreService.getAll(page);
    genres.value = response.data.data;

    currentPage.value = response.data.current_page;
    linkNext.value = response.data.next_page_url;
    linkPrev.value = response.data.prev_page_url;
    pageFrom.value = response.data.from;
    pageTo.value = response.data.to;
    pageTotal.value = response.data.total;
  } catch (error) {
    console.error(error);
  }
};

const prevPage = () => {
  if (linkPrev) {
    currentPage.value--;
    updateQueryPage(currentPage.value);
    fetchGenres(currentPage.value);
  }
};

const nextPage = () => {
  if (linkNext) {
    currentPage.value++;
    updateQueryPage(currentPage.value);
    fetchGenres(currentPage.value);
  }
};

const updateQueryPage = (page) => {
  router.push({
    name: "genre",
    query: { page },
  });
};

const deleteItem = async (slug) => {
  try {
    await genreService.delete(slug);
    alert("Genre delete successfully!");
    fetchGenres(currentPage.value);
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  currentPage.value = parseInt(route.query.page) || 1;
  fetchGenres(currentPage.value);
});

watch(route, (newRoute) => {
  if (newRoute.query.page) {
    currentPage.value = parseInt(newRoute.query.page);
    fetchGenres(currentPage.value);
  }
});
</script>
