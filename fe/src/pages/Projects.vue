<template>
  <div class="component-container">
    <h2>Project list</h2>
    <table class="component-table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="project in projects" :key="project.id">
          <td>{{ project.name }}</td>
          <td>{{ project.description }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { fetchProjects } from "@/services/projectService";

const projects = ref([]);

onMounted(async () => {
  projects.value = await fetchProjects();
});
</script>

<style scoped src="@/assets/styles/component-style.css"></style>
