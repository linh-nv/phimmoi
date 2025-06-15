<template>
  <div class="min-h-screen bg-black text-white">
    <!-- Header -->
    <div
      class="flex items-center justify-between border-b border-gray-700 px-4 py-2"
    >
      <div class="flex items-center space-x-4">
        <button
          @click="goBack"
          class="rounded-full p-2 transition-colors hover:bg-gray-700"
        >
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </button>
        <div class="flex items-center space-x-3">
          <span
            class="rounded-sm bg-red-600 px-2 py-1 text-xs font-bold text-white"
            >LIVE</span
          >
          <h1 class="text-lg font-medium">{{ room.title || "Đang tải..." }}</h1>
        </div>
      </div>
      <div class="flex items-center space-x-4">
        <button
          @click="endRoom"
          class="rounded bg-red-600 px-4 py-2 text-sm font-medium transition-colors hover:bg-red-700"
        >
          Kết thúc
        </button>
        <button
          @click="toggleSettings"
          class="rounded-full p-2 transition-colors hover:bg-gray-700"
        >
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </button>
      </div>
    </div>

    <div class="flex flex-1">
      <!-- Video Player Area -->
      <div class="relative flex-1 bg-gray-900">
        <!-- Video Container -->
        <div class="relative aspect-video bg-black">
          <!-- Video Player -->
          <!-- <iframe
            :src="room?.episode?.link_embed"
            class="h-full w-full"
            frameborder="0"
            allowfullscreen
            allow="autoplay; encrypted-media"
          ></iframe> -->
        </div>

        <!-- Movie Info -->
        <div class="bg-gray-800 px-4 py-3.5">
          <div class="flex items-center justify-between">
            <div class="flex items-center space-x-6">
              <button
                @click="showShareModal = true"
                class="flex items-center space-x-2 rounded px-3 py-1 transition-colors hover:bg-gray-700"
              >
                <svg
                  class="h-5 w-5 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"
                  ></path>
                </svg>
                <span class="text-sm text-gray-400">Chia sẻ</span>
              </button>

              <div class="flex items-center space-x-2">
                <svg
                  class="h-5 w-5 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                    clip-rule="evenodd"
                  ></path>
                  <path
                    d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z"
                  ></path>
                </svg>
                <span class="text-sm text-gray-400">Xem riêng</span>
              </div>
            </div>

            <div class="text-right">
              <span class="text-sm font-medium text-white">{{
                room.user?.name || "Linh"
              }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Chat Panel -->
      <div
        v-if="showChat"
        class="flex w-1/4 flex-col border-l border-gray-700 bg-gray-900"
      >
        <!-- Chat Header -->
        <div class="border-b border-gray-700 bg-green-600 p-4">
          <div class="text-sm font-medium text-white">
            Buổi xem chung bắt đầu.
          </div>
          <div class="mt-1 text-xs text-green-100">
            Chúc các bạn xem phim vui vẻ thông quen.
          </div>
        </div>

        <!-- Chat Messages -->
        <div class="flex-1 space-y-3 overflow-y-auto p-4">
          <div class="text-center text-xs text-gray-400">
            {{ room.episode?.name || "Phần 1 - Tập 5" }} •
            {{ room.movie?.name || "Khi Cuộc Đời Cho Bạn Quả Quyết" }}
          </div>

          <!-- System Messages -->
          <div class="rounded-lg bg-gray-800 p-3 text-sm">
            <div class="mb-1 font-medium text-yellow-400">Hệ thống</div>
            <div class="text-gray-300">Phòng đã được tạo thành công</div>
          </div>
        </div>
        <div class="flex-1 space-y-3 overflow-y-auto p-4">
          <div
            v-for="(msg, index) in chatMessages"
            :key="index"
            class="text-sm"
          >
            <div
              :class="[
                'rounded px-3 py-2',
                msg.type === 'sent'
                  ? 'ml-auto max-w-[80%] self-end bg-blue-700 text-white'
                  : 'max-w-[80%] bg-gray-700 text-white',
              ]"
            >
              <div>{{ msg.text }}</div>
              <div class="mt-1 text-right text-xs text-gray-300">
                {{ msg.time }}
              </div>
            </div>
          </div>
        </div>

        <!-- Chat Input -->
        <div class="border-t border-gray-700 p-4">
          <div class="flex space-x-2">
            <input
              v-model="chatMessage"
              @keyup.enter="sendMessage"
              type="text"
              placeholder="Chat gì đó..."
              class="flex-1 rounded-lg border border-gray-600 bg-gray-800 px-3 py-2 text-sm text-white placeholder-gray-400 focus:border-blue-500 focus:outline-none"
            />
            <button
              @click="sendMessage"
              class="rounded-lg bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700"
            >
              Gửi
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Share Modal -->
    <div
      v-if="showShareModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
      @click.self="showShareModal = false"
    >
      <div class="mx-4 w-96 max-w-sm rounded-lg bg-white p-6">
        <h3 class="mb-4 text-lg font-medium text-gray-900">
          Liên kết gửi bạn bè
        </h3>

        <div class="mb-4">
          <input
            ref="shareUrlInput"
            :value="shareUrl"
            readonly
            class="w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-gray-900 focus:outline-none"
          />
        </div>

        <div class="flex space-x-3">
          <button
            @click="copyShareUrl"
            class="flex-1 rounded-md bg-gray-900 px-4 py-2 text-white transition-colors hover:bg-gray-800"
          >
            {{ copyButtonText }}
          </button>
          <button
            @click="showShareModal = false"
            class="px-4 py-2 text-gray-500 transition-colors hover:text-gray-700"
          >
            Đóng
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted, nextTick } from "vue";
import { useRoute, useRouter } from "vue-router";
import { clientService } from "@/services/Client";
import echo from "@/echo.js";

