<template>
  <div class="mx-auto my-4 max-w-xl rounded-md bg-zinc-800 px-4 py-4">
    <h1 class="mb-6 text-xl font-bold text-zinc-300">Đổi mật khẩu</h1>
    <Form
      @submit="handleSubmit"
      :validation-schema="validationSchema"
      class="flex flex-col gap-4"
    >
      <div class="flex w-full flex-col gap-1">
        <label for="old_password">Nhập mật khẩu cũ:</label>
        <Field
          name="old_password"
          v-model="form.old_password"
          type="password"
          id="old_password"
        />
        <ErrorMessage name="old_password" class="form-message text-red-500" />
      </div>

      <div class="flex w-full flex-col gap-1">
        <label for="new_password">Nhập mật khẩu mới:</label>
        <Field
          name="new_password"
          v-model="form.new_password"
          type="password"
          id="new_password"
        />
        <ErrorMessage name="new_password" class="form-message text-red-500" />
      </div>

      <div class="flex w-full flex-col gap-1">
        <label for="new_password_confirmation">Xác nhận nhập lại mật khẩu mới:</label>
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
        class="w-full rounded-md mt-5 bg-red-500 px-4 py-2 text-xl font-semibold text-white"
        type="submit"
      >
        Submit
      </button>
    </Form>
  </div>
</template>
<script setup>
import { reactive } from "vue";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { useRouter } from "vue-router";
import { clientAuthService } from "@/services/Client/clientAuthService";

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
    await clientAuthService.changePassword(form);
    alert("Password changed successfully!");
    router.push({ name: "trangchu" });
  } catch (error) {
    alert("Wrong password!");
    console.error("Error changing password:", error);
  }
};
</script>
<style scoped>

</style>