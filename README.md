# short-urls

### Для розгортання проекту необхідно, щоб на ПК був встановленний Docker    

#### 1. Склонуйте проект
#### 2. Перейдіть в папку з проектом
#### 3. При необхіності внесіть зміни в `.env` для підключення до БД
#### 4. Виконайте наступні команди:
``` shell script
docker-compose up -d --build
```
``` shell script
docker-compose run --rm php74-service composer install
```
``` shell script
docker-compose run --rm php74-service php bin/console doctrine:database:create
```
``` shell script
docker-compose run --rm php74-service php bin/console doctrine:migrations:migrate
```
``` shell script
docker-compose run --rm node-service yarn install
```
``` shell script
docker-compose run --rm node-service yarn dev
```

#### Додайте в Ваш файл `hosts`:
``` shell script
127.0.0.1 		url.loc
```
