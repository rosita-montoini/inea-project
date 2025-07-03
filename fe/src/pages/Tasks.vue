<template>
  <div>
    <h2>Task list</h2>
    <div class="component-container">
      <table class="component-table">
        <thead>
          <tr>
            <th>ID</th>
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
              <td>{{ task.id }}</td>
              <td>{{ task.title }}</td>
              <td :class="`status-${task.status.replace(/\s+/g, '_')}`">
                {{ task.status }}
              </td>
              <td>{{ task.project_name }}</td>
              <td>{{ task.user_name }}</td>
              <td v-if="isAdmin" class="button">
                <button
                  title="Edit task"
                  class="edit-button"
                  @click="editTask(task)"
                >
                  <font-awesome-icon icon="edit" />
                </button>
              </td>
            </tr>
            <tr
              class="comments-container"
              v-if="task.comments && task.comments.length > 0"
            >
              <td></td>
              <td colspan="4">
                <div>
                  <strong>Comments:</strong>
                  <ul>
                    <li v-for="comment in task.comments" :key="comment.id">
                      {{ comment.comment }}
                      <em>
                        Author: {{ comment.author }} - {{ comment.created_at }}
                      </em>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
            <tr class="comment-button-container">
              <td colspan="5" v-if="!isAdmin">
                <button
                  title="Add comment"
                  class="add-comment-button"
                  @click="addComment(task)"
                >
                  Add
                </button>
              </td>
            </tr>
          </template>
        </tbody>
      </table>
      <div v-if="isAdmin" title="Add task" class="button">
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
      @submit="saveComment"
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
import {
  fetchTaskComments,
  createTaskComment,
} from "@/services/taskCommentsService";
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

const loadComments = async () => {
  taskComments.value = (await fetchTaskComments()) || [];
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
  tasks.value = tasks.value.map((task) => {
    const project = projects.value.find((p) => p.id === task.project_id);
    const user = users.value.find((u) => u.id === task.assigned_to);

    const allComments = taskComments.value
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
      comments: allComments ?? [],
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

const addComment = (task) => {
  addNewComment.value = {
    comment: "",
    created_at: new Date().toISOString(),
    task_id: task.id,
    user_id: isAuthUser,
  };
  showFormComment.value = true;
};

const saveComment = async (data) => {
  await createTaskComment(data);
  showFormComment.value = false;
  await loadAllData();
};

const loadAllData = async () => {
  await loadTasks();
  await loadComments();
  await loadFormData();
  expandTasks();
};

onMounted(async () => {
  await checkAuth();
  await loadAllData();
});
</script>

<style scoped src="@/assets/styles/component-style.css"></style>
