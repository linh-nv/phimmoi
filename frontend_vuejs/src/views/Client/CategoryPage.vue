<template>
  <h1 class="py-2 text-center text-2xl font-normal uppercase text-gray-200">
    {{ itemTitle }}
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
import { useBreadcrumbStore } from "@/stores/breadcrumbStore";
import { ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const breadcrumbStore = useBreadcrumbStore();
const itemTitle = ref("");
const movies = ref({});
const pagination = ref({});

const fetchMovies = async (url = null) => {
  try {
    const response = url
      ? await clientService.getPaginate(url)
      : await clientService.getCategory(route.params.slug);

    console.log(response);
    
    movies.value = response.data.data;
    pagination.value = response.data;
  } catch (error) {
    console.error("Error: ", error);
  }
};


onMounted(() => {
  fetchMovies();
});

watch(
  () => route.params.slug,
  async (newSlug) => {
    try {
      fetchMovies();
      if (!newSlug) {
        breadcrumbStore.clearItemTitle();
      }
      itemTitle.value = breadcrumbStore.itemTitle;
    } catch (error) {
      console.error("Error: ", error);
    }
  },
);

const updateMovies = (response) => {
  movies.value = response.data;
  pagination.value = response;
};

itemTitle.value = breadcrumbStore.itemTitle;
</script>
