# Kaspersky Endpoint Security docker service

Столкнулся с необходимостью проверять загружаемые клиентам файлы на наличие вирусов в реальном времени (синхронном режиме). Причем результат нужно было показывать клиенту сразу при загрузке, а не асинхронно. Готового решения проверки в синхронном режиме найти не смог. Как следствие, разработал следующий микросервис для docker архитектуры.

Решение базируется на следующем стеке:
 1. Docker образ phusion/baseimage
 2. Kaspersky endpoint security
 3. Nginx
 4. PHP-FPM 7.2

Решение представляет собой антивирус с web интерфейсом для проверки файлов. Методы API будут описаны ниже.

## Kaspersky endpoint security
Выбрал данный антивирус, т.к. он проверенный и находит большинство вирусов. В docker контейнере он работает в штатном режиме, обновляется сам и обновляет антивирусные базы.
Документация: [https://docs.s.kaspersky-labs.com/russian/kes10_linux_adminguide_ru.pdf](https://docs.s.kaspersky-labs.com/russian/kes10_linux_adminguide_ru.pdf)

## Nginx и PHP-FPM
В связи с тем, что веб сервису приходится работать с антивирусом, к которому *доступ ограничен от всех пользователей, кроме root* - пришлось исправить файлы конфигурации для старта данных сервисов из под root. **Да простят меня системные администраторы ;)**

## Установка
### Использование готового образа

    docker pull smskin/kes:latest

### Сборка образа из исходников

    git clone git@github.com:smskin/docker-kes.git
    cd docker-kes
    cp .env.example .env
    docker-compose build
    docker-compose up

В Dockerfile используется переменная **KES_SOURCE**, определенная в файле **.env** - адрес, с которого необходимо скачивать deb пакет kaspersky endpoint security. Последнюю версию пакета можно узнать по адресу [https://www.kaspersky.ru/small-to-medium-business-security/downloads/endpoint](https://www.kaspersky.ru/small-to-medium-business-security/downloads/endpoint)

Так же в проекте используется скрипт автоматической установки kaspersky endpoint security. Он описан в файле */system/kes/autoinstall* (в проекте) и в */root/kes/autoinstall* (в фс образа). Скрипт настроен следующим образом:
 - Все соглашения принимаются
 - Используется триальный ключ, который выдается автоматически при разворачивании образа
 - Включено автоматическое обновление сигнатур
 - При обновлении настройки антивируса будут сохранены

Если вы желаете внести изменения в настройки установки, мануал тут: [https://docs.s.kaspersky-labs.com/russian/kes10_linux_adminguide_ru.pdf](https://docs.s.kaspersky-labs.com/russian/kes10_linux_adminguide_ru.pdf)

## API
С помощью swagger реализована документация, доступная по адресу: [http://localhost:81/docs/index.html](http://localhost:81/docs/index.html) (при развертывании из предложенного docker-compose.yml). Если развертываете самостоятельно, то доступна по адресу {host}/docs/index.html

API состоит из следующих методов:
**GET: ​/kes​/app-info**
Возвращает информацию об антивирусе, состоянии баз и статистику.
Запрашивает данные с помощью вызова антивируса:

    /opt/kaspersky/kesl/bin/kesl-control --app-info

**POST /kes/scan-file**
С помощью данного метода вы можете отправить файл на проверку. В ответе вы получите состояние файла (isInfected) + информацию о тестировании (сырую) от антивируса.
Запрашивает данные с помощью вызова антивируса:

    /opt/kaspersky/kesl/bin/kesl-control --scan-file %fileName%
