<template>
  <div id="home_page" class="container mx-auto px-2">
    <section class="slider-bar">
      <h2 class="home-title">
        Phim mới cập nhật
      </h2>
      <TheSlider />
    </section>
  </div>
</template>
<script setup>
import TheSlider from "@/components/Client/TheSlider.vue";
</script>
<style scoped>
.home-title {
}
</style>