# 👟 Shoe Store - Laravel & Filament Admin Panel

A modern e-commerce web application for shoe retail built with Laravel and Filament admin panel.

## 🚀 Features

- **Public Website**: Beautiful responsive homepage for customers
- **Admin Panel**: Powerful Filament-based admin interface
- **Multi-tenant Support**: Team-based management system
- **Modern UI**: Built with Tailwind CSS
- **Database**: MySQL support with migrations
- **Authentication**: Secure login system

## 📋 Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL 5.7+ or 8.0+
- Git

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd web-shose-store
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Setup

Copy the environment file:
```bash
cp .env.example .env
```

Generate application key:
```bash
php artisan key:generate
```

### 5. Database Configuration

Update your `.env` file with database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shose-db
DB_USERNAME=shoseuser
DB_PASSWORD=shosepass123
```

### 6. Create MySQL Database & User

Connect to MySQL and run:

```sql
CREATE DATABASE IF NOT EXISTS `shose-db`;
CREATE USER 'shoseuser'@'localhost' IDENTIFIED BY 'shosepass123';
GRANT ALL PRIVILEGES ON `shose-db`.* TO 'shoseuser'@'localhost';
FLUSH PRIVILEGES;
```

Or use the following command:
```bash
sudo mysql -e "
CREATE DATABASE IF NOT EXISTS \`shose-db\`;
CREATE USER IF NOT EXISTS 'shoseuser'@'localhost' IDENTIFIED BY 'shosepass123';
GRANT ALL PRIVILEGES ON \`shose-db\`.* TO 'shoseuser'@'localhost';
FLUSH PRIVILEGES;
"
```

### 7. Run Database Migrations

```bash
php artisan migrate
```

### 8. Seed Database (Optional)

```bash
php artisan db:seed
```

### 9. Build Assets

```bash
npm run build
```

## 🏃‍♂️ Running the Application

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at:
- **Public Website**: http://127.0.0.1:8000
- **Admin Panel**: http://127.0.0.1:8000/admin

### Production Build

For production, ensure you:

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run: `composer install --optimize-autoloader --no-dev`
4. Run: `php artisan config:cache`
5. Run: `php artisan route:cache`
6. Run: `php artisan view:cache`

## 🔐 Default Admin Credentials

For the admin panel, use these demo credentials:

- **Email**: admin@filamentphp.com
- **Password**: demo.Filament@2021!

⚠️ **Important**: Change these credentials in production!

## 📁 Project Structure

```
├── app/
│   ├── Filament/           # Filament admin components
│   │   ├── App/            # App panel resources
│   │   ├── Pages/          # Custom pages
│   │   └── Resources/      # Admin resources
│   ├── Http/
│   │   └── Controllers/    # Web controllers
│   ├── Models/             # Eloquent models
│   └── Providers/
│       └── Filament/       # Panel providers
├── resources/
│   └── views/              # Blade templates
├── routes/
│   ├── web.php            # Web routes
│   └── api.php            # API routes
└── database/
    ├── migrations/        # Database migrations
    └── seeders/          # Database seeders
```

## 🎨 Customization

### Admin Panel

The admin panel is configured in:
- `app/Providers/Filament/AdminPanelProvider.php`

### Home Page

The public homepage can be customized in:
- Controller: `app/Http/Controllers/HomeController.php`
- View: `resources/views/home.blade.php`

### Styling

The project uses Tailwind CSS. You can customize styles by:
1. Editing the main view files
2. Running `npm run build` to compile assets

## 🔧 Useful Commands

### Development

```bash
# Clear all caches
php artisan optimize:clear

# Generate new migration
php artisan make:migration create_products_table

# Create new model
php artisan make:model Product -m

# Create Filament resource
php artisan make:filament-resource Product

# Watch for file changes (assets)
npm run dev
```

### Database

```bash
# Fresh migration with seeding
php artisan migrate:fresh --seed

# Rollback migrations
php artisan migrate:rollback

# Check migration status
php artisan migrate:status
```

## 🐛 Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   sudo chown -R $USER:www-data storage bootstrap/cache
   sudo chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Error**
   - Verify MySQL is running: `sudo systemctl status mysql`
   - Check database credentials in `.env`
   - Ensure database exists

3. **Assets Not Loading**
   ```bash
   npm run build
   php artisan config:clear
   ```

4. **Filament Panel Not Accessible**
   - Clear config: `php artisan config:clear`
   - Check panel provider registration

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📞 Support

If you encounter any issues or have questions:
1. Check the troubleshooting section above
2. Search existing issues in the repository
3. Create a new issue with detailed information

---

Made with ❤️ for shoe enthusiasts everywhere!
# web-shose-store
