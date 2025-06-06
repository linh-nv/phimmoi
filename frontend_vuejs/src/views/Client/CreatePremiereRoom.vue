<template>
  <div v-if="Object.keys(movie).length !== 0" class="mb-20">
    <div class="movie-room-form">
      <!-- Left Column: Movie Poster and Info -->
      <div class="overflow-hidden rounded-lg">
        <!-- Wrapper: relative để chứa ảnh + overlay -->
        <div class="relative">
          <!-- Ảnh poster -->
          <img
            :src="movie.poster_url || movie.thumb_url"
            :alt="movie.name"
            class="h-[500px] w-full object-cover rounded-lg"
            @error="handleImageError"
          />

          <!-- Overlay tối mờ dần -->
          <div
            class="absolute inset-0 bg-gradient-to-t from-[#0E1320] to-transparent"
          ></div>

          <!-- Thông tin phim đè lên ảnh -->
          <div class="absolute bottom-0 left-0 z-10 w-full p-5 text-white">
            <h2 class="mb-1 text-xl font-bold">{{ movie.name }}</h2>
            <p v-if="movie.origin_name" class="mb-3 text-sm text-[#FFD875]">
              {{ movie.origin_name }}
            </p>

            <!-- Tag Info -->
            <div class="mb-3 flex flex-wrap gap-2 text-xs font-medium">
              <span
                v-if="movie.episode_current"
                class="rounded bg-yellow-500 px-2 py-1"
              >
                {{ movie.episode_current }}
              </span>
              <span v-if="movie.quality" class="rounded bg-gray-700 px-2 py-1">
                HD
              </span>
              <span v-if="movie.lang" class="rounded bg-gray-700 px-2 py-1">
                {{ movie.lang }}
              </span>
              <span v-if="movie.year" class="rounded bg-gray-700 px-2 py-1">
                {{ movie.year }}
              </span>
            </div>

            <!-- Mô tả -->
            <p v-if="movie.content" class="line-clamp-3 text-sm opacity-80">
              {{ movie.content }}
            </p>

            <!-- Chọn tập -->
            <div class="mt-4">
              <select
                class="w-full rounded border border-white bg-transparent px-4 py-2 text-sm text-white"
              >
                <option :value="null" disabled class="bg-[#111]">
                  Chọn tập phim
                </option>
                <option
                  v-for="(ep, index) in movie.episodes"
                  :key="ep.slug"
                  :value="ep"
                  class="bg-[#111]"
                >
                  {{ ep.name || "Tập " + (index + 1) }}
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column: Room Creation Form -->
      <div class="form-section">
        <!-- Room Name Input -->
        <div class="form-group">
          <label class="form-label">1. Tên phòng</label>
          <input
            v-model="roomData.name"
            type="text"
            class="form-input"
            :placeholder="`Cùng xem ${movie.name} nhé`"
          />
        </div>

        <!-- Poster Selection -->
        <div class="form-group">
          <label class="form-label">2. Poster hiển thị</label>
          <div class="poster-preview">
            <img
              :src="movie.poster_url"
              :alt="movie.name"
              class="preview-image"
            />
          </div>
        </div>

        <!-- Privacy Settings -->
        <div class="form-group">
          <label class="form-label">3. Bạn chỉ muốn xem với bạn bè?</label>
          <div class="privacy-notice">
            <span class="privacy-text">
              Nếu bật, chỉ có thành viên có link mới xem được phòng này.
            </span>
            <div class="toggle-switch">
              <input
                type="checkbox"
                id="private-room"
                v-model="roomData.isPrivate"
                class="toggle-input"
              />
              <label for="private-room" class="toggle-label"></label>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <button @click="createRoom" class="btn-create">Tạo phòng</button>
          <button @click="cancelRoom" class="btn-cancel">Hủy bỏ</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { clientService } from "@/services/Client";
