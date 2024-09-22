<template>
  <h1 class="py-2 text-center text-2xl font-normal uppercase text-gray-200">
    {{ itemTitle }}
  </h1>
  <MovieFilter />
  <MoviesDisplay :movies="movies" />
</template>
<script setup>
import MoviesDisplay from "@/components/Client/ListMovie/MoviesDisplay.vue";
import MovieFilter from "@/components/Client/MovieFilter/MovieFilter.vue";
import { clientService } from "@/services/Client";
import { useBreadcrumbStore } from "@/stores/breadcrumbStore";
import { ref, onMounted, watch } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const breadcrumbStore = useBreadcrumbStore();
const itemTitle = ref("");
const movies = ref({});

onMounted(async () => {
  try {
    const response = await clientService.getGenre(route.params.slug);

    movies.value = response.data.data;
  } catch (error) {
    console.error("Error: ", error);
  }
});
watch(
  () => route.params.slug,
  async (newSlug) => {
    try {
      const response = await clientService.getGenre(newSlug);

      movies.value = response.data.data;

      if (!newSlug) {
        breadcrumbStore.clearItemTitle();
      }
      itemTitle.value = breadcrumbStore.itemTitle;
    } catch (error) {
      console.error("Error: ", error);
    }
  },
);

itemTitle.value = breadcrumbStore.itemTitle;
</script>
