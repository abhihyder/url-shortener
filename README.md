# URL Shorten Application

## Overview

The URL Shorten Application is a Laravel 9-based web application that allows users to generate shortened URLs and share them with others. The application supports three types of users: Super Admin, Moderator, and General User. Any individual can register as a General User and start using the application's features.

## Features

#### User Registration and Authentication

-   Users can register for an account and provide their necessary details.
-   After registration, users can log in to the system using their credentials.

### URL Shortening

#### URL Creation

-   Users can create shortened URLs by providing two mandatory inputs: name and URL.
-   The "name" field is a user-defined identifier for the shortened URL.
-   The "URL" field requires a valid web address that the shortened URL will redirect to.

#### Optional Inputs

Users can also provide the following optional inputs when creating or editing a shortened URL:

1. Access Key:

    - Users can set an access key, which acts as an additional security measure.
    - The access key must be provided when someone tries to access the shortened URL.
    - This feature allows users to restrict access to the URL only to those who know the access key.

2. Expiration Date:

    - Users can set an expiration date for the shortened URL.
    - After the specified date, the shortened URL will no longer be accessible.
    - This feature is useful for time-sensitive URLs or when users want to limit the lifespan of a URL.

3. Status:

    - Users can set the status of the shortened URL as active or inactive.
    - An active URL will redirect users to the original web page, while an inactive URL will not.
    - This feature allows users to control the visibility and functionality of their shortened URLs.

#### QR Code Generation

-   After a user creates a shortened URL, the application generates a QR code representing that URL.
-   The QR code contains the shortened URL, allowing users to access the original web page by scanning the QR code.

#### Sharing QR Codes

-   Users can share the QR code with others through various mediums such as email, messaging apps, or printing it on physical materials.
-   Recipients can scan the QR code using a QR code scanner app on their smartphones or other devices to access the original web page associated with the shortened URL.

#### Editing Shortened URLs

-   Users can edit the details of their existing shortened URLs.
-   This includes modifying the name, URL, access key, expiration date, and status of the shortened URL.

### Visitor Log History and Payment System

The URL Shorten Application includes a visitor log history feature that tracks and records information about visitors who access the shortened URLs. Additionally, the application implements a payment system where the creator of the shortened URL receives a certain amount of payment for each unique visitor within a specified time period.

#### Visitor Log History

-   When someone visits a shortened URL, the application captures and records the following information:
    -   Visitor IP address: The IP address of the visitor who accessed the shortened URL.
    -   Operating System: The operating system used by the visitor's device.
    -   Browser: The web browser used by the visitor to access the URL.

#### Payment System

-   The creator of a shortened URL is eligible to receive payments for unique visitors within a certain time period.
-   The application tracks the number of unique visitors for each shortened URL and calculates the payment amount based on the defined payment rate.
-   The payment rate can be customized and set by the application administrators.

### Referral System and Earnings from Referred Users

The URL Shorten Application now includes a referral system that allows users to earn payments when someone registers using their referral code. Additionally, users will receive payments when visitors access shortened URLs created by the referred users.

#### Referral System

-   Each user is provided with a unique referral code.
-   Users can share their referral code with others to encourage them to register for the application.
-   When a new user registers using a referral code, the referrer (user who shared the code) is credited as the referrer of the new user.

#### Earnings from Referred Users

-   When unique visitors access shortened URLs created by referred users, the original referrer will receive payments based on a predefined payment rate.
-   The payment rate for referred users' URL visits can be customized and set by the application administrators.

### Withdrawal System and Payment Disbursement

The URL Shorten Application includes a withdrawal system that allows users to request payments, and administrators can review and disburse the requested payments via listed payment methods.

#### Withdrawal System

-   Users can request payments by initiating withdrawal requests.
-   Users need to provide the necessary details for payment disbursement, such as preferred payment method and account information.
-   The withdrawal request will include the amount the user wishes to withdraw from their earnings.

#### Payment Disbursement by Administrators

-   Administrators have access to review and process withdrawal requests.
-   Administrators can verify the withdrawal requests and ensure they meet the specified criteria before approving them.
-   Once approved, administrators will disburse the requested payments to the users via their chosen payment methods.

## Server Requirements

To run the URL Shorten Application, your server must meet the following requirements:

-   PHP version `8.0.2` or later
-   `gd` extension enabled
-   `imagick` extension enabled (for generating QR codes in PNG format)

## Installation

To set up the URL Shorten Application on your local environment, follow these steps:

1.  Clone the repository to your local machine and Navigate to the project directory.
2.  Install the required dependencies using Composer:

```shell
composer install
```

3.  Create a new .env file:

```shell
cp .env.example .env
```

4.  Generate an application key:

```shell
php artisan key:generate
```

5.  Configure your database connection in the .env file:

```shell
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6.  Migrate the database:

```shell
php artisan migrate
```

7.  Seed the database with sample data:

```shell
php artisan db:seed
```

8.  Start the local development server:

```shell
php artisan serve
```

9.  Access the application in your web browser using the provided URL.

## Demo User and Data

After running the database seeding process, the URL Shorten Application will be ready to use with a demo user account and pre-populated data. This allows you to explore the application's features and functionalities without the need to create new users or URLs.

The following information is relevant to the demo user and data:

#### Users:

1.  -   Email: superadmin@url-shortener.com
    -   Password: secret
2.  -   Email: moderator@url-shortener.com
    -   Password: secret
3.  -   Email: johndoe@url-shortener.com
    -   Password: secret

#### Pre-populated Data:

-   The application will include a set of pre-generated shortened URLs with associated statistics.
-   These URLs can be used to explore the statistical dashboard and see sample data on URL usage and visitor information.
-   You can also interact with the existing URLs, customize them, or generate new ones.   

Feel free to log in with the provided demo user account and explore the application using the pre-populated data. Remember to change the credentials and add new data as needed when deploying the application for production or real-world use.

## User Roles and Permissions

The URL Shorten Application provides different user roles with varying levels of access:

-   Super Admin: Has access to all application features and can manage user accounts.
-   Moderator: Has limited access and can assist in managing withdrwal requests.
-   General User: Can generate shortened URLs and access their statistical dashboard.
