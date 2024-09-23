<template>
  <div id="section_home" class="">
    <section class="slider-bar">
      <h2 class="category-title w-fit bg-red-500 text-2xl">Mới cập nhật</h2>
      <TheSlider />
    </section>
    <div class="grid grid-cols-12">
      <div class="col-span-12 flex flex-col gap-10 md:col-span-8">
        <section v-for="(movies, title) in allList" class="movie-list">
          <h2 class="category-title">{{ title }}</h2>
          <MoviesDisplay :movies="movies" />
        </section>
      </div>
      <div class="col-span-12 md:col-span-4">
        <TrendingMovie />
      </div>
    </div>
  </div>
</template>
<script setup>
import TheSlider from "@/components/Client/TheSlider.vue";
import MoviesDisplay from "@/components/Client/ListMovie/MoviesDisplay.vue";
import TrendingMovie from "@/components/Client/TrendingList/TrendingMovie.vue";
import { onMounted, ref } from "vue";
import { clientService } from "@/services/Client";

const allList = ref({});

onMounted(async () => {
  try {
    const response = await clientService.getHome();

    allList.value = response.data;
  } catch (error) {
    console.error("Error: ", error);
  }
});
</script>
