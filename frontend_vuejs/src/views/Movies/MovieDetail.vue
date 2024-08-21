<template>
  <section class="head flex items-center justify-between">
    <h1>Movie Details</h1>
    <router-link
      :to="{ name: 'movie' }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-400"
    >
      <i class="fa-solid fa-rectangle-list"></i>
      <span>List movies</span>
    </router-link>
  </section>
  <div class="line border border-gray-200"></div>
  <section class="form-box flex flex-col items-center justify-center">
    <div class="images relative w-full pb-20">
      <div class="thumbnail relative flex w-full items-center justify-center">
        <figure class="relative h-fit w-fit">
          <img
            class="h-[50vh] w-full object-contain"
            :src="movie.thumb_url"
            :alt="'thumb_' + movie.slug"
          />
          <div class="blur-thumb"></div>
        </figure>
      </div>
      <div class="poster absolute bottom-0 left-0">
        <figure class="h-fit w-[30vh] shadow-lg shadow-white">
          <img
            class="h-full w-full object-contain"
            :src="movie.poster_url"
            :alt="'poster_' + movie.slug"
          />
        </figure>
      </div>
    </div>

    <h1>{{ movie.name }}</h1>
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import { movieService } from "@/services/Movie/movie";

const movie = ref([]);
const route = useRoute();

const slug = route.params.slug;

const fetchMovie = async () => {
  try {
    const response = await movieService.find(slug);
    movie.value = response.data;
  } catch (error) {
    console.error("Failed to fetch movie:", error);
  }
};

onMounted(() => {
  fetchMovie();
});
</script>

<style scoped>
.blur-thumb {
  width: 100%;
  height: 100%;
  position: absolute;
  top: 0;
  background: linear-gradient(
    to right,
    rgba(255, 255, 255, 1),
    rgba(255, 255, 255, 0) 0
  );
  box-shadow: 0px 0px 30px 50px #fff inset;
}
</style>
