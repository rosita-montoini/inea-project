const API_BASE = `${import.meta.env.VITE_API_URL}/routes`;

export async function fetchProjects() {
  const res = await fetch(`${API_BASE}/projects.php`);
  if (!res.ok) throw new Error("Failed to fetch projects");
  return res.json();
}

export async function updateProject(project) {
  const res = await fetch(`${API_BASE}/projects.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(project),
  });

  if (!res.ok) throw new Error("Failed to update project");
  return res.json();
}

export async function createProject(projectData) {
  const res = await fetch(`${API_BASE}/projects.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(projectData),
  });
  if (!res.ok) throw new Error("Failed to create project");
  return res.json();
}
