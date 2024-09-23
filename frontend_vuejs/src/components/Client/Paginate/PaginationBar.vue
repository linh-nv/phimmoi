<template>
  <div class="pagination-bar">
    <button
      v-for="link in pagination.links"
      :key="link.label"
      :class="['pagination-button', { active: link.active }]"
      @click="link.url ? goToPage(link.url) : null"
      :disabled="!link.url || link.active"
    >
      <span v-html="link.label"></span>
    </button>
  </div>
</template>

<script setup>
import { defineEmits, defineProps } from "vue";

// Nhận props từ component cha
const props = defineProps({
  pagination: {
    type: Object,
    required: true,
  },
});
console.log(props.pagination);

// Phát sự kiện paginate khi người dùng chuyển trang
const emit = defineEmits(["paginate"]);

function goToPage(url) {
  emit("paginate", url);
}
</script>

<style scoped>
.pagination-bar {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 5px;
  margin-top: 20px;
}

.pagination-button {
  padding: 5px 10px;
  border: 1px solid #ccc;
  cursor: pointer;
  border-radius: 5px;
}

.pagination-button.active {
  background-color: #007bff;
  color: white;
  cursor: default;
}

.pagination-button:disabled {
  cursor: not-allowed;
  opacity: 0.6;
}
</style>
