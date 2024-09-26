<template>
  <div>
    <!-- Nút quay lại -->
    <button
      v-if="selectedEpisode"
      @click="exitEpisode"
      class="fixed left-4 top-4 z-[99] flex items-center justify-center gap-2 rounded-full bg-neutral-800 px-4 py-2 text-white hover:bg-neutral-600"
    >
      <i class="fa-solid fa-chevron-left"></i>
      Quay lại
    </button>

    <!-- Thông tin tập phim -->
    <transition name="fade" mode="out-in">
      <div
        v-if="selectedEpisode && !showIframe"
        :class="{ 'opacity-100': isVisible }"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-85 opacity-0 transition-opacity duration-500 ease-in-out"
      >
        <div
          class="relative flex h-full w-full flex-col p-6 text-white shadow-lg"
        >
          <!-- Lớp phủ làm mờ nền -->
          <div
            class="absolute inset-0 z-10 bg-black opacity-50"
            :style="{
              backgroundImage: `url(${movie.thumb_url})`,
              backgroundSize: 'cover',
              backgroundPosition: 'center',
            }"
          ></div>

          <!-- Nội dung -->
          <div class="relative z-20 px-5 py-20">
            <h2 class="mb-2 text-3xl font-bold">{{ movie.name }}</h2>
            <h3 class="mb-2 text-2xl font-semibold">{{ movie.origin_name }}</h3>
            <p class="mb-4 text-xl">{{ selectedEpisode.name }}</p>
            <p class="opacity-80">Đang chuyển đến video...</p>
          </div>
        </div>
      </div>
    </transition>

    <!-- Video -->
    <transition name="fade" mode="out-in">
      <div v-if="showIframe" class="relative">
        <iframe
          :src="selectedEpisode.link_embed"
          class="fixed inset-0 z-50 h-full w-full"
          frameborder="0"
          allowfullscreen
          allow="autoplay"
        ></iframe>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { defineProps, defineEmits, ref, watch, computed } from "vue";

const props = defineProps({
  movie: Object,
  selectedEpisode: Object,
  showIframe: Boolean,
  isVisible: Boolean,
});

const emit = defineEmits(["exitEpisode"]);
const showIframe = ref(false);
const isVisible = ref(false);

// Đồng bộ hóa ref cục bộ với props
const localShowIframe = computed({
  get: () => showIframe.value,
  set: (val) => {
    showIframe.value = val;
    emit("update:showIframe", val);
  },
});

const localIsVisible = computed({
  get: () => isVisible.value,
  set: (val) => {
    isVisible.value = val;
    emit("update:isVisible", val);
  },
});

const exitEpisode = () => {
  emit("exitEpisode");
};

watch(
  () => props.selectedEpisode,
  (newValue) => {
    if (newValue) {
      showIframe.value = false;
      isVisible.value = false;

      setTimeout(() => {
        isVisible.value = true;
      }, 100);
      setTimeout(() => {
        showIframe.value = true;
      }, 2000);
    }
  },
  { immediate: true },
);

watch(
  () => props.showIframe,
  (newValue) => {
    showIframe.value = newValue;
  },
);

watch(
  () => props.isVisible,
  (newValue) => {
    isVisible.value = newValue;
  },
);
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition:
    opacity 1s ease,
    transform 0.5s ease;
}
.fade-enter,
.fade-leave-to {
  opacity: 0;
  transform: scale(1.1);
}
</style>
