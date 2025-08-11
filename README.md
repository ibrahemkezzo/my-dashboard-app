# SalonBooking Platform

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![PHP Version](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net/)

SalonBooking is a comprehensive web platform designed for booking appointments at beauty salons. It provides a seamless experience for customers to discover, book, and rate salons, while empowering salon owners to manage their services and bookings efficiently. Administrators have full control over the platform's operations through a robust dashboard. Built with modern web development practices, the platform ensures security, scalability, and an intuitive user interface.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technologies Used](#technologies-used)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Contact](#contact)

## Overview

SalonBooking revolutionizes the beauty industry by connecting customers with salons through an easy-to-use online booking system. Key highlights include:

- **Admin Control Panel**: Full management of users, salons, bookings, and site content.
- **Customer Features**: Search, filter, book appointments, view maps, and rate salons.
- **Salon Owner Features**: Profile management, service listings, booking handling, and updates.
- **Responsive Design**: Optimized for desktops, tablets, and mobiles.
- **Email Notifications**: Automated alerts for booking statuses to customers and salon owners.

The platform adheres to SOLID principles, clean code standards, and input validation for enhanced security and maintainability.

## Features

### Admin Dashboard
- Comprehensive control over registered salons, users, bookings, available cities, and services.
- Management of site pages including support, terms of service, privacy policy, and site policies.
- Advanced reporting with filters:
  - User visits, devices, countries.
  - Salon and user activity.
  - Booking statistics and analytics.
- Built using Laravel Blade templates with modern development practices, SOLID principles, clean code, and input validation for security.

### Frontend Interfaces
- **Elegant and Responsive Design**: Intuitive UI/UX adaptable to all devices (mobile, tablet, laptop, and various screen sizes).
- **User Types**:
  - **Customers (Regular Users)**:
    - Browse and search for beauty salons.
    - Flexible filtering by location, price, services, and features.
    - Book appointments seamlessly.
    - Integrated Google Maps for easy salon navigation.
    - Rating system for salons to share experiences.
  - **Salon Owners**:
    - Create and manage salon accounts.
    - Customize salon profiles and list services.
    - Receive and manage bookings (accept, reject, cancel).
    - Add new services, update prices, and edit existing offerings.
    - User-friendly dashboards with attractive designs for smooth operations.

### Additional Capabilities
- **Email Notification System**: Sends updates on booking statuses to customers and new booking alerts to salon owners.
- **Security and Validation**: All inputs are validated to prevent vulnerabilities.

## Technologies Used

- **Backend**: Laravel (latest version), PHP 8.2+
- **Frontend**: Blade templating, HTML5, CSS3, JavaScript (with responsive frameworks like Bootstrap or Tailwind CSS)
- **Database**: MySQL/PostgreSQL (configurable via Laravel)
- **Integrations**:
  - Google Maps API for location services.
  - Email services (e.g., Mailgun, SMTP via Laravel Mail).
- **Development Practices**: SOLID principles, Clean Code, MVC architecture, Validation rules.
- **Tools**: Git for version control, Composer for dependency management.

## Installation

To set up the project locally, follow these steps:

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js and NPM (for frontend assets)
- MySQL or PostgreSQL database
- Git

### Steps
1. Clone the repository:
   ```
   git clone https://github.com/yourusername/salonbooking.git
   cd salonbooking
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install frontend dependencies (if applicable):
   ```
   npm install
   npm run dev  # or npm run build for production
   ```

4. Copy the environment file and configure:
   ```
   cp .env.example .env
   ```
   Edit `.env` with your database credentials, email settings, Google Maps API key, etc.

5. Generate application key:
   ```
   php artisan key:generate
   ```

6. Run migrations and seed the database:
   ```
   php artisan migrate --seed
   ```

7. Start the development server:
   ```
   php artisan serve
   ```
   Access the platform at `http://localhost:8000`.

For production deployment, refer to Laravel's [deployment guide](https://laravel.com/docs/deployment).

## Configuration

- **Database**: Configure in `.env` (e.g., `DB_CONNECTION=mysql`, `DB_HOST=127.0.0.1`).
- **Email**: Set up mail driver in `.env` (e.g., `MAIL_MAILER=smtp`, `MAIL_HOST=smtp.mailgun.org`).
- **Google Maps**: Add `GOOGLE_MAPS_API_KEY` in `.env`.
- **Queueing**: For email notifications, run `php artisan queue:work`.

## Usage

- **Admin Access**: Login at `/admin` with seeded credentials (e.g., admin@example.com).
- **Customer Registration**: Sign up as a regular user to browse and book.
- **Salon Owner Registration**: Sign up as a salon owner to manage your profile.
- **Testing Emails**: Use tools like Mailtrap for development.

For detailed API endpoints (if applicable), check the `routes/api.php` file.

## Contributing

We welcome contributions! Please follow these steps:
1. Fork the repository.
2. Create a feature branch: `git checkout -b feature/YourFeature`.
3. Commit your changes: `git commit -m 'Add YourFeature'`.
4. Push to the branch: `git push origin feature/YourFeature`.
5. Open a Pull Request.

Ensure code follows SOLID and clean code principles. Run tests with `php artisan test`.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

For questions or support, reach out to [your.email@example.com](mailto:your.email@example.com) or open an issue on GitHub.

Thank you for using SalonBooking! 🚀
