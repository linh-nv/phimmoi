<template>
  <div
    class="h-screen max-h-screen overflow-x-hidden overflow-y-scroll bg-gray-800 text-white"
  >
    <!-- Header -->
    <div
      class="flex items-center justify-between border-b border-gray-700 px-4 py-5 max-h-[75px] max-w-[75vw]"
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
            />
          </svg>
        </button>
        <div class="flex items-center space-x-3">
          <span
            class="rounded-sm bg-red-600 px-2 py-1 text-xs font-bold text-white"
          >
            LIVE
          </span>
          <h1 class="text-lg font-medium">{{ room.title || "Đang tải..." }}</h1>
        </div>
      </div>
      <div class="flex items-center space-x-4">
        <button
          @click="endRoom(room.code)"
          class="rounded bg-red-600 px-4 py-2 text-sm font-medium transition-colors hover:bg-red-700"
        >
          Kết thúc
        </button>
        <!-- <button
          @click="toggleSettings"
          class="rounded-full p-2 transition-colors hover:bg-gray-700"
        >
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z"
              clip-rule="evenodd"
            />
          </svg>
        </button> -->
      </div>
    </div>

    <div class="flex">
      <!-- Video Player Area -->
      <div class="relative w-3/4 bg-gray-900">
        <!-- Video Container -->
        <div class="relative aspect-video bg-black">
          <!-- Video Player -->
          <iframe
            v-if="room.status"
            :src="room?.episode?.link_embed"
            class="h-full w-full"
            frameborder="0"
            allowfullscreen
            allow="autoplay; encrypted-media"
          />
        </div>

        <!-- Action Bar -->
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
                  />
                </svg>
                <span class="text-sm text-gray-400">Chia sẻ</span>
              </button>

              <router-link
                v-if="room.movie"
                :to="{
                  name: 'phim',
                  params: { slug: room?.movie?.slug },
                  query: { title: room?.movie?.name },
                }"
                class="flex items-center space-x-2"
              >
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                  <path
                    fill-rule="evenodd"
                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                    clip-rule="evenodd"
                  />
                </svg>
                <span class="text-sm text-gray-400">Xem riêng</span>
              </router-link>
            </div>

            <div class="text-right">
              <span class="text-sm font-medium text-white">
                {{ room.user?.name || "Linh" }}
              </span>
            </div>
          </div>
        </div>

        <!-- Movie Info Section -->
        <div class="bg-gray-900 px-4 py-4">
          <div class="flex items-start space-x-4">
            <!-- Movie Poster -->
            <div class="flex-shrink-0">
              <img
                :src="room.movie?.poster_url"
                :alt="room.movie?.name"
                class="h-32 w-20 rounded-lg object-cover shadow-lg"
              />
            </div>

            <!-- Movie Details -->
            <div class="min-w-0 flex-1">
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <h2 class="mb-2 text-xl font-bold text-white">
                    {{ room.movie?.name || "M3GAN 2.0" }}
                  </h2>
                  <p class="mb-3 text-sm text-gray-400">
                    {{ room.movie?.original_name || "M3GAN 2.0" }}
                  </p>

                  <!-- Rating & Info Tags -->
                  <div class="mb-3 flex flex-wrap items-center gap-2">
                    <span
                      class="rounded bg-yellow-600 px-2 py-1 text-xs font-medium text-white"
                    >
                      {{ room.episode?.name }}
                    </span>

                    <span
                      class="rounded bg-gray-700 px-2 py-1 text-xs text-white"
                    >
                      {{ room.movie?.year || "2025" }}
                    </span>

                    <span
                      class="rounded bg-gray-700 px-2 py-1 text-xs text-white"
                    >
                      {{ room.movie?.time || "1h 40m" }}
                    </span>
                    <span
                      class="rounded bg-gray-700 px-2 py-1 text-xs text-white"
                    >
                      {{ "HD" }}
                    </span>
                  </div>

                  <!-- Genres
                  <div class="mb-3 flex flex-wrap gap-2">
                    <span
                      v-for="genre in room.movie?.genres || [
                        'Chiều Rạp',
                        'Gay Cấn',
                        'Kinh Dị',
                        'Khoa Học',
                        'Tâm Lý',
                        'Viễn Tưởng',
                      ]"
                      :key="genre"
                      class="text-sm text-gray-300"
                    >
                      {{ genre }}
                    </span>
                  </div> -->

                  <!-- Description -->
                  <p class="line-clamp-2 text-sm text-gray-300">
                    {{
                      room.movie?.description ||
                      "Phần tiếp theo của bộ phim kinh dị về con búp bê AI M3GAN. Câu chuyện tiếp tục khai thác những khía cạnh đen tối của trí tuệ nhân tạo và sự nguy hiểm tiềm ẩn khi công nghệ vượt khỏi tầm kiểm soát của con người."
                    }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Chat Panel -->
      <div
        v-if="showChat"
        class="fixed right-0 top-0 flex h-screen w-1/4 flex-col justify-between border-l border-gray-700 bg-gray-900"
      >
        <div>
          <!-- Chat Header -->
          <div class="border-b border-gray-700 bg-green-600 p-4">
            <div class="text-sm font-medium text-white">
              Buổi xem chung bắt đầu.
            </div>
            <div class="mt-1 text-xs text-green-100">
              Chúc các bạn xem phim vui vẻ!
            </div>
            <!-- Active Users -->
            <div v-if="activeUsers.length > 0" class="mt-2">
              <div class="mb-1 text-xs text-green-100">Người tham gia:</div>
              <div class="flex flex-wrap gap-1">
                <span
                  v-for="user in activeUsers"
                  :key="user.id"
                  class="inline-block rounded-full bg-green-700 px-2 py-1 text-xs text-green-100"
                >
                  {{ user.name }}
                </span>
              </div>
            </div>
          </div>

          <!-- Episode Info -->
          <div class="p-4">
            <div class="text-center text-xs text-gray-400">
              {{ room.episode?.name }} •
              {{ room.movie?.name }}
            </div>
          </div>
          <!-- Chat Messages -->
          <div
            ref="chatContainer"
            class="max-h-[78vh] flex-1 space-y-3 overflow-y-scroll p-4"
          >
            <!-- System Message -->
            <div class="rounded-lg bg-gray-800 p-3 text-sm">
              <div class="mb-1 font-medium text-yellow-400">Hệ thống</div>
              <div class="text-gray-300">Phòng đã được tạo thành công</div>
            </div>

            <!-- Chat Messages -->
            <div
              v-for="(msg, index) in chatMessages"
              :key="index"
              class="flex"
              :class="msg.isOwnMessage ? 'justify-end' : 'justify-start'"
            >
              <div
                class="group relative max-w-[80%]"
                :class="msg.isOwnMessage ? 'mr-2' : 'ml-2'"
              >
                <!-- Username -->
                <div
                  v-if="!msg.isOwnMessage && msg.userName"
                  class="mb-1 px-3 text-xs text-gray-400"
                >
                  {{ msg.userName }}
                </div>

                <div
                  class="relative rounded-lg px-3 py-2 text-sm"
                  :class="[
                    msg.isOwnMessage
                      ? 'bg-blue-600 text-white'
                      : 'bg-gray-700 text-white',
                  ]"
                >
                  <div>{{ msg.text }}</div>
                  <div
                    class="mt-1 flex items-center justify-between text-xs opacity-70"
                    :class="
                      msg.isOwnMessage ? 'text-blue-100' : 'text-gray-300'
                    "
                  >
                    <span>{{ msg.time }}</span>
                    <!-- Delete Button -->
                    <button
                      v-if="msg.isOwnMessage"
                      @click="deleteMessage(msg.id)"
                      class="ml-2 opacity-0 transition-opacity duration-200 hover:text-red-300 group-hover:opacity-100"
                      title="Xóa tin nhắn"
                    >
                      <svg
                        class="h-3 w-3"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                      >
                        <path
                          fill-rule="evenodd"
                          d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9zM4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v1H4V5zM3 8a1 1 0 011-1h12a1 1 0 110 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V9a1 1 0 01-1-1z"
                          clip-rule="evenodd"
                        />
                      </svg>
                    </button>
                  </div>
                </div>
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
              :disabled="!chatMessage.trim()"
              class="rounded-lg bg-blue-600 px-4 py-2 text-white transition-colors hover:bg-blue-700 disabled:cursor-not-allowed disabled:bg-gray-600"
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

    <!-- Delete Confirmation Modal -->
    <div
      v-if="showDeleteModal"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
      @click.self="showDeleteModal = false"
    >
      <div class="mx-4 w-96 max-w-sm rounded-lg bg-white p-6">
        <h3 class="mb-4 text-lg font-medium text-gray-900">
          Xác nhận xóa tin nhắn
        </h3>
        <p class="mb-6 text-sm text-gray-600">
          Bạn có chắc chắn muốn xóa tin nhắn này không? Hành động này không thể
          hoàn tác.
        </p>
        <div class="flex space-x-3">
          <button
            @click="confirmDeleteMessage"
            class="flex-1 rounded-md bg-red-600 px-4 py-2 text-white transition-colors hover:bg-red-700"
          >
            Xóa
          </button>
          <button
            @click="showDeleteModal = false"
            class="flex-1 rounded-md bg-gray-300 px-4 py-2 text-gray-700 transition-colors hover:bg-gray-400"
          >
            Hủy
          </button>
        </div>
      </div>
    </div>

    <!-- Room Ended Modal -->
    <div
      v-if="!room.status && room?.movie?.slug"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70"
    >
      <div
        class="mx-4 w-[420px] overflow-hidden rounded-2xl bg-gray-900 shadow-2xl"
      >
        <div class="px-6 py-4 text-center">
          <div class="text-sm font-medium text-gray-300">Đã kết thúc</div>
          <div class="mt-1 text-lg font-bold text-yellow-400">
            {{ room?.movie?.name }}
          </div>
        </div>

        <div class="flex gap-10 p-6">
          <router-link
            :to="{
              name: 'phim',
              params: { slug: room?.movie.slug },
              query: { title: room?.movie.name },
            }"
            class="flex w-full max-w-52 items-center justify-between gap-5 rounded-xl bg-white px-6 py-4 font-medium text-gray-900 transition-all duration-200 hover:bg-gray-100 hover:shadow-lg"
          >
            <i class="fa-solid fa-eye" />
            <span>Xem riêng</span>
          </router-link>

          <router-link
            :to="{
              name: 'xemchung',
              query: { title: 'Xem chung' },
            }"
            class="flex w-full max-w-52 items-center justify-between gap-5 rounded-xl border-2 border-gray-600 bg-transparent px-6 py-4 font-medium text-white transition-all duration-200 hover:border-gray-500 hover:bg-gray-800"
          >
            <i class="fa-solid fa-podcast" />
            <span>Live khác</span>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, computed, onMounted, nextTick, onUpdated } from "vue";
