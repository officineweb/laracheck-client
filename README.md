<div align="center">
  
  # Laracheck Client
  
  **Automatic Exception Tracking for Laravel Applications**
  
  Send exceptions from your Laravel app to your Laracheck monitoring server with zero configuration.
  
  [![Packagist](https://img.shields.io/packagist/v/officineweb/laracheck-client.svg)](https://packagist.org/packages/officineweb/laracheck-client)
  [![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE.md)
  [![Laravel](https://img.shields.io/badge/Laravel-9+-red.svg)](https://laravel.com)
  [![PHP](https://img.shields.io/badge/PHP-8.1+-purple.svg)](https://php.net)
</div>

---

## 🚀 Installation

Install the package via Composer:

```bash
composer require officineweb/laracheck-client
```

## ⚡ Quick Setup (3 Steps)

### 1. Publish Configuration

```bash
php artisan vendor:publish --tag=laracheck-config
```

### 2. Add Credentials to `.env`

Get your API key from your Laracheck dashboard and add to `.env`:

```env
LARACHECK_KEY=your-api-key-from-laracheck-dashboard
LARACHECK_URL=https://your-laracheck-server.com
```

### 3. Register Exception Tracking

In your `bootstrap/app.php`, add exception tracking:

```php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 👇 Add this line
        app('laracheck')->track($exceptions);
    })
    ->create();
```

**That's it!** 🎉 Your application will now automatically send exceptions to Laracheck.

## 📊 What Gets Tracked

The client automatically captures:

- ✅ Exception message and stack trace
- ✅ File path and line number
- ✅ HTTP method and full URL
- ✅ Environment (local, staging, production)
- ✅ HTTP status code
- ✅ Authenticated user information
- ✅ Request metadata (IP, user agent)
- ✅ Server information

### Smart Tracking

- **4xx errors** (404, 403, etc.) are auto-marked as fixed with no alerts
- **5xx errors** (500, 503, etc.) trigger immediate notifications
- **Environment-aware** - separates local, staging, and production exceptions

## 🔒 Security

- API key authentication for all requests
- Secure HTTPS communication
- No sensitive data is sent (passwords, tokens, etc.)
- Failed requests fail silently to avoid infinite loops

## 📝 Example Data Structure

```json
{
  "exception": "ErrorException: Undefined variable",
  "file": "app/Http/Controllers/UserController.php",
  "line": "42",
  "class": "ErrorException",
  "code": 500,
  "method": "GET",
  "fullUrl": "https://myapp.com/users/123",
  "host": "myapp.com",
  "env": "production",
  "user": {
    "id": 1,
    "email": "user@example.com",
    "name": "John Doe"
  }
}
```

## 🌐 Laracheck Server

This client requires a Laracheck server instance. Get started:

```bash
git clone https://github.com/officineweb/laracheck.git
cd laracheck
composer install
php artisan migrate
php artisan serve
```

Visit the [Laracheck Server Repository](https://github.com/officineweb/laracheck) for complete installation instructions.

## 🛠️ Requirements

- PHP 8.1 or higher
- Laravel 9.x, 10.x, 11.x, or 12.x
- Guzzle HTTP client (auto-installed)

## 🤝 Contributing

Contributions are welcome! Please submit issues and pull requests to the [GitHub repository](https://github.com/officineweb/laracheck-client).

## 📄 License

The MIT License (MIT). See [LICENSE](LICENSE.md) for more information.

## 💙 Credits

Built with ❤️ by [Officine Web](https://officineweb.it)

---

<div align="center">
  <strong>Keep your Laravel apps bug-free!</strong>
  <br>
  <a href="https://github.com/officineweb/laracheck">View Laracheck Server</a> •
  <a href="https://github.com/officineweb/laracheck-client">⭐ Star on GitHub</a>
</div>
