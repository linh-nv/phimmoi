<template>
  <TheHeader />
  <main class="container mx-auto grid grid-cols-12 px-4 pt-24 md:px-8">
    <div class="col-span-12 md:col-span-9">
      <router-view></router-view>
    </div>
    <div class="col-span-12 md:col-span-3">
      <TrendingMovie />
    </div>
  </main>
  <TheFooter />
</template>
<script setup>
import TheHeader from "@/components/Client/TheHeader.vue";
import TheFooter from "@/components/Client/TheFooter.vue";
import TrendingMovie from "@/components/Client/TrendingMovie.vue";
</script>
