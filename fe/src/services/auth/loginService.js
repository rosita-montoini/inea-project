import { authState } from "../../stores/authState";

const API_BASE = `${import.meta.env.VITE_API_URL}/routes`;

export async function login(email, password, router, error) {
  const res = await fetch(`${API_BASE}/auth/login.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ email: email.value, password: password.value }),
    credentials: "include",
  });

  const data = await res.json();

  if (res.ok && data.success) {
    authState.isAuthenticated = true;
    router.push("/tasks");
  } else {
    error.value = data.message || "Login failed";
  }
}
