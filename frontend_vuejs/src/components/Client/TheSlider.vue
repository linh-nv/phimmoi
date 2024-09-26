<template>
  <div class="card-slider relative">
    <div class="hot-movie h-full w-full select-none overflow-scroll">
      <div
        class="list-movie flex w-max gap-[10px] py-5 sm:gap-[20px] lg:gap-[20px]"
      >
        <!-- Items -->
        <router-link
          :to="{
            name: 'phim',
            params: { slug: movie.slug },
            query: { title: movie.name },
          }"
          v-for="movie in movieData"
          class="item-movie relative aspect-[2/3] w-[45vw] scale-100 scroll-smooth transition-all duration-300 ease-linear hover:scale-110 sm:w-[190px] md:w-[160px] lg:w-[175px] xl:w-[225px] 2xl:w-[228px]"
        >
          <!-- Img -->
          <img
            loading="lazy"
            class="h-full w-full rounded-lg"
            :src="movie.poster_url"
            :alt="movie.name"
            @load="imageLoaded = true"
          />
          <!-- Caption -->
          <div
            class="movie-name absolute bottom-0 left-0 right-0 rounded-b-lg bg-[#000000cc] p-2 text-center"
          >
            <div class="title truncate py-1 font-semibold">
              {{ movie.name }}
            </div>
            <div class="original-name truncate opacity-80">
              {{ movie.origin_name }}
            </div>
          </div>
        </router-link>
      </div>
    </div>
    <!-- Button -->
    <div class="hot-movie-button">
      <button
        @click="onPrev"
        class="hot-movie-prev absolute left-1 top-[30%] z-10 h-[80px] w-[40px] origin-center rounded-lg bg-[#000000aa] opacity-50 transition-all duration-100 ease-linear hover:scale-110 hover:opacity-100 sm:left-2 sm:h-[100px] sm:w-[50px] lg:left-10"
      >
        &#10092;
      </button>
      <button
        @click="onNext"
        class="hot-movie-next absolute right-1 top-[30%] z-10 h-[80px] w-[40px] origin-center rounded-lg bg-[#000000aa] opacity-50 transition-all duration-100 ease-linear hover:scale-110 hover:opacity-100 sm:right-2 sm:h-[100px] sm:w-[50px] lg:right-10"
      >
        &#10093;
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { clientService } from "@/services/Client";

const movieData = ref([]);

onMounted(async () => {
  try {
    const response = await clientService.getSilier();

    movieData.value = Object.values(response.data);
  } catch (error) {
    console.error("Error: ", error);
  }
});

const onNext = () => {
  const widthItem = document.querySelector(".item-movie").offsetWidth;
  document.querySelector(".hot-movie").scrollLeft += widthItem + 30;
};
const onPrev = () => {
  const widthItem = document.querySelector(".item-movie").offsetWidth;
  document.querySelector(".hot-movie").scrollLeft -= widthItem + 30;
};
</script>