const route = useRoute();
const router = useRouter();

const room = ref({});
const showChat = ref(true);
const chatMessage = ref("");
const chatMessages = ref([]); // 👈 lưu tin nhắn nhận được
const showShareModal = ref(false);
const copyButtonText = ref("Sao chép");
const shareUrlInput = ref(null);

// Kết nối channel và lắng nghe tin nhắn
onMounted(() => {
  if (route.params.code) {
    fetchMovies(route.params.code);
    fetchMessages(route.params.code);
    setupChatRealtime(route.params.code);
  }
});

const shareUrl = computed(() => window.location.href);

const setupChatRealtime = (roomCode) => {
  echo
    .join(`chat-room.${roomCode}`)
    .listen(".message.sent", (e) => {
      console.log("Tin nhắn mới:", e);
      
      chatMessages.value.push({
        id: e.message.id,
        text: e.message.message,
        time: new Date(e.message.created_at).toLocaleTimeString(),
        type:
          e.message.user_id === room.value.current_user_id
            ? "sent"
            : "received",
      });
    })
    .listen(".message.deleted", (e) => {
      chatMessages.value = chatMessages.value.filter(
        (msg) => msg.id !== e.messageId,
      );
    });
};

const fetchMovies = async (slug) => {
  try {
    const response = await clientService.getPremiereRoom(slug);
    room.value = response.data;
  } catch (error) {
    console.error("Error fetching room data:", error);
  }
};

const fetchMessages = async (roomCode) => {
  try {
    const response = await clientService.getChatMessages(roomCode);
    chatMessages.value = response.data.map((msg) => ({
      id: msg.id,
      text: msg.message,
      time: new Date(msg.created_at).toLocaleTimeString(),
      type: msg.user_id === room.value.current_user_id ? "sent" : "received",
    }));
  } catch (err) {
    console.error("Lỗi tải tin nhắn:", err);
  }
};

const sendMessage = async () => {
  if (!chatMessage.value.trim()) return;

  try {
    await clientService.sendChatMessage({
      room_code: route.params.code,
      message: chatMessage.value,
      type: "text",
    });
    chatMessage.value = "";
  } catch (err) {
    console.error("Gửi tin nhắn thất bại:", err);
  }
};

const toggleSettings = () => {};

const goBack = () => {
  router.go(-1);
};

const endRoom = () => {
  router.push("/");
};

const copyShareUrl = async () => {
  try {
    await navigator.clipboard.writeText(shareUrl.value);
    copyButtonText.value = "Đã sao chép!";
    setTimeout(() => (copyButtonText.value = "Sao chép"), 2000);
  } catch (err) {
    if (shareUrlInput.value) {
      shareUrlInput.value.select();
      shareUrlInput.value.setSelectionRange(0, 99999);
      document.execCommand("copy");
      copyButtonText.value = "Đã sao chép!";
      setTimeout(() => (copyButtonText.value = "Sao chép"), 2000);
    }
  }
};
</script>
