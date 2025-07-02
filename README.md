# Inea vue project set up

## Front-end set up

- fe/
  - Create a .env file in this folder and put your variables there, like in the .env.example file.
  - nvm use 20
  - npm install
  - npm run dev

## Back-end set up

- be/
  - Create a .env file in this folder and put your variables there, like in the .env.example file.
  - composer install
  - php -S localhost:8000

## MySql set up

### Generate hash password

- php -r "echo password_hash('123456', PASSWORD_DEFAULT) . PHP_EOL;"

- Put this hash password in the file init.sql for users table

### To install db run this command

- mysql -u root -p < sql/init.sql
