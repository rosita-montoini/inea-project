import { createRouter, createWebHistory } from "vue-router";
import Tasks from "@/pages/Tasks.vue";
import Projects from "@/pages/Projects.vue";

const routes = [
  {
    path: "/tasks",
    name: "tasks",
    component: Tasks,
  },
  {
    path: "/projects",
    name: "projects",
    component: Projects,
  },
  {
    path: "/",
    redirect: "/tasks",
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
