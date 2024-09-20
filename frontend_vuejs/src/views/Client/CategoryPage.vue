<template>
  <MovieFilter />
  <MoviesDisplay :movies="movies" />
</template>
<script setup>
import MoviesDisplay from "@/components/Client/ListMovie/MoviesDisplay.vue";
import MovieFilter from "@/components/Client/ListMovie/MovieFilter.vue";
import { clientService } from "@/services/Client";
import { ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const movies = ref({});

onMounted( async () => {
    try {
      const response = await clientService.getCategory(route.params.slug);

      movies.value = response.data;
    } catch (error) {
      console.error("Error: ", error);
    }
  },
);
watch(
  () => route.params.slug,
  async (newSlug) => {
    try {
      const response = await clientService.getCategory(newSlug);

      movies.value = response.data;
    } catch (error) {
      console.error("Error: ", error);
    }
  },
);
</script>
