const API_BASE = `${import.meta.env.VITE_API_URL}/routes`;

export async function fetchTaskComments() {
  const res = await fetch(`${API_BASE}/task-comments.php`);
  if (!res.ok) throw new Error("Failed to fetch task comments");
  return res.json();
}
