User:     user@mail.com
Password: 123123123

Приложение делалось в спешке, много моментов опушено, а именно:
psr Request\Responce interfaces
CORS защита
Предпологается что mysqli метод bind_params безопасен, и защита от sql инъекций ложится на него

Была использована библиотека php-di для создания контейнера и техники внедрения зависимостей, сконфигурирована и спроектирована в спешке, можно было получше но с текущими тербованиями справляется

Основная логика вывода средств происходит в методе doWithdraw() классса User.
Суть в том что перед модификацией бд, блокирутся строка для записи и для чтения, с которой работаем (все в транзакции)

session_write_close() вызывается в методе doWithdraw() в контроллере, непосредственно перед работой с базой, что подразумевает разблокирование сессиии php для паралельного запроса.

В коде не везде соблюденны стандарты psr (возврачаемые значения методов и т.д) форматирование, остуствуют комментарии, так как делалось в спешке, надеюсь на ваше понимание. Если наймете меня то буду писать аккуратно и чисто)

Спасибо.
