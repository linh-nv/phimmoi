<template>
  <li class="py-2 md:relative md:py-0">
    <div
      @click="toggleSection"
      :class="[
        'menu-item md:flex md:gap-2 md:text-nowrap',
        isActive ? 'active' : '',
      ]"
    >
      <span v-if="Object.keys(items).length > 0" class="flex items-center">
        <i :class="iconClass" class="md:hidden"></i>
        <p>{{ title }}</p>
      </span>
      
      <router-link
        v-else
        class="flex items-center"
        :to="{
          name: 'xemchung',
          query: { title: 'Xem chung' },
        }"
      >
        <i :class="iconClass" class="md:hidden"></i>
        <p>{{ title }}</p>
      </router-link>

      <button class="more" v-if="Object.keys(items).length > 0">
        <i
          :class="isActive ? 'fa-solid fa-angle-up' : 'fa-solid fa-angle-down'"
        ></i>
      </button>
    </div>
    <transition name="slide" v-if="Object.keys(items).length > 0">
      <div
        v-if="isActive"
        class="ml-9 mt-2 flex max-h-[50vh] flex-col gap-2 overflow-y-auto text-sm md:absolute md:left-0 md:mx-0 md:grid md:h-fit md:w-max md:max-w-[40vw] md:grid-cols-3 md:items-center md:justify-center md:gap-5 md:overflow-x-hidden md:rounded-lg md:bg-black md:p-5 md:shadow-lg lg:max-w-[50vw] xl:max-w-[60vw] xl:grid-cols-4"
      >
        <router-link
          v-for="(itemTitle, slug) in items"
          :key="slug"
          :to="{
            name: routeName,
            params: { slug },
            query: { title: itemTitle },
          }"
          @click="onClose()"
          class="flex w-full hover:text-red-400 md:justify-center"
        >
          {{ itemTitle }}
        </router-link>
      </div>
    </transition>
  </li>
</template>

<script setup>
import { computed } from "vue";
const props = defineProps({
  items: {
    type: Object,
    // required: true,
    default: () => ({}),
  },
  title: {
    type: String,
    required: true,
  },
  iconClass: {
    type: String,
    required: true,
  },
  sectionKey: {
    type: String,
    required: true,
  },
  activeSection: {
    type: [String, null],
    required: true,
  },
  routeName: {
    type: String,
    required: true,
  },
});

const isActive = computed(() => props.activeSection === props.sectionKey);

const emit = defineEmits(["update:activeSection"]);
const toggleSection = () => {
  emit("update:activeSection", isActive.value ? null : props.sectionKey);
};

const onClose = () => {
  emit("update:activeSection", null);
};
</script>

<style scoped>
.menu-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 10px;
  color: #ffffffcc;
  cursor: pointer;
  transition:
    background-color 0.3s ease,
    color 0.3s ease;
}

.menu-item.active {
  color: white;
  border-left: 4px solid #ef4444;
}

/* Transition */
.slide-enter-active,
.slide-leave-active {
  transition:
    max-height 0.5s ease,
    opacity 0.5s ease;
}
.slide-enter-from,
.slide-leave-to {
  max-height: 0;
  opacity: 0;
}
.slide-enter-to,
.slide-leave-from {
  max-height: 50vh;
  opacity: 1;
}

@media (min-width: 768px) {
  .menu-item.active {
    color: white;
    border-left: 0;
    border-bottom: 4px solid #ef4444;
  }
}
</style>
