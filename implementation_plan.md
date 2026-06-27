# Laravel Livewire Blogging Website & Admin Panel Implementation Plan

This plan details the steps to build a premium, highly interactive blogging website and its admin panel using **Laravel 11.x**, **Livewire 3**, and a **MySQL** database. The styling will be entirely custom **Vanilla CSS** designed to replicate the elegant, warm aesthetic of **[A Kernel for Christ](https://akernelforchrist.com)**.

---

## Visual & Aesthetic Design System

We will match the reference website's elegant styling in our custom CSS system:
*   **Typography**:
    *   Headings & Titles: `'Lora', serif` (or PT Serif/Playfair Display) for an elegant, literary feel.
    *   Body Content: `'Open Sans', sans-serif` for clean readability.
    *   Line Height: `1.8` for body text to allow comfortable reading.
*   **Color Palette**:
    *   Primary Accent: Warm gold/mustard yellow (`#bf9f5a` or `#caa316`) for links, buttons, borders, highlights, and focus indicators.
    *   Light Mode: White background (`#ffffff`), charcoal text (`#313131`), and light grey borders (`#dedede`).
    *   Dark Mode: Black background (`#000000`), near-white text (`#ffffff`), dark charcoal borders (`#313131`), and gold highlights.
*   **Layout**:
    *   Header: Elegant centered branding ("A Kernel for Christ" / "Planted to Prevail & Produce") and a clean navigation menu bar.
    *   Layout structure: A main content area with a 2-column layout (main posts feed + sidebar) on the Home page, and clean, focused 1-column layouts for the About and Contact pages.

---

## User Review Required

> [!IMPORTANT]
> **Environment Setup Requirements:**
> 1. **MySQL Installation:** We will install MySQL via Homebrew (`brew install mysql`) and start the service (`brew services start mysql`).
> 2. **Database Credentials:** The default Laravel `.env` will be configured for local development. Please review the MySQL configuration below.
> 3. **Vanilla CSS Styling:** We will build a custom responsive CSS design system matching `akernelforchrist.com` rather than using Tailwind CSS. 

---

## Open Questions

> [!IMPORTANT]
> **Please clarify the following design and technical preferences:**
> 1. **MySQL Database Details:** Should we create a database named `sheeba_blog` with user `root` and no password (standard for local macOS brew installs)?
> 2. **Authentication Flow:** Should we implement a lightweight custom Livewire authentication system (cleaner for Vanilla CSS integration) or install Laravel Breeze (which brings Tailwind CSS dependencies by default)? *We recommend a custom Livewire auth system to keep the CSS pure and premium.*
> 3. **Blog Post Content Editor:** Do you prefer a simple textarea, a markdown editor (with preview), or a rich-text editor (e.g., Quill or Trix) for creating blog posts? *We recommend a custom Markdown editor with a side-by-side live preview.*
> 4. **Aesthetic Preferences:** Do you want a default dark mode theme, light mode theme, or a dynamic theme toggle? *We recommend a modern dark-mode-first aesthetic with a glassmorphism card layout.*

---

## Proposed Changes

Since the workspace is currently empty (except for `plan.txt` and `notes.txt`), we will first initialize a clean Laravel project by temporarily moving the notes files, running the composer installation, and then restoring them.

### 1. Database & Models Layer

We will define the database schema and Laravel Eloquent models:

*   **`User` Model (Laravel default)**: For admin authentication.
*   **`Category` Model**: Columns: `id`, `name`, `slug`, `description`.
*   **`Post` Model**: Columns: `id`, `user_id` (foreign key), `category_id` (foreign key), `title`, `slug`, `excerpt`, `body`, `featured_image` (string/null), `status` (enum: draft/published), `published_at` (timestamp/null).
*   **`Tag` Model**: Columns: `id`, `name`, `slug`.
*   **`PostTag` Pivot Table**: Columns: `post_id`, `tag_id`.
*   **`Comment` Model**: Columns: `id`, `post_id` (foreign key), `name`, `email`, `body`, `is_approved` (boolean), timestamps.
*   **`Message` Model**: Columns: `id`, `name`, `email`, `subject`, `message`, timestamps. (To store contact form submissions).
*   **`Setting` Model**: Columns: `id`, `key` (string), `value` (text). (To store site configurations and About page content dynamically).

#### [NEW] [create_categories_table.php](file:///Users/sandeep/Projects/sheeba/database/migrations/create_categories_table.php)
#### [NEW] [create_posts_table.php](file:///Users/sandeep/Projects/sheeba/database/migrations/create_posts_table.php)
#### [NEW] [create_tags_table.php](file:///Users/sandeep/Projects/sheeba/database/migrations/create_tags_table.php)
#### [NEW] [create_post_tag_table.php](file:///Users/sandeep/Projects/sheeba/database/migrations/create_post_tag_table.php)
#### [NEW] [create_comments_table.php](file:///Users/sandeep/Projects/sheeba/database/migrations/create_comments_table.php)
#### [NEW] [create_messages_table.php](file:///Users/sandeep/Projects/sheeba/database/migrations/create_messages_table.php)
#### [NEW] [create_settings_table.php](file:///Users/sandeep/Projects/sheeba/database/migrations/create_settings_table.php)

---

### 2. Frontend Layout & CSS (Vanilla CSS)

We will construct a custom modern design system matching `akernelforchrist.com` using native form elements, CSS Grid layouts, and custom fonts.

#### [NEW] [app.css](file:///Users/sandeep/Projects/sheeba/public/css/app.css)
Custom CSS for the public blog: Centered header, elegant gold (`#bf9f5a`) links and button highlights, card layouts with Lora headings and Open Sans paragraphs, and responsive layout grids.
#### [NEW] [admin.css](file:///Users/sandeep/Projects/sheeba/public/css/admin.css)
Custom CSS for the admin dashboard: Sidebar navigation layout, flex actions, scrollable lists with `scrollbar-gutter: stable`, and form field invalidation styling using `:invalid:user-invalid`.
#### [NEW] [app.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/components/layouts/app.blade.php)
Main layout container for public visitors. Includes Google Fonts imports (Lora and Open Sans).
#### [NEW] [admin.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/components/layouts/admin.blade.php)
Layout container for the admin panel.

---

### 3. Public Pages (Livewire Components)

We will implement the three required public pages:
*   **`Home` Component**: A grid of published posts, live search filtering, pagination, and a category filter sidebar. Handles single post overlay details or details navigation.
*   **`About` Component**: A beautifully styled biographical page displaying content retrieved dynamically from the database (`settings` table), including editable profile images and text.
*   **`Contact` Component**: A contact form conforming to modern accessibility rules (autofill, ARIA descriptors, user input validation). On submit, stores the inquiry in the `messages` table and shows a success overlay.

#### [NEW] [Home.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Home.php) / [home.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/home.blade.php)
#### [NEW] [About.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/About.php) / [about.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/about.blade.php)
#### [NEW] [Contact.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Contact.php) / [contact.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/contact.blade.php)
#### [NEW] [PostShow.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/PostShow.php) / [post-show.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/post-show.blade.php) (Blog post detail page)

---

### 4. Admin Panel Features (Livewire Components)

*   **`Login` Component**: Custom admin credentials check, secure authentication session, and error handling.
*   **`Dashboard` Component**: Statistics counters for posts (drafts vs published), categories, tags, pending comments, and unread messages.
*   **`Categories` Component**: Responsive table with edit-in-place forms for category creation/updating/deletion.
*   **`Posts\Index` Component**: Searchable and paginated table listing posts with active filters, image previews, and edit/delete actions.
*   **`Posts\Create` / `Edit` Components**: Multi-control forms with title slug auto-generation, custom markdown content editor with live preview, featured image upload, and tag manager.
*   **`Comments` Component**: Moderation tool to approve, reject, or delete visitor comments.
*   **`Messages` Component**: View, read, and delete contact inquiries submitted from the Contact page.
*   **`Settings` Component**: Admin panel to edit site settings (site subtitle, social media links) and the About page biography/profile image.

#### [NEW] [Login.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Login.php) / [login.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/login.blade.php)
#### [NEW] [Dashboard.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Dashboard.php) / [dashboard.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/dashboard.blade.php)
#### [NEW] [Categories.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Categories.php) / [categories.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/categories.blade.php)
#### [NEW] [Index.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Posts/Index.php) / [index.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/posts/index.blade.php)
#### [NEW] [Create.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Posts/Create.php) / [create.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/posts/create.blade.php)
#### [NEW] [Edit.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Posts/Edit.php) / [edit.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/posts/edit.blade.php)
#### [NEW] [Comments.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Comments.php) / [comments.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/comments.blade.php)
#### [NEW] [Messages.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Messages.php) / [messages.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/messages.blade.php)
#### [NEW] [Settings.php](file:///Users/sandeep/Projects/sheeba/app/Livewire/Admin/Settings.php) / [settings.blade.php](file:///Users/sandeep/Projects/sheeba/resources/views/livewire/admin/settings.blade.php)

---

### 5. Routing Configuration

Modify the web routing file to register public pages and wrap admin components behind an authentication middleware.

#### [MODIFY] [web.php](file:///Users/sandeep/Projects/sheeba/routes/web.php)

---

## Verification Plan

### Automated Tests
- Run database migrations: `php artisan migrate:fresh --seed`
- Create a test post seeder to generate mock data.
- Run standard PHPUnit tests if applicable: `php artisan test`

### Manual Verification
- **Local Dev Server Execution**: Spin up the server using `php artisan serve`.
- **Aesthetic Match Verification**:
  - Verify centered header layout with the elegant title and navigation menu bar.
  - Verify Lora fonts on headings, Open Sans on paragraphs, and gold/mustard theme accents.
- **Three Public Pages Walkthrough**:
  - **Home**: Navigate posts grid, filter by search/category/tag, view details.
  - **About**: View static/dynamic biographical text and image.
  - **Contact**: Enter fields, verify autofocus/autofill attributes, validate native error states, and submit contact inquiry.
- **Admin Panel Walkthrough**:
  - Log in, check stats on Dashboard.
  - Edit About page settings, categories, and posts. Upload images.
  - Approve comments.
  - Read and manage contact inquiries from the Messages section.
