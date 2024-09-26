<template>
  <div class="container mx-auto">
    <TheHeader />
    <main class="container mx-auto px-4 pt-24 md:px-8">
      <router-view></router-view>
    </main>
    <TheFooter />
  </div>
</template>
<script setup>
import TheHeader from "@/components/Client/TheHeader.vue";
import TheFooter from "@/components/Client/TheFooter.vue";
</script>
