<template>
  <div class="h-[40vh] premiere-room-btns flex justify-center items-center">
    <div class="cards-row wide live-manager flex w-full justify-center gap-10">
      <div class="buttons line-center flex gap-3">
        <button class="btn btn-xl btn-rounded btn-light z-10" type="button">
          <i class="fa-solid fa-podcast"></i><span>Quản lý</span>
        </button>

        <!-- Tạo mới -->
        <button
          class="btn btn-xl btn-rounded btn-outline z-10"
          @click="showModal = true"
        >
          <i class="fa-solid fa-circle-plus"></i><span>Tạo mới</span>
        </button>
      </div>
    </div>

    <!-- Modal hướng dẫn -->
    <div
      v-if="showModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60"
    >
      <div
        class="relative w-[90vw] max-w-md rounded-xl bg-[#1C1E22] p-6 text-white shadow-lg"
      >
        <!-- Nút đóng -->
        <button
          class="absolute right-4 top-4 text-xl text-white hover:text-red-400"
          @click="showModal = false"
        >
          &times;
        </button>

        <!-- Tiêu đề -->
        <h2 class="mb-1 text-xl font-bold">Tạo phòng xem chung</h2>
        <p class="mb-10 text-sm text-gray-400">
          Hướng dẫn nhanh cách tạo phòng xem chung
        </p>

        <!-- Danh sách các bước -->
        <ol class="space-y-4 text-sm">
          <li>
            <p class="flex gap-2">
              <strong class="mr-2 text-yellow-400">1</strong> Tìm phim bạn muốn
              xem chung.
            </p>
          </li>
          <li>
            <p class="flex gap-2">
              <strong class="mr-2 text-yellow-400">2</strong>
              <span>
                Chuyển tới trang xem của tập phim đó, chọn biểu tượng
                <span
                  class="ml-1 inline-flex items-center rounded bg-gray-700 px-2 py-1 text-xs"
                >
                  🎬 Xem chung
                </span>
                trên thanh công cụ phía dưới player.
              </span>
            </p>
          </li>
          <li>
            <p class="flex gap-2">
              <strong class="mr-2 text-yellow-400">3</strong> Điền thông tin và
              cài đặt thời gian chiếu.
            </p>
          </li>
          <li>
            <p class="flex gap-2">
              <strong class="mr-2 text-yellow-400">4</strong> Hoàn thành và chia
              sẻ cho bạn bè.
            </p>
          </li>
        </ol>

        <!-- Nút xác nhận -->
        <div class="mt-10 text-center">
          <button
            class="w-full rounded-md bg-white px-5 py-2 font-semibold text-black hover:bg-gray-200"
            @click="showModal = false"
          >
            Đã hiểu
          </button>
        </div>
      </div>
    </div>
  </div>

	<div class="grid mt-10">
		<h2>Công chiếu</h2>
	</div>
</template>

<script setup>
import { ref } from "vue";

const showModal = ref(false);
</script>

<style scoped>
.premiere-room-btns {
  position: relative;
  overflow: hidden;
}

.premiere-room-btns::before {
  content: "";
  position: absolute;
  inset: 0;
  z-index: 0;
  background-image:
    radial-gradient(
      ellipse at center,
      rgba(0, 0, 0, 0) 60%,
      #111111 90%
    ),
    url("https://user-images.githubusercontent.com/33485020/108069438-5ee79d80-7089-11eb-8264-08fdda7e0d11.jpg");
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  opacity: 0.2;
  filter: brightness(1);
}

.btn-light {
  background-color: #fff !important;
  color: #000 !important;
  border-color: #fff !important;
  padding: 8px 16px !important;
  border-radius: 20px;
  display: flex;
  justify-content: space-between;
  gap: 10px;
  align-items: center;
}
.btn-outline {
  background-color: transparent !important;
  color: #fff !important;
  padding: 8px 16px !important;
  border-radius: 20px;
  display: flex;
  justify-content: space-between;
  gap: 10px;
  align-items: center;
  border-color: rgba(255, 255, 255, 0.5) !important;
  border-width: 1px;
  cursor: pointer;
}
</style>
