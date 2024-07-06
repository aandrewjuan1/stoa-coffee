# Coffee Shop Website in Laravel (Under Development)

A web application for a coffee shop, built with Laravel. Currently under active development.

## Overview

This project aims to create a modern and user-friendly web application for a coffee shop, allowing customers to browse products, place orders, and administrators to manage inventory and orders efficiently.

## Features

- Browse coffee products
- Customize coffee orders
- Add products to the cart
- Place orders
- Manage inventory (admin)
- Track orders (admin)

## Setup Instructions

Follow these steps to set up the project locally:

### Prerequisites

- PHP >= 7.3
- Composer
- Node.js & npm (or Yarn)
- MySQL (or any other database supported by Laravel)

### Steps

1. **Clone the Repository**
   ```sh
   git clone https://github.com/username/repository.git
   cd repository
2. Install PHP Dependencies
    ```sh
    composer install
3. Install Node.js Dependencies
    ```sh
    npm install
    # or
    yarn install
4. Set Up Environment Variables
    ```sh
    cp .env.example .env
5. Generate Application Key
    ```sh
    php artisan key:generate
6. Configure Database

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
7. Run Migrations
    ```sh
    php artisan migrate
8. Seed the Database
    ```sh
    php artisan db:seed
9. Compile Assets
    ```sh
    npm run dev
    # or
    yarn dev
10. Serve the Application
    ```sh
    php artisan serve
