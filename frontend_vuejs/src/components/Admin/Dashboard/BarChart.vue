<template>
  <Bar
    id="my-chart-id"
    :options="chartOptions"
    :data="chartData"
    class="h-full"
  />
</template>

<script setup>
import { Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from "chart.js";
import { computed, ref } from "vue";

// Đăng ký các thành phần của Chart.js
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
);

const props = defineProps({
  genre: { type: Array, required: true },
});

// Tạo dữ liệu biểu đồ từ dữ liệu bộ phim
const chartData = computed(() => ({
  labels: props.genre.map((genre) => genre.title),
  datasets: [
    {
      label: "Views",
      data: props.genre.map((genre) => genre.total_views),
      backgroundColor: "rgba(54, 162, 235, 0.2)",
      borderColor: "rgba(54, 162, 235, 1)",
      borderWidth: 1,
    },
  ],
}));

// Tạo các tùy chọn biểu đồ
const chartOptions = ref({
  responsive: true,
  scales: {
    y: {
      beginAtZero: true,
    },
  },
});
</script>

<style scoped></style>