import { useRoute, useRouter } from "vue-router";

import { clientService } from "@/services/Client";

import { useClientStore } from "@/stores/clientStore";
import echo from "@/echo.js";

const useClient = useClientStore();
const route = useRoute();
const router = useRouter();

const getClient = computed(() => useClient.getClient || {});

const room = ref({});
const showChat = ref(true);
const chatContainer = ref(null);
const chatMessage = ref("");
const chatMessages = ref([]);
const activeUsers = ref([]); // Danh sách người tham gia
const showShareModal = ref(false);
const showDeleteModal = ref(false);
const messageToDelete = ref(null);
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
    .channel(`chat-room.${roomCode}`)
    .listen(".message.sent", (e) => {
      const messageData = e.message;
      const isOwnMessage = messageData.user_id === getClient.value.id;

      chatMessages.value.push({
        id: messageData.id,
        text: messageData.message,
        time:
          messageData.formatted_time ||
          new Date(messageData.created_at).toLocaleTimeString(),
        userName: messageData.user_name,
        userId: messageData.user_id,
        isOwnMessage: isOwnMessage,
      });

      // Cập nhật danh sách người tham gia
      updateActiveUsers(messageData.user);

      // Scroll xuống cuối
      nextTick(() => {
        scrollToBottom();
      });
    })
    .listen(".message.deleted", (e) => {
      chatMessages.value = chatMessages.value.filter(
        (msg) => msg.id !== e.messageId,
      );
    })
    .listen(".user.joined", (e) => {
      // Cập nhật danh sách khi có người tham gia
      updateActiveUsers(e.user);
    })
    .listen(".user.left", (e) => {
      // Xóa người dùng khỏi danh sách khi rời khỏi
      activeUsers.value = activeUsers.value.filter(
        (user) => user.id !== e.userId,
      );
    });
};

