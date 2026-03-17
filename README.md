# Laravel-Damien

Laravel-Damien is a basic dockerized Laravel web application for my learning experiment. It features base user authentication and posts which logged in users can create, read, update and delete. An external worker also retreives posts from a public API and inserts them into the table. If the user is not logged in they see only the most recent 10 articles (polled for live data visibility). 


## Installation


## Usage

Scheduler function that queries a public endpoint and creates records of the "Posts" in the database.
```bash
php artisan schedule:work
```

Testing (Pest)
```bash
php artisan test
```

### How to Run

1. Install dependencies
```bash
php artisan schedule:work
```

2. Configure environment
Copy .env.example to .env
Set database connection and run:
```bash
php artisan key:generate
php artisan migrate
```

3. Run the development server
```bash
php artisan serve
```

4. Visit http://localhost:8000 in a browser.

## Todo
- Update blades to use livewire layout
- Policies for users

## Design highlights

- Clean separation of concerns: Routing/controllers handle HTTP actions, while Livewire components encapsulate interactive UI state (forms, validation, polling).
- Modern Laravel + PHP conventions: Eloquent ORM for data access and PHP attribute-based Livewire validation for readable, maintainable rules.
- Security-minded defaults: Password hashing, input validation/sanitization, and authentication guards with clear user-facing error feedback.
- Realtime updates without a heavy frontend: Livewire polling keeps the “Top Posts” dashboard current with minimal JavaScript complexity.
- Built for iteration: Pest tests provide quick regression coverage for key workflows 

## License

[MIT](https://choosealicense.com/licenses/mit/)