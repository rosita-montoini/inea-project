CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin', 'user') DEFAULT 'user',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT
);

CREATE TABLE IF NOT EXISTS tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  status ENUM('open', 'in_progress', 'done') DEFAULT 'open',
  project_id INT,
  assigned_to INT,
  FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE SET NULL,
  FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS task_comments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  comment TEXT,
  task_id INT,
  user_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE SET NULL,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

INSERT INTO users (name, email, role, password_hash) VALUES
(
  'Bill Gates', 
  'bill.gates@example.com', 
  'admin', 
  '$2y$10$5JK0yib4s4AO9pOmt6gXMetDAklg23eTnNn4yYOR/8pL//AIs33Ce'
),
(
  'Steve Jobs', 
  'steve.jobs@example.com', 
  'user', 
  '$2y$10$5JK0yib4s4AO9pOmt6gXMetDAklg23eTnNn4yYOR/8pL//AIs33Ce'
),
(
  'Mark Zuckerberg', 
  'mark.zuckerberg@example.com', 
  'user', 
  '$2y$10$5JK0yib4s4AO9pOmt6gXMetDAklg23eTnNn4yYOR/8pL//AIs33Ce'
),
(
  'Sergey Brin', 
  'sergey.brin@example.com', 
  'user', 
  '$2y$10$5JK0yib4s4AO9pOmt6gXMetDAklg23eTnNn4yYOR/8pL//AIs33Ce'
);

INSERT INTO projects (name, description) VALUES
(
    'BuildSmart CRM', 
    'A customer relationship management system'
),
(
    'FitTrack Mobile', 
    'A mobile fitness app'
),
(
    'TeamFlow', 
    'A collaborative task management web app for teams'
);

INSERT INTO tasks (title, status, project_id, assigned_to) VALUES
('Create database schema for clients and leads', 'in_progress', 1, 1),
('Design workout logging screen', 'in_progress', 2, 3),
('Implement food diary feature', 'done', 2, 3),
('Implement drag-and-drop for task cards', 'open', 3, 2),
('Add real-time updates with WebSocket', 'open', 3, 2),
('Build search and filtering system', 'in_progress', 3, 2);

INSERT INTO task_comments (comment, task_id, user_id) VALUES
('New comment 1', 1, 1),
('New comment 2', 4, 2);