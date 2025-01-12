# Stripe Web Portal

As this is my first time using Codeigniter, AJAX and Stripe payment system, I took some time to read the documentations to get a rough understanding of what is going on. However due to severe time constraints, there are some things that I have not read up to test, do and debug like the Stripe transactions and some bugs that I had no time to fix like CSS tailwind working for certain frontend web pages and none for some. I will explain what other improvements I would have done later but I would also have done some testing such as unit testing, integration testing and E2E testing through a CI/CD if I had more time. 

# Questions
## Instruction on installing and testing the web application.
Ans: If you are using a mac, you can import the necessary using brew and you can import the necessary php 7.3 by running

```
brew install php@7.3
brew install composer
brew install mysql
brew services start mysql

```

Run

```
composer install
```
or
```
composer update 
```

Setup your SQL database ideally with my sql and run this sql command to set up the database and please call your database shop and run this SQL command to create the database

```
CREATE DATABASE shop;

USE shop;

-- Users Table
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('user', 'admin') DEFAULT 'user',
    `name` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products Table
CREATE TABLE `products` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `price` DECIMAL(10, 2) NOT NULL,
    `stock_quantity` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Invoices Table
CREATE TABLE `invoices` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `total_amount` DECIMAL(10, 2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

-- Receipts Table
CREATE TABLE `receipts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `invoice_id` INT NOT NULL,
    `receipt_data` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`)
);

-- Transactions Table
CREATE TABLE `transactions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `invoice_id` INT NOT NULL,
    `transaction_id` VARCHAR(255) UNIQUE,
    `payment_status` ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    `payment_method` ENUM('stripe', 'paypal') DEFAULT 'stripe',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`invoice_id`) REFERENCES `invoices`(`id`)
);
```

Ensure nginx or apache is started and then run
```
php -S localhost:8000
```


## ER Diagram to illustrate the relationships between the designed tables.

Ans: Here below is the ER diagram for your reference. 

```
+----------------+        +------------------+        +-----------------+
|     Users     |        |     Invoices     |        |     Products    |
+----------------+        +------------------+        +-----------------+
| id (PK)       |<-------| id (PK)          |        | id (PK)         |
| email         |        | user_id (FK)     |        | name            |
| password      |        | total_amount     |        | description     |
| role          |        | created_at       |        | price           |
| name          |        +------------------+        | stock_quantity  |
| created_at    |              |                   | created_at      |
| updated_at    |              |                   | updated_at      |
+----------------+              |                   +-----------------+
        |                       |
        |                       |
        v                       v
 +------------------+       +-----------------+       +-----------------+
 |    Transactions |       |    Receipts     |       |   Purchase      |
 +------------------+       +-----------------+       |   History       |
 | id (PK)          |       | id (PK)         |       | user_id (FK)    |
 | invoice_id (FK)  |       | invoice_id (FK) |       | product_id (FK) |
 | transaction_id   |       | receipt_data    |       | quantity        |
 | payment_status   |       | created_at      |       | price_at_purchase|
 | payment_method   |       +-----------------+       +-----------------+
 | created_at       |
 +------------------+
