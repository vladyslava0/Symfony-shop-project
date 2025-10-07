# Symfony Shop Project

A simple Symfony web application implementing:
- User authentication
- Product catalog
- Shopping cart
- Order creation and management

## Author
Vladyslava Bilyk

## Structure Overview

### Controllers (`src/Controller`)
Handle page logic and routes:
- `HomeController` – displays homepage
- `CatalogController` – lists all available items
- `CartController` – manages the shopping cart and order checkout
- `RegistrationController` – handles registration
- `SecurityController` – handles login and logout

### Entities (`src/Entity`)
Represent database tables:
- `User` – registered users
- `Item` – products available in the catalog
- `Order` – user orders
- `OrderItem` – items belonging to an order

### Services (`src/Service`)
Contain business logic separated from controllers:
- `CartService` – manages adding, updating, and removing items in the cart

### Templates (`templates/`)
Twig templates for rendering pages:
- `base.html.twig` – base layout
- `homepage.html.twig` – homepage
- `catalog/index.html.twig` – item list
- `cart/index.html.twig` – shopping cart and orders history
- `security/login.html.twig`, `security/register.html.twig` – authentication pages

---

## Setup & Installation

1. Clone the repository:
```bash
   git clone https://github.com/vladyslava0/Symfony-shop-project.git
   cd Symfony-shop-project
``` 
2. Install dependencies:
```bash
   composer install
```
Note: After running `composer install`, you also need to install the frontend assets for Symfony UX by executing:
```bash
   php bin/console importmap:install

```
3. Set up your database connection by filling in the DATABASE_URL variable in your .env, for example:
 ```bash
   DATABASE_URL="mysql://username:password@127.0.0.1:3306/db_name"
```
4. Create and migrate database:
 ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
```
5. Populate the catalog table (Items) via Doctrine Fixtures:
 ```bash
   php bin/console doctrine:fixtures:load
```
Creating users and orders must be done manually.

6. Run the local web server:
 ```bash
   symfony server:start
```
7. Open in browser:
 ```bash
   http://127.0.0.1:8000
```

---
## Technologies
- Symfony
- Doctrine ORM
- Twig
- Bootstrap
- PHP 8.3