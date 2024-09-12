<template>
  <div class="card-slider relative">
    <div class="hot-movie h-full w-full select-none overflow-scroll">
      <div
        class="list-movie flex w-max gap-[10px] py-5 sm:gap-[20px] lg:gap-[20px]"
      >
        <!-- Items -->
        <a
          v-for="movie in movieData"
          href="#"
          class="item-movie relative w-[47vw] scale-100 scroll-smooth transition-all duration-300 ease-linear hover:scale-110 sm:w-[195px] md:w-[173px] lg:w-[185px] xl:w-[235px] 2xl:w-[235px]"
          style="aspect-ratio: 2 / 3"
        >
          <!-- Img -->
          <img
            class="h-full w-full rounded-lg"
            :src="movie.poster_url"
            :alt="movie.name"
            @load="imageLoaded = true"
          />
          <!-- Caption -->
          <div
            class="movie-name absolute bottom-0 left-0 right-0 rounded-b-lg bg-[rgba(0,0,0,0.7)] p-2 text-center"
          >
            <div class="title truncate py-1">{{ movie.name }}</div>
            <div class="original-name truncate">{{ movie.origin_name }}</div>
          </div>
        </a>
      </div>
    </div>
    <!-- Button -->
    <div class="hot-movie-button">
      <button
        @click="onPrev"
        class="hot-movie-prev absolute left-1 top-[30%] z-10 h-[80px] w-[40px] origin-center rounded-lg bg-[rgba(0,0,0,0.7)] opacity-50 transition-all duration-100 ease-linear hover:scale-110 hover:opacity-100 sm:left-2 sm:h-[100px] sm:w-[50px] lg:left-10"
      >
        &#10092;
      </button>
      <button
        @click="onNext"
        class="hot-movie-next absolute right-1 top-[30%] z-10 h-[80px] w-[40px] origin-center rounded-lg bg-[rgba(0,0,0,0.7)] opacity-50 transition-all duration-100 ease-linear hover:scale-110 hover:opacity-100 sm:right-2 sm:h-[100px] sm:w-[50px] lg:right-10"
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
    console.log(movieData.value);
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

<style>
.list-movie {
  &:hover .item-movie {
    opacity: 0.5;
  }
  .item-movie {
    &:hover {
      opacity: 1;
    }
  }
}
.item-movie {
  scroll-snap-align: start;
}
.trending-list-items {
  &:hover .trending-item {
    opacity: 0.5;
  }
  .trending-item {
    &:hover {
      opacity: 1;
    }
  }
}

.hot-movie {
  scroll-behavior: smooth;
  scroll-snap-type: both;
}
.hot-movie::-webkit-scrollbar {
  display: none;
}
</style>
