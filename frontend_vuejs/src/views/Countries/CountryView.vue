<template>
  <section class="head flex items-center justify-between">
    <h1>List Countries</h1>
    <router-link
      :to="{ name: 'country-create' }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
    >
      <i class="fa-solid fa-circle-plus"></i>
      <span>New country</span>
    </router-link>
  </section>
  <div class="line border border-gray-200"></div>
  <section class="table">
    <table class="w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th class="long-space">Title</th>
          <th class="long-space">Slug</th>
          <th>Description</th>
          <th>Status</th>
          <th class="long-space">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="country in countries" :key="country.id">
          <td>{{ country.id }}</td>
          <td class="long-space truncate">{{ country.title }}</td>
          <td class="long-space truncate">{{ country.slug }}</td>
          <td class="truncate">{{ country.description }}</td>
          <td>{{ country.status }}</td>
          <td class="long-space">
            <div class="actions text-white">
              <router-link
                :to="{
                  name: 'country-update',
                  params: { slug: country.slug },
                }"
              >
                <button class="bg-orange-500">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
              </router-link>
              <button @click="deleteItem(country.slug)" class="bg-red-500">
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
</template>

<script setup>
import { ref, onMounted } from "vue";
import { countryService } from "@/services/Country/country.js";

const countries = ref([]);
const linkNext = ref({});
const linkPrev = ref({});
const currentPage = ref({});
const pageFrom = ref({});
const pageTo = ref({});
const pageTotal = ref({});

const fetchCountries = async (page = 1) => {
  try {
    const response = await countryService.getAll(page);
    countries.value = response.data.data;

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
    fetchCountries(currentPage.value);
  }
};

const nextPage = () => {
  if (linkNext) {
    currentPage.value++;
    fetchCountries(currentPage.value);
  }
};

const deleteItem = async (slug) => {
  try {
    const response = await countryService.delete(slug);
    alert("Country delete successfully!");
    fetchCountries();
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  fetchCountries();
});
</script>
