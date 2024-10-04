<template>
  <div class="comment mx-auto mt-2 border border-neutral-800 bg-neutral-900 px-4 py-3 antialiased">
    <div class="mb-4 flex items-center justify-between">
      <h2 class="text-md font-medium text-white">Bình Luận</h2>
    </div>
    <div v-if="user" class="mb-6 border-b border-zinc-800 pb-2">
      <div class="mb-4 rounded-lg rounded-t-lg border border-zinc-700 bg-zinc-800 px-4 py-2">
        <textarea
          class="w-full border-0 bg-zinc-800 px-0 text-sm text-white placeholder-zinc-400 focus:outline-none focus:ring-0"
          placeholder="Để lại bình luận..." v-model="form.comment"></textarea>
      </div>
      <button @click="createComment"
        class="inline-flex items-center rounded-lg bg-zinc-700 px-3 py-2 text-center text-xs font-medium text-white hover:opacity-90">
        Bình Luận
      </button>
    </div>
    <div v-else class="text-sm opacity-75 mb-10">Vui lòng đăng nhập để bình luận!</div>
    <div class="min-h-18">
      <div>
        <article class="mb-3 text-sm">
          <div v-for="comment in comments" class="mt-2 rounded-lg border-t border-zinc-700 bg-zinc-800 p-3">
            <div class="mb-2 flex items-center justify-between">
              <div class="flex items-center">
                <p class="mr-3 inline-flex items-center text-sm font-semibold text-zinc-300">
                <div class="mr-2 h-8 w-8 bg-zinc-600 flex justify-center items-center uppercase font-bold rounded-full">
                  {{ comment.user.name.charAt(0) }}
                </div>
                {{ comment.user.name }}
                </p>
                <p class="text-xs text-zinc-400">
                  <span>{{ formatDate(comment.updated_at) }}</span>
                </p>
              </div>
            </div>
            <p class="text-sm text-zinc-300">{{ comment.comment }}</p>
            <!-- button -->
            <div class="relative mt-2 flex items-center space-x-2 text-xs font-medium text-zinc-300">
              <!-- <button class="flex items-center hover:underline">
                Reply
              </button> -->
              <button v-if="user && user.id === comment.user.id" @click="deleteComment(comment.id)"
                class="hover:underline">
                <i class="fa-solid fa-trash-can"></i>
                Delete
              </button>
            </div>
          </div>
          <div class="text-center">
            <button v-if="linkNext" @click="fetchMoreComments"
              class="mt-2 rounded-md bg-zinc-700 px-2.5 py-1.5 font-medium text-zinc-300">
              Tải thêm bình luận
            </button>
          </div>
        </article>
      </div>
    </div>
  </div>
</template>
<script setup>
import { clientService } from "@/services/Client";
import { apiClientService } from "@/services/Client/apiClientService";
import { useClientStore } from "@/stores/clientStore";
import { onMounted, reactive, ref } from "vue";
import { useRoute } from "vue-router";

const clientStore = useClientStore();
const route = useRoute();
const slug = route.params.slug;
const comments = ref([]);
const linkNext = ref(null);
const user = clientStore.getClient ?? null;
const props = defineProps({
  movie_id: {
    type: Number,
    required: true,
  }
})
const form = reactive({
  comment: "",
  movie_id: null,
  user_id: null,
  parent_id: null
})
const fetchComment = async () => {
  const response = await clientService.getComments(slug);
  comments.value = response.data.data;
  linkNext.value = response.data.next_page_url;  
};
const fetchMoreComments = async () => {
  if (linkNext.value) {
    const response = await apiClientService.getByUrl(linkNext.value);
    comments.value = [...comments.value, ...response.data.data];
    linkNext.value = response.data.next_page_url;
  }
};

const createComment = () => {
  if (form.comment && user) {
    form.user_id = user.id;
    form.movie_id = props.movie_id;

    clientService.createComments(form);
    fetchComment();
    form.comment = "";
  }
}
const deleteComment = (id) => {
  clientService.deleteComments(id);
  fetchComment();
}
onMounted(() => {
  fetchComment();
});

const formatDate = (dateString) => {
  const date = new Date(dateString);

  const day = String(date.getDate()).padStart(2, '0');
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const year = date.getFullYear();

  return `${day}/${month}/${year}`;
}
</script>
