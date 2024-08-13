<template>
  <router-view></router-view>
    <TheLoader v-if="isLoading"  />
</template>
<script setup>
import { computed } from "vue";
import { useLoadingStore } from "@/stores/loadingStore";
import TheLoader from "./components/TheLoader.vue";

const loadingStore = useLoadingStore();
const isLoading = computed(() => loadingStore.isLoading);
</script>
