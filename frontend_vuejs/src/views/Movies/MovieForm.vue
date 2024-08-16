<template>
  <Form @submit="handleSubmit" :validation-schema="validationSchema">
    <div>
      <label for="name">Name:</label>
      <Field name="name" v-model="form.name" type="text" id="name" />
      <ErrorMessage name="name" class="form-message text-red-500" />
    </div>

    <div>
      <label for="slug">Slug:</label>
      <Field name="slug" v-model="form.slug" type="text" id="slug" />
      <ErrorMessage name="slug" class="form-message text-red-500" />
    </div>

    <div>
      <label for="origin_name">Origin Name:</label>
      <Field
        name="origin_name"
        v-model="form.origin_name"
        type="text"
        id="origin_name"
      />
      <ErrorMessage name="origin_name" class="form-message text-red-500" />
    </div>

    <div>
      <label for="content">Content:</label>
      <Field as="textarea" name="content" v-model="form.content" id="content" />
      <ErrorMessage name="content" class="form-message text-red-500" />
    </div>

    <div>
      <label for="type">Type:</label>
      <Field name="type" v-model.number="form.type" type="number" id="type" />
      <ErrorMessage name="type" class="form-message text-red-500" />
    </div>

    <div>
      <label for="status">Status:</label>
      <Field
        name="status"
        v-model.number="form.status"
        type="number"
        id="status"
      />
      <ErrorMessage name="status" class="form-message text-red-500" />
    </div>

    <div>
      <label for="poster">Poster:</label>
      <Field
        name="poster"
        @change="handleFileChange($event, 'poster')"
        type="file"
        id="poster"
      />
      <ErrorMessage name="poster" class="form-message text-red-500" />
    </div>

    <div>
      <label for="thumb">Thumb:</label>
      <Field
        name="thumb"
        @change="handleFileChange($event, 'thumb')"
        type="file"
        id="thumb"
      />
      <ErrorMessage name="thumb" class="form-message text-red-500" />
    </div>

    <div>
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

    <div>
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

    <div>
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

    <div>
      <label for="trailer_url">Trailer URL:</label>
      <Field
        name="trailer_url"
        v-model="form.trailer_url"
        type="text"
        id="trailer_url"
      />
      <ErrorMessage name="trailer_url" class="form-message text-red-500" />
    </div>

    <div>
      <label for="time">Time:</label>
      <Field name="time" v-model="form.time" type="text" id="time" />
      <ErrorMessage name="time" class="form-message text-red-500" />
    </div>

    <div>
      <label for="episode_current">Episode Current:</label>
      <Field
        name="episode_current"
        v-model="form.episode_current"
        type="text"
        id="episode_current"
      />
      <ErrorMessage name="episode_current" class="form-message text-red-500" />
    </div>

    <div>
      <label for="episode_total">Episode Total:</label>
      <Field
        name="episode_total"
        v-model.number="form.episode_total"
        type="number"
        id="episode_total"
      />
      <ErrorMessage name="episode_total" class="form-message text-red-500" />
    </div>

    <div>
      <label for="quality">Quality:</label>
      <Field
        name="quality"
        v-model.number="form.quality"
        type="number"
        id="quality"
      />
      <ErrorMessage name="quality" class="form-message text-red-500" />
    </div>

    <div>
      <label for="lang">Language:</label>
      <Field name="lang" v-model="form.lang" type="text" id="lang" />
      <ErrorMessage name="lang" class="form-message text-red-500" />
    </div>

    <div>
      <label for="notify">Notify:</label>
      <Field name="notify" v-model="form.notify" type="text" id="notify" />
      <ErrorMessage name="notify" class="form-message text-red-500" />
    </div>

    <div>
      <label for="showtimes">Showtimes:</label>
      <Field
        name="showtimes"
        v-model="form.showtimes"
        type="text"
        id="showtimes"
      />
      <ErrorMessage name="showtimes" class="form-message text-red-500" />
    </div>

    <div>
      <label for="year">Year:</label>
      <Field name="year" v-model.number="form.year" type="number" id="year" />
      <ErrorMessage name="year" class="form-message text-red-500" />
    </div>

    <div>
      <label for="actor">Actor:</label>
      <input
        v-model="actorInput"
        type="text"
        id="actor"
        @keydown.enter.prevent="addActor"
      />
      <button @click.prevent="addActor">Add Actor</button>
      <ul>
        <Field name="actor" v-for="(actor, index) in form.actor" :key="index">
          {{ actor }}
          <button @click.prevent="removeActor(index)">Remove</button>
        </Field>
      </ul>
      <ErrorMessage name="actor" class="form-message text-red-500" />
    </div>

    <div>
      <label for="director">Director:</label>
      <input
        v-model="directorInput"
        type="text"
        id="director"
        @keydown.enter.prevent="addDirector"
      />
      <button @click.prevent="addDirector">Add Director</button>
      <ul>
        <Field
          name="director"
          v-for="(director, index) in form.director"
          :key="index"
        >
          {{ director }}
          <button @click.prevent="removeDirector(index)">Remove</button>
        </Field>
      </ul>
      <ErrorMessage name="director" class="form-message text-red-500" />
    </div>

    <div>
      <label for="genre_ids">Genres:</label>
      <Field
        name="genre_ids"
        v-model.number="genreInput"
        type="number"
        id="genre_ids"
        @keydown.enter.prevent="addGenre"
      />
      <button @click.prevent="addGenre">Add Genre</button>
      <ul>
        <li v-for="(genre, index) in form.genre_ids" :key="index">
          {{ genre }}
          <button @click.prevent="removeGenre(index)">Remove</button>
        </li>
      </ul>
      <ErrorMessage name="genre_ids" class="form-message text-red-500" />
    </div>

    <div>
      <label for="country_id">Country:</label>
      <Field
        name="country_id"
        v-model.number="form.country_id"
        type="number"
        id="country_id"
      />
      <ErrorMessage name="country_id" class="form-message text-red-500" />
    </div>

    <div>
      <label for="category_id">Category:</label>
      <Field
        name="category_id"
        v-model.number="form.category_id"
        type="number"
        id="category_id"
      />
      <ErrorMessage name="category_id" class="form-message text-red-500" />
    </div>

    <button type="submit">Add Movie</button>
  </Form>
</template>

<script setup>
import { ref, reactive } from "vue";
import { movieService } from "@/services/Movie/movie.js";
import { useRoute } from "vue-router";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";

const route = useRoute();

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
  country_id: yup.number().required("Country is required"),
  category_id: yup.number().required("Category is required"),
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
const genreInput = ref(null);

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

const addGenre = () => {
  if (genreInput.value) {
    form.genre_ids.push(genreInput.value);
    genreInput.value = null;
  }
};

const removeGenre = (index) => {
  form.genre_ids.splice(index, 1);
};

const handleSubmit = async () => {
  form.chieurap = form.chieurap ? 1 : 0;
  form.is_copyright = form.is_copyright ? 1 : 0;
  form.sub_docquyen = form.sub_docquyen ? 1 : 0;
  try {
    await movieService.create(form);
    route.push('movie')
    alert("Movie added successfully!");
  } catch (error) {
    if (error.response && error.response.data.errors) {
      errors.value = error.response.data.errors;
    } else {
      console.error(error);
    }
  }
};
</script>
