<template>
  <nav class="navbar">
    <ul>
      <li v-if="!authState.isAuthenticated">
        <router-link to="/login" class="nav-link">Login</router-link>
      </li>
      <li v-if="!authState.isAuthenticated">
        <router-link to="/register" class="nav-link">Register</router-link>
      </li>
      <template v-if="authState.isAuthenticated">
        <li v-for="item in items" :key="item.to">
          <router-link :to="item.to" class="nav-link">
            {{ item.label }}
          </router-link>
        </li>
        <li>
          <a href="#" class="nav-link logout" @click.prevent="handleLogout"
            >Logout</a
          >
        </li>
      </template>
    </ul>
  </nav>
</template>

<script setup>
import { defineProps, ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { authState } from "@/stores/authState";
import { checkAuth } from "@/services/auth/authService";
import { logout } from "@/services/auth/logoutService";

const router = useRouter();

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
});

async function handleLogout() {
  try {
    await logout(router);
  } catch (error) {
    console.error("Logout failed:", error);
  }
}

onMounted(async () => {
  await checkAuth();
});
</script>

<style scoped>
.navbar {
  background-color: #2c3e50;
  padding: 20px 30px;
}

.navbar ul {
  list-style: none;
  margin: 0 50px;
  padding: 0;
  display: flex;
}

.navbar li {
  margin-right: 20px;
}

.nav-link {
  color: white;
  text-decoration: none;
  padding: 20px 30px;
  transition: color 0.3s ease;
}

.nav-link:hover {
  color: #b9c5d1;
}

.nav-link.logout {
  color: rgb(68, 211, 255);
}

.nav-link.logout:hover {
  color: rgb(42, 179, 221);
}

@media (max-width: 768px) {
  .nav-link {
    font-size: 12px;
    text-align: center;
    padding: 10px 20px;
  }
  .navbar {
    background-color: #2c3e50;
    padding: 10px 20px;
  }
  .navbar li {
    margin-right: 10px;
  }
}
</style>
