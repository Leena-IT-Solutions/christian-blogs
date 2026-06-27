# 🌿 Be Rooted in Christ

> *"Abide in me, and I in you. As the branch cannot bear fruit of itself, except it abide in the vine; no more can ye, except ye abide in me."* — **John 15:4**

**Be Rooted in Christ** is a premium, highly interactive Christian devotional blog and administration panel. Built with **Laravel 11.x**, **Livewire 3**, and a **MySQL** database, it features a custom **Vanilla CSS** design system crafted to match the warm, elegant, and literary aesthetic of [A Kernel for Christ](https://akernelforchrist.com).

---

## ✨ Features

### 📖 Public Devotional Blog
* **Elegant Aesthetic:** Clean layout with centered branding, a navigation bar, and a theme selector (default dark mode / glassmorphism card styling).
* **Interactive Post Reading:** View posts directly within a rich, fast, overlay/modal window (no page reloads) or navigate to dedicated post detail pages.
* **Filter & Search:** Live, instant query search and sidebar filters for categories and tags.
* **Modern Comment Section:** Interactive comment forms featuring native validation and direct integration with admin approval workflows.
* **Accessible Contact Page:** Fully accessible contact forms supporting autofill attributes, ARIA accessibility markup, and custom validation.
* **SEO Optimized:** Dynamic meta headers (title, description, keywords), canonical links, automated JSON-LD Schema.org graphs (Blog and Article), and an auto-generated `/sitemap.xml`.

### 🛡️ Admin Management Panel
* **Lightweight Authentication:** Custom, lightweight Livewire-driven admin authentication system.
* **Dashboard Analytics:** High-level summary showing the total count of posts, categories, tags, pending comments, and unread contact messages.
* **Markdown Post Editor:** Elegant post creation/modification workspace with an interactive side-by-side live markdown preview, featured image uploads, and real-time slug auto-generation.
* **Taxonomy Management:** Live edit-in-place Category and Tag managers.
* **Comment Moderation:** Queue-based moderation system to approve, reject, or delete visitor comments.
* **Message Center:** View, read, and delete contact inquiries submitted from the frontend.
* **Dynamic Content Manager:** Custom Settings panel to control site subtitles, social links, and about page text/images.

---

## 🎨 Visual Design System

The application utilizes a completely custom CSS layout instead of Tailwind CSS utility classes to achieve a premium, custom-crafted feel.

* **Color Palette:** Deep black backgrounds (`#000000`) and charcoal borders for a high-contrast dark theme, accented with a warm gold/mustard highlight (`#bf9f5a`).
* **Typography:** Elegant `'Lora', serif` headings for a literary feel combined with highly readable `'Open Sans', sans-serif` for body copy.
* **Micro-interactions:** Smooth CSS transitions for button states, image scales, hover animations, and scale-in modals.

---

## 🛠️ Technology Stack

* **Backend:** Laravel 11.x (PHP 8.3+)
* **Frontend:** Livewire 3 (Reactive components) & Custom Vanilla CSS
* **Database:** MySQL
* **Assets:** Vite (with CSS compilation)

---

## 🚀 Getting Started

Follow these steps to set up the project locally.

### Prerequisites

Ensure you have the following installed:
* PHP 8.3 or higher
* Composer
* Node.js (v18+) & NPM
* MySQL Database

### ⚡ One-Step Initialization

For convenience, a custom setup script is configured in `composer.json`. Simply run the following command in the project root:

```bash
composer run setup
```

This script will automatically:
1. Install PHP dependencies (`composer install`)
2. Create your `.env` file from the example if it doesn't exist
3. Generate the application encryption key
4. Run migrations and database seeding
5. Install Node packages and compile production assets

> [!NOTE]
> Ensure you have configured your database credentials in your `.env` file before running migrations. Read below for manual configuration steps.

---

### 🔧 Manual Setup

If you prefer to set up the project step-by-step:

#### 1. Clone & Install Dependencies

```bash
# Clone the repository
git clone https://github.com/Leena-IT-Solutions/christian-blogs.git
cd christian-blogs

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

#### 2. Configure Environment

Copy the `.env.example` file and configure your database settings:

```bash
cp .env.example .env
```

Open `.env` and set your MySQL connection details:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=berootedinchrist.com
DB_USERNAME=root
DB_PASSWORD=YourPassword Here
```

Generate the app key:

```bash
php artisan key:generate
```

#### 3. Database Migration & Seeding

Run the migrations and seed the database to populate tags, categories, sample settings, a default blog post, and the admin user:

```bash
php artisan migrate:fresh --seed
```

#### 4. Compile Assets

```bash
# Run dev server
npm run dev

# Or build for production
npm run build
```

---

## 🏃 Running the Application

To run the entire development environment concurrently (Laravel Server, Vite asset compilation, Queue listener, and Pail logs):

```bash
composer run dev
```

Alternatively, you can run the individual servers manually:

```bash
# Start Laravel development server
php artisan serve

# Start Vite asset compilation
npm run dev
```

Open `http://localhost:8000` in your browser.

---

## 🔑 Seeding & Admin Credentials

The default database seeder populates the initial administrator credentials:

* **Login URL:** `/login`
* **Email:** `admin@berootedinchrist.com`
* **Password:** `password`

*You should update these credentials in the Settings panel immediately after your first login.*

---

## 📂 Project Structure

Key paths of interest for development:

* **Livewire Components:**
  * Public Views: [app/Livewire](file:///Users/sandeep/Projects/sheeba/app/Livewire)
  * Admin Views: [app/Livewire/Admin](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin)
* **Custom Styling:**
  * Public Stylesheet: [public/css/app.css](file:///Users/sandeep/Projects/sheeba/public/css/app.css)
  * Admin Stylesheet: [public/css/admin.css](file:///Users/sandeep/Projects/sheeba/public/css/admin.css)
* **Database & Seeds:**
  * Migrations: [database/migrations](file:///Users/sandeep/Projects/sheeba/database/migrations)
  * Default Seed: [database/seeders/DatabaseSeeder.php](file:///Users/sandeep/Projects/sheeba/database/seeders/DatabaseSeeder.php)
* **Routes:**
  * Web Routes: [routes/web.php](file:///Users/sandeep/Projects/sheeba/routes/web.php)
