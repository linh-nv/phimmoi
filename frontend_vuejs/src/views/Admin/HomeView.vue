<template>
  <h1>Dashboard</h1>
  <section class="mb-4 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
    <!-- Stats cards -->
    <div class="rounded-lg bg-white p-4 shadow">
      <h2>New Users In The Month</h2>
      <p class="text-3xl font-bold">40,689</p>
      <p class="text-green-500">8.5% Up from yesterday</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
      <h2>Views In The Month</h2>
      <p class="text-3xl font-bold">10,293</p>
      <p class="text-green-500">1.3% Up from past week</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
      <h2>Visits During The Month</h2>
      <p class="text-3xl font-bold">$89,000</p>
      <p class="text-red-500">4.3% Down from yesterday</p>
    </div>
    <div class="rounded-lg bg-white p-4 shadow">
      <h2>New Movies Of The Month</h2>
      <p class="text-3xl font-bold">2,040</p>
      <p class="text-green-500">1.8% Up from yesterday</p>
    </div>
  </section>

  <section class="mb-4 rounded-lg bg-white p-4 shadow">
    <!-- Sales Details chart -->
    <h2 class="mb-4">Views Categories Of The Month</h2>
    <BarChart />
  </section>
</template>
<script setup>
import BarChart from "@/components/Dashboard/BarChart.vue";
</script>
