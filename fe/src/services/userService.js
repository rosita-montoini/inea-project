const USER_API = `${import.meta.env.VITE_API_URL}/routes/users.php`;

export async function fetchUsers() {
  const res = await fetch(USER_API);
  if (!res.ok) throw new Error("Failed to fetch users");
  return res.json();
}
