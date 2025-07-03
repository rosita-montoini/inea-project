import { authState } from "../../stores/authState";

const API_BASE = `${import.meta.env.VITE_API_URL}/routes`;

export async function requireAuth(to, from) {
  try {
    const res = await fetch(`${API_BASE}/auth/check.php`, {
      credentials: "include",
    });

    const data = await res.json();

    if (data.authenticated) {
      return true;
    } else {
      return { path: "/login" };
    }
  } catch (e) {
    return { path: "/login" };
  }
}

export async function checkAuth() {
  const res = await fetch(`${API_BASE}/auth/check.php`, {
    credentials: "include",
  });

  const data = await res.json();

  authState.isAuthenticated = data.authenticated;
  authState.user = data.user || null;

  return data;
}
