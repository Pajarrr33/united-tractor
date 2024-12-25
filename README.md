
# United Tractor

United Tractor is a RESTful API designed to manage Category Product and Product. It includes secure endpoints and detailed swagger documentation


## Installation

1. Clone the repository

```bash
    git clone https://github.com/Pajarrr33/united-tractor.git
```

2. Swith to the repo folder

```bash
    cd united-tractor
```

3. Install all the dependencies

```bash
    composer install
```

4. Copy the `.env.example` file and make the required configuration changes in the `.env` file

```bash
    cp .env.example .env
```

5. Generate a new application key

```bash
    php artisan key:generate
```

6. Generate a new jwt authentication secret key
```bash
    php artisan jwt:generate
```

7. Run the database migration (Set the database connection in .env before migrating)
```bash
    php artisan migrate
```

8. Start the local development server
```bash
    php artisan serve
```
    
## Database seeding
Run the database seeder
```bash
    php artisan db:seed
```
## API Specification
All of the api specification is in `storage/api-docs/api-docs.json` and you can also import a postman collection in `storage/api-docs/united-tractor.postman_collection.json`

You can also generate the api-docs
```bash
    php artisan l5-swagger:generate
```

You can check the swagger documentation in
```bash
    http://localhost:8000/api/documentation/
```