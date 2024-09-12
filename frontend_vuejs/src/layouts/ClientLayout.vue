<template>
  <TheHeader />
  <main class="pt-12">
    <router-view></router-view>
  </main>
</template>
<script setup>
import TheHeader from "@/components/Client/TheHeader.vue";
</script>
