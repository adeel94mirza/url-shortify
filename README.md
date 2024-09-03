# URL Shortener Service

This is a web application built with Laravel 11 and Vue.js that allows users to shorten long URLs into more manageable links. The application offers a variety of features, including user authentication, URL statistics, custom short URLs, and more.

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [API](#api)
- [Security](#security)
- [Roadmap](#roadmap)
- [Contributing](#contributing)
- [License](#license)

## Features
- **URL Shortening**: Convert long URLs into short, easy-to-share links.
- **Redirection**: Redirect users to the original URL when they access the short URL.
- **User Authentication**: Optional user registration and login to manage URLs.
- **Dashboard**: Authenticated users can view and manage their shortened URLs with analytics.
- **URL Statistics**: Track how many times a URL has been accessed, along with additional analytics.
- **Custom Short URLs**: Users can create custom short URLs instead of using randomly generated ones.
- **Expiration Dates**: Set expiration dates for short URLs.
- **QR Code Generation**: Automatically generate a QR code for each shortened URL.
- **API Access**: Provide API endpoints for integrating URL shortening into other applications.
- **Admin Panel**: Manage users, URLs, and monitor for malicious activity.
- **Security Measures**: Implement checks to prevent malicious URLs and rate limiting.

## Requirements
- PHP 8.3 or higher
- Node.js 20.x or higher
- Composer
- MySQL or other supported database
- Redis (optional, for caching and queues)

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/yourusername/url-shortener-service.git
    cd url-shortener-service
    ```

2. **Install PHP dependencies:**
    ```bash
    composer install
    ```

3. **Install Node.js dependencies:**
    ```bash
    npm install
    ```

4. **Copy the example environment file and set the application key:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Configure the environment variables:**
    - Update your `.env` file with the necessary database and other configurations.

6. **Run database migrations and seeders:**
    ```bash
    php artisan migrate --seed
    ```

7. **Build the front-end assets:**
    ```bash
    npm run build
    ```

8. **Start the development server:**
    ```bash
    php artisan serve
    ```

## Configuration
- Ensure that the `.env` file is correctly configured for your environment, including database, mail, and other service configurations.
- Set up your database, and ensure it's running.

## Usage
- **Unauthenticated Users:**
  - Visit the homepage and input a long URL to generate a shortened URL.
  - Copy and share the shortened URL as needed.

- **Authenticated Users:**
  - Log in to access the dashboard.
  - Manage your shortened URLs, view statistics, and create custom short URLs.
  - Set expiration dates for URLs and download QR codes.

## API
- The application provides an API for developers to integrate URL shortening into their own apps.
- **Endpoints:**
  - `POST /api/shorten`: Shorten a URL.
  - `GET /api/stats/{short_url}`: Retrieve statistics for a shortened URL.
- Refer to the API documentation for full details.

## Security
- The application includes security measures to prevent abuse, such as rate limiting and malicious URL detection.
- Admins have the ability to manage users and URLs via the admin panel.

## Roadmap
- Implement additional analytics features (e.g., geographic locations, devices).
- Add more customizable options for the front-end UI.
- Improve scalability and performance for high-traffic scenarios.

## Contributing
Contributions are welcome! Please follow the standard GitHub fork and pull request workflow.

## License
This project is licensed under the MIT License. See the `LICENSE` file for more information.