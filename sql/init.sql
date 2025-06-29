CREATE DATABASE IF NOT EXISTS task_manager;
USE task_manager;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL
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

INSERT INTO users (name, email) VALUES
('Iryna Chernenko', 'iryna.ch@example.com'),
('Dmytro Chernenko', 'dmytroch@example.com'),
('Maria Ostapenko', 'maria@example.com');

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

INSERT INTO tasks (title, project_id, assigned_to) VALUES
('Create database schema for clients and leads', 1, 1),
('Design lead input form UI', 1, 1);