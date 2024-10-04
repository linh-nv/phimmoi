<template>
  <div class="mx-auto flex gap-x-4 border-b border-zinc-800 py-3 md:gap-x-8">
    <div class="flex h-full w-5/12 md:w-4/12">
      <img
        :src="movie.poster_url"
        :alt="movie.name"
        class="mx-auto w-full rounded-md object-contain object-center md:block"
      />
    </div>
    <div class="w-7/12 lg:w-11/12">
      <h2
        class="text-md mb-1 font-bold uppercase text-gray-300 md:pt-0 md:text-xl"
      >
        {{ movie.name }}
      </h2>
      <h3 class="font-medium text-gray-400">{{ movie.origin_name }}</h3>
      <time
        class="block pt-2 text-sm font-medium text-zinc-500"
        :datetime="movie.year"
      >
        {{ movie.year }}
      </time>
      <div class="pt-2 shadow md:rounded-lg">
        <span class="bg-red-500 px-2 py-1 text-[14px] font-medium">
          {{ movie.episode_current }}
        </span>
        <div class="mt-2 flex flex-col gap-2 pt-4 text-sm">
          <!-- Category -->
          <div class="flex gap-2" v-if="category">
            <span class="text-nowrap text-zinc-400">Thể loại:</span>
            <span>
              <router-link
                :to="{
                  name: 'theloai',
                  params: { slug: category?.slug },
                  query: { title: category?.title },
                }"
                class="hover:text-red-300"
                :title="category?.title"
              >
                {{ category?.title }}
              </router-link>
            </span>
          </div>
          <!-- Genre -->
          <div class="flex gap-2" v-if="genres && genres.length">
            <span class="text-nowrap text-zinc-400">Danh mục:</span>
            <span>
              <router-link
                v-for="genre in genres"
                :key="genre.slug"
                :to="{
                  name: 'danhmuc',
                  params: { slug: genre?.slug },
                  query: { title: genre?.title },
                }"
                class="mr-2 hover:text-red-300"
                :title="genre?.title"
              >
                {{ genre?.title }}
              </router-link>
            </span>
          </div>
          <!-- Country -->
          <div class="flex gap-2" v-if="country">
            <span class="text-nowrap text-zinc-400">Quốc gia:</span>
            <span>
              <router-link
                :to="{
                  name: 'quocgia',
                  params: { slug: country?.slug },
                  query: { title: country?.title },
                }"
                class="hover:text-red-300"
                :title="country?.title"
              >
                {{ country?.title }}
              </router-link>
            </span>
          </div>
          <div class="mt-1 flex max-w-[180px] gap-2 text-center">
            <button
              @click="handleWatchNow"
              title="Xem Phim"
              class="mt-5 flex cursor-pointer items-center justify-center gap-2 rounded bg-[#d9534f] px-5 py-2 font-medium text-white hover:opacity-90"
            >
              <i class="fa-solid fa-play"></i>
              <span class="text-nowrap">Xem ngay</span>
            </button>
            <button
              @click="addFavorite()"
              :class="[
                'mt-5 flex cursor-pointer items-center justify-center gap-2 rounded px-5 py-2 font-medium text-white hover:opacity-90',
                movieFavorite ? 'bg-orange-500' : 'bg-gray-500',
              ]"
              :title="
                movieFavorite
                  ? 'Đã thêm vào danh sách yêu thích'
                  : 'Thêm vào list yêu thích'
              "
            >
              <i
                :class="
                  movieFavorite
                    ? 'fa-solid fa-check'
                    : 'fa-solid fa-heart-circle-plus'
                "
              ></i>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { clientService } from "@/services/Client";
import { ref, watch } from "vue";

const props = defineProps({
  movie: { type: Object, required: true },
  category: { type: Object, required: true },
  genres: { type: Object, required: true },
  country: { type: Object, required: true },
  firstEpisode: { type: Object, required: true },
});
const createView = async () => {
  try {
    await clientService.createView(props.movie.id);
  } catch (error) {
    console.error("Error: ", error);
  }
};
const emit = defineEmits(["showEpisodeInfo"]);
const handleWatchNow = () => {
  createView();
  emit("showEpisodeInfo", props.firstEpisode);
};

const movieFavorite = ref(false);
const addFavorite = async () => {
  const response = await clientService.createFavorite({
    movie_id: props.movie.id,
  });

  movieFavorite.value = response.data ? true : false;
};

watch(
  () => props.movie.id,
  async (newId) => {
    if (newId) {
      const response = await clientService.checkExistFavorite(newId);
      movieFavorite.value = response.data;
    }
  },
  { immediate: true },
);
</script>
