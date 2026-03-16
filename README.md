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

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)