<template>
  <div class="pagination-bar border-b border-gray-400 md:border-none">
    <div class="pagination-content">
      Showing page <span>{{ pagination.current_page }}</span> of
      {{ pagination.last_page }}
    </div>
    <div class="pagination-button">
      <button
        @click="
          pagination.prev_page_url ? goToPage(pagination.prev_page_url) : null
        "
        :disabled="!pagination.prev_page_url"
      >
        <span><i class="fa-solid fa-caret-left"></i></span>
      </button>
      <button
        @click="
          pagination.next_page_url ? goToPage(pagination.next_page_url) : null
        "
        :disabled="!pagination.next_page_url"
      >
        <span><i class="fa-solid fa-caret-right"></i></span>
      </button>
    </div>
  </div>
</template>

<script setup>
import { defineEmits, defineProps } from "vue";

const props = defineProps({
  pagination: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(["paginate"]);

function goToPage(url) {
  emit("paginate", url);
}
</script>
<style scoped>
.pagination-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 20px;
  margin-bottom: 20px;
}
.pagination-content span {
  font-weight: 600;
  color: #60a5fa;
}
.pagination-button {
  display: flex;
  gap: 10px;
}
.pagination-button button {
  padding: 5px 10px;
  cursor: pointer;
  border-radius: 5px;
  background-color: #414144;
}

.pagination-button:disabled {
  cursor: not-allowed;
  opacity: 0.6;
}
</style>
