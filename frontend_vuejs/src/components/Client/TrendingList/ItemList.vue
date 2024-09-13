<template>
  <div
    class="relative mb-6 flex w-full min-w-0 flex-col break-words rounded text-lg shadow-lg"
  >
    <div class="flex-auto px-2 py-3">
      <div class="tab-content tab-space">
        <div>
          <router-link
            :to="{ name: 'phim', params: { slug: movie.slug } }"
            v-for="(movie, key) in movies"
            :title="movie.name"
            class="over:shadow-xl gapx-3 group grid transform grid-cols-12 items-center pb-2 duration-300 hover:scale-105 hover:opacity-80"
          >
            <div class="col-span-2">
              <div class="font-medium text-gray-200 hover:shadow-lg">
                <span
                  class="inline-block h-7 w-7 rounded-full bg-red-600 text-center leading-7"
                >
                  {{ key + 1 }}
                </span>
              </div>
            </div>
            <div class="col-span-10 ml-1">
              <span class="text-md block truncate capitalize text-gray-200">
                {{ movie.name }}
              </span>
              <span class="text-sm text-gray-400">{{ formatNumber(movie.view) }} lượt xem</span>
            </div>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { formatNumber } from '@/utils/formatNumber';

const props = defineProps({
  movies: { type: [Object, null], required: true },
});
</script>
