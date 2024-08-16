<template>
  <section class="head flex items-center justify-between">
    <h1>List Movies</h1>
    <router-link
      :to="{ name: 'movie-form' }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
    >
      <i class="fa-solid fa-circle-plus"></i>
      <span>New movie</span>
    </router-link>
  </section>
  <div class="line border border-gray-200"></div>
  <section class="table">
    <table class="w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th>Poster</th>
          <th class="long-space">Title</th>
          <th>Episode Total</th>
          <th>Episode Current</th>
          <th>Year</th>
          <th>Status</th>
          <th>Views</th>
          <th class="long-space">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="movie in movies" :key="movie.id">
          <td>{{ movie.id }}</td>
          <td>
            <img :src="movie.poster_url" alt="poster" />
          </td>
          <td class="long-space">{{ movie.name }}</td>
          <td>{{ movie.episode_total }}</td>
          <td>{{ movie.episode_current }}</td>
          <td>{{ movie.year }}</td>
          <td>{{ movie.status }}</td>
          <td>{{ movie.view }}</td>
          <td class="long-space">
            <div class="actions text-white">
              <button class="bg-green-500">
                <i class="fa-solid fa-circle-info"></i>
              </button>
              <button class="bg-sky-500">
                <i class="fa-solid fa-pen-to-square"></i>
              </button>
              <button class="bg-red-500">
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
  <section class="paginate">
    <span>Showing {{ meta.from }}-{{ meta.to }} of {{ meta.total }}</span>
    <div class="paginate-button">
      <button
        class="left"
        @click="prevPage"
        :disabled="!links.prev"
        :class="!links.prev ? 'opacity-50' : ''"
      >
        <i class="fa-solid fa-caret-left"></i>
      </button>
      <button
        class="right"
        @click="nextPage"
        :disabled="!links.next"
        :class="!links.next ? 'opacity-50' : ''"
      >
        <i class="fa-solid fa-caret-right"></i>
      </button>
    </div>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { movieService } from "@/services/Movie/movie.js";

const movies = ref([]);
const links = ref({});
const meta = ref({});
const currentPage = ref(1);

const fetchMovies = async (page = 1) => {
  try {
    const response = await movieService.getAll(page);
    movies.value = response.data.data;
    links.value = response.data.links;
    meta.value = response.data.meta;
  } catch (error) {
    console.error(error);
  }
};

const prevPage = () => {
  if (links.value.prev) {
    currentPage.value -= 1;
    fetchMovies(currentPage.value);
  }
};

const nextPage = () => {
  if (links.value.next) {
    currentPage.value += 1;
    fetchMovies(currentPage.value);
  }
};

onMounted(() => {
  fetchMovies();
});
</script>

<style scoped>

</style>
