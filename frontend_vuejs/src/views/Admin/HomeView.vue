<template>
  <h1>Dashboard</h1>
  <section class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
    <!-- Stats cards -->
    <div class="flex justify-between gap-5 rounded-lg bg-white p-4 shadow">
      <div class="flex h-full flex-col justify-between">
        <h2>New Users In The Month</h2>
        <p class="text-3xl text-blue-500">
          <strong>{{ data.new_users }}</strong> users
        </p>
      </div>
      <img
        class="h-20 w-20"
        src="/src/assets/images/user.png"
        alt="user icon"
      />
    </div>
    <div class="flex justify-between gap-5 rounded-lg bg-white p-4 shadow">
      <div class="flex h-full flex-col justify-between">
        <h2>Views In The Month</h2>
        <p class="text-3xl text-orange-500">
          <strong>{{ data.total_views }}</strong> views
        </p>
      </div>
      <img
        class="h-20 w-20"
        src="/src/assets/images/eye-exam.png"
        alt="user icon"
      />
    </div>
    <div class="flex justify-between gap-5 rounded-lg bg-white p-4 shadow">
      <div class="flex h-full flex-col justify-between">
        <h2>New Movies Of The Month</h2>
        <p class="text-3xl text-red-500">
          <strong>{{ data.new_movies }}</strong> movies
        </p>
      </div>
      <img
        class="h-20 w-20"
        src="/src/assets/images/movie.png"
        alt="user icon"
      />
    </div>
  </section>

  <section class="mb-4 w-full rounded-lg bg-white p-4 shadow">
    <!-- Sales Details chart -->
    <h2 class="mb-4">Views Genres Of The Month</h2>
    <div class="grid grid-cols-2 gap-4 h-full w-full">
      <div class="col-span-1">
        <BarChart :genre="data.views_by_genre" />
      </div>
      <div class="col-span-1 h-[90%]">
        <GenreCharts :genre="data.views_by_genre" />
      </div>
    </div>
  </section>
</template>
<script setup>
import BarChart from "@/components/Admin/Dashboard/BarChart.vue";
import GenreCharts from "@/components/Admin/Dashboard/GenreCharts.vue";
import { dashboardService } from "@/services/Admin/Dashboard";
import { onMounted, reactive } from "vue";

const data = reactive({
  new_users: null,
  total_views: null,
  new_movies: null,
  views_by_genre: [],
});
onMounted(async () => {
  const response = await dashboardService.getOverview();
  data.new_users = response.data.new_users;
  data.total_views = response.data.total_views;
  data.new_movies = response.data.new_movies;
  data.views_by_genre = response.data.views_by_genre;
});
</script>