```

## How will you further enhance this system to ensure system users can perform a certain task only within the web application?

Ans: Due to severe time constraints, I would have implemented
user authentication with Sessions or JWT for more security and also have protected routes for users and admins which only the appropriate roles can access those routes by having an authorization middleware. I would enforce checks on this on both the frontend and the backend to ensure that only specific users can perform certain actions in the system. 

## If we were to implement an API for mobile applications, what would be the things you'd take into consideration for this framework? Do address the limitations if there are any. 

I would consider network constraints as mobile devices often experience fluctuating connectivity and limited bandwidth and to address this issue, we can use more efficient and compact data formats such as JSON and to optimize API endpoints to send only necessary data with retry mechanisms. Furthermore, we can implement rate limiting and throttling to prevent abuse and manage resource usage.

## How would you deploy this project to a staging vs production site? You may provide network architectures, deployment strategies, est, and cost if you host this solution within the cloud.

Deploying a project requires a strategic approach to ensure scalability, security, and performance. This involves setting up separate environments for staging and production, choosing the right network architecture, implementing effective deployment strategies, and hosting the solution on the cloud while managing costs. 

The first step in deploying the app is designing the network architecture for staging and production environments.

The staging environment serves as a replica of the production setup, used for testing new features, updates, and bug fixes before releasing them to users. This environment should operate in a private network, accessible only to internal teams through secure access points like VPNs and SSH tunnels. To minimize costs, the infrastructure can be scaled down by using smaller instance types and a single application server. Staging data should be anonymized or synthetic to ensure security and avoid exposing sensitive user information.

The typical staging architecture includes a single application server, a smaller database instance, and optional load balancing. Monitoring tools should be integrated to track performance and identify potential issues early.

The production environment is designed to handle live traffic from the application and end users. Its architecture emphasizes scalability, high availability, and security. A load balancer distributes traffic across multiple servers to prevent overloading any single instance, while auto-scaling ensures the infrastructure adapts to traffic fluctuations. Managed database services are essential for reliability and automated backups. To further enhance performance, a caching layer like Redis or Memcached and a Content Delivery Network (CDN) for serving static assets should be incorporated.

A Virtual Private Cloud (VPC) is recommended for isolating resources. Public subnets host load balancers, while private subnets contain application servers and databases, enhancing security.

Deployment strategies play a critical role in maintaining the stability and reliability of the system. They differ slightly between staging and production environments.

In the staging environment, updates are pushed to a dedicated staging branch in version control, triggering automated CI/CD pipelines. Infrastructure as Code (IaC) tools like Terraform or AWS CloudFormation are used to deploy changes. Feature flags allow for toggling new features, ensuring they can be tested without affecting other functionality. Comprehensive testing, including functional, integration, and user acceptance tests, is performed before changes are approved for production.

In the production environment, changes are merged into the main branch, and CI/CD pipelines deploy updates using advanced strategies like blue-green or canary deployments. Blue-green deployment involves deploying to a new environment (blue) while keeping the old one (green) active, allowing for a seamless switch once the new version is stable. Canary deployment gradually routes traffic to new instances, monitoring for issues before fully transitioning. These approaches ensure zero downtime and allow for quick rollbacks in case of failures. Security checks, such as dependency scanning and vulnerability tests, are integrated into the CI/CD process to maintain a secure production environment.

Cloud hosting provides the flexibility and scalability required for applications. Providers like AWS, Google Cloud Platform (GCP), and Microsoft Azure offer managed services that simplify deployment and maintenance.

The cost of hosting varies between staging and production environments. A staging environment typically requires a smaller setup, costing approximately $30 per month. This includes a small application server, a managed database instance, and minimal storage. Production environments, designed to handle higher traffic, cost around $250–300 per month for a low-scale setup. This includes load balancers, auto-scaling servers, managed databases, caching services, CDNs, and monitoring tools.

To reduce costs without compromising performance, right-sizing resources and using reserved instances for predictable workloads can be effective. Additionally, serverless solutions like AWS Lambda can be explored for low-traffic scenarios, as they charge only for actual usage.

Security is paramount when deploying applications. HTTPS should be enforced across all endpoints, and sensitive environment variables should be managed using services like AWS Secrets Manager or GCP Secret Manager. Firewalls and Web Application Firewalls (WAFs) can help block malicious traffic.

Applications often experience fluctuating traffic. Auto-scaling mechanisms and optimized database queries ensure the API can handle these changes efficiently.

Automated database backups and multi-AZ deployments provide redundancy, ensuring business continuity during failures.

Staging and production environments must be isolated to prevent accidental data mixing. Separate API keys and configurations should be maintained for each environment.

Testing is critical for delivering a reliable API. Unit tests, integration tests, and end-to-end tests should be automated as part of the CI/CD pipeline. Tools like Postman or Swagger can be used for API testing.


## Feel free to describe any additional tools or libraries you have used or can be used during the development.

I used Postman to test the API endpoints including stripe integration to ensure that there proper payments as I was using the test environment on stripe which I managed to create successful transactions on it and CSS Tailwind for styling the frontend on some of the pages. However I would like to point out two things that I would have been able to do if I had no time constraints, which is to create the transactions page and to also fix the receipts and invoice page for users which is only returning the user's receipt and invoice data in a json format instead of a page. 