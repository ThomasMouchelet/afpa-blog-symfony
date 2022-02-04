# Cloner le projet
```bash
git clone https://github.com/ThomasMouchelet/afpa-blog-symfony
```
```bash
composer install
npm install
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
npm run dev-server
```

```bash
php bin/console doctrine:database:drop --force
```

# Create form
```bash
php bin/console make:form
```

# Create user
```bash
php bin/console make:user
php bin/console make:controller
> SecurityController
php bin/console make:auth
```
# Create login form
```bash
php bin/console make:auth
```
# Create registration form
```bash
php bin/console make:registration-form
```