<template>
  <div class="form-container register-form">
    <h2>Register</h2>
    <form @submit.prevent="userRegister">
      <div class="form-group">
        <label for="name">Name</label>
        <input
          v-model="data.name"
          type="text"
          placeholder="Name"
          required
          class="form-control"
        />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input
          v-model="data.email"
          type="email"
          placeholder="Email"
          autocomplete="email"
          required
          class="form-control"
        />
      </div>
      <div class="form-group password-field">
        <label for="password">Password</label>
        <input
          v-model="data.password"
          :type="showPassword ? 'text' : 'password'"
          placeholder="Password"
          autocomplete="new-password"
          required
          class="form-control"
        />
        <button
          type="button"
          class="toggle-password-btn"
          @click="togglePasswordVisibility"
          :aria-label="showPassword ? 'Hide password' : 'Show password'"
        >
          {{ showPassword ? "Hide password" : "Show password" }}
          <font-awesome-icon :icon="showPassword ? 'eye-slash' : 'eye'" />
        </button>
      </div>
      <div class="form-actions">
        <button type="submit">Register</button>
      </div>
      <p class="error" v-if="error">{{ error }}</p>
    </form>
    <router-link to="/login">Back to login</router-link>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { register } from "@/services/auth/registerService";
import { validateRegistrationForm } from "@/utils/validation";

const data = reactive({
  name: "",
  email: "",
  password: "",
});
const error = ref("");
const router = useRouter();
const showPassword = ref(false);

function togglePasswordVisibility() {
  showPassword.value = !showPassword.value;
}

const userRegister = async () => {
  error.value = "";

  const validationError = validateRegistrationForm(data);
  if (validationError) {
    error.value = validationError;
    return;
  }
  await register(data, router, error);
};
</script>

<style scoped src="@/assets/styles/auth-style.css"></style>
