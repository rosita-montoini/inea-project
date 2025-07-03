<template>
  <div class="form-container auth-form">
    <h2>Login</h2>
    <form @submit.prevent="userLogin">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          v-model="email"
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
          v-model="password"
          :type="showPassword ? 'text' : 'password'"
          placeholder="Password"
          autocomplete="current-password"
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
        <button type="submit">Login</button>
      </div>
      <p class="error" v-if="error">{{ error }}</p>
    </form>
    <router-link to="/register">Don’t have an account? Register</router-link>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { login } from "@/services/auth/loginService";

const email = ref("");
const password = ref("");
const error = ref("");
const router = useRouter();
const showPassword = ref(false);

function togglePasswordVisibility() {
  showPassword.value = !showPassword.value;
}

const userLogin = async () => {
  await login(email, password, router, error);
};
</script>

<style scoped src="@/assets/styles/auth-style.css"></style>
