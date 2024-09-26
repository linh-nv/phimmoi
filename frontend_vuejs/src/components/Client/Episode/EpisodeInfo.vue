<template>
  <div class="pb-3">
    <h3
      class="block text-sm font-medium uppercase tracking-wider text-zinc-300"
    >
      Tóm Tắt
    </h3>
    <div class="block pt-3 text-justify leading-relaxed text-gray-400">
      <b>{{ movie.name }}</b>
      <p v-html="movie.content"></p>
    </div>
  </div>
  <div class="mt-6">
    <h3 class="text-sm font-medium uppercase text-zinc-300">Thông tin</h3>
    <div class="mt-4">
      <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
        <li class="text-zinc-400">
          <span>Tên gốc: </span>
          <span class="inline-block text-zinc-300">
            {{ movie.origin_name }}
          </span>
        </li>
        <li class="text-zinc-400">
          <span>Tên khác: </span>
          <span class="inline-block text-zinc-300">
            {{ movie.name }}
          </span>
        </li>
        <li class="text-zinc-400">
          <span>Số tập: </span
          ><span class="inline-block text-zinc-300">
            {{ movie.episode_total }}
          </span>
        </li>
        <li class="text-zinc-400">
          <span>Thời lượng: </span>
          <span class="inline-block text-zinc-300">
            {{ movie.time }}
          </span>
        </li>
        <li class="text-zinc-400">
          <span>Sub: </span>
          <span class="inline-block text-zinc-300">
            {{ movie.lang }}
          </span>
        </li>
      </ul>
    </div>
  </div>
</template>
<script setup>
const props = defineProps({
  movie: { type: Object, required: true },
});
</script>
