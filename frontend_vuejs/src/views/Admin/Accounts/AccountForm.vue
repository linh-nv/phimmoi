<template>
  <section class="head flex items-center justify-between">
    <h1>New Account</h1>
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
    autocomplete="off"
  >
    <div class="flex w-full gap-10">
      <div class="form-group">
        <label for="name">Name:</label>
        <Field
          name="user_name"
          v-model="form.name"
          type="text"
          id="name"
          autocomplete="off"
        />
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <Field
          name="user_email"
          v-model="form.email"
          type="text"
          id="email"
          autocomplete="off"
        />
      </div>

      <div class="form-group">
        <label for="phone">Phone:</label>
        <Field
          name="user_phone"
          v-model="form.phone"
          type="text"
          id="phone"
          autocomplete="off"
        />
      </div>
    </div>

    <div class="flex w-full gap-10">
      <div class="form-group">
        <label for="password">Password:</label>
        <Field
          name="user_password"
          v-model="form.password"
          type="password"
          id="password"
          autocomplete="new-password"
        />
      </div>

      <div class="form-group">
        <label for="password_confirmation">Password confirmation:</label>
        <Field
          name="user_password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          id="password_confirmation"
          autocomplete="new-password"
        />
      </div>
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
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import { formSchema } from "@/validation/Account/formSchema";
import { authService } from "@/services/authService";

const router = useRouter();
const { validate } = useForm({
  validationSchema: formSchema,
});
// const validationSchema = formSchema;

// useForm({
//   validationSchema,
// });

const form = reactive({
  name: "",
  email: "",
  phone: "",
  password: "",
  password_confirmation: "",
});

const errors = ref({});

const handleSubmit = async () => {
  const isValid = await validate();
  if (!isValid) return;

  try {
    await authService.register(form);
    alert("Account added successfully!");
    router.push({ name: "accounts-management" });
  } catch (error) {
    alert(error.response.data.message);
    if (error.response && error.response.data.errors) {
      errors.value = error.response.data.errors;
    } else {
      console.error(error);
    }
  }
};
</script>
