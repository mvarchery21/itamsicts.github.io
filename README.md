# IT Asset Management System (ITAM)

A comprehensive web-based IT Asset Management System built with Laravel 11, featuring authentication, role-based access control, and complete asset lifecycle management.

## Features

### 🔐 Authentication & Security
- Secure login system powered by Laravel Breeze
- Role-based access control (Admin and User roles)
- Password hashing and session management
- Protected routes with middleware

### 👨‍💼 Admin Features
- **Dashboard**: Real-time statistics and overview
  - Total assets count
  - Available assets count
  - Assigned assets count
  - Total users count
  - Recent assignment activity
- **Asset Management**: Complete CRUD operations
  - Create, view, edit, and delete assets
  - Track detailed information: name, asset tag, category, description, serial number, manufacturer, model, purchase date, purchase price
  - Multiple status options: Available, Assigned, Maintenance, Retired
- **Asset Assignment**: 
  - Assign assets to users
  - Add assignment notes
  - Track assignment dates
  - Return asset functionality
- **User Management**: View all users and their assignment statistics
- **Assignment Tracking**: Complete history of all asset assignments

### 👤 User Features
- **My Assets**: View currently assigned assets in an easy-to-read card format
- **Assignment History**: Complete history of all assets ever assigned
- **Asset Details**: View detailed information about assigned assets including serial numbers, assignment dates, and notes

## Technology Stack

- **Framework**: Laravel 11
- **PHP**: 8.2+
- **Database**: SQLite (easily configurable to MySQL/PostgreSQL)
- **Frontend**: Blade Templates + Tailwind CSS
- **Authentication**: Laravel Breeze
- **Build Tools**: Vite

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/mvarchery21/itamsicts.github.io.git
   cd itamsicts.github.io
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Set up database**
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   - Open your browser and navigate to `http://localhost:8000`

## Default Credentials

After running the seeders, you can log in with these test accounts:

**Administrator:**
- Email: `admin@itam.com`
- Password: `password`

**Regular Users:**
- Jane Smith: `jane@example.com` / `password`
- John Doe: `john@example.com` / `password`
- Bob Johnson: `bob@example.com` / `password`

## Database Schema

### Users Table
- `id`: Primary key
- `name`: User's full name
- `email`: Unique email address
- `password`: Hashed password
- `is_admin`: Boolean flag for admin role
- `created_at`, `updated_at`: Timestamps

### Assets Table
- `id`: Primary key
- `name`: Asset name
- `asset_tag`: Unique identifier
- `category`: Asset category (Laptop, Monitor, etc.)
- `description`: Detailed description
- `serial_number`: Serial number
- `manufacturer`: Manufacturer name
- `model`: Model number/name
- `purchase_date`: Date of purchase
- `purchase_price`: Purchase price
- `status`: Current status (available, assigned, maintenance, retired)
- `created_at`, `updated_at`: Timestamps

### Asset Assignments Table
- `id`: Primary key
- `asset_id`: Foreign key to assets
- `user_id`: Foreign key to users
- `assigned_date`: Date when asset was assigned
- `return_date`: Date when asset was returned (nullable)
- `notes`: Assignment notes
- `status`: Assignment status (active, returned)
- `created_at`, `updated_at`: Timestamps

## Usage Guide

### For Administrators

1. **Adding a New Asset**
   - Navigate to Assets → Add New Asset
   - Fill in asset details
   - Click "Create Asset"

2. **Assigning an Asset**
   - Go to Assets → View (for specific asset)
   - Select user from dropdown
   - Set assignment date
   - Add optional notes
   - Click "Assign Asset"

3. **Returning an Asset**
   - View the asset details or assignments page
   - Click "Return Asset" next to the active assignment
   - Asset status will update to "Available"

### For Users

1. **Viewing Assigned Assets**
   - Click "My Assets" in the navigation
   - See currently assigned assets in card format
   - View complete assignment history below

## Project Structure

```
itamsicts.github.io/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AssetController.php
│   │   │   └── UserAssetController.php
│   │   └── Middleware/
│   │       └── IsAdmin.php
│   └── Models/
│       ├── Asset.php
│       ├── AssetAssignment.php
│       └── User.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── assets/
│       │   ├── dashboard.blade.php
│       │   ├── users.blade.php
│       │   └── assignments.blade.php
│       ├── user/
│       │   └── assets.blade.php
│       └── auth/
└── routes/
    └── web.php
```

## Screenshots

### Login Page
![Login Page](https://github.com/user-attachments/assets/5f564e1b-4b6b-4590-a8c4-e7bff2d11b2c)

### Admin Dashboard
![Admin Dashboard](https://github.com/user-attachments/assets/bf7f091c-dc70-4fcf-bfbf-5f0bb0de7e3d)

### Asset Management
![Asset List](https://github.com/user-attachments/assets/6e1ce5f1-9bec-4de8-8a4b-ee1a1a11ab3d)

### Asset Details & Assignment
![Asset Details](https://github.com/user-attachments/assets/31934015-4fb7-419b-b2cd-659e8a7e71f9)

### User Asset View
![User Assets](https://github.com/user-attachments/assets/965d2c63-a21c-4654-9362-c81dd04e07d0)

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open-source and available under the MIT License.

## Support

For issues, questions, or contributions, please open an issue on the GitHub repository.

## Acknowledgments

- Built with [Laravel](https://laravel.com)
- UI styling with [Tailwind CSS](https://tailwindcss.com)
- Authentication via [Laravel Breeze](https://laravel.com/docs/starter-kits)
