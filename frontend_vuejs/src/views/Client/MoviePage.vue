<template>
  <section class="movie-info mb-10 bg-zinc-900">
    <MovieSumary
      :movie="movie"
      :category="category"
      :genres="genres"
      :country="country"
      :firstEpisode="firstEpisode"
      @showEpisodeInfo="showEpisodeInfo"
    />
    <!-- Tab -->
    <div class="w-full">
      <ul class="mb-0 flex w-auto list-none flex-row flex-wrap gap-y-2 p-4">
        <li class="-mb-px mr-2 text-center last:mr-0">
          <button
            @click="setActiveTab('episodes')"
            class="block cursor-pointer rounded bg-zinc-800 px-2 py-1 text-xs font-bold uppercase leading-normal text-white shadow-lg sm:px-3 sm:py-2"
            :style="{
              backgroundColor: activeTab === 'episodes' ? '#ef4444' : '',
            }"
          >
            Danh sách tập
          </button>
        </li>
        <li class="-mb-px mr-2 text-center last:mr-0">
          <a
            @click="setActiveTab('info')"
            class="block cursor-pointer rounded bg-zinc-800 px-2 py-1 text-xs font-bold uppercase leading-normal shadow-lg sm:px-3 sm:py-2"
            :style="{
              backgroundColor: activeTab === 'info' ? '#ef4444' : '',
            }"
          >
            Thông tin phim
          </a>
        </li>
        <li class="-mb-px mr-2 text-center last:mr-0">
          <a
            @click="setActiveTab('actor')"
            class="block cursor-pointer rounded bg-zinc-800 px-2 py-1 text-xs font-bold uppercase leading-normal shadow-lg sm:px-3 sm:py-2"
            :style="{
              backgroundColor: activeTab === 'actor' ? '#ef4444' : '',
            }"
          >
            Diễn Viên
          </a>
        </li>
      </ul>
      <div
        class="relative mb-6 flex w-full min-w-0 flex-col break-words rounded border-t border-zinc-800 shadow-lg"
      >
        <div class="flex-auto p-4">
          <div class="tab-content tab-space">
            <!-- Episode -->
            <div v-if="activeTab === 'episodes'">
              <div class="pb-3">
                <div class="w-full">
                  <h3
                    class="inline-block text-sm font-medium uppercase text-gray-300"
                  >
                    Danh Sách Tập
                  </h3>
                  <div class="flex flex-row flex-wrap gap-x-2 pt-3">
                    <button
                      v-for="episode in episodes"
                      :key="episode.slug"
                      @click="showEpisodeInfo(episode)"
                      :title="'Xem phim ' + movie.name + ' ' + episode.name"
                      class="mb-2 min-w-[60px] rounded-sm bg-neutral-700 px-1 py-1.5 text-center text-[13px] font-medium text-gray-300 visited:bg-zinc-800 hover:bg-neutral-600"
                    >
                      {{ episode.name }}
                    </button>
                  </div>
                </div>
              </div>
            </div>
            <EpisodeWatch
              v-if="selectedEpisode"
              :movie="movie"
              :selectedEpisode="selectedEpisode"
              :showIframe="showIframe"
              :isVisible="isVisible"
              @exitEpisode="exitEpisode"
            />

            <!-- Detail information -->
            <div v-if="activeTab === 'info'">
              <EpisodeInfo :movie="movie" />
            </div>
            <!-- Actor, director -->
            <div v-if="activeTab === 'actor'">
              <EpisodeCast :movie="movie" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <MovieComment />
  </section>
</template>

<script setup>
import EpisodeInfo from "@/components/Client/Episode/EpisodeInfo.vue";
import EpisodeWatch from "@/components/Client/Episode/EpisodeWatch.vue";
import EpisodeCast from "@/components/Client/Episode/EpisodeCast.vue";
import MovieSumary from "@/components/Client/Movie/MovieSumary.vue";
import MovieComment from "@/components/Client/Movie/MovieComment.vue";
import { clientService } from "@/services/Client";
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const slug = route.params.slug;
const movie = ref({});
const category = ref({});
const genres = ref({});
const country = ref({});
const episodes = ref({});
const firstEpisode = ref({});

onMounted(async () => {
  const response = await clientService.getMovie(slug);
  movie.value = response.data;
  category.value = response.data.category;
  genres.value = response.data.genres;
  country.value = response.data.country;
  episodes.value = response.data.episodes;
  firstEpisode.value = episodes.value[0];
});

const activeTab = ref("episodes");

const setActiveTab = (tab) => {
  activeTab.value = tab;
};

const selectedEpisode = ref(null);
const showIframe = ref(false);
const isVisible = ref(false);

const showEpisodeInfo = (episode) => {
  selectedEpisode.value = episode;
  isVisible.value = true;
  showIframe.value = true;
};

const exitEpisode = () => {
  selectedEpisode.value = null;
  showIframe.value = false;
};
</script>
