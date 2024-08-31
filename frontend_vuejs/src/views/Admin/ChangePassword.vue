<template>
  <section class="head flex items-center justify-between">
    <h1>Change Password</h1>
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
    <div class="flex flex-col w-full gap-1">
      <label for="old_password">Old Password:</label>
      <Field
        name="old_password"
        v-model="form.old_password"
        type="password"
        id="old_password"
      />
      <ErrorMessage name="old_password" class="form-message text-red-500" />
    </div>

    <div class="flex flex-col w-full gap-1">
      <label for="new_password">New Password:</label>
      <Field
        name="new_password"
        v-model="form.new_password"
        type="password"
        id="new_password"
      />
      <ErrorMessage name="new_password" class="form-message text-red-500" />
    </div>

    <div class="flex flex-col w-full gap-1">
      <label for="new_password_confirmation">Confirm New Password:</label>
      <Field
        name="new_password_confirmation"
        v-model="form.new_password_confirmation"
        type="password"
        id="new_password_confirmation"
      />
      <ErrorMessage
        name="new_password_confirmation"
        class="form-message text-red-500"
      />
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
import { reactive } from "vue";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { useRouter } from "vue-router";
import { authService } from "@/services/authService";

const router = useRouter();

const validationSchema = yup.object({
  old_password: yup.string().required("Old password is required"),
  new_password: yup
    .string()
    .required("New password is required")
    .min(8, "New password must be at least 8 characters")
    .notOneOf(
      [yup.ref("old_password")],
      "New password must be different from the old password",
    ),
  new_password_confirmation: yup
    .string()
    .oneOf([yup.ref("new_password")], "Passwords must match")
    .required("Please confirm your new password"),
});

useForm({
  validationSchema,
});

const form = reactive({
  old_password: "",
  new_password: "",
  new_password_confirmation: "",
});

const handleSubmit = async () => {
  try {
    await authService.changePassword(form);
    alert("Password changed successfully!");
    router.push({ name: "home" });
  } catch (error) {
    alert("Wrong password!");
    console.error("Error changing password:", error);
  }
};
</script>
