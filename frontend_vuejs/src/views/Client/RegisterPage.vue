<template>
  <nav class="flex flex-col justify-start">
    <div
      class="auth-body flex flex-col justify-center gap-5 px-10 py-2 text-center"
    >
      <div class="auth__title text-2xl font-bold">Đăng ký</div>
      <div class="auth__form flex flex-col gap-5">
        <div class="flex w-full flex-col items-center justify-center">
          <div class="flex w-full max-w-96 flex-col gap-4">
            <!-- Email -->
            <Form
              v-if="!verify"
              @submit="onSubmit"
              :validation-schema="formValidationSchema"
              class="auth-email flex w-full flex-col gap-2"
            >
              <label class="flex justify-start" for="email_register"
                >Email:</label
              >
              <Field
                v-model="email"
                name="email"
                id="email_register"
                type="text"
                placeholder="user@gmail.com"
                class="w-full bg-transparent text-white focus:outline-none"
              />
              <ErrorMessage
                name="email"
                class="flex justify-start text-red-500"
              />

              <label class="flex justify-start" for="name"
                >Tên người dùng:</label
              >
              <Field
                v-model="name"
                name="name"
                id="name"
                type="name"
                class="w-full bg-transparent text-white focus:outline-none"
              />
              <ErrorMessage
                name="name"
                class="flex justify-start text-red-500"
              />

              <label class="flex justify-start" for="phone"
                >Số điện thoại:</label
              >
              <Field
                v-model="phone"
                name="phone"
                id="phone"
                type="phone"
                class="w-full bg-transparent text-white focus:outline-none"
              />
              <ErrorMessage
                name="phone"
                class="flex justify-start text-red-500"
              />

              <label class="flex justify-start" for="password_register"
                >Mật khẩu:</label
              >
              <Field
                v-model="password"
                name="password"
                id="password_register"
                type="password"
                class="w-full bg-transparent text-white focus:outline-none"
              />
              <ErrorMessage
                name="password"
                class="flex justify-start text-red-500"
              />

              <label class="flex justify-start" for="password_confirmation"
                >Nhập lại mật khẩu:</label
              >
              <Field
                v-model="password_confirmation"
                name="password_confirmation"
                id="password_confirmation"
                type="password"
                class="w-full bg-transparent text-white focus:outline-none"
              />
              <ErrorMessage
                name="password_confirmation"
                class="flex justify-start text-red-500"
              />

              <button
                class="my-5 w-full rounded-lg bg-[red] px-4 py-2 font-bold text-white"
                type="submit"
              >
                Next
              </button>
            </Form>
            <!-- Verify code -->
            <Form
              v-else
              @submit="onSubmit"
              :validation-schema="verifyCodeValidationSchema"
              class="flex w-full flex-col gap-2"
            >
              <label class="flex justify-start" for="verification_code"
                >Mã xác thực:</label
              >
              <Field
                v-model="verification_code"
                name="verification_code"
                id="verification_code"
                type="text"
                placeholder="XXXXXX"
                class="w-full bg-transparent text-white focus:outline-none"
              />
              <ErrorMessage
                name="verification_code"
                class="flex justify-start text-red-500"
              />
              <button
                class="my-5 w-full rounded-lg bg-[red] px-4 py-2 font-bold text-white"
                type="submit"
              >
                Submit
              </button>
            </Form>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>
<script setup>
import { ref } from "vue";
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { clientAuthService } from "@/services/Client/clientAuthService";
import { useRouter } from "vue-router";

const router = useRouter();
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const name = ref("");
const phone = ref("");
const verification_code = ref("");

const formValidationSchema = yup.object({
  email: yup.string().email("Email không hợp lệ").required("Email là bắt buộc"),
  name: yup.string().required("Tên là bắt buộc"),
  phone: yup.string(),
  password: yup
    .string()
    .min(6, "Mật khẩu phải có ít nhất 6 ký tự")
    .required("Mật khẩu là bắt buộc"),
  password_confirmation: yup
    .string()
    .oneOf([yup.ref("password"), null], "Xác nhận mật khẩu không khớp")
    .required("Xác nhận mật khẩu là bắt buộc"),
});

const verifyCodeValidationSchema = yup.object({
  verification_code: yup
    .string()
    .length(6, "Mã xác thực phải có 6 ký tự")
    .required("Mã xác thực là bắt buộc"),
});

const onSubmit = async () => {
  try {
    if (email.value) {
      await clientAuthService.register({
        email: email.value,
        name: name.value,
        phone: phone.value,
        verification_code: verification_code.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
      });

      if (verify.value === true) {
        router.push({ name: "trangchu" });
        alert("Đăng ký thành công!!");
      }
      verify.value = true;
    }
  } catch (error) {
    alert("An unexpected error occurred. Please try again.");
  }
};

const verify = ref(false);
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
