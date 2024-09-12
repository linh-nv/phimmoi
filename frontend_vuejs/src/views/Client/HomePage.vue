<template>
  <div id="section_home" class="flex flex-col gap-10">
    <section class="slider-bar">
      <h2 class="category-title text-2xl bg-red-500 w-fit">Mới cập nhật</h2>
      <TheSlider />
    </section>
    <section v-for="(movies, title) in allList" class="movie-list">
      <h2 class="category-title">{{ title }}</h2>
      <MoviesDisplay :movies="movies" />
    </section>
  </div>
</template>
<script setup>
import TheSlider from "@/components/Client/TheSlider.vue";
import MoviesDisplay from "@/components/Client/ListMovie/MoviesDisplay.vue";
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
