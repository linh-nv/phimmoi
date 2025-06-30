<template>
  <h1 class="py-2 text-center text-2xl font-normal uppercase text-gray-200">
    Phòng xem chung của bạn {{ rooms?.length > 0 ? `(${rooms.length})` : "" }}
  </h1>
  <div class="my-10">
    <div
      class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
    >
      <div
        v-for="room in rooms"
        :key="room.id"
        class="premiere-card relative overflow-hidden rounded-lg bg-gradient-to-b from-gray-800 to-gray-900 transition-transform hover:scale-105"
      >
        <!-- Thumbnail phim -->
        <div class="relative aspect-video">
          <img
            :src="room.movie.thumb_url"
            :alt="room.movie.name"
            class="h-full w-full object-cover"
          />

          <!-- Status badge -->
          <div class="absolute left-2 top-2 flex items-center gap-2">
            <span
              v-if="room.status === 1"
              class="rounded bg-green-500 px-2 py-1 text-xs font-semibold text-white"
            >
              Đang phát
            </span>
            <span
              v-else
              class="rounded bg-red-500 px-2 py-1 text-xs font-semibold text-white"
            >
              Đã kết thúc
            </span>
            <span
              v-if="room.isPublic === false"
              class="rounded bg-gray-700 px-2 py-1 text-xs font-semibold text-white"
            >
              Riêng tư
            </span>
          </div>

          <!-- Play button overlay -->
          <div
            class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30 opacity-0 transition-opacity hover:opacity-100"
          >
            <router-link
              :to="{
                name: 'phim',
                params: { slug: room?.movie.slug },
                query: { title: room?.movie.name },
              }"
              class="aspect-square cursor-pointer rounded-full bg-white bg-opacity-20 p-3"
            >
              <i class="fa-solid fa-play text-xl text-white"></i>
            </router-link>
          </div>
        </div>

        <!-- Thông tin phòng -->
        <div class="p-4">
          <!-- Tiêu đề phòng -->
          <h3 class="mb-2 line-clamp-2 text-sm font-semibold text-white">
            {{ room.title }}
          </h3>

          <!-- Thông tin phim -->
          <div class="space-y-1 text-xs text-gray-400">
            <p class="flex items-center gap-2">
              <i class="fa-solid fa-film"></i>
              <span class="truncate">{{ room.movie.name }}</span>
            </p>

            <p class="flex items-center gap-2">
              <i class="fa-solid fa-play-circle"></i>
              <span>{{ room.episode.name }}</span>
            </p>

            <p class="flex items-center gap-2">
              <i class="fa-solid fa-user"></i>
              <span>{{ room.user.name }}</span>
            </p>
          </div>

          <!-- Thống kê phòng -->
          <div
            class="mt-3 flex items-center justify-between text-xs text-gray-500"
          >
            <div class="flex items-center gap-3">
              <span class="flex items-center gap-1">
                <i class="fa-solid fa-users"></i>
                {{ room.online_users_count }}
              </span>
              <span class="flex items-center gap-1">
                <i class="fa-solid fa-comments"></i>
                {{ room.total_messages_count }}
              </span>
            </div>
            <span>{{ room.last_activity }}</span>
          </div>

          <!-- Nút tham gia -->
          <button
            class="mt-3 w-full rounded bg-blue-600 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-600"
            :disabled="room.status === 0"
            @click="joinRoom(room.code)"
          >
            <span v-if="room.status === 1">Tham gia</span>
            <span v-else>Đã kết thúc</span>
          </button>
        </div>
      </div>
    </div>

    <!-- Hiển thị khi không có phòng -->
    <div v-if="!rooms || rooms.length === 0" class="py-12 text-center">
      <div class="text-lg text-gray-400">
        <i class="fa-solid fa-film mb-4 block text-4xl"></i>
        <p>Chưa có phòng xem chung nào của bạn</p>
        <p class="mt-2 text-sm">Hãy tạo phòng đầu tiên!</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { clientService } from "@/services/Client";
import { useClientStore } from "@/stores/clientStore";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

const rooms = ref(false);
const router = useRouter();
const clientStore = useClientStore();
const user = clientStore.getClient ?? null;

const fetchData = async () => {
  try {
    const response = await clientService.getPrivatePremiereRoom(user.id);
    rooms.value = response.data;
  } catch (error) {
    console.error("Error fetching room data:", error);
  }
};

onMounted(() => {
  fetchData();
});

const joinRoom = (code) => {
  router.push({ name: "room-detail", params: { code: code } });
};
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
  background-image: radial-gradient(
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
