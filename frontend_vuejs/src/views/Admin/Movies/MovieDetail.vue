<template>
  <section class="head flex items-center justify-between">
    <h1>Movie Details</h1>
    <div class="flex gap-2">
      <button
        @click="router.back()"
        class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-400"
      >
        <i class="fa-solid fa-circle-chevron-left"></i>
        <span>Back</span>
      </button>
      <router-link
        :to="{ name: 'movie-update', params: { slug: slug } }"
        class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-orange-500 px-4 py-2 text-white hover:bg-orange-400"
      >
        <i class="fa-solid fa-pen-to-square"></i>
        <span>Update</span>
      </router-link>
    </div>
  </section>
  <div class="line border border-gray-200"></div>

  <section v-if="movie" class="flex flex-col gap-2">
    <!-- Thumnail -->
    <article class="form-box">
      <div class="flex w-full flex-col gap-5">
        <h2>Thumbnail:</h2>
        <figure class="h-fit w-fit">
          <img
            class="h-[20vh] object-contain"
            :src="movie.thumb_url"
            :alt="'thumb_' + movie.slug"
          />
        </figure>
      </div>
    </article>

    <!-- Poster -->
    <article class="form-box">
      <div class="flex w-full flex-col gap-5">
        <h2>Poster:</h2>
        <figure class="h-fit w-fit">
          <img
            class="h-[20vh] object-contain"
            :src="movie.poster_url"
            :alt="'poster_' + movie.slug"
          />
        </figure>
      </div>
    </article>

    <!-- Name -->
    <article class="form-box">
      <div class="flex w-full flex-col gap-5">
        <div class="flex flex-wrap items-center gap-2">
          <h2>Name:</h2>
          <p>{{ movie.name }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h2>Origin Name:</h2>
          <p>{{ movie.origin_name }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h2>Slug:</h2>
          <p>{{ movie.slug }}</p>
        </div>
      </div>
    </article>

    <!-- Content -->
    <article class="form-box">
      <div class="flex w-full flex-col gap-5">
        <h2>Content:</h2>
        <div class="flex flex-wrap">
          <p v-html="movie.content"></p>
        </div>
      </div>
    </article>

    <!-- Episodes -->
    <article class="form-box">
      <div class="flex w-full flex-col gap-5">
        <h2>Episodes:</h2>
        <div
          v-for="episode in movie.episodes.reverse().slice(0, 5)"
          class="border-b border-gray-100 pb-3"
        >
          <span class="flex items-center gap-2">
            <h3>Name:</h3>
            <p>{{ episode.name }}</p>
          </span>
          <span class="flex items-center gap-2">
            <h3>Slug:</h3>
            <p>{{ episode.slug }}</p>
          </span>
          <span class="flex items-center gap-2 whitespace-nowrap">
            <h3>Link_embed:</h3>
            <a
              class="truncate text-blue-500 underline"
              :href="episode.link_embed"
            >
              {{ episode.link_embed }}
            </a>
          </span>
        </div>
      </div>
      <div class="w-full">
        <router-link :to="{ name: 'episode', params: { slug: movie.slug } }">
          <button
            class="rounded-lg bg-sky-500 px-5 py-2 text-white hover:opacity-75"
          >
            View more ...
          </button>
        </router-link>
      </div>
    </article>

    <article class="form-box">
      <div class="flex w-full flex-col gap-8">
        <div class="flex flex-wrap items-center gap-2">
          <h3>Type:</h3>
          <p>{{ movie.type }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Status:</h3>
          <p>{{ movie.status }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Is_copyright:</h3>
          <p>{{ movie.is_copyright }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Sub_docquyen:</h3>
          <p>{{ movie.sub_docquyen }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Chieurap:</h3>
          <p>{{ movie.chieurap }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Trailer url:</h3>
          <p>{{ movie.trailer_url }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Time:</h3>
          <p>{{ movie.time }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Episode current:</h3>
          <p>{{ movie.episode_current }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Episode total:</h3>
          <p>{{ movie.episode_total }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Quality:</h3>
          <p>{{ movie.quality }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <h3>Lang:</h3>
          <p>{{ movie.lang }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <h3>Notify:</h3>
          <p>{{ movie.notify }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Showtimes:</h3>
          <p>{{ movie.showtimes }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <h3>Year:</h3>
          <p>{{ movie.year }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <h3>Views:</h3>
          <p>{{ movie.view }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Actor:</h3>
          <p>{{ movie.actor }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <h3>Director:</h3>
          <p>{{ movie.director }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
          <h3>Country:</h3>
          <p>{{ movie.country.title }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <h3>Category:</h3>
          <p>{{ movie.category.title }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <h3>Genres:</h3>
          <span v-for="genre in movie.genres">
            <p>{{ genre.title }}</p>
          </span>
        </div>
      </div>
    </article>
  </section>
  <div class="line border border-gray-200"></div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { movieService } from "@/services/Admin/Movie/movie";

const movie = ref(null);
const route = useRoute();
const router = useRouter();

const slug = route.params.slug;

const fetchMovie = async () => {
  try {
    const response = await movieService.find(slug);
    movie.value = response.data;
  } catch (error) {
    console.error("Failed to fetch movie:", error);
  }
};

onMounted(() => {
  fetchMovie();
});

watch(
  () => route.params.slug,
  () => {
    router.go(0);
    fetchMovie();
  },
);
</script>
