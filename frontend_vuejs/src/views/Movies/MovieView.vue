<template>
  <section class="flex flex-col gap-6">
    <section class="head flex items-center justify-between">
      <h1>List Movies</h1>
      <a
        to="/movie/form"
        class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
      >
        <i class="fa-solid fa-circle-plus"></i>
        <span>New movie</span>
      </a>
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
table {
  border-collapse: collapse;
  width: 100%;
  background-color: #fff;
  border-radius: 1rem;
  box-shadow: 0 0 1px 1px #e5e7eb;
  padding: 1rem;
}
th,
td {
  padding: 1rem;
  text-align: center;
}
th {
  width: calc(100% / 9);
}
td {
  width: calc(100% / 9);
}
.long-space {
  word-break: break-word;
  white-space: normal;
  overflow: unset;
  width: 20%;
}
td {
  text-overflow: ellipsis;
  overflow: hidden;
}
thead,
tbody {
  display: table;
  width: 100%;
  table-layout: fixed;
}
tr {
  border-bottom: 1px solid #e5e7eb;
}
tbody {
  width: 100%;
  overflow-y: auto;
}
.actions {
  word-break: break-word;
  white-space: normal;
  overflow: unset;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}
.actions button {
  word-break: break-word;
  white-space: normal;
  overflow: unset;
  display: block;
  padding: 0.25rem;
  border-radius: 50%;
  aspect-ratio: 4;
  white-space: wrap;
}

.paginate {
  display: flex;
  justify-content: space-between;
}
.paginate-button {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 2px;
}
.paginate-button button {
  padding: 0.1rem 0.8rem;
  background-color: #fff;
  border: 1px solid #e5e7eb;
}
.paginate-button button:hover {
  color: #3b82f6;
}
.paginate-button .left {
  border-radius: 10px 0 0 10px;
}
.paginate-button .right {
  border-radius: 0 10px 10px 0;
}
</style>
