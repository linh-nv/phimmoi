<template>
  <section class="head flex items-center justify-between">
    <h1>New Movie</h1>
    <router-link
      :to="{ name: 'movie' }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-sky-500 px-4 py-2 text-white hover:bg-sky-400"
    >
      <i class="fa-solid fa-circle-plus"></i>
      <span>List movies</span>
    </router-link>
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
      <label for="origin_name">Origin Name:</label>
      <Field
        name="origin_name"
        v-model="form.origin_name"
        type="text"
        id="origin_name"
      />
      <ErrorMessage name="origin_name" class="form-message text-red-500" />
    </div>

    <div class="flex w-full flex-col">
      <label for="content">Content:</label>
      <Field as="textarea" name="content" v-model="form.content" id="content" />
      <ErrorMessage name="content" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="type">Type:</label>
      <Field name="type" v-model.number="form.type" type="number" id="type" />
      <ErrorMessage name="type" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="status">Status:</label>
      <Field
        name="status"
        v-model.number="form.status"
        type="number"
        id="status"
      />
      <ErrorMessage name="status" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="poster">Poster:</label>
      <Field
        name="poster"
        @change="handleFileChange($event, 'poster')"
        type="file"
        id="poster"
      />
      <ErrorMessage name="poster" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="thumb">Thumb:</label>
      <Field
        name="thumb"
        @change="handleFileChange($event, 'thumb')"
        type="file"
        id="thumb"
      />
      <ErrorMessage name="thumb" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <div class="flex gap-4">
        <label for="is_copyright">Is Copyright:</label>
        <Field
          name="is_copyright"
          v-model="form.is_copyright"
          type="checkbox"
          id="is_copyright"
          :true-value="true"
          :false-value="false"
        />
        <ErrorMessage name="is_copyright" class="form-message text-red-500" />
      </div>

      <div class="flex gap-4">
        <label for="sub_docquyen">Sub Docquyen:</label>
        <Field
          name="sub_docquyen"
          v-model="form.sub_docquyen"
          type="checkbox"
          id="sub_docquyen"
          :true-value="true"
          :false-value="false"
        />
        <ErrorMessage name="sub_docquyen" class="form-message text-red-500" />
      </div>

      <div class="flex gap-4">
        <label for="chieurap">Chieurap:</label>
        <Field
          name="chieurap"
          v-model="form.chieurap"
          type="checkbox"
          id="chieurap"
          :true-value="true"
          :false-value="false"
        />
        <ErrorMessage name="chieurap" class="form-message text-red-500" />
      </div>
    </div>

    <div class="form-group">
      <label for="trailer_url">Trailer URL:</label>
      <Field
        name="trailer_url"
        v-model="form.trailer_url"
        type="text"
        id="trailer_url"
      />
      <ErrorMessage name="trailer_url" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="time">Time:</label>
      <Field name="time" v-model="form.time" type="text" id="time" />
      <ErrorMessage name="time" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="episode_current">Episode Current:</label>
      <Field
        name="episode_current"
        v-model="form.episode_current"
        type="text"
        id="episode_current"
      />
      <ErrorMessage name="episode_current" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="episode_total">Episode Total:</label>
      <Field
        name="episode_total"
        v-model.number="form.episode_total"
        type="number"
        id="episode_total"
      />
      <ErrorMessage name="episode_total" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="quality">Quality:</label>
      <Field
        name="quality"
        v-model.number="form.quality"
        type="number"
        id="quality"
      />
      <ErrorMessage name="quality" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="lang">Language:</label>
      <Field name="lang" v-model="form.lang" type="text" id="lang" />
      <ErrorMessage name="lang" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="notify">Notify:</label>
      <Field name="notify" v-model="form.notify" type="text" id="notify" />
      <ErrorMessage name="notify" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="showtimes">Showtimes:</label>
      <Field
        name="showtimes"
        v-model="form.showtimes"
        type="text"
        id="showtimes"
      />
      <ErrorMessage name="showtimes" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="year">Year:</label>
      <Field name="year" v-model.number="form.year" type="number" id="year" />
      <ErrorMessage name="year" class="form-message text-red-500" />
    </div>

    <!-- Country Select -->
    <div class="flex w-full flex-wrap gap-8">
      <div class="form-group">
        <label for="country_id">Country:</label>
        <select v-model.number="form.country_id" id="country_id">
          <option v-for="[id, title] in countries" :key="id" :value="id">
            {{ title }}
          </option>
        </select>
        <ErrorMessage name="country_id" class="form-message text-red-500" />
      </div>

      <!-- Category Select -->
      <div class="form-group">
        <label for="category_id">Category:</label>
        <select v-model.number="form.category_id" id="category_id">
          <option v-for="[id, title] in categories" :key="id" :value="id">
            {{ title }}
          </option>
        </select>
        <ErrorMessage name="category_id" class="form-message text-red-500" />
      </div>
    </div>

    <div class="flex w-full flex-wrap justify-center gap-8">
      <div class="form-group">
        <label for="actor">Actor:</label>
        <div class="flex gap-2">
          <input
            v-model="actorInput"
            type="text"
            id="actor"
            @keydown.enter.prevent="addActor"
            class="flex-1"
          />
          <button
            @click.prevent="addActor"
            class="rounded-lg bg-sky-500 px-4 py-1 text-white"
          >
            Add Actor
          </button>
        </div>
        <ul class="flex flex-col gap-1">
          <Field name="actor" v-for="(actor, index) in form.actor" :key="index">
            <li
              class="flex items-center justify-between rounded-lg bg-green-50 pl-4 shadow shadow-gray-100"
            >
              {{ actor }}
              <button
                @click.prevent="removeActor(index)"
                class="rounded-lg bg-rose-500 px-1 py-2 text-white"
              >
                Remove
              </button>
            </li>
          </Field>
        </ul>
        <ErrorMessage name="actor" class="form-message text-red-500" />
      </div>

      <div class="form-group">
        <label for="director">Director:</label>
        <div class="flex gap-2">
          <input
            v-model="directorInput"
            type="text"
            id="director"
            @keydown.enter.prevent="addDirector"
            class="flex-1"
          />
          <button
            @click.prevent="addDirector"
            class="rounded-lg bg-sky-500 px-4 py-1 text-white"
          >
            Add Director
          </button>
        </div>
        <ul class="flex flex-col gap-1">
          <Field
            name="director"
            v-for="(director, index) in form.director"
            :key="index"
          >
            <li
              class="flex items-center justify-between rounded-lg bg-green-50 pl-4 shadow shadow-gray-100"
            >
              {{ director }}
              <button
                @click.prevent="removeDirector(index)"
                class="rounded-lg bg-rose-500 px-1 py-2 text-white"
              >
                Remove
              </button>
            </li>
          </Field>
        </ul>
        <ErrorMessage name="director" class="form-message text-red-500" />
      </div>
    </div>

    <div class="flex w-full flex-wrap gap-2">
      <label for="genres">Genres:</label>
      <div class="flex flex-wrap">
        <label class="w-1/4 p-2" v-for="[id, title] in genres" :key="id">
          <input type="checkbox" :value="id" v-model="form.genre_ids" />
          {{ title }}
        </label>
      </div>
      <ErrorMessage name="genre_ids" class="form-message text-red-500" />
    </div>

    <button
      class="w-2/3 rounded-md bg-blue-500 px-4 py-2 text-xl font-semibold text-white"
      type="submit"
    >
      Submit
    </button>
  </Form>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { categoryService } from "@/services/Category/category";
