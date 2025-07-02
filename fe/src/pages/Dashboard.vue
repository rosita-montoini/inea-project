<template>
  <div class="chart-container">
    <h2>Task chart</h2>
    <select v-model="selectedProjectId" class="form-control">
      <option v-for="project in projects" :key="project.id" :value="project.id">
        {{ project.name }}
      </option>
    </select>
    <TaskChart :tasks="tasks" :projectId="selectedProjectId" />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import TaskChart from "@/components/TaskChart.vue";
import { fetchTasks } from "@/services/taskService";
import { fetchProjects } from "@/services/projectService";

const tasks = ref([]);
const projects = ref([]);
const selectedProjectId = ref(0);

const loadTasks = async () => {
  tasks.value = await fetchTasks();
};

const loadProjects = async () => {
  projects.value = await fetchProjects();
};

const defaultProjectId = () => {
  if (projects.value.length > 0) {
    selectedProjectId.value = projects.value[0].id;
  }
};

onMounted(async () => {
  await loadTasks();
  await loadProjects();
  defaultProjectId();
});
</script>

<style scoped>
.chart-container {
  width: 100%;
}
h2 {
  text-align: center;
  margin-bottom: 30px;
  margin-top: 80px;
}

select.form-control {
  padding: 5px 10px;
  margin-bottom: 30px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  width: 20%;
}

@media (max-width: 768px) {
  h2 {
    font-size: 18px;
    margin-top: 20px;
  }

  select.form-control {
    font-size: 12px;
    width: 50%;
    padding: 3px 6px;
  }
}
</style>
