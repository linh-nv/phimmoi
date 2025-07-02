<template>
  <section class="head flex items-center justify-between">
    <h1>List Accounts</h1>
    <router-link
      :to="{ name: 'account-create', query: { page: currentPage } }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
    >
      <i class="fa-solid fa-circle-plus"></i>
      <span>New account</span>
    </router-link>
  </section>
  <div class="line border border-gray-200"></div>
  <section class="table">
    <table class="w-full">
      <thead>
        <tr>
          <th>ID</th>
          <th class="long-space">Name</th>
          <th class="long-space">Email</th>
          <th>Phone</th>
          <th class="long-space">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="account in accounts.filter((item) => item.id !== admin.id)"
          :key="account.id"
        >
          <td>{{ account.id }}</td>
          <td class="long-space truncate">{{ account.name }}</td>
          <td class="long-space truncate">{{ account.email }}</td>
          <td class="truncate">{{ account.phone ?? "-" }}</td>
          <td class="long-space">
            <div class="actions text-white">
              <button @click="deleteItem(account.id)" class="bg-red-500">
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
import { useRoute, useRouter } from "vue-router";
import { authService } from "@/services/authService";
import { useAdminStore } from "@/stores/adminStore";
const adminStore = useAdminStore();
const admin = adminStore.admin;

const accounts = ref([]);
const linkNext = ref({});
const linkPrev = ref({});
const currentPage = ref(1);
const pageFrom = ref({});
const pageTo = ref({});
const pageTotal = ref({});

const route = useRoute();
const router = useRouter();

const fetchAccounts = async (page) => {
  try {
    const response = await authService.getAll(page);
    accounts.value = response.data.data;

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
    fetchAccounts(currentPage.value);
  }
};

const nextPage = () => {
  if (linkNext) {
    currentPage.value++;
    updateQueryPage(currentPage.value);
    fetchAccounts(currentPage.value);
  }
};

const updateQueryPage = (page) => {
  router.push({
    name: "account",
    query: { page },
  });
};

const deleteItem = async (id) => {
  try {
    await authService.delete(id);
    alert("account delete successfully!");
    fetchAccounts();
  } catch (error) {
    console.error(error);
  }
};

onMounted(() => {
  currentPage.value = parseInt(route.query.page) || 1;
  fetchAccounts(currentPage.value);
});

watch(route, (newRoute) => {
  if (newRoute.query.page) {
    currentPage.value = parseInt(newRoute.query.page);
    fetchAccounts(currentPage.value);
  }
});
</script>
