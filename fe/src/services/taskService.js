const API_BASE = `${import.meta.env.VITE_API_URL}/routes`;

export async function fetchTasks() {
  const res = await fetch(`${API_BASE}/tasks.php`);
  if (!res.ok) throw new Error("Failed to fetch tasks");
  return res.json();
}

export async function updateTask(task) {
  const res = await fetch(`${API_BASE}/tasks.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(task),
  });

  if (!res.ok) throw new Error("Failed to update task");
  return res.json();
}
