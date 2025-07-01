<template>
  <div class="component-container">
    <h2>Task list</h2>
    <table class="component-table">
      <thead>
        <tr>
          <th>Title</th>
          <th>Status</th>
          <th>Project</th>
          <th>User</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td>{{ task.title }}</td>
          <td>{{ task.status }}</td>
          <td>{{ task.project_name }}</td>
          <td>{{ task.user_name }}</td>
          <td class="button">
            <button class="edit-button" @click="editTask(task)">Edit</button>
            <!-- <button class="add-button" @click="editTask(task)">Add</button> -->
          </td>
        </tr>
      </tbody>
    </table>

    <ModalForm
      v-if="showForm"
      :title="'Edit Task'"
      :model-value="selectedTask"
      :fields="formFields"
      @submit="saveTask"
      @close="showForm = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { fetchTasks, updateTask } from "@/services/taskService";
import { fetchUsers } from "@/services/userService";
import { fetchProjects } from "@/services/projectService";
import { baseTaskFields } from "@/constants/constants.js";
import ModalForm from "@/components/ModalForm.vue";

const tasks = ref([]);
const users = ref([]);
const projects = ref([]);
const selectedTask = ref({});
const formFields = ref([]);
const showForm = ref(false);

const loadTasks = async () => {
  tasks.value = await fetchTasks();
};

const loadFormData = async () => {
  users.value = await fetchUsers();
  projects.value = await fetchProjects();

  formFields.value = baseTaskFields.map((field) => {
    if (field.name === "project_id") {
      return {
        ...field,
        options: projects.value.map((p) => ({ value: p.id, label: p.name })),
      };
    }
    if (field.name === "assigned_to") {
      return {
        ...field,
        options: users.value.map((u) => ({ value: u.id, label: u.name })),
      };
    }
    return field;
  });
};

const expandTasks = () => {
  tasks.value = tasks.value.map((task) => {
    const project = projects.value.find((p) => p.id === task.project_id);
    const user = users.value.find((u) => u.id === task.assigned_to);

    return {
      ...task,
      project_name: project ? project.name : "Unknown",
      user_name: user ? user.name : "Unknown",
    };
  });
};

const editTask = (task) => {
  selectedTask.value = { ...task };
  showForm.value = true;
};

const saveTask = async (updatedTask) => {
  await updateTask(updatedTask);
  await loadAllData();
};

const loadAllData = async () => {
  await loadTasks();
  await loadFormData();
  expandTasks();
};

onMounted(async () => {
  await loadAllData();
});
</script>

<style scoped src="@/assets/styles/component-style.css"></style>
