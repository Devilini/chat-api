### Задание: https://github.com/avito-tech/msg-backend-trainee-assignment

### Установка

- **Для запуска можно использовать OpenServer (PHP: 7.4, MySQL: 8.0)**
- **Клонировать проект**
- **Выполнить composer install**
- **В файде .env прописать название БД (необходимо создать вручную) с логином и паролем (секции DB_USERNAME и DB_PASSWORD соответственно)**
- **Выполнить миграции в папке проекта через консоль - php artisan migrate**
- **Запустить команду php artisan serve --host 127.0.0.1 --port 9000**
- **В заголовках передавать Accept = application/json и Authorization (см. Токен доступа)**

### Архитектура

- **Безопасность - с каждым запросом необходимо передовать заголовок Authorization с токеном (см. Токен доступа)**
- **Идемпотентность - В заголовках можно передовать Idempotency-Key с уникальным значением. Если ключ не Будет найден в кэше, то после выполнения операции, результат сохранится в кэш, при новом запросе с тем же ключом данные будут взяты сразу из кэша (хранятся 24 часа).  Так как по ТЗ все запросы POST (даже на получение данных) для удобства этот заголовок можно не указывать, тогда проверка осуществляться не будет**


### Токен доступа
eyJhbGciOiJIUzI1NiJ9.eyJSb2xlIjoiQWRtaW4iLCJJc3N1ZXIiOiJJc3N1ZXIiLCJVc2VybmFtZSI6IkphdmFJblVzZSIsImV4cCI6MTYyNjg5NzU1NywiaWF0IjoxNjI2ODk3NTU3fQ.QLtDeDWzRANP4nD3WhruFQGDRMnbqqsn0KAAUha9Ows