const updateActiveUsers = (user) => {
  if (user && user.id !== getClient.value.id) {
    const existingUser = activeUsers.value.find((u) => u.id === user.id);
    if (!existingUser) {
      activeUsers.value.push({
        id: user.id,
        name: user.name,
      });
    }
  }
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
    chatMessages.value = response.data.map((msg) => {
      const isOwnMessage = msg.user_id === getClient.value.id;

      // Cập nhật danh sách người tham gia từ tin nhắn cũ
      if (msg.user && !isOwnMessage) {
        updateActiveUsers(msg.user);
      }

      return {
        id: msg.id,
        text: msg.message,
        time:
          msg.formatted_time || new Date(msg.created_at).toLocaleTimeString(),
        userName: msg.user_name,
        userId: msg.user_id,
        isOwnMessage: isOwnMessage,
      };
    });

    // Scroll xuống cuối sau khi load tin nhắn
    nextTick(() => {
      scrollToBottom();
    });
  } catch (err) {
    console.error("Lỗi tải tin nhắn:", err);
  }
};

const sendMessage = async () => {
  if (!chatMessage.value.trim()) return;

  try {
    const response = await clientService.sendChatMessage({
      room_code: route.params.code,
      message: chatMessage.value,
      type: "text",
    });

    chatMessage.value = "";

    // Scroll xuống cuối sau khi gửi tin nhắn
    nextTick(() => {
      scrollToBottom();
    });
  } catch (err) {
    console.error("Gửi tin nhắn thất bại:", err);
  }
};

const deleteMessage = (messageId) => {
  messageToDelete.value = messageId;
  showDeleteModal.value = true;
};

const confirmDeleteMessage = async () => {
  if (!messageToDelete.value) return;

  try {
    console.log("Xóa tin nhắn với ID:", messageToDelete.value);

    await clientService.deleteChatMessage(messageToDelete.value);

    // Xóa tin nhắn khỏi local state
    chatMessages.value = chatMessages.value.filter(
      (msg) => msg.id !== messageToDelete.value,
    );

    showDeleteModal.value = false;
    messageToDelete.value = null;
  } catch (err) {
    console.error("Xóa tin nhắn thất bại:", err);
    showDeleteModal.value = false;
    messageToDelete.value = null;
  }
};

const scrollToBottom = () => {
  if (chatContainer.value) {
    chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
  }
};

const toggleSettings = () => {};

const goBack = () => {
  router.go(-1);
};

const endRoom = async (code) => {
  try {
    const res = await clientService.endPremiereRoom(code);

    router.push("/");
  } catch (error) {
    console.error("❌ Lỗi xóa phòng:", error);
  }
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

onUpdated(() => {
  scrollToBottom();
});
</script>
<style>
.loading-box {
  display: none;
}
</style>