import { computed, onMounted, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";

const router = useRouter();
const route = useRoute();
const slug = route.params.slug;
const movie = ref({});
const category = ref({});
const genres = ref({});
const country = ref({});
const episodes = ref({});
const firstEpisode = ref({});

const fetchMovies = async (slug) => {
  const response = await clientService.getMovie(slug);
  movie.value = response.data;
  category.value = response.data.category;
  genres.value = response.data.genres;
  country.value = response.data.country;
  episodes.value = response.data.episodes;
  firstEpisode.value = episodes.value[0];
};

onMounted(() => {
  fetchMovies(slug);
});

watch(route, () => {
  try {
    router.go(0);
    fetchMovies(slug);
  } catch (error) {
    console.error("Error: ", error);
  }
});

// Reactive form data
const roomData = ref({
  name: "",
  startMode: "manual", // 'auto' or 'manual'
  isPrivate: false,
});

// Computed property for room name placeholder
const roomNamePlaceholder = computed(() => {
  return movie ? `Cùng xem ${movie.name} nhé` : null;
});

// Methods for handling form actions
const createRoom = () => {
  const roomConfig = {
    name: roomData.value.name || roomNamePlaceholder.value,
    movieId: props.movie.id,
    autoStart: roomData.value.startMode === "auto",
    isPrivate: roomData.value.isPrivate,
    poster: props.movie.poster_url,
  };

  console.log("Tạo phòng với cấu hình:", roomConfig);
  // Emit event to parent component or call API
  // emit('create-room', roomConfig)
};

const cancelRoom = () => {
  console.log("Hủy tạo phòng");
  // Reset form or emit cancel event
  // emit('cancel')
};
</script>

<style scoped>
.movie-room-form {
  display: flex;
  gap: 20px;
  max-width: 1200px;
  margin: 0 auto;
  backdrop-filter: blur(10px);
}

/* Left Column - Movie Info */
.movie-info-section {
  background: linear-gradient(135deg, #0f1419 0%, #1a202c 100%);
  flex: 0 0 320px;
}

.movie-poster-wrapper {
  position: relative;
}

.movie-poster {
  width: 100%;
  height: 450px;
  object-fit: cover;
  border-radius: 12px;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
  margin-bottom: 1.5rem;
}

.movie-details {
  color: white;
}

.movie-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 0.5rem;
  line-height: 1.2;
}

.movie-origin {
  font-size: 1rem;
  color: #ffd875;
  margin-bottom: 1rem;
  font-weight: 500;
}

.movie-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.tag {
  padding: 0.25rem 0.75rem;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.tag-rating {
  background: #dc2626;
  color: white;
}
.tag-quality {
  background: #059669;
  color: white;
}
.tag-lang {
  background: #7c3aed;
  color: white;
}
.tag-year {
  background: #0891b2;
  color: white;
}
.tag-category {
  background: #ea580c;
  color: white;
}
.tag-episode {
  background: #be123c;
  color: white;
}

.movie-categories {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.category-item {
  color: #94a3b8;
  font-size: 0.875rem;
  padding: 0.25rem 0;
  border-bottom: 1px solid transparent;
  cursor: pointer;
  transition: all 0.3s ease;
}

.category-item:hover {
  color: #ffd875;
  border-bottom-color: #ffd875;
}

.category-item:not(:last-child)::after {
  content: "•";
  margin-left: 0.5rem;
  color: #475569;
}

.movie-description {
  color: #cbd5e1;
  font-size: 0.875rem;
  line-height: 1.6;
  margin-bottom: 1.5rem;
  display: -webkit-box;
  -webkit-line-clamp: 4;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.play-button {
  background: #ffd875;
  color: #1a202c;
  border: none;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.3s ease;
  width: 100%;
}

.play-button:hover {
  background: #fbbf24;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}

/* Right Column - Form */
.form-section {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-label {
  color: #ffffff;
  font-size: 0.875rem;
  font-weight: 600;
  margin-bottom: 0.75rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.form-input {
  background: #1e293b;
  border: 1px solid #334155;
  border-radius: 8px;
  padding: 1rem;
  color: #ffffff;
  font-size: 0.875rem;
  transition: all 0.3s ease;
}

.form-input:focus {
  outline: none;
  border-color: #ffd875;
  box-shadow: 0 0 0 3px rgba(255, 216, 117, 0.1);
}

.form-input::placeholder {
  color: #64748b;
}

.poster-preview {
  background: #1e293b;
  border: 1px solid #334155;
  border-radius: 8px;
  padding: 1rem;
  display: flex;
  align-items: center;
  justify-content: flex-start;
}

.preview-image {
  width: 60px;
  height: 85px;
  object-fit: cover;
  border-radius: 6px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
}

.checkbox-group {
  background: #1e293b;
  border: 1px solid #334155;
  border-radius: 8px;
  padding: 1rem;
}

.checkbox-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.custom-radio {
  width: 18px;
  height: 18px;
  accent-color: #ffd875;
}

.checkbox-label {
  color: #cbd5e1;
  font-size: 0.875rem;
  cursor: pointer;
}

.privacy-notice {
  background: #1e293b;
  border: 1px solid #334155;
  border-radius: 8px;
  padding: 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.privacy-text {
  color: #cbd5e1;
  font-size: 0.875rem;
  flex: 1;
}

.toggle-switch {
  position: relative;
}

.toggle-input {
  opacity: 0;
  width: 0;
  height: 0;
}

.toggle-label {
  display: block;
  width: 44px;
  height: 24px;
  background: #374151;
  border-radius: 12px;
  cursor: pointer;
  transition: all 0.3s ease;
  position: relative;
}

.toggle-label::after {
  content: "";
  position: absolute;
  top: 2px;
  left: 2px;
  width: 20px;
  height: 20px;
  background: #ffffff;
  border-radius: 50%;
  transition: all 0.3s ease;
}

.toggle-input:checked + .toggle-label {
  background: #ffd875;
}

.toggle-input:checked + .toggle-label::after {
  transform: translateX(20px);
}

.action-buttons {
  display: flex;
  gap: 1rem;
  margin-top: auto;
}

.btn-create {
  background: #ffd875;
  color: #1a202c;
  border: none;
  padding: 0.875rem 2rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.3s ease;
  flex: 1;
}

.btn-create:hover {
  opacity: 0.8;
  box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}

.btn-cancel {
  background: transparent;
  color: #cbd5e1;
  border: 1px solid #475569;
  padding: 0.875rem 2rem;
  border-radius: 8px;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.3s ease;
  flex: 0 0 auto;
}

.btn-cancel:hover {
  background: #374151;
  border-color: #6b7280;
  color: #ffffff;
}

/* Responsive Design */
@media (max-width: 768px) {
  .movie-room-form {
    flex-direction: column;
    gap: 2rem;
  }

  .movie-info-section {
    flex: none;
  }

  .action-buttons {
    flex-direction: column;
  }
}
</style>
