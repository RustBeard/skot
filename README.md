# Personal Wallet Web App

A simple, self-hosted personal finance web application built with PHP and SQLite.

## Features

- Add and manage transactions with amount, description, category, and date
- View all transactions in a clean, responsive interface
- Delete unwanted transactions
- Mobile-friendly design using Tailwind CSS
- No authentication required (personal use)

## Requirements

- PHP 8.0 or higher
- SQLite3 PHP extension
- Write permissions for the database directory

## Installation

1. Upload all files to your web hosting directory
2. Make sure the `database` directory is writable by the web server
3. Visit `init_db.php` in your browser to initialize the database
4. Delete `init_db.php` after successful initialization
5. Access the application through your web browser

## Directory Structure

```
personal-wallet/
├── database/           # SQLite database storage
├── includes/           # PHP includes
│   └── Database.php   # Database connection class
├── add_transaction.php # Add new transactions
├── index.php          # Main application file
├── init_db.php        # Database initialization
└── README.md          # This file
```

## Security Notes

- This application is designed for personal use and does not include authentication
- Ensure your web server is properly configured to prevent direct access to the database file
- Consider adding basic authentication through your web server if needed

## License

MIT License
