# Api на чистом php

Данное Api включает в себя создание нескольких таблиц в БД Sqlite3, моделей для работы с таблицам и апи для получения и создания записей в таблице, а именно:

1) Настройка подключения к базе `db.sqlite` в `src\db\connection.php`
2) Создание таблиц `users` и `post` в БД в `scr\db\initial.php`
3) Создание класса модели User в `src\Models\User.php` с указанными в задании методами и свойствами
4) Создание класса модели Post в `src\Models\Post.php` с указанными в задании методами и свойствами
5) Настройка endpoint для апи по урлам `PUT /api/users` `GET /api/users/:id` выполняющими указанные в задании процессы



#### Получение user по ID

`GET /api/users/:id` - где `:id` это число, указывающие ID из таблицы users, на этот запрос возвращается ответ в формате JSON с полями из таблицы users по полученному ID, пример:

```text
//Request:
GET /api/users/1

//Response:
{
    "id": 1,
    "email": "some-email@mail.com",
    "first_name": "SomeName",
    "last_name": "SomeLastName",
    "password": "SomePassword",
    "created_at": 1659633384,
}
```

#### Создание user

```text
PUT /api/users

{
    "email": :email,
    "first_name": :first_name,
    "last_name": :last_name,
    "password": :password,
}
```

- где `:email`, `:first_name`, `:last_name` и `:password` это поля в таблице users для создания в ней записи, на этот возвращается ответ в формате JSON с полями из таблицы users по полученной после создания записи, пример:

```text
//Request:
PUT /api/users

{
    "email": "api-email@mail.com",
    "first_name": "ApiName",
    "last_name": "ApiLastName",
    "password": "ApiPassword",
}

//Response:
{
    "id": 23,
    "email": "api-email@mail.com",
    "first_name": "ApiName",
    "last_name": "ApiLastName",
    "password": "ApiPassword",
    "created_at": 1659633584,
]
```
