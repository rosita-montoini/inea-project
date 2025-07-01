export const navigationItems = [
  { to: "/tasks", label: "Tasks" },
  { to: "/projects", label: "Projects" },
];

export const baseTaskFields = [
  { name: "title", label: "Title", type: "input" },
  {
    name: "status",
    label: "Status",
    type: "select",
    options: [
      { value: "open", label: "Open" },
      { value: "in_progress", label: "In Progress" },
      { value: "done", label: "Done" },
    ],
  },
  { name: "project_id", label: "Project", type: "select" },
  { name: "assigned_to", label: "User", type: "select" },
];

export const baseProjectFields = [
  { name: "name", label: "Name", type: "input" },
  { name: "description", label: "Description", type: "textarea" },
];
