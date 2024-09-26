<template>
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
</template>
<script setup>
const props = defineProps({
  movie: { type: Object, required: true },
});
</script>
