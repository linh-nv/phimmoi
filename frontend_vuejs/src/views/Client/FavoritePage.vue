<template>
  <h1 class="py-2 text-center text-2xl font-normal uppercase text-gray-200">
    {{ title }}
  </h1>
  <MoviesDisplay :movies="movies" />
  <PaginationBar :pagination="pagination" @paginate="fetchMovies" />
</template>
<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import MoviesDisplay from "@/components/Client/ListMovie/MoviesDisplay.vue";
import PaginationBar from "@/components/Client/Paginate/PaginationBar.vue";
import { clientService } from "@/services/Client";
import { useClientStore } from "@/stores/clientStore";

const route = useRoute();
const title = ref(route.query.title);
const clientStore = useClientStore();
const user = clientStore.getClient ?? null;

const movies = ref({});
const pagination = ref({});

const fetchMovies = async (url = null) => {
  try {
    const response = url
      ? await clientService.getPaginate(url)
      : await clientService.getFavorite(user.id);

    movies.value = response.data.data;
    pagination.value = response.data;
  } catch (error) {
    console.error("Error: ", error);
  }
};

onMounted(() => {
  fetchMovies();
});
</script>
