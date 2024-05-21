## Laravel Login Package

This package provides a simple and secure login system for Laravel applications. It includes OTP verification and user authentication using Laravel Passport, with integration for Kavenegar for OTP sending and Sentry for error tracking.

### Installation

To install the package, follow these steps:

1. Install the package via Composer:

    ```bash
    composer require usermp/laravel-login
    ```

2. Add the required environment variables to your `.env` file:

    ```env
    # Constants for OTP settings
    OTP_TOKEN_EXPIRE_SECONDS=180
    OTP_TOKEN_NUM_DIGITS=6

    # Kavenegar API settings
    KAVENEGAR_API_KEY=""
    KAVENEGAR_SENDER=""

    # Sentry configuration
    SENTRY_LARAVEL_DSN=""
    SENTRY_TRACES_SAMPLE_RATE=1.0
    ```

3. Add the `LoginServiceProvider` class to the providers array in your `config/app.php` file:

    ```php
    'providers' => [
        // Other Service Providers
        Usermp\LaravelLogin\LoginServiceProvider::class,
    ],
    ```

4. Run the migrations to set up the necessary database tables:

    ```bash
    php artisan migrate
    ```

5. Configure Laravel Passport:

    ```bash
    php artisan passport:install
    ```

With these steps completed, your Laravel application is now equipped with a secure login system integrated with OTP verification.
