<template>
  <section class="head flex items-center justify-between">
    <h1>{{ slug ? "Edit Movie" : "New Movie" }}</h1>
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
    <!-- Poster - Thumbnail -->
    <div class="flex w-full flex-wrap gap-8">
      <div class="form-group">
        <label for="poster">Poster:</label>
        <div v-if="slug" class="w-full">
          <img :src="form.poster_url" alt="" />
        </div>
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
        <div v-if="slug" class="w-full">
          <img :src="form.thumb_url" alt="" />
        </div>
        <Field
          name="thumb"
          @change="handleFileChange($event, 'thumb')"
          type="file"
          id="thumb"
        />
      </div>
      <ErrorMessage name="thumb" class="form-message text-red-500" />
    </div>

    <!-- Name - Slug - Origin name - Content -->
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

    <!-- Type -->
    <div class="form-group">
      <label for="type">Type:</label>
      <Field as="select" v-model.number="form.type" id="type" name="type">
        <option value="" disabled>Select Type</option>
        <option v-for="[key, value] in type" :value="key">
          {{ value }}
        </option>
      </Field>
      <ErrorMessage name="type" class="form-message text-red-500" />
    </div>

    <!-- Status -->
    <div class="form-group">
      <label for="status">Status:</label>
      <Field as="select" v-model.number="form.status" id="status" name="status">
        <option value="" disabled>Select Status</option>
        <option v-for="[key, value] in movieStatus" :value="key">
          {{ value }}
        </option>
      </Field>
      <ErrorMessage name="status" class="form-message text-red-500" />
    </div>

    <!-- Is Copyright - Sub Docquyen - Chieurap -->
    <div class="form-group">
      <div class="flex gap-4">
        <label for="is_copyright">Is Copyright:</label>
        <input
          name="is_copyright"
          v-model="form.is_copyright"
          type="checkbox"
          id="is_copyright"
          :true-value="true"
          :false-value="false"
        />
      </div>
      <div class="flex gap-4">
        <label for="sub_docquyen">Sub Docquyen:</label>
        <input
          name="sub_docquyen"
          v-model="form.sub_docquyen"
          type="checkbox"
          id="sub_docquyen"
          :true-value="true"
          :false-value="false"
        />
      </div>
      <div class="flex gap-4">
        <label for="chieurap">Chieurap:</label>
        <input
          name="chieurap"
          v-model="form.chieurap"
          type="checkbox"
          id="chieurap"
          :true-value="true"
          :false-value="false"
        />
      </div>
    </div>

    <!-- Trailer URL -  -->
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

    <!-- Quality -->
    <div class="form-group">
      <label for="quality">Quality:</label>
      <Field
        as="select"
        v-model.number="form.quality"
        id="quality"
        name="quality"
      >
        <option value="" disabled>Select Quality</option>
        <option v-for="[key, value] in quality" :value="key">
          {{ value }}
        </option>
      </Field>
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

    <!-- Country - Category Select -->
    <div class="flex w-full flex-wrap gap-8">
      <div class="form-group">
        <label for="country_id">Country:</label>
        <Field
          as="select"
          v-model.number="form.country_id"
          id="country_id"
          name="country_id"
        >
          <option v-for="[id, title] in countries" :key="id" :value="id">
            {{ title }}
          </option>
        </Field>
        <ErrorMessage name="country_id" class="form-message text-red-500" />
      </div>
      <div class="form-group">
        <label for="category_id">Category:</label>
        <Field
          as="select"
          v-model.number="form.category_id"
          id="category_id"
          name="category_id"
        >
          <option v-for="[id, title] in categories" :key="id" :value="id">
            {{ title }}
          </option>
        </Field>
        <ErrorMessage name="category_id" class="form-message text-red-500" />
      </div>
    </div>

    <!-- Actor - Director -->
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

    <!-- Genre -->
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

    <!-- Submit -->
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
import { categoryService } from "@/services/Admin/Category/category";
import { countryService } from "@/services/Admin/Country/country";
import { genreService } from "@/services/Admin/Genre/genre";
import { movieService } from "@/services/Admin/Movie/movie.js";
import { enumService } from "@/services/Admin/Enum/enum.js";
import { useRouter, useRoute } from "vue-router";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import { createSchema } from "@/validation/Movie/createSchema";
import { updateSchema } from "@/validation/Movie/updateSchema";

const router = useRouter();
const route = useRoute();
const slug = route.params.slug;

const validationSchema = slug ? updateSchema : createSchema;

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
    if (slug) {
      await movieService.update(slug, form);

      alert("Movie updated successfully!");
    } else {
      await movieService.create(form);

      alert("Movie added successfully!");
    }

    router.push({ name: "movie" });
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
const type = ref([]);
const quality = ref([]);
const movieStatus = ref([]);

onMounted(async () => {
  try {
    const categoryResponse = await categoryService.pluck();
    const countryResponse = await countryService.pluck();
    const genreResponse = await genreService.pluck();
    const enumResponse = await enumService.getAll();

    categories.value = Object.entries(categoryResponse.data);
    countries.value = Object.entries(countryResponse.data);
    genres.value = Object.entries(genreResponse.data);
    type.value = Object.entries(enumResponse.data.type);
    quality.value = Object.entries(enumResponse.data.quality);
    movieStatus.value = Object.entries(enumResponse.data["movie-status"]);

    if (slug) {
      const response = await movieService.find(slug);

      form.genre_ids = response.data.genres.map((genre) => genre.id);
      Object.assign(form, {
        ...response.data,
        actor: response.data.actor.split(","),
        director: response.data.director.split(","),
        category_id: response.data.category.id,
        country_id: response.data.country.id,
        genres: response.data.genres,
      });
    }
  } catch (error) {
    console.error("Error fetching data", error);
  }
});
</script>
