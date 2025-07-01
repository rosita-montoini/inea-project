const PROJECT_API = `${import.meta.env.VITE_API_URL}/routes/projects.php`;

export async function fetchProjects() {
  const res = await fetch(PROJECT_API);
  if (!res.ok) throw new Error("Failed to fetch projects");
  return res.json();
}
