<template>
  <main>
    <Navigation :items="navigationItems" />
    <div class="page-content">
      <router-view />
    </div>
  </main>
</template>

<script setup>
import Navigation from "@/components/Navigation.vue";
import { navigationItems } from "@/constants/constants.js";
</script>

<style scoped></style>
