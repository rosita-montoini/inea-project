<template>
  <div>
    <h2>Task list</h2>
    <div class="component-container">
      <table class="component-table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Project</th>
            <th>User</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks" :key="task.id">
            <td>{{ task.title }}</td>
            <td :class="`status-${task.status.replace(/\s+/g, '_')}`">
              {{ task.status }}
            </td>
            <td>{{ task.project_name }}</td>
            <td>{{ task.user_name }}</td>
            <td class="button">
              <button class="edit-button" @click="editTask(task)">
                <font-awesome-icon icon="edit" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="component-button">
        <button class="add-button" @click="addTask(task)">Add task</button>
      </div>
    </div>

    <ModalForm
      v-if="showForm"
      :title="isNewTask ? 'Add Task' : 'Edit Task'"
      :model-value="selectedTask"
      :fields="formFields"
      @submit="saveTask"
      @close="
        showForm = false;
        isNewTask = false;
      "
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { fetchTasks, updateTask, createTask } from "@/services/taskService";
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
const isNewTask = ref(false);

const loadTasks = async () => {
  tasks.value = await fetchTasks();
};

//expanding task fields, adding options to special field
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

const addTask = () => {
  selectedTask.value = {
    title: "",
    status: "open",
    project_id: null,
    assigned_to: null,
  };
  isNewTask.value = true;
  showForm.value = true;
};

const saveTask = async (taskData) => {
  if (isNewTask.value) {
    await createTask(taskData);
  } else {
    await updateTask(taskData);
  }
  showForm.value = false;
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
