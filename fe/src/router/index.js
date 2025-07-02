import { createRouter, createWebHistory } from "vue-router";
import Login from "@/pages/Login.vue";
import Register from "@/pages/Register.vue";
import Tasks from "@/pages/Tasks.vue";
import Projects from "@/pages/Projects.vue";
import Dashboard from "@/pages/Dashboard.vue";
import { requireAuth } from "@/services/auth/authService";

const routes = [
  { path: "/login", name: "login", component: Login },
  {
    path: "/register",
    name: "register",
    component: Register,
  },
  {
    path: "/tasks",
    name: "tasks",
    component: Tasks,
    beforeEnter: requireAuth,
  },
  {
    path: "/dashboard",
    name: "dashboard",
    component: Dashboard,
    beforeEnter: requireAuth,
  },
  {
    path: "/projects",
    name: "projects",
    component: Projects,
    beforeEnter: requireAuth,
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
