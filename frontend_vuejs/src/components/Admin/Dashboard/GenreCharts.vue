<template>
  <Doughnut
    id="doughnut-chart-id"
    :options="chartOptions"
    :data="chartData"
    class="h-full"
  />
</template>

<script setup>
import { Doughnut } from "vue-chartjs";
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from "chart.js";
import { computed, ref } from "vue";

// Đăng ký các thành phần cần thiết cho biểu đồ Doughnut
ChartJS.register(Title, Tooltip, Legend, ArcElement);

const props = defineProps({
  genre: { type: Array, required: true },
});

// Tạo dữ liệu biểu đồ Doughnut
const chartData = computed(() => ({
  labels: props.genre.map((genre) => genre.title),
  datasets: [
    {
      label: "Lượt xem",
      data: props.genre.map((genre) => genre.total_views),
      backgroundColor: [
        "#FF6384",
        "#36A2EB",
        "#FFCE56",
        "#4BC0C0",
        "#9966FF",
        "#FF9F40",
        "#E7E9ED",
        "#00A36C",
        "#D7263D",
        "#6B4226",
        "#D8A47F",
      ],
      borderColor: "#fff",
      borderWidth: 1,
    },
  ],
}));

// Tùy chọn hiển thị
const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: "bottom",
    },
    title: {
      display: true,
      // text: "Tỉ lệ lượt xem theo thể loại",
    },
  },
});
</script>

<style scoped>
#doughnut-chart-id {
  max-width: 600px;
  margin: auto;
}
</style>
