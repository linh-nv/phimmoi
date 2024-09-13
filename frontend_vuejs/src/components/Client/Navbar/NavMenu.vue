<template>
  <nav
    class="fixed left-0 top-0 z-50 h-full w-full bg-[#000000aa] transition-transform duration-300"
    :class="{ '-translate-x-full': !isNavOpen, 'translate-x-0': isNavOpen }"
  >
    <div class="nav__wrap flex h-full w-3/4 flex-col gap-2 bg-black px-5 py-2">
      <div class="nav__header flex justify-end">
        <!-- Close Button -->
        <button @click="$emit('closeNav')" class="py-2 pl-2">
          <i class="fa-solid fa-xmark fa-xl"></i>
        </button>
      </div>
      <div class="nav__body">
        <ul class="logged h-16 border-b border-b-gray-800">
          <img
            loading="lazy"
            class="h-full object-contain"
            src="/src/assets/images/netflix-logo.png"
            alt=""
          />
        </ul>

        <!-- Nav body -->
        <ul id="main-menu" class="flex flex-col text-[#ffffffcc]">
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
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref, onMounted } from "vue";
import NavItem from "./NavItem.vue";
import { clientService } from "@/services/Client";

const props = defineProps({
  isNavOpen: {
    type: Boolean,
    required: true,
  },
});

const activeSection = ref(null);

const categories = ref({});
const genres = ref({});
const countries = ref({});

// Lấy dữ liệu cho các mục menu
onMounted(async () => {
  const response = await clientService.getHeader();
  categories.value = response.data.categories;
  genres.value = response.data.genres;
  countries.value = response.data.countries;
});
</script>

<style scoped></style>
