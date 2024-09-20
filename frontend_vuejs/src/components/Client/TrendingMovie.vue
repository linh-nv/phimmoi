<template>
  <div class="flex flex-wrap pl-0 md:pl-5 lg:pl-10">
    <div class="w-full">
      <span
        class="block w-full border-b border-zinc-800 pb-2 text-xl font-medium uppercase text-gray-200"
      >
        Trending
      </span>

      <!-- Buttons for Day, Week, Month -->
      <ul class="mb-2 flex list-none flex-row flex-wrap pt-2 text-lg">
        <li
          class="-mb-px mr-2 flex-auto cursor-pointer text-center last:mr-0"
          @click="showDayList"
        >
          <div
            :class="{ 'bg-zinc-700': isDay, 'bg-transparent': !isDay }"
            class="block lg:px-3 lg:py-1 text-[14px] font-medium text-gray-100"
          >
            Ngày
          </div>
        </li>
        <li
          class="-mb-px mr-2 flex-auto cursor-pointer text-center last:mr-0"
          @click="showWeekList"
        >
          <div
            :class="{ 'bg-zinc-700': isWeek, 'bg-transparent': !isWeek }"
            class="block lg:px-3 lg:py-1 text-[14px] font-medium text-gray-100"
          >
            Tuần
          </div>
        </li>
        <li
          class="-mb-px mr-2 flex-auto cursor-pointer text-center last:mr-0"
          @click="showMonthList"
        >
          <div
            :class="{ 'bg-zinc-700': isMonth, 'bg-transparent': !isMonth }"
            class="block lg:px-3 lg:py-1 text-[14px] font-medium text-gray-100"
          >
            Tháng
          </div>
        </li>
      </ul>
    </div>

    <!-- Display ItemList based on the active boolean flag -->
    <ItemList v-if="isDay && movies.day" :movies="movies.day" />
    <ItemList v-if="isWeek && movies.week" :movies="movies.week" />
    <ItemList v-if="isMonth && movies.month" :movies="movies.month" />
  </div>
</template>

<script setup>
import ItemList from "./TrendingList/ItemList.vue";
import { ref, onMounted } from "vue";
import { clientService } from "@/services/Client";

// State to hold movie data for day, week, and month
const movies = ref({});

// Boolean flags for which period is active
const isDay = ref(true);
const isWeek = ref(false);
const isMonth = ref(false);

// Fetch trending movies on mounted
onMounted(async () => {
  const response = await clientService.getTrending();
  movies.value = response.data;
});

// Methods to toggle between periods
const resetFlags = () => {
  isDay.value = false;
  isWeek.value = false;
  isMonth.value = false;
};

const showDayList = () => {
  resetFlags();
  isDay.value = true;
};

const showWeekList = () => {
  resetFlags();
  isWeek.value = true;
};

const showMonthList = () => {
  resetFlags();
  isMonth.value = true;
};
</script>
