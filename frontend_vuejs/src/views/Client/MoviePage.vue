<template>
  <section class="movie-info mb-10 bg-zinc-900">
    <div class="mx-auto flex gap-x-4 border-b border-zinc-800 py-3 md:gap-x-8">
      <div class="flex aspect-[2/3] h-full w-5/12 md:w-4/12">
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
            <div class="mt-1 max-w-[180px] text-center">
              <a
                title="Xem Phim"
                class="mx-auto mt-5 flex cursor-pointer items-center justify-center gap-2 rounded bg-[#d9534f] px-3 py-[8px] font-medium text-white hover:opacity-90"
              >
                <span class="">Xem Ngay</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full">
      <ul
        class="mb-0 flex w-auto list-none flex-row flex-wrap gap-y-2 pb-4 pt-3"
      >
        <li class="-mb-px mr-2 text-center last:mr-0">
          <button
            @click="setActiveTab('episodes')"
            class="block cursor-pointer rounded bg-zinc-800 px-3 py-2 text-xs font-bold uppercase leading-normal text-white shadow-lg"
            :class="{ 'bg-[#ef4444]': activeTab === 'episodes' }"
          >
            Danh sách tập
          </button>
        </li>
        <li class="-mb-px mr-2 text-center last:mr-0">
          <a
            @click="setActiveTab('info')"
            class="block cursor-pointer rounded bg-zinc-800 px-3 py-2 text-xs font-bold uppercase leading-normal shadow-lg"
            :class="{ 'bg-[#ef4444]': activeTab === 'info' }"
          >
            Thông tin phim
          </a>
        </li>
        <li class="-mb-px mr-2 text-center last:mr-0">
          <a
            @click="setActiveTab('actor')"
            class="block cursor-pointer rounded bg-zinc-800 px-3 py-2 text-xs font-bold uppercase leading-normal shadow-lg"
            :class="{ 'bg-[#ef4444]': activeTab === 'actor' }"
          >
            Diễn Viên
          </a>
        </li>
      </ul>
      <div
        class="relative mb-6 flex w-full min-w-0 flex-col break-words rounded border-t border-zinc-800 shadow-lg"
      >
        <div class="flex-auto px-4 py-4">
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
