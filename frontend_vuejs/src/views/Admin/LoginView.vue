<template>
  <div class="auth">
    <Form
      @submit="onSubmit"
      :validation-schema="validationSchema"
      class="form-login"
      id="form_login"
    >
      <section class="form-top">
        <h1>Login to Account</h1>
        <span class="note"
          >Please enter your email and password to continue</span
        >
      </section>
      <section class="form-mid">
        <div class="form-group">
          <label for="email">Email address:</label>
          <Field
            v-model="email"
            name="email"
            id="email"
            type="text"
            placeholder="esteban_schiller@gmail.com"
            class="focus:outline-none"
          />
          <ErrorMessage name="email" class="form-message text-red-500" />
        </div>
        <div class="form-group">
          <div class="password-note">
            <label for="password">Password:</label>
          </div>
          <Field
            v-model="password"
            name="password"
            id="password"
            type="password"
            class="focus:outline-none"
          />
          <ErrorMessage name="password" class="form-message text-red-500" />
        </div>
      </section>
      <section class="form-bottom">
        <button class="login-btn" type="submit">Sign In</button>
        <div class="create-account">
          <span>Don’t have an account?</span>
          <a href="#register">Create Account</a>
        </div>
      </section>
    </Form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter, useRoute } from "vue-router";
import { authService } from "@/services/authService";
import { useAdminStore } from "@/stores/adminStore";
import { useForm, Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";

const router = useRouter();
const route = useRoute();
const adminStore = useAdminStore();
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

const onSubmit = async () => {
  try {
    const response = await authService.login({
      email: email.value,
      password: password.value,
    });

    adminStore.setAdmin(response.data.data);

    const redirectPath = route.query.redirect || router.resolve({ name: "home" });
    router.push(redirectPath);
  } catch (error) {
    alert("An unexpected error occurred. Please try again.");
  }
};
</script>

<style scoped>
.auth {
  width: 100vw;
  height: 100vh;
  font-size: 1.45rem;
  line-height: 21.82px;
  background-color: #4880ff;
  background-image: url("../assets/images/background-login.png");
  display: flex;
  justify-content: center;
  align-items: center;
  overflow-x: hidden;
}
.form-login {
  display: flex;
  flex-direction: column;
  border-radius: 20px;
  background-color: #fff;
  padding: 90px 57px;
  width: 630px;
  gap: 40px;
}
.form-top {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 15px;
}

.form-mid {
  display: flex;
  flex-direction: column;
  gap: 20px;
}
.form-mid .form-group input {
  border: 1px solid #d1d5db;
  background-color: #fafafa;
  border-radius: 10px;
  padding: 15px;
  width: 100%;
}
.form-group {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.form-group label {
  font-size: 1.35rem;
}
.password-note {
  display: flex;
  justify-content: space-between;
}
.remember-password {
  display: flex;
  justify-content: start;
  align-items: center;
  gap: 10px;
}
.remember-password label {
  cursor: pointer;
}
.remember-password input {
  cursor: pointer;
}
#password {
  margin-bottom: 24px;
}
#remember {
  width: 2rem;
  border-radius: 10px;
}

.form-bottom {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  gap: 18px;
}
.form-bottom button {
  font-size: 1.35rem;
  font-weight: 600;
  color: #fff;
  background-color: #3b82f6;
  border: none;
  border-radius: 10px;
  width: 100%;
  padding: 1.5rem;
  cursor: pointer;
}
.create-account {
  display: flex;
  gap: 0.6rem;
}
.create-account a {
  text-decoration: underline;
  color: #3b82f6;
}
.invalid .form-message {
  color: red;
  font-size: 12px;
}
.invalid input {
  border-color: red;
}
</style>
