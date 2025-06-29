<template>
  <nav>
    <ul>
      <li v-for="item in items" :key="item.to">
        <router-link :to="item.to">{{ item.label }}</router-link>
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
nav ul {
  list-style: none;
  padding: 0;
  display: flex;
}
nav ul li {
  margin-right: 15px;
}
</style>
