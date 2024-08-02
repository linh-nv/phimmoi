<template>
  <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>

<script setup>
import { ref } from "vue";
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

// Đăng ký các thành phần của Chart.js
ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
);

const movieViews = [
  { name: "Movie 1", views: 1500 },
  { name: "Movie 2", views: 1200 },
  { name: "Movie 3", views: 1100 },
  { name: "Movie 4", views: 900 },
  { name: "Movie 5", views: 850 },
  { name: "Movie 6", views: 800 },
  { name: "Movie 7", views: 750 },
  { name: "Movie 8", views: 700 },
  { name: "Movie 9", views: 650 },
  { name: "Movie 10", views: 600 },
];

// Tạo dữ liệu biểu đồ từ dữ liệu bộ phim
const chartData = ref({
  labels: movieViews.map((movie) => movie.name),
  datasets: [
    {
      label: "Views",
      data: movieViews.map((movie) => movie.views),
      backgroundColor: "rgba(54, 162, 235, 0.2)",
      borderColor: "rgba(54, 162, 235, 1)",
      borderWidth: 1,
    },
  ],
});

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
