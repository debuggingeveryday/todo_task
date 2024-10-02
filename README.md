# todo task

### Requirements

docker - https://www.docker.com/
git bash - https://git-scm.com/

## Installation

### Configuration (git bash or bash only)

```
git clone https://github.com/debuggingeveryday/todo_task.git
cd todo_task
// build container
docker-compose up -d
// once if finish build the container then run to tty with container php
docker-compose exec php bash
cp .env.example .env
composer install
// once if finish installing composer package
npm install
php artisan key:generate
php artisan migrate
```

### Address location

for web project: http://localhost
for managing database: http://localhost:9090

### Run project

```
// run watch
npm run watch
// to build
npm run build
```

### Credentials

Admin
user: admin@system.com
pass: admin12345

Staff
user: staff@system.com
pass: staff12345

### Reference

for Dockerfile: https://github.com/refactorian/laravel-docker/tree/main
