# News project

### Переменные окружения

`APP_ENV` -- Окружение проекта. Может быть "dev" (локальная разработка), "stage", "prod".

### БД

```
php bin/console doctrine:database:drop --force
php bin/console doctrine:database:create
```

### Миграции

```
php bin/console doctrine:migrations:diff
php bin/console doctrine:migrations:migrate
```

### Команды

```
php bin/console app:parse-news
```

### Установка

```
cp .env .env.local

-- Настраиваем доступы к БД

composer install

php bin/console doctrine:migrations:migrate

php bin/console app:parse-news

-- Всё. Можно открывать главную страницу в браузере.
```
