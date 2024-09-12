<template>
  <section
    class="movies-display mb-5 grid grid-cols-2 justify-between gap-4 border-b border-neutral-400 pb-10 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 2xl:grid-cols-6"
  >
    <router-link
      :to="{ name: 'phim', params: { slug: movie.slug } }"
      v-for="movie in movies"
      class="item-movie relative aspect-[2/3] overflow-hidden rounded-lg"
    >
      <!-- Img -->
      <img
        loading="lazy"
        class="h-full w-full rounded-lg transition-all duration-300 ease-linear hover:scale-110"
        :src="movie.poster_url"
        :alt="movie.name"
        @load="imageLoaded = true"
      />
      <!-- Caption -->
      <div
        class="movie-name absolute bottom-0 left-0 right-0 rounded-b-lg bg-[#000000cc] p-2 text-center"
      >
        <div class="title truncate py-1 font-semibold">{{ movie.name }}</div>
        <div class="original-name truncate opacity-80">
          {{ movie.origin_name }}
        </div>
      </div>
    </router-link>
  </section>
</template>
<script setup>
const props = defineProps({
  movies: { type: Object, required: true },
});
</script>
