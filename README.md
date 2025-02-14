# Translation API Service

## Overview
This is a Laravel-based API-driven service for managing translations across multiple locales with tagging and efficient search functionality. The API provides token-based authentication using Laravel Passport, optimized SQL queries, and high-performance JSON responses.

## Features
- Store translations for multiple locales (e.g., `en`, `fr`, `es`).
- Support tagging for context (e.g., `mobile`, `desktop`, `web`).
- Expose CRUD endpoints for translations.
- Search translations by key, tag, or content.
- Provide a JSON export endpoint for frontend applications.
- Optimized response times (<200ms for regular queries, <500ms for large datasets).
- Scalable database schema following PSR-12 and SOLID principles.
- 100k+ records population for performance testing.
- Implemented token-based authentication with Laravel Passport.
- OpenAPI/Swagger documentation for API reference.
- Dockerized setup for easy deployment.
- >95% test coverage with unit and feature tests.

## Requirements
- PHP 8.2+
- Composer 2.0
- MySQL 8.0+
- Laravel 11

## Installation & Setup
### 1. Clone the Repository
```sh
git clone https://github.com/your-repo/translation-api.git
cd translation-api
```

### 2. Install Dependencies
```sh
composer install
```

### 3. Set Up Environment Variables
Copy the `.env.example` file and update the database credentials:
```sh
cp .env.example .env
```
Modify `.env`:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=translations_db
DB_USERNAME=root
DB_PASSWORD=secret
```

### 4. Run Migrations
```sh
php artisan migrate
```

### 5. Install Laravel Passport
```sh
php artisan passport:install
```

### 6. Seed Database with 100K+ Records (Optional for Testing)
```sh
php artisan db:seed
```

### 7. Serve the Application
```sh
php artisan serve
```


## API Endpoints
### Authentication
- `POST /api/login` - Authenticate and receive an access token
### Translations
- `GET /api/translations` - Retrieve all translations (searchable by key, tag, locale)
- `POST /api/translations` - Create a new translation
- `PUT /api/translations/{id}` - Update a translation
- `DELETE /api/translations/{id}` - Delete a translation
- `GET /api/translations/export` - Export all translations as JSON

## Testing
Run the unit and feature tests:
```sh
php artisan test
```

## API Documentation
Swagger documentation is available at:
```
http://127.0.0.1:8000/api/documentation
```
Generate updated API docs:
```sh
php artisan l5-swagger:generate
```

## Performance & Scalability
- Optimized SQL queries with indexing for fast searches.
- Paginated results to handle large datasets efficiently.
- JSON export endpoint optimized for responses under 500ms.
- Factory and Seeder available to populate 100K+ records.

## Contribution
Pull requests are welcome. Follow PSR-12 and SOLID principles.

## License
MIT License.

## Contact
For any inquiries, contact `habibahmed001@gmail.com`.

