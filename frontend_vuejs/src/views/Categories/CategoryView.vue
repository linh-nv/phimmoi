<template>
  <section class="head flex items-center justify-between">
    <h1>List Categories</h1>
    <router-link
      :to="{ name: 'category-create', query: { page: currentPage } }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
    >
      <i class="fa-solid fa-circle-plus"></i>
      <span>New category</span>
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
        <tr v-for="category in categories" :key="category.id">
          <td>{{ category.id }}</td>
          <td class="long-space truncate">{{ category.title }}</td>
          <td class="long-space truncate">{{ category.slug }}</td>
          <td class="truncate">{{ category.description }}</td>
          <td>{{ category.status }}</td>
          <td class="long-space">
            <div class="actions text-white">
              <router-link
                :to="{
                  name: 'category-update',
                  params: { slug: category.slug },
                }"
              >
                <button class="bg-orange-500">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
              </router-link>
              <button @click="deleteItem(category.slug)" class="bg-red-500">
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
import { ref, onMounted, watch } from "vue";
import { categoryService } from "@/services/Category/category.js";
import { useRoute, useRouter } from "vue-router";

const categories = ref([]);
const linkNext = ref({});
const linkPrev = ref({});
const currentPage = ref(1);
const pageFrom = ref({});
const pageTo = ref({});
const pageTotal = ref({});

const route = useRoute();
const router = useRouter();

const fetchCategories = async (page) => {
  try {
    const response = await categoryService.getAll(page);
    categories.value = response.data.data;

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
    updateQueryPage(currentPage.value);
    fetchCategories(currentPage.value);
  }
};

const nextPage = () => {
  if (linkNext) {
    currentPage.value++;
    updateQueryPage(currentPage.value);
    fetchCategories(currentPage.value);
  }
};

const updateQueryPage = (page) => {
  router.push({
    name: "category",
    query: { page },
  });
};

const deleteItem = async (slug) => {
  try {
    await categoryService.delete(slug);
    alert("Category delete successfully!");
    fetchCategories();
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  currentPage.value = parseInt(route.query.page) || 1;
  fetchCategories(currentPage.value);
});

watch(route, (newRoute) => {
  if (newRoute.query.page) {
    currentPage.value = parseInt(newRoute.query.page);
    fetchCategories(currentPage.value);
  }
});
</script>
