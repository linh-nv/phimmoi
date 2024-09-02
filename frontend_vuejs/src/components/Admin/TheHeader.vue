<template>
  <header
    class="fixed right-0 top-0 z-50 flex w-full flex-1 items-center justify-between border-b border-b-gray-200 bg-white px-8 py-4"
  >
    <router-link :to="{ name: 'home' }" class="flex">
      <div class="flex items-center justify-center bg-transparent text-red-500">
        <h1>LINHFLIX</h1>
      </div>
    </router-link>
    <div class="flex items-center">
      <div class="search-box relative mx-8">
        <i
          class="fa-solid fa-magnifying-glass absolute left-0 top-0 flex h-full cursor-pointer items-center p-4 text-gray-500"
        ></i>
        <input
          v-model="searchQuery"
          @input="onSearchInput"
          class="w-96 rounded-3xl border border-gray-200 bg-gray-100 px-12 py-2 outline-none placeholder:text-gray-500"
          type="text"
          placeholder="Search"
        />
        <div
          v-if="searchResults.length"
          class="absolute w-full rounded-b-2xl bg-white p-2 shadow-lg"
        >
          <div class="flex flex-col gap-2">
            <router-link
              v-for="result in searchResults"
              :key="result.slug"
              :to="getUpdateRoute(result)"
              @click.native="navigateToUpdate(result.slug)"
              class="flex flex-col gap-1 border-b border-b-gray-100 p-3 hover:bg-gray-50"
            >
              <h3>{{ result.label }}</h3>
              <p>{{ result.slug }}</p>
            </router-link>
          </div>
        </div>
      </div>
      <div class="account group relative">
        <span class="flex cursor-pointer items-center gap-2 py-2">
          <h3 class="ml-2">{{ admin.name }}</h3>
          <div
            class="flex aspect-square h-5 w-5 items-center justify-center rounded-[50%] border border-gray-400"
          >
            <i
              class="fa-solid fa-chevron-down flex aspect-square items-center justify-center text-xs"
            ></i>
          </div>
        </span>

        <div
          class="account-information invisible absolute right-0 top-10 z-50 flex-col gap-2 rounded-2xl border border-gray-100 bg-white p-3 opacity-0 shadow-lg transition-opacity duration-300 ease-in-out group-hover:visible group-hover:opacity-100"
        >
          <router-link
            :to="{ name: 'account-information' }"
            class="flex w-full items-center gap-3 text-nowrap rounded-sm p-2 hover:bg-gray-50"
          >
            <i class="fa-solid fa-key text-green-500"></i>
            Change Password
          </router-link>
          <button
            @click="logout()"
            class="flex w-full items-center gap-3 text-nowrap rounded-sm p-2 hover:bg-gray-50"
          >
            <i class="fa-solid fa-door-open text-red-500"></i>
            Logout
          </button>
        </div>
      </div>
    </div>
  </header>
</template>
<script setup>
import { ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useAdminStore } from "@/stores/adminStore";
import _ from "lodash";
import { authService } from "@/services/authService";

const adminStore = useAdminStore();
const admin = adminStore.admin;

// Khai báo các service và routeName trong đối tượng ánh xạ
const serviceMap = {
  "/admin/movie": {
    service: () =>
      import("@/services/Admin/Movie/movie").then((m) => m.movieService),
    routeName: "movie-detail",
    labelKey: "name",
  },
  "/admin/category": {
    service: () =>
      import("@/services/Admin/Category/category").then(
        (m) => m.categoryService,
      ),
    routeName: "category-update",
    labelKey: "title",
  },
  "/admin/country": {
    service: () =>
      import("@/services/Admin/Country/country").then((m) => m.countryService),
    routeName: "country-update",
    labelKey: "name",
  },
  "/admin/genre": {
    service: () =>
      import("@/services/Admin/Genre/genre").then((m) => m.genreService),
    routeName: "genre-update",
    labelKey: "name",
  },
};

const searchQuery = ref("");
const searchResults = ref([]);
const route = useRoute();
const router = useRouter();

const performSearch = _.debounce(async () => {
  if (!searchQuery.value) {
    searchResults.value = [];
    return;
  }

  try {
    const matchedRoute = Object.keys(serviceMap).find((key) =>
      route.path.includes(key),
    );
    if (matchedRoute) {
      const { service, labelKey } = serviceMap[matchedRoute];
      const serviceInstance = await service();
      const response = await serviceInstance.search(searchQuery.value);
      if (response?.data?.data) {
        searchResults.value = response.data.data.map((item) => ({
          label: item[labelKey],
          slug: item.slug,
        }));
      }
    }
  } catch (error) {
    console.error("Error call API", error);
  }
}, 1000);

const onSearchInput = () => {
  performSearch();
};

const getUpdateRoute = (result) => {
  const matchedRoute = Object.keys(serviceMap).find((key) =>
    route.path.includes(key),
  );
  if (matchedRoute) {
    return {
      name: serviceMap[matchedRoute].routeName,
      params: { slug: result.slug },
    };
  }
  return {};
};

const navigateToUpdate = async (slug) => {
  const matchedRoute = Object.keys(serviceMap).find((key) =>
    route.path.includes(key),
  );
  if (matchedRoute && slug) {
    const routeName = serviceMap[matchedRoute].routeName;
    await router.push({ name: routeName, params: { slug } });
    router.go(0);
  }
  closeSearch();
};

const closeSearch = () => {
  searchQuery.value = "";
};

const logout = async () => {
  try {
    await authService.logout();

    router.push({ name: "login" });
  } catch (error) {
    console.log("Error: ", error);
  }
};
watch(searchQuery, (newValue) => {
  if (!newValue) {
    performSearch.cancel();
    searchResults.value = [];
  }
});
</script>
