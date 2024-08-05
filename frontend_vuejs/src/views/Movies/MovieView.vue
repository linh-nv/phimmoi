<template>
  <section class="flex flex-col gap-6">
    <section class="head flex items-center justify-between">
      <h1>List Movies</h1>
      <route-view
        :to="MovieForm"
        class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
      >
        <i class="fa-solid fa-circle-plus"></i>
        <span>New movie</span>
      </route-view>
    </section>
    <div class="line border border-gray-200"></div>
    <section class="table">
      <table class="w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Poster</th>
            <th class="long-space">Title</th>
            <th>Episode Total</th>
            <th>Episode Current</th>
            <th>Year</th>
            <th>Status</th>
            <th>Views</th>
            <th class="long-space">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>
              <img
                src="https://phimimg.com/upload/vod/20240423-1/7b281d88350fd638d84dc9abb5b6b0a6.jpg"
                alt="poster"
              />
            </td>
            <td class="long-space">
              Maiassssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss
            </td>
            <td>Maisdfhdsfhdsfhdfshdsf</td>
            <td>Maisdfhdfffffffffffffffffffffffffffffffffffffffffffhsdfhsdf</td>
            <td>Maisdfhdsfhdsfhdfshsdfhdfshsdffffffffffffhsd</td>
            <td>Maidsfhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh</td>
            <td>
              Maisdfffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff
            </td>
            <td class="long-space">
              <div class="actions text-white">
                <button class="bg-green-500">
                  <i class="fa-solid fa-circle-info"></i>
                </button>
                <button class="bg-sky-500">
                  <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="bg-red-500">
                  <i class="fa-solid fa-trash-can"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </section>
  </section>
</template>

<script setup>
import MovieForm from "./MovieForm.vue";
</script>

<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
  background-color: #fff;
  border-radius: 1rem;
  box-shadow: 0 0 1px 1px #e5e7eb;
  padding: 1rem;
}

th,
td {
  padding: 1rem;
  text-align: center;
}

th {
  width: calc(100% / 9);
}

td {
  width: calc(100% / 9);
}

.long-space {
  word-break: break-word;
  white-space: normal;
  overflow: unset;
  width: 20%;
}

td {
  text-overflow: ellipsis;
  overflow: hidden;
}

thead,
tbody {
  display: table;
  width: 100%;
  table-layout: fixed;
}

tr {
  border-bottom: 1px solid #e5e7eb;
}

tbody {
  width: 100%;
  overflow-y: auto;
}

.actions {
  word-break: break-word;
  white-space: normal;
  overflow: unset;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
}

.actions button {
  word-break: break-word;
  white-space: normal;
  overflow: unset;
  display: block;
  padding: 0.25rem;
  border-radius: 50%;
  aspect-ratio: 4;
  white-space: wrap;
}
</style>