import { countryService } from "@/services/Country/country";
import { genreService } from "@/services/Genre/genre";
import { movieService } from "@/services/Movie/movie.js";
import { useRouter } from "vue-router";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";

const router = useRouter();
const validationSchema = yup.object({
  name: yup.string().max(255).required("Name is required"),
  slug: yup.string().max(255).required("Slug is required"),
  origin_name: yup.string().max(255).required("Origin name is required"),
  content: yup.string().required("Content is required"),
  type: yup.number().oneOf([1, 2, 3]).required("Type is required"),
  status: yup.number().oneOf([1, 2]).required("Status is required"),
  poster: yup.mixed().required("Poster is required"),
  thumb: yup.mixed().required("Thumb is required"),
  is_copyright: yup.boolean(),
  sub_docquyen: yup.boolean(),
  chieurap: yup.boolean(),
  trailer_url: yup.string().max(255).nullable(true),
  time: yup.string().max(255).nullable(true),
  episode_current: yup.string().max(255).nullable(true),
  episode_total: yup.number().max(10).nullable(true),
  quality: yup.number().oneOf([1, 2, 3]).nullable(true),
  lang: yup.string().max(255).nullable(true),
  notify: yup.string().max(255).nullable(true),
  showtimes: yup.string().max(255).nullable(true),
  year: yup
    .number()
    .min(1900)
    .max(new Date().getFullYear())
    .required("Year is required"),
  actor: yup
    .array()
    .of(yup.string().max(255))
    .min(1, "At least one actor is required"),
  director: yup
    .array()
    .of(yup.string().max(255))
    .min(1, "At least one director is required"),
  genre_ids: yup.array().of(yup.number().integer().min(1)).nullable(true),
  country_id: yup.number(),
  category_id: yup.number(),
});

useForm({
  validationSchema,
});

const form = reactive({
  name: "",
  slug: "",
  origin_name: "",
  content: "",
  type: null,
  status: null,
  poster: null,
  thumb: null,
  is_copyright: false,
  sub_docquyen: false,
  chieurap: false,
  trailer_url: "",
  time: "",
  episode_current: "",
  episode_total: null,
  quality: null,
  lang: "",
  notify: "",
  showtimes: "",
  year: null,
  actor: [],
  director: [],
  genre_ids: [],
  country_id: null,
  category_id: null,
});

const errors = ref({});
const actorInput = ref("");
const directorInput = ref("");

const handleFileChange = (event, field) => {
  form[field] = event.target.files[0];
};

const addActor = () => {
  if (actorInput.value) {
    form.actor.push(actorInput.value);
    actorInput.value = "";
  }
};

const removeActor = (index) => {
  form.actor.splice(index, 1);
};

const addDirector = () => {
  if (directorInput.value) {
    form.director.push(directorInput.value);
    directorInput.value = "";
  }
};

const removeDirector = (index) => {
  form.director.splice(index, 1);
};

const handleSubmit = async () => {
  form.chieurap = form.chieurap ? 1 : 0;
  form.is_copyright = form.is_copyright ? 1 : 0;
  form.sub_docquyen = form.sub_docquyen ? 1 : 0;
  try {
    await movieService.create(form);
    router.push({ name: "movie" });
    alert("Movie added successfully!");
  } catch (error) {
    if (error.response && error.response.data.errors) {
      errors.value = error.response.data.errors;
    } else {
      console.error(error);
    }
  }
};

const categories = ref([]);
const countries = ref([]);
const genres = ref([]);

onMounted(async () => {
  try {
    const categoryResponse = await categoryService.pluck();
    const countryResponse = await countryService.pluck();
    const genreResponse = await genreService.pluck();

    categories.value = Object.entries(categoryResponse.data);
    countries.value = Object.entries(countryResponse.data);
    genres.value = Object.entries(genreResponse.data);
  } catch (error) {
    console.error("Error fetching data", error);
  }
});
</script>
