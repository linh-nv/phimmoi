<template>
  <section class="head flex items-center justify-between">
    <h1>New Category</h1>
    <router-link
      :to="{ name: 'category' }"
      class="flex cursor-pointer items-center justify-between gap-3 rounded-md bg-amber-500 px-4 py-2 text-white hover:bg-amber-400"
    >
      <i class="fa-solid fa-rectangle-list"></i>
      <span>List categories</span>
    </router-link>
  </section>
  <div class="line border border-gray-200"></div>
  <Form
    @submit="handleSubmit"
    :validation-schema="validationSchema"
    class="form-box"
  >
    <div class="form-group">
      <label for="title">Title:</label>
      <Field name="title" v-model="form.title" type="text" id="title" />
      <ErrorMessage name="title" class="form-message text-red-500" />
    </div>

    <div class="form-group">
      <label for="slug">Slug:</label>
      <Field name="slug" v-model="form.slug" type="text" id="slug" />
      <ErrorMessage name="slug" class="form-message text-red-500" />
    </div>

    <div class="flex w-full flex-col">
      <label for="description">Description:</label>
      <Field
        as="textarea"
        name="description"
        v-model="form.description"
        id="description"
      />
      <ErrorMessage name="description" class="form-message text-red-500" />
    </div>

    <!-- Status -->
    <div class="form-group">
      <label for="status">Status:</label>
      <Field as="select" v-model.number="form.status" id="status" name="status">
        <option value="" disabled>Select Status</option>
        <option v-for="[key, value] in categoryStatus" :value="key">
          {{ value }}
        </option>
      </Field>
      <ErrorMessage name="status" class="form-message text-red-500" />
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
import { categoryService } from "@/services/Category/category";
import { enumService } from "@/services/Enum/enum.js";
import { useRouter, useRoute } from "vue-router";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import { formSchema } from "@/validation/Category/formSchema";

const router = useRouter();
const route = useRoute();
const slug = route.params.slug;

const validationSchema = formSchema;

useForm({
  validationSchema,
});

const form = reactive({
  title: "",
  slug: "",
  origin_name: "",
  description: "",
  status: null,
});

const errors = ref({});

const handleSubmit = async () => {
  try {
    if (slug) {
      await categoryService.update(slug, form);

      alert("Category updated successfully!");
    } else {
      await categoryService.create(form);

      alert("Category added successfully!");
    }

    router.push({ name: "category" });
  } catch (error) {
    if (error.response && error.response.data.errors) {
      errors.value = error.response.data.errors;
    } else {
      console.error(error);
    }
  }
};

const categoryStatus = ref([]);

onMounted(async () => {
  try {
    const enumResponse = await enumService.getStatus();
    categoryStatus.value = Object.entries(enumResponse.data);

    if (slug) {
      const response = await categoryService.find(slug);
      Object.assign(form, { ...response.data });
    }
  } catch (error) {
    console.error("Error fetching data", error);
  }
});
</script>
