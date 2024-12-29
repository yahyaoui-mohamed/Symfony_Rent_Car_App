# Symfony Car Rental Application

This project is a full-featured car rental application that includes a user-facing website for booking cars and an admin dashboard for managing bookings, cars, and users. Built with modern web technologies, the app provides a seamless experience for both customers and administrators.

---

## Features

- **User Features:**
  - Search for available cars
  - Book cars
  - View booking history

- **Admin Dashboard:**
  - Add, update, or delete car listings
  - Manage customer bookings
  - View system analytics and reports

---

## Screenshots

![Home Page](https://i.imgur.com/dhRrC4q.png)
![](https://i.imgur.com/jsIBE5O.png)


## Technologies Used

- **Frontend:**
  - HTML, CSS, Sass, JavaScript
  - Bootstrap for responsive design

- **Backend:**
  - PHP (Symfony Framework)

- **Database:**
  - MySQL

- **Payment Gateway:**
  - Stripe

---

## Requirements

To run this project, ensure you have the following installed:

- PHP >= 8.2
- Symfony >= 7
- Composer
- Node.js and npm/yarn
- MySQL Server
- A web server like Apache or Nginx

---

## Installation

Follow these steps to install and run the application:

1. **Clone the Repository**
   ```bash
   git clone https://github.com/yahyaoui-mohamed/Symfony_Rent_Car_App
   cd Symfony_Rent_Car_App
   ```

2. **Install Backend Dependencies**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

4. **Set Up the Database**
   - Configure the `.env` file in the project root with your database credentials:
     ```env
     DATABASE_URL="mysql://username:password@127.0.0.1:3306/car_rental"
     ```
    - Create a MySQL database:
     ```bash
     php bin/console doctrine:database:create
     ```
   - Run database migrations:
     ```bash
     php bin/console doctrine:migrations:migrate
     ```

5. **Build Frontend Assets**
   ```bash
   npm run build
   ```

6. **Run the Application**
   - Start the Symfony server:
     ```bash
     symfony server:start
     ```
   - Alternatively, use PHP's built-in server:
     ```bash
     php -S 127.0.0.1:8000 -t public
     ```

7. **Access the Application**
   - Open your browser and navigate to `http://127.0.0.1:8000` for the user interface.
   - To access the admin dashboard, navigate to `http://127.0.0.1:8000/admin`.

---

## Additional Notes

- **Environment Variables:**
  Ensure you have a valid `.env` file configured in the root directory. You can use `.env.example` as a template.

- **Development Mode:**
  For development, you can enable hot-reloading for the frontend:
  ```bash
  npm run watch
  ```

<!-- - **Admin Credentials:**
  After running migrations, you may need to seed the database with an admin user. Use the following command to create an admin:
  ```bash
  php bin/console app:create-admin
  ``` -->

- **Testing:**
  Run the test suite to ensure everything is functioning correctly:
  ```bash
  php bin/phpunit
  ```

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository.
2. Create a new branch for your feature or bug fix:
   ```bash
   git checkout -b feature-name
   ```
3. Commit your changes:
   ```bash
   git commit -m "Description of changes"
   ```
4. Push to your fork:
   ```bash
   git push origin feature-name
   ```
5. Open a pull request.

---

<!-- ## License

This project is licensed under the MIT License. See the `LICENSE` file for details. -->

---

## Contact

For inquiries or support, please contact [alayahyaoui1999@gmail.com].