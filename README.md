# Version Project
"version": "2.0.0"

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
- [Changelog](#changelog)
- [License](#license)
- [Contact](#contact)

## Overview

SalonBooking revolutionizes the beauty industry by connecting customers with salons through an easy-to-use online booking system. Key highlights include:

- **Admin Control Panel**: Full management of users, salons, bookings, subscriptions, and site content.
- **Customer Features**: Search, filter, book appointments, view maps, and rate salons.
- **Salon Owner Features**: Profile management, service listings, booking handling, and subscription tracking.
- **Automated Billing**: Integrated subscription plans with automated trial periods for new partners.

## Features

### Admin Dashboard
- Comprehensive control over registered salons, users, bookings, available cities, and services.
- **Subscription Management**: Create plans, manage salon statuses, and adjust expiration dates manually.
- Advanced reporting with filters:
  - User visits, devices, countries.
  - Salon and user activity.
  - Revenue tracking and subscription analytics.

### Frontend Interfaces
- **User Types**:
  - **Customers**: Browse salons, filter by location/price, book appointments, and integrated Google Maps.
  - **Salon Owners**: Manage salon profiles, customize services, and handle bookings (Accept/Reject).
- **Subscription Dashboard**: Dedicated section for owners to track their plan, view remaining trial days, and upgrade via secure payment gateways.

### Additional Capabilities
- **Subscription & Billing System**: 
  - **Automated Free Trial**: New salons automatically receive a trial plan assigned instantly upon registration.
  - **Payment Gateway**: Secure online renewals via **Moyasar Integration**.
  - **Transparent History**: Owners view financial logs while internal admin adjustments remain hidden.
- **Email Notification System**: Automated updates for booking statuses and subscription reminders.
- **Security and Validation**: All inputs are validated to prevent vulnerabilities.

## Technologies Used

- **Backend**: Laravel 12.x, PHP 8.2+
- **Frontend**: Blade templating, Livewire (for real-time components), Tailwind CSS/Bootstrap.
- **Database**: MySQL/PostgreSQL (configurable via Laravel).
- **Integrations**:
  - **Moyasar API** for payment processing.
  - **Google Maps API** for location services.
  - Email services (e.g., Mailgun, SMTP via Laravel Mail).
- **Architecture**: SOLID Principles, Clean Code, MVC, Service-Repository Pattern.

## Installation




1. Install PHP dependencies:
```bash
composer install

```


2. Install frontend dependencies:
```bash
npm install && npm run dev

```


3. Configure Environment:
```bash
cp .env.example .env
# Update DB_*, MOYASAR_*, and GOOGLE_MAPS_API_KEY

```


4. Setup Database & Key:
```bash
php artisan key:generate
php artisan migrate --seed

```


5. Start Server:
```bash
php artisan serve

```



## Usage

* **Admin Access**: Login at `/admin` with seeded credentials.
* **Salon Registration**: New salons are automatically placed on a trial plan after Step 1 of registration.
* **Subscription Tracking**: Owners can monitor their status and history through the dedicated "Subscriptions" tab in their profile.

## Changelog

### v2.0.0 (February 2026) — Subscriptions & Automated Onboarding

* **feat**: Implemented automatic free trial assignment during the salon registration wizard (`storeStep1`).
* **feat**: Integrated **Moyasar Payment Gateway** for online plan renewals and automated callback handling.
* **refactor**: Centralized billing and history logic in `SubscriptionService` to decouple business logic from Controllers.
* **fix**: Enhanced subscription history visibility to filter out administrative manual date adjustments from user-facing views.
* **ux**: Added dynamic subscription widgets showing "Joining Gift" status and trial period countdowns.
* **perf**: Automated salon deactivation/activation based on real-time subscription expiry checks.

### v1.5.0 — Rewards, Points, and Notifications

* **Points System**: Earn points automatically on completed bookings.
* **Livewire Notifications**: Real-time dropdowns for booking updates and rewards in Dashboard & Frontend.
* **Booking Logic**: Enhanced `canBeCompleted()` validation based on appointment time.
* **UX**: Custom 419 error page and responsive Sidebar updates.

### v1.4.0 (October 2025)

* Multi-service booking support in a single appointment.
* Added price range filtering (min/max) for salon listings.
* Improved salon creation and service assignment workflow.

---


## Contact

For support or questions, reach out to [ibrahemkezzo.w@gmail.com](mailto:ibrahemkezzo.w@gmail.com).


