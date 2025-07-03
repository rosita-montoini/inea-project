const API_BASE = `${import.meta.env.VITE_API_URL}/routes`;

export async function fetchTaskComments() {
  const res = await fetch(`${API_BASE}/task-comments.php`);
  if (!res.ok) throw new Error("Failed to fetch task comments");
  return res.json();
}

export async function createTaskComment(data) {
  const res = await fetch(`${API_BASE}/task-comments.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  });
  if (!res.ok) throw new Error("Failed to create comment");
  return res.json();
}
