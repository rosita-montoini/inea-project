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
            <th v-if="isAdmin"></th>
          </tr>
        </thead>
        <tbody>
          <template v-for="task in tasks" :key="task.id">
            <tr>
              <td>{{ task.title }}</td>
              <td :class="`status-${task.status.replace(/\s+/g, '_')}`">
                {{ task.status }}
              </td>
              <td>{{ task.project_name }}</td>
              <td>{{ task.user_name }}</td>
              <td v-if="isAdmin" class="button">
                <button class="edit-button" @click="editTask(task)">
                  <font-awesome-icon icon="edit" />
                </button>
              </td>
            </tr>
            <tr>
              <td :colspan="isAdmin ? 5 : 3">
                <div class="comments">
                  <strong>Comments:</strong>
                  <ul>
                    <li v-for="comment in task.comments" :key="comment.id">
                      {{ comment.comment }} —
                      <em>Author: {{ comment.author }}</em>
                      <div>
                        <span class="created-at">{{ comment.created_at }}</span>
                      </div>
                    </li>
                  </ul>
                </div>
              </td>
              <td v-if="!isAdmin" class="button">
                <button class="add-comment-button" @click="addComment(task)">
                  Comment
                </button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
      <div v-if="isAdmin" class="component-button">
        <button class="add-button" @click="addTask()">Add task</button>
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

    <ModalCommentForm
      v-if="showFormComment"
      :model-value="addNewComment"
      @submit="saveTask"
      @close="showFormComment = false"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import ModalForm from "@/components/ModalForm.vue";
import ModalCommentForm from "@/components/ModalCommentForm.vue";
import { fetchTasks, updateTask, createTask } from "@/services/taskService";
import { fetchUsers } from "@/services/userService";
import { fetchTaskComments } from "@/services/taskCommentsService";
import { fetchProjects } from "@/services/projectService";
import { baseTaskFields } from "@/constants/constants.js";
import { authState } from "@/stores/authState";
import { checkAuth } from "@/services/auth/authService";

const tasks = ref([]);
const users = ref([]);
const projects = ref([]);
const selectedTask = ref({});
const formFields = ref([]);
const taskComments = ref([]);
const showForm = ref(false);
const showFormComment = ref(false);
const isNewTask = ref(false);
const addNewComment = ref({});

const isAdmin = computed(() => authState.user?.role === "admin");
const isAuthUser = computed(() => authState.user?.id);

const loadTasks = async () => {
  tasks.value = await fetchTasks();
};

//expanding task fields, adding options to special field
const loadFormData = async () => {
  users.value = (await fetchUsers()) || [];
  projects.value = (await fetchProjects()) || [];

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

const expandTasks = async () => {
  taskComments.value = (await fetchTaskComments()) || [];

  tasks.value = tasks.value.map((task) => {
    const project = projects.value.find((p) => p.id === task.project_id);
    const user = users.value.find((u) => u.id === task.assigned_to);

    const allTaskComments = taskComments.value
      .filter((c) => c.task_id === task.id)
      .map((comment) => {
        const author = users.value.find((u) => u.id === comment.user_id);
        return {
          ...comment,
          author: author ? author.name : "",
        };
      });

    return {
      ...task,
      project_name: project ? project.name : "",
      user_name: user ? user.name : "",
      comments: allTaskComments ?? [],
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

const addComment = (task) => {
  addNewComment.value = {
    comment: "",
    task_id: task.id,
    user_id: isAuthUser,
    created_at: new Date(),
  };
  showFormComment.value = true;
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
  await checkAuth();
  await loadAllData();
});
</script>

<style scoped src="@/assets/styles/component-style.css"></style>
