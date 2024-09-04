<template>
  <TheHeader />
  <main class="bg-[#111111] h-[2000px] text-white pt-12">
    <div class="backgound-poster-movie">
        <img src="https://phimimg.com/upload/vod/20240821-1/e84c3eb9aa4f77c64295b07b12580bc5.jpg" alt="">
    </div>
    <router-view></router-view>
  </main>
</template>
<script setup>
import TheHeader from "@/components/Client/TheHeader.vue";
</script>
<style scoped>
.backgound-poster-movie{
    position: relative;
}
.backgound-poster-movie::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
}
.backgound-poster-movie::before {
    /* background: linear-gradient(to right, rgba(0, 0, 0, 1), rgba(0, 0, 0, 0)); */
    box-shadow: 0px 0px 15px 25px #111111 inset;
}
</style>