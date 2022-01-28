# Cloner le projet
```bash
git clone https://github.com/ThomasMouchelet/afpa-blog-symfony
```
```bash
composer install
```
```bash
php bin/console doctrine:database:create
```
```bash
php bin/console doctrine:migrations:migrate
```
```bash
php bin/console doctrine:fixtures:load
```
```bash
php -S 127.0.0.1:8000 -t ./public
```

# Create form
```bash
php bin/console make:form
```
