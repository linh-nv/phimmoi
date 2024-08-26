<template>
  <section class="head flex items-center justify-between">
    <h1>List Episodes</h1>
    <div class="flex gap-4">
      <router-link
        :to="{ name: 'movie' }"
        class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-400"
      >
        <i class="fa-solid fa-circle-left"></i>
        <span>List movies</span>
      </router-link>
      <router-link
        :to="{ name: 'episode-create', params: { slug: slug } }"
        class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
      >
        <i class="fa-solid fa-circle-plus"></i>
        <span>New episode</span>
      </router-link>
    </div>
  </section>
  <div class="line border border-gray-200"></div>
  <section class="table">
    <table class="w-full">
      <thead>
        <tr>
          <th>Name</th>
          <th>Slug</th>
          <th class="truncate">Link_embed</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="episode in episodes" :key="episode.id">
          <td class="truncate">{{ episode.name }}</td>
          <td class="truncate">{{ episode.slug }}</td>
          <td class="truncate">{{ episode.link_embed }}</td>
          <td>
            <div class="actions text-white">
              <router-link
                :to="{
                  name: 'episode-update',
                  params: { slug: slug, id: episode.id },
                }"
              >
                <button class="bg-orange-500">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
              </router-link>
              <button @click="deleteItem(episode.id)" class="bg-red-500">
                <i class="fa-solid fa-trash-can"></i>
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </section>
  <section class="paginate">
    <span>Showing {{ pageFrom }}-{{ pageTo }} of {{ pageTotal }}</span>
    <div class="paginate-button">
      <button
        class="left"
        @click="prevPage"
        :disabled="!linkPrev"
        :class="!linkPrev ? 'opacity-50' : ''"
      >
        <i class="fa-solid fa-caret-left"></i>
      </button>
      <button
        class="right"
        @click="nextPage"
        :disabled="!linkNext"
        :class="!linkNext ? 'opacity-50' : ''"
      >
        <i class="fa-solid fa-caret-right"></i>
      </button>
    </div>
  </section>
  <div class="line border border-gray-200"></div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { episodeService } from "@/services/Episode/episode.js";
import { useRouter, useRoute } from "vue-router";

const router = useRouter();
const route = useRoute();
const slug = route.params.slug;

const episodes = ref([]);
const linkNext = ref({});
const linkPrev = ref({});
const currentPage = ref({});
const pageFrom = ref({});
const pageTo = ref({});
const pageTotal = ref({});

const fetchEpisodes = async (page = 1) => {
  try {
    const response = await episodeService.getByMovie(slug, page);
    episodes.value = response.data.data;

    currentPage.value = response.data.current_page;
    linkNext.value = response.data.next_page_url;
    linkPrev.value = response.data.prev_page_url;
    pageFrom.value = response.data.from;
    pageTo.value = response.data.to;
    pageTotal.value = response.data.total;
  } catch (error) {
    console.error(error);
  }
};

const prevPage = () => {
  if (linkPrev) {
    currentPage.value--;
    fetchEpisodes(currentPage.value);
  }
};

const nextPage = () => {
  if (linkNext) {
    currentPage.value++;
    fetchEpisodes(currentPage.value);
  }
};

const deleteItem = async (id) => {
  try {
    await episodeService.delete(id);
    alert("Episode delete successfully!");
    fetchEpisodes();
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchEpisodes();
});
</script>
