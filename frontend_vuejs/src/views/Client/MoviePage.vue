<template>
  <section class="movie-info mb-10 bg-zinc-900">
    <MovieSumary
      :movie="movie"
      :category="category"
      :genres="genres"
      :country="country"
    />
    <!-- Tab -->
    <div class="w-full">
      <ul class="mb-0 flex w-auto list-none flex-row flex-wrap gap-y-2 p-4">
        <li class="-mb-px mr-2 text-center last:mr-0">
          <button
            @click="setActiveTab('episodes')"
            class="block cursor-pointer rounded bg-zinc-800 px-3 py-2 text-xs font-bold uppercase leading-normal text-white shadow-lg"
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
            class="block cursor-pointer rounded bg-zinc-800 px-3 py-2 text-xs font-bold uppercase leading-normal shadow-lg"
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
            class="block cursor-pointer rounded bg-zinc-800 px-3 py-2 text-xs font-bold uppercase leading-normal shadow-lg"
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
                <h3
                  class="inline-block text-sm font-medium uppercase text-gray-300"
                >
                  Danh Sách Tập
                </h3>
                <div class="flex flex-row flex-wrap gap-x-2 pt-3">
                  <router-link
                    v-for="episode in episodes"
                    :key="episode.slug"
                    :to="{
                      name: 'xemphim',
                      params: { movie: movie.slug, slug: episode.slug },
                    }"
                    :title="'Xem phim ' + movie.name + ' ' + episode.name"
                    class="mb-2 min-w-[60px] rounded-sm bg-neutral-700 px-1 py-1.5 text-center text-[13px] font-medium text-gray-300 visited:bg-zinc-800 hover:bg-neutral-600"
                  >
                    {{ episode.name }}
                  </router-link>
                </div>
              </div>
            </div>
            <!-- Detail information -->
            <div v-if="activeTab === 'info'">
              <div class="pb-3">
                <h3
                  class="block text-sm font-medium uppercase tracking-wider text-zinc-300"
                >
                  Tóm Tắt
                </h3>
                <div
                  class="block pt-3 text-justify leading-relaxed text-gray-400"
                >
                  <b>{{ movie.name }}</b>
                  <p>{{ movie.content }}</p>
                </div>
              </div>
              <div class="mt-6">
                <h3 class="text-sm font-medium uppercase text-zinc-300">
                  Thông tin
                </h3>
                <div class="mt-4">
                  <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                    <li class="text-zinc-400">
                      <span>Tên gốc: </span>
                      <span class="inline-block text-zinc-300">
                        {{ movie.origin_name }}
                      </span>
                    </li>
                    <li class="text-zinc-400">
                      <span>Tên khác: </span>
                      <span class="inline-block text-zinc-300">
                        {{ movie.name }}
                      </span>
                    </li>
                    <li class="text-zinc-400">
                      <span>Số tập: </span
                      ><span class="inline-block text-zinc-300">
                        {{ movie.episode_total }}
                      </span>
                    </li>
                    <li class="text-zinc-400">
                      <span>Thời lượng: </span>
                      <span class="inline-block text-zinc-300">
                        {{ movie.time }}
                      </span>
                    </li>
                    <li class="text-zinc-400">
                      <span>Sub: </span>
                      <span class="inline-block text-zinc-300">
                        {{ movie.lang }}
                      </span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <!-- Actor, director -->
            <div v-if="activeTab === 'actor'">
              <div class="border-b border-zinc-800 pb-4">
                <span
                  class="inline-block pb-2 text-sm font-medium uppercase tracking-wider text-gray-300"
                >
                  Creator
                </span>
                <div class="mt-2 grid grid-cols-12 gap-x-2 gap-y-6">
                  <div class="col-span-6" title="Yu Je-won">
                    <div class="text-left">
                      <p class="pt-2 text-sm font-medium text-gray-300">
                        {{ movie.director }}
                      </p>
                      <p class="text-sm text-gray-500"></p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="pt-3">
                <span
                  class="inline-block pb-2 text-sm font-medium uppercase tracking-wider text-gray-300"
                  >Diễn Viên</span
                >
                <div class="mt-2 grid grid-cols-12 gap-x-2 gap-y-6">
                  <div class="col-span-6" title="Yu Je-won">
                    <div class="text-left">
                      <p class="pt-2 text-sm font-medium text-gray-300">
                        {{ movie.actor }}
                      </p>
                      <p class="text-sm text-gray-500"></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="comment mx-auto mt-2 border border-zinc-800 bg-zinc-900 px-4 py-3 antialiased"
    >
      <div class="mb-4 flex items-center justify-between">
        <h2 class="text-md font-medium text-white">Bình Luận</h2>
      </div>
    </div>
  </section>
</template>

<script setup>
import MovieSumary from "@/components/Client/Movie/MovieSumary.vue";
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

onMounted(async () => {
  const response = await clientService.getMovie(slug);
  movie.value = response.data;
  category.value = response.data.category;
  genres.value = response.data.genres;
  // country.value = response.data.country;
  episodes.value = response.data.episodes;
});

const activeTab = ref("episodes");

const setActiveTab = (tab) => {
  activeTab.value = tab;
};
</script>
