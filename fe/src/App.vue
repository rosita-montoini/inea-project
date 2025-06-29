<template>
  <main>
    <Navigation :items="navigationItems" />
    <router-view />
  </main>
</template>

<script setup>
import Navigation from "@/components/Navigation.vue";
import { navigationItems } from "@/constants/constants.js";
</script>

<style scoped></style>
