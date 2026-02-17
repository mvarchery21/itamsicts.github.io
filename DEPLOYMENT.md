# Deployment Guide

This guide provides instructions for deploying the IT Asset Management System to various environments.

## Development Environment

Already covered in README.md. Use `php artisan serve` for local development.

## Production Deployment

### Prerequisites

- Web server (Apache/Nginx)
- PHP 8.2 or higher with required extensions
- Composer
- Database (MySQL/PostgreSQL/SQLite)
- Node.js & npm (for building assets)

### Step 1: Server Setup

#### For Apache

Create a virtual host configuration:

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    DocumentRoot /var/www/itam/public

    <Directory /var/www/itam/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/itam-error.log
    CustomLog ${APACHE_LOG_DIR}/itam-access.log combined
</VirtualHost>
```

#### For Nginx

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/itam/public;

    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Step 2: Deploy Application

```bash
# Clone repository
cd /var/www
git clone https://github.com/mvarchery21/itamsicts.github.io.git itam
cd itam

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Set up environment
cp .env.example .env
nano .env  # Configure your production settings
php artisan key:generate

# Set up database
php artisan migrate --force
php artisan db:seed  # Optional: Add test data

# Set permissions
sudo chown -R www-data:www-data /var/www/itam
sudo chmod -R 755 /var/www/itam
sudo chmod -R 775 /var/www/itam/storage
sudo chmod -R 775 /var/www/itam/bootstrap/cache

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 3: Environment Configuration

Edit `.env` file with production settings:

```env
APP_NAME="IT Asset Management System"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Use MySQL for production
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=itam
DB_USERNAME=your_db_user
DB_PASSWORD=your_secure_password

# Configure mail settings
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
```

### Step 4: SSL Certificate (Recommended)

Install Let's Encrypt certificate:

```bash
sudo apt install certbot python3-certbot-apache  # For Apache
# OR
sudo apt install certbot python3-certbot-nginx   # For Nginx

# Get certificate
sudo certbot --apache -d your-domain.com  # For Apache
# OR
sudo certbot --nginx -d your-domain.com   # For Nginx
```

### Step 5: Create Admin User

If you didn't run seeders, create an admin user manually:

```bash
php artisan tinker
```

Then in tinker:

```php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin User',
    'email' => 'admin@yourdomain.com',
    'password' => Hash::make('your-secure-password'),
    'is_admin' => true,
]);
exit
```

## Shared Hosting Deployment

For shared hosting environments:

1. Upload files via FTP/SFTP
2. Point document root to `/public` directory
3. Import database using phpMyAdmin or similar
4. Configure `.env` via file manager or SSH
5. Run migrations via SSH or create a temporary migration route

## Docker Deployment

Create a `docker-compose.yml`:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - "8000:80"
    volumes:
      - .:/var/www/html
    environment:
      - DB_CONNECTION=mysql
      - DB_HOST=db
      - DB_DATABASE=itam
      - DB_USERNAME=itam_user
      - DB_PASSWORD=secret
    depends_on:
      - db

  db:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: itam
      MYSQL_USER: itam_user
      MYSQL_PASSWORD: secret
      MYSQL_ROOT_PASSWORD: root_secret
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

## Maintenance

### Updating the Application

```bash
cd /var/www/itam
git pull origin main
composer install --no-dev --optimize-autoloader
npm install && npm run build
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Backup

Create regular backups:

```bash
# Backup database
php artisan backup:run  # If using spatie/laravel-backup
# OR manually
mysqldump -u user -p itam > backup-$(date +%Y%m%d).sql

# Backup files
tar -czf itam-backup-$(date +%Y%m%d).tar.gz /var/www/itam
```

## Troubleshooting

### Permission Issues

```bash
sudo chown -R www-data:www-data /var/www/itam
sudo chmod -R 755 /var/www/itam
sudo chmod -R 775 /var/www/itam/storage /var/www/itam/bootstrap/cache
```

### Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Check Logs

```bash
tail -f storage/logs/laravel.log
```

## Security Checklist

- [ ] Change all default passwords
- [ ] Set `APP_DEBUG=false` in production
- [ ] Enable HTTPS with valid SSL certificate
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Disable directory listing
- [ ] Set up regular backups
- [ ] Keep Laravel and dependencies updated
- [ ] Use strong database passwords
- [ ] Configure firewall rules
- [ ] Set up monitoring and alerting

## Performance Optimization

```bash
# Enable OPcache in php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000

# Use Redis for caching (optional)
# Update .env
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## Support

For deployment issues, consult:
- [Laravel Deployment Documentation](https://laravel.com/docs/deployment)
- Project GitHub Issues
- Laravel Community Forums
