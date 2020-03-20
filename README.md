# Task Manage

- Symfony
- Doctrine
- Docker

## Gereksinimler

- Tüm paketler [composer](https://getcomposer.org) ile kurulacaktır.
- Proje [docker](https://www.docker.com/) ile çalışmaktadır. [docker compose](https://docs.docker.com/compose/) ile entegredir.

## Kurulum

### Docker için kurulum ayarları

docker-compose.yml.dist dosyası docker-compose.yml olarak değiştirilmeli ve docker-compose.yml.dist **silinmemeli!**
docker.dist klasörü kopyalanıp yalnızca docker olacak şekilde aynı dizine yapıştırılmalı.
.env.dist dosyası kopyalanıp yalnızca .env olacak şekilde aynı dizine yapıştırılmalı.

Ardından var/ klasörü oluşturulmalı.
```bash
mkdir -m 777 var
```

Proje ilk defa klolandıysa veya proje içinde bulunan docker dosyalarında bir değişiklik olursa aşağıdaki satır çalıştırılmalı.
```bash
docker-compose build
```

Proje docker üzerinden ayağa kaldırılmak istenirse 
```bash
docker-compose up
```

## Dev Domain:

Aşağıdaki domain /etc/host içerisine tanımlanmalı ve ip olarak 127.0.0.1 verilmeli.

```bash
taskmanage.net
```

## Composer kurulumları
Docker Php container'ına bağlanarak;
```bash
composer install
```  

## Migration
Docker Php container'ına bağlanarak;
```bash
php bin/console doctrine:migrations:migrate
``` 

## Seed
Provider ve Developer listesini db'ye eklemektedir. 
Docker Php container'ına bağlanarak;
```bash
php bin/console app:seed
``` 

## Provider Task'ları Almak için
Docker Php container'ına bağlanarak;
```bash
php bin/console app:task:get
``` 
