# Job Portal Website

## Overview
This is a job portal website where users can post jobs, apply for jobs, search for jobs, and filter them based on location and job type. Both employers and job seekers can register on the platform.

## Features
- User Registration (Employer & Job Seeker)
- Job Posting by Employers
- Job Searching with Filters (Location, Job Type, etc.)
- Job Application by Job Seekers
- Email Notifications (Using PHPMailer)

## Technology Stack
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- Email: PHPMailer

## Database Schema
A reference database schema file (`jboard_database_schema.sql`) is provided for database setup.

## PHPMailer Configuration
PHPMailer is used for sending emails in the following files:
- `employer_registration.php`
- `jobseeker_registration.php`
- `schedule_interview.php`

### Configuration Steps:
1. Open the above-mentioned files.
2. Locate the PHPMailer section (comments are provided to guide you).
3. Replace placeholders with your email and app password.

## Setup Instructions
1. Clone or download the repository.
2. Import the provided `jboard_database_schema.sql` into MySQL.
3. Configure database connection in `config.php`.
4. Configure PHPMailer as per the instructions above.
5. Deploy the application on a PHP-supported server.

