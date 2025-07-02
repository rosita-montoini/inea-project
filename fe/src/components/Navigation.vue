<template>
  <nav class="navbar">
    <ul>
      <li v-for="item in items" :key="item.to">
        <router-link :to="item.to" class="nav-link">{{
          item.label
        }}</router-link>
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
  items: {
    type: Array,
    required: true,
  },
});
</script>

<style scoped>
.navbar {
  background-color: #2c3e50;
  padding: 20px 30px;
}

.navbar ul {
  list-style: none;
  margin: 0;
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
