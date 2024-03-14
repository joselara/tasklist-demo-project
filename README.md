# Coalition Technologies Laravel Demo

**Overview**

This demo project showcases the creation of a basic CRUD (Create, Read, Update, Delete) application using the Laravel framework. I've leveraged Laravel Jetstream with Vue.js to streamline the development process and provide a solid foundation for authentication and UI components.

**Technologies**

-   **Backend:** Laravel (PHP Framework)
-   **Frontend:** Vue.js (JavaScript Framework)
-   **Authentication:** Laravel Jetstream
-   **Database:** MySQL (or your preferred database)

**Features**

-   User authentication
-   Task creation
-   Task listing
-   Task editing
-   Task deletion
-   Reorderable tasks using a custom table component

**Setup Instructions**

1. **Clone the Repository:**

    ```bash
    git clone https://github.com/joselara/tasklist-demo-project.git
    ```

2. **Install Dependencies:**

    ```bash
    composer install
    npm install
    ```

3. **Configure Environment:**

    - Create a database named `tasklist`.
    - Copy the `.env.example` file to `.env` and adjust the database credentials.

4. **Run Migrations and Seeders:**

    ```bash
    php artisan migrate --seed
    ```

5. **Start the Development Servers:**

    - In one terminal: `php artisan serve`
    - In a separate terminal: `npm run dev`

6. **Access the Application:**
   Open http://localhost:8000 in your web browser.

7. **Login Credentials:**
    - Email: test@example.com
    - Password: password

**Exploring the Code**

-   **Routes:** `routes/web.php`
-   **Controllers:** `app/Http/Controllers`
-   **Models:** `app/Models`
-   **Vue Components:** `resources/js`

This demo serves as a starting point. Feel free to extend the functionality, integrate additional UI libraries, and tailor it to Coalition Technologies' specific requirements.
