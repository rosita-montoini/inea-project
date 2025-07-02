import { reactive } from "vue";

export const authState = reactive({
  isAuthenticated: false,
  user: null,
});
