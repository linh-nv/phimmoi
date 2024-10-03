<template>
  <nav
    class="fixed right-0 top-0 z-50 flex h-screen w-full flex-col justify-start bg-black transition-transform duration-300"
    :class="{
      'translate-x-full': !isAuthOpen,
      'translate-x-0': isAuthOpen,
    }"
  >
    <div class="container mx-auto h-full bg-[#000000dd]">
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
        <div class="auth__title text-2xl font-bold">Đăng nhập</div>
        <div class="auth__form flex flex-col gap-5">
          <div class="flex w-full flex-col items-center justify-center">
            <Form
              @submit="onSubmit"
              :validation-schema="validationSchema"
              class="flex w-full max-w-96 flex-col gap-4"
            >
              <div class="auth-email flex w-full flex-col gap-2">
                <label class="flex justify-start" for="email">Email:</label>
                <Field
                  v-model="email"
                  name="email"
                  id="email"
                  type="text"
                  placeholder="user@gmail.com"
                  class="w-full bg-transparent text-white focus:outline-none"
                />
                <ErrorMessage
                  name="email"
                  class="flex justify-start text-red-500"
                />
              </div>
              <div class="auth-password flex flex-col gap-2">
                <label class="flex justify-start" for="password"
                  >Password:</label
                >
                <Field
                  v-model="password"
                  name="password"
                  id="password"
                  type="password"
                  class="w-full bg-transparent text-white focus:outline-none"
                />
                <ErrorMessage
                  name="password"
                  class="flex justify-start text-red-500"
                />
              </div>
              <button
                class="w-full rounded-lg bg-[red] px-4 py-2 font-bold text-white"
                type="submit"
              >
                Sign In
              </button>
            </Form>
          </div>
          <div class="flex flex-col items-center">
            <span class="font-semibold uppercase opacity-50">Hoặc</span>
            <div class="social-auth flex gap-5 p-5">
              <div class="github-auth transition duration-300 hover:scale-110">
                <button class="rounded-lg bg-white">
                  <img
                    src="/src/assets/images/github-icon.png"
                    alt="Github icon"
                  />
                </button>
              </div>
              <div class="google-auth transition duration-300 hover:scale-110">
                <button class="rounded-lg bg-white">
                  <img
                    src="/src/assets/images/google-icon.png"
                    alt="Google icon"
                  />
                </button>
              </div>
            </div>
          </div>
        </div>
        <div class="create-account">
          <span>Chưa có tài khoản?</span>
          <router-link
            @click="$emit('closeAuth')"
            :to="{ name: 'dangky' }"
            class="font-semibold text-blue-500"
          >
            Đăng ký ngay!
          </router-link>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from "vue";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { clientAuthService } from "@/services/Client/clientAuthService";

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
  background-image: url("https://user-images.githubusercontent.com/33485020/108069438-5ee79d80-7089-11eb-8264-08fdda7e0d11.jpg");
  background-size: cover;
  background-position: center;
  box-shadow: 0px 0px 150px 70px #000 inset;
  z-index: -1;
}
</style>
