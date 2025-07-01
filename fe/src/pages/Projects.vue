<template>
  <div>
    <h2>Project list</h2>
    <div class="component-container">
      <table class="component-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Description</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="project in projects" :key="project.id">
            <td>{{ project.name }}</td>
            <td>{{ project.description }}</td>
            <td class="button">
              <button class="edit-button" @click="editProject(project)">
                <font-awesome-icon icon="edit" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="component-button">
        <button class="add-button" @click="addProject(project)">
          Add project
        </button>
      </div>
    </div>

    <ModalForm
      v-if="showForm"
      :title="isNewProject ? 'Add Project' : 'Edit Project'"
      :model-value="selectedProject"
      :fields="formFields"
      @submit="saveProject"
      @close="
        showForm = false;
        isNewTask = false;
      "
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import {
  fetchProjects,
  updateProject,
  createProject,
} from "@/services/projectService";
import { baseProjectFields } from "@/constants/constants.js";
import ModalForm from "@/components/ModalForm.vue";

const projects = ref([]);
const selectedProject = ref({});
const formFields = ref([]);
const showForm = ref(false);
const isNewProject = ref(false);

const loadProjects = async () => {
  projects.value = await fetchProjects();
  formFields.value = baseProjectFields;
};

const editProject = (project) => {
  selectedProject.value = { ...project };
  showForm.value = true;
};

const addProject = () => {
  selectedProject.value = {
    name: "",
    description: "",
  };
  isNewProject.value = true;
  showForm.value = true;
};

const saveProject = async (projectData) => {
  if (isNewProject.value) {
    await createProject(projectData);
  } else {
    await updateProject(projectData);
  }
  showForm.value = false;
  await loadProjects();
};

onMounted(async () => {
  await loadProjects();
});
</script>

<style scoped src="@/assets/styles/component-style.css"></style>
