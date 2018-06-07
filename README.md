# Contact manager

> API only by now

Laravel

### Requirements

- Composer

### Installation

This project use Laravel 5.6 as Framework, to run it see the packages needed [here](https://laravel.com/docs/5.6/#server-requirements)

1 - Clone the project

```bash
$ git clone git@github.com:LucasLeandro1204/contact-manager.git
$ cd contact-manager
```

2 - Create a .env file

```bash
$ cp .env.example .env
```

_SQLITE is the default database provider_

3 - Install composer dependencies

```bash
$ composer install
```

### Testing

This projects has unit / feature tests, simple run phpunit
```bash
$ composer run test
```

### Coverage

1 - Run the command below
```bash
$ composer run coverage
```

2 - Go to
```contact-manager.test/coverage/index.html```
