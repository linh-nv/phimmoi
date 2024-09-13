<template>
  <nav
    class="fixed right-0 top-0 z-50 flex h-screen w-full flex-col justify-start bg-black transition-transform duration-300"
    :class="{
      'translate-x-full': !isAuthOpen,
      'translate-x-0': isAuthOpen,
    }"
  >
    <div class="relative flex w-full items-center gap-2 px-5 py-2">
      <button @click="$emit('closeAuth')" class="h-full px-4">
        <i class="fa-solid fa-angle-left fa-xl"></i>
      </button>
      <img
        loading="lazy"
        src="/src/assets/images/netflix-logo.png"
        alt="Netflix Logo"
        class="h-10 w-auto"
      />
    </div>
    <div
      class="auth-body flex flex-col justify-center gap-5 px-10 py-2 text-center"
    >
      <div class="auth__title text-2xl font-bold">
        Đăng nhập LinhFlix để tận hưởng kho Phim, Show, Thể thao, Truyền hình
        cực đỉnh
      </div>
      <span class="text-sm">Vui lòng chọn phương thức để bắt đầu</span>
      <div class="auth__form flex flex-col items-center gap-2">
        <span>Đăng nhập bằng tài khoản</span>
        <Form
          @submit="onSubmit"
          :validation-schema="validationSchema"
          class="flex flex-col gap-4"
        >
          <div class="auth-email flex flex-col gap-2">
            <label class="flex justify-start" for="email">Email:</label>
            <Field
              v-model="email"
              name="email"
              id="email"
              type="text"
              placeholder="esteban_schiller@gmail.com"
              class="bg-transparent text-white focus:outline-none"
            />
            <ErrorMessage
              name="email"
              class="flex justify-start text-red-500"
            />
          </div>
          <div class="auth-password flex flex-col gap-2">
            <label class="flex justify-start" for="password">Password:</label>
            <Field
              v-model="password"
              name="password"
              id="password"
              type="password"
              class="bg-transparent text-white focus:outline-none"
            />
            <ErrorMessage
              name="password"
              class="flex justify-start text-red-500"
            />
          </div>
          <button
            class="w-full rounded-lg bg-blue-500 px-4 py-2 font-bold text-white"
            type="submit"
          >
            Sign In
          </button>
          <div class="create-account">
            <span>Chưa có tài khoản?</span>
            <router-link :to="{ name: 'dangky' }" class="text-blue-500">
              Đăng ký ngay!
            </router-link>
          </div>
        </Form>
      </div>
      <span class="text-sm">Phương thức khác</span>
      <div class="social-auth"></div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { clientAuthService } from "@/services/clientAuthService";
import { defineEmits } from "vue";

const router = useRouter();
const route = useRoute();
const email = ref("");
const password = ref("");

const validationSchema = yup.object({
  email: yup.string().email().required("Email is required"),
  password: yup
    .string()
    .min(6, "Password must be at least 6 characters")
    .required("Password is required"),
});
const { handleSubmit } = useForm({
  validationSchema,
});

const props = defineProps({
  isAuthOpen: {
    type: [Boolean, null],
    required: true,
  },
});

const onSubmit = async () => {
  try {
    await clientAuthService.login({
      email: email.value,
      password: password.value,
    });

    window.location.reload();
  } catch (error) {
    alert("An unexpected error occurred. Please try again.");
  }
};
</script>
<style scoped>
.auth-body::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0.5;
  height: 100%;
  width: 100vw;
  background-image: url("/src/assets/images/netflix-background.jpg");
  background-size: cover;
  background-position: center;
  box-shadow: 0px 0px 150px 70px #000 inset;
  z-index: -1;
}
</style>
