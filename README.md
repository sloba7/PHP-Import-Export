# PHP-Import-Export

This is a PHP-based web application that allows you to import and export product data in JSON, Excel, and CSV. It provides managing product data, importing data from external sources, exporting data for backup or analysis purposes, as well as adding products through a form.

# Features

- Import product data from JSON, Excel, or CSV files.
- Export product data to JSON, Excel, or CSV files.
- Add products manually through a form.
- Supports basic product information such as name, description, price, and image.
- Prevents duplication of products based on a unique identifier (ID).

# Requirements

- PHP 5.6 or higher.
- MySQL database.
- Web server (e.g., Apache, Nginx).
- Composer (for installing dependencies).

# Installation

1. Clone the repository or download the source code.
2. Install dependencies by running composer install.
3. Create a MySQL database for storing the product data. Use the following script to create the products table:

   ```php

   CREATE TABLE products (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    PRIMARY KEY (id));

 
4. Update the database credentials in the import_products.php, export_products.php, and add_product.php files.
5. Configure your web server to serve the project directory.



# Usage

- Access the application through your web browser.
- Use the provided interface to import or export product data.
- Select the desired format (JSON, Excel, or CSV) for import/export.
- Follow the on-screen instructions to select the file and initiate the import/export process.
- To add a product manually, fill in the required fields in the form.
- Submit the form to add the product to the database.
- Upon successful completion, the imported data will be added to the database or the exported file will be downloaded.


