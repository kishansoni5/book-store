
# Book Bank - E-commerce Bookstore Website

A responsive e-commerce platform designed for buying and selling books online. Users can register, log in, browse books, manage their cart, view feedback, and securely make payments.

## Table of Contents
1. [Installation](#installation)
2. [Usage](#usage)
3. [Features](#features)
4. [Technologies Used](#technologies-used)
5. [API Endpoints](#api-endpoints)
6. [Contributing](#contributing)
7. [License](#license)

## Installation

To get your project up and running locally, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/book-bank.git
   ```

2. Navigate to the project directory:
   ```bash
   cd book-bank
   ```

3. Install the dependencies (if you are using any specific package manager):
   ```bash
   npm install
   ```

4. Set up your environment variables (if any):
   ```bash
   cp .env.example .env
   ```

5. Run the development server:
   ```bash
   php -S localhost:8000
   ```

6. The project should now be running on `http://localhost:8000` or whichever port is specified.

## Usage

Once the project is running, you can access the following features:

1. **User Registration**: Create an account by providing basic details.
2. **User Login**: Secure login functionality for users to access their profile and shopping cart.
3. **Book Browsing**: Browse available books by category, author, or title.
4. **Add to Cart**: Add books to the shopping cart and proceed to checkout.
5. **Payment Integration**: Make secure payments using Razorpay.
6. **Feedback System**: Leave feedback for books you’ve purchased.

## Features

- **User Authentication**: Secure login and registration system using PHP and MySQL.
- **Admin Panel**: Admin can manage book listings, view feedback, and process orders.
- **Responsive Design**: Built with Bootstrap to ensure the site is fully responsive on all devices.
- **Payment Integration**: Razorpay is integrated for secure online payments.
- **Search Functionality**: Users can search for books based on title, author, or category.
- **Feedback System**: Users can leave reviews and feedback on purchased books.

## Technologies Used

- **Frontend**:
  - HTML5, CSS3, Bootstrap
  - JavaScript
- **Backend**:
  - PHP, MySQL
- **Payment Integration**:
  - Razorpay
- **Database**:
  - MySQL (for storing user and book data)

## API Endpoints

### **GET /api/books**
Fetch all available books in the store.

#### Response:
```json
[
  {
    "id": 1,
    "title": "The Great Gatsby",
    "author": "F. Scott Fitzgerald",
    "price": 10.99
  },
  ...
]
```

### **POST /api/checkout**
Checkout the books in the user's cart and process payment through Razorpay.

#### Body:
```json
{
  "cart": [
    {
      "book_id": 1,
      "quantity": 2
    },
    ...
  ],
  "user_id": 12345
}
```

#### Response:
```json
{
  "status": "success",
  "payment_url": "https://razorpay.com/checkout?order_id=xyz"
}
```

### **GET /api/orders**
Fetch order history for the logged-in user.

#### Response:
```json
[
  {
    "order_id": 1,
    "book_title": "The Great Gatsby",
    "status": "Delivered",
    "date": "2025-04-20"
  },
  ...
]
```

## Contributing

We welcome contributions! Here's how you can get involved:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-branch`).
3. Make your changes and commit them (`git commit -am 'Add feature'`).
4. Push to your branch (`git push origin feature-branch`).
5. Open a pull request for review.

Make sure to write tests for any new functionality you add, and follow existing code formatting.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
