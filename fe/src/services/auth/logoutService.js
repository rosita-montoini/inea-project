import { authState } from "../../stores/authState";

const API_BASE = `${import.meta.env.VITE_API_URL}/routes`;

export async function logout(router) {
  await fetch(`${API_BASE}/auth/logout.php`, {
    credentials: "include",
  });
  authState.isAuthenticated = false;
  authState.user = null;

  router.push("/login");
}
