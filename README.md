# Inea vue project set up

## MySql set up

- mysql -u root -p
- CREATE DATABASE project_demo;
- USE project_demo;
- CREATE TABLE auth_users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255)
  );

## Front-end set up

- fe/
  npm install
  npm run dev
