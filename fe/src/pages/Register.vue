<template>
  <div class="form-container register-form">
    <h2>Login</h2>
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
          required
          class="form-control"
        />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          v-model="data.password"
          type="password"
          placeholder="Password"
          required
          class="form-control"
        />
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

const data = reactive({
  name: "",
  email: "",
  password: "",
});
const error = ref("");
const router = useRouter();

const userRegister = async () => {
  await register(data, router, error);
};
</script>

<style scoped>
.form-container {
  background: white;
  padding: 20px 30px;
  border-radius: 8px;
  width: 400px;
  margin: 0 auto;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.register-form {
  margin-top: 60px;
}

h2 {
  margin-bottom: 20px;
  text-align: center;
  font-weight: 700;
}

.form-group {
  margin-bottom: 15px;
  display: flex;
  flex-direction: column;
}

.form-group label {
  margin-bottom: 5px;
  font-weight: 600;
  font-size: 14px;
}

input.form-control {
  padding: 8px 12px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 4px;
  width: 100%;
  box-sizing: border-box;
  transition: border-color 0.3s ease;
}

input.form-control:focus {
  border-color: #409eff;
  outline: none;
}

.form-actions {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin: 25px 0;
}

.form-actions button {
  padding: 8px 25px;
  font-size: 14px;
  border-radius: 4px;
  border: none;
  cursor: pointer;
  background-color: #409eff;
  color: white;
  transition: background-color 0.3s ease;
}

.form-actions button:hover {
  background-color: #66b1ff;
}

.error {
  color: red;
  margin-top: 10px;
  text-align: center;
  font-size: 14px;
}

router-link {
  margin-top: 15px;
  color: #409eff;
  text-decoration: none;
}

router-link:hover {
  text-decoration: underline;
}

@media (max-width: 768px) {
  .form-container {
    width: 300px;
  }
  input.form-control {
    font-size: 12px;
  }
  .form-group label {
    font-size: 12px;
  }
  h2 {
    font-size: 16px;
  }
}
</style>
