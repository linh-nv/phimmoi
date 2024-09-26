<template>
  <h1 class="py-2 text-center text-2xl font-normal uppercase text-gray-200">
    {{ title }}
  </h1>
  <MovieFilter @update:movies="updateMovies" />
  <MoviesDisplay :movies="movies" />
  <PaginationBar :pagination="pagination" @paginate="fetchMovies" />
</template>

<script setup>
import MoviesDisplay from "@/components/Client/ListMovie/MoviesDisplay.vue";
import MovieFilter from "@/components/Client/MovieFilter/MovieFilter.vue";
import PaginationBar from "@/components/Client/Paginate/PaginationBar.vue";
import { clientService } from "@/services/Client";
import { ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

// Title
const title = ref(route.query.title);

watch(route, (newRoute) => {
  try {
    fetchMovies();
  } catch (error) {
    console.error("Error: ", error);
  }

  title.value = newRoute.query.title;
});

// Items
const movies = ref({});
const pagination = ref({});

const fetchMovies = async (url = null) => {
  try {
    const response = url
      ? await clientService.getPaginate(url)
      : await clientService.getGenre(route.params.slug);

    movies.value = response.data.data;
    pagination.value = response.data;
  } catch (error) {
    console.error("Error: ", error);
  }
};

onMounted(() => {
  fetchMovies();
});

const updateMovies = (response) => {
  movies.value = response.data;
  pagination.value = response;
};
</script>
