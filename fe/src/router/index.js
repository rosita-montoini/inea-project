import { createRouter, createWebHistory } from "vue-router";
import Tasks from "@/components/Tasks.vue";

const routes = [
  {
    path: "/tasks",
    name: "tasks",
    component: Tasks,
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
