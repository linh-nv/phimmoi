<template>
  <nav
    class="fixed left-0 top-0 z-50 h-full w-full bg-[#000000aa] transition-transform duration-300 md:relative md:translate-x-0 md:bg-transparent"
    :class="{ '-translate-x-full': !isNavOpen, 'translate-x-0': isNavOpen }"
  >
    <div
      class="nav__wrap flex h-full w-3/4 flex-col gap-2 bg-black px-5 py-2 md:my-auto md:w-fit md:bg-transparent"
    >
      <div class="nav__header flex justify-end md:hidden">
        <!-- Close Button -->
        <button @click="$emit('closeNav')" class="py-2 pl-2">
          <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>
      <div class="nav__body">
        <ul class="logged h-16 border-b border-b-gray-800 md:hidden">
          <img
            loading="lazy"
            class="h-full object-contain"
            src="/src/assets/images/netflix-logo.png"
            alt=""
          />
        </ul>

        <!-- Nav body -->
        <ul
          id="main-menu"
          class="flex flex-col text-[#ffffffcc] md:flex-row md:gap-5"
        >
          <!-- Category -->
          <NavItem
            title="Thể loại"
            :items="categories"
            icon-class="fa-solid fa-layer-group w-9"
            section-key="categories"
            v-model:activeSection="activeSection"
            route-name="theloai"
          />

          <!-- Genre -->
          <NavItem
            title="Danh mục"
            :items="genres"
            icon-class="fa-solid fa-list w-9"
            section-key="genres"
            v-model:activeSection="activeSection"
            route-name="danhmuc"
          />

          <!-- Country -->
          <NavItem
            title="Quốc gia"
            :items="countries"
            icon-class="fa-solid fa-globe w-9"
            section-key="countries"
            v-model:activeSection="activeSection"
            route-name="quocgia"
          />

          <!-- <a
            :href="`http://localhost:5173/home`"
            class="flex items-center gap-2"
          >
            Mạng xã hội
          </a> -->

          <NavItem
            v-if="user"
            title="Xem chung"
            icon-class="fa-solid fa-globe w-9"
            section-key="premiere_rooms"
            v-model:activeSection="activeSection"
            route-name="xemchung"
          />
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from "vue";
import NavItem from "./NavItem.vue";
import { clientService } from "@/services/Client";
import { clientCookieService } from "@/services/Client/clientCookieService";
import { useClientStore } from "@/stores/clientStore";

const props = defineProps({
  isNavOpen: {
    type: Boolean,
    required: true,
  },
});
const clientStore = useClientStore();

const user = clientStore.getClient ?? null;

const activeSection = ref(null);

const categories = ref({});
const genres = ref({});
const countries = ref({});
const refreshToken = clientCookieService.getRefreshToken();

onMounted(async () => {
  const response = await clientService.getHeader();
  categories.value = response.data.categories;
  genres.value = response.data.genres;
  countries.value = response.data.countries;
});
</script>

<style scoped></style>
