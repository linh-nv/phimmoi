<template>
  <section class="head flex items-center justify-between">
    <h1>New Episode</h1>
    <button
      @click="router.back()"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-400"
    >
      <i class="fa-solid fa-circle-chevron-left"></i>
      <span>Back</span>
    </button>
  </section>
  <div class="line border border-gray-200"></div>
  <Form
    @submit="handleSubmit"
    :validation-schema="validationSchema"
    class="form-box"
  >
    <div class="form-group">
      <label for="name">Name:</label>
      <Field name="name" v-model="form.name" type="text" id="name" />
      <ErrorMessage name="name" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="slug">Slug:</label>
      <Field name="slug" v-model="form.slug" type="text" id="slug" />
      <ErrorMessage name="slug" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="link_embed">Link:</label>
      <Field
        name="link_embed"
        v-model="form.link_embed"
        type="text"
        id="link_embed"
      />
      <ErrorMessage name="link_embed" class="form-message text-red-500" />
    </div>

    <button
      class="w-full rounded-md bg-blue-500 px-4 py-2 text-xl font-semibold text-white"
      type="submit"
    >
      Submit
    </button>
  </Form>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { episodeService } from "@/services/Episode/episode";
import { movieService } from "@/services/Movie/movie";
import { useRouter, useRoute } from "vue-router";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import { formSchema } from "@/validation/Episode/formSchema";

const router = useRouter();
const route = useRoute();
const slug = route.params.slug;
const id = route.params.id;

const validationSchema = formSchema;

useForm({
  validationSchema,
});

const form = reactive({
  movie_id: "",
  name: "",
  slug: "",
  link_embed: "",
});

const errors = ref({});

const handleSubmit = async () => {
  try {
    if (id) {
      await episodeService.update(id, form);

      alert("Episode updated successfully!");
    } else {
      await episodeService.create(form);

      alert("Episode added successfully!");
    }

    router.push({ name: "episode" });
  } catch (error) {
    if (error.response && error.response.data.errors) {
      errors.value = error.response.data.errors;
    } else {
      console.error(error);
    }
  }
};

onMounted(async () => {
  try {
    const movieResponse = await movieService.find(slug);

    form.movie_id = movieResponse.data.id;

    if (id) {
      const response = await episodeService.find(id);
      Object.assign(form, { ...response.data });
    }
  } catch (error) {
    console.error(error);
  }
});
</script>
