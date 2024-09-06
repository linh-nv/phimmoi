<template>
  <li class="py-2">
    <div
      @click="toggleSection"
      :class="['menu-item', isActive ? 'active' : '']"
    >
      <span class="flex items-center">
        <i :class="iconClass"></i>
        <p>{{ title }}</p>
      </span>
      <button class="more">
        <i
          :class="isActive ? 'fa-solid fa-angle-up' : 'fa-solid fa-angle-down'"
        ></i>
      </button>
    </div>
    <transition name="slide">
      <div
        v-if="isActive"
        class="ml-9 max-h-[50vh] mt-2 flex flex-col gap-2 overflow-y-auto text-sm"
      >
        <router-link
          v-for="(itemTitle, slug) in items"
          :key="slug"
          :to="{ name: routeName, params: { slug } }"
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
    required: true,
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
    type: [String, null], // Accept both String and null
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
</style>
