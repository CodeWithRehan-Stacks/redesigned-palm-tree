# 📚 ShareNote

![ShareNote Hero Banner](sharenote_hero_banner.png)

## 🌟 Overview

**ShareNote** is a premium, full-stack social learning platform designed for the modern academic ecosystem. It empowers students and educators to share knowledge, collaborate on notes, and build a vibrant learning community through a sleek, high-performance interface.

Built with a focus on **productivity and connectivity**, ShareNote combines the power of Laravel with a stunning glassmorphism design system to provide an unparalleled user experience.

---

## ✨ Key Features

### 🔍 Intelligent Discovery
- **Explore Page:** Discover trending notes based on a custom-weighted algorithm.
- **Subject Categorization:** Navigate through academic disciplines with ease.
- **Top Contributors:** Connect with the most influential note-sharers on the platform.

### 📝 Note Ecosystem
- **Rich Note Management:** Create and edit detailed academic notes with support for multiple file attachments.
- **Collaborative Raises:** Engage in "Note Raises"—a unique discussion and reposting system for deepening academic dialogue.
- **Smart Search:** Find exactly what you need with an optimized search engine for notes and users.

### 👥 Social & Community
- **Interactive Profiles:** Showcase your contributions and track your academic influence.
- **Engagement Tools:** Like, comment, and save notes for offline study.
- **Follow System:** Build your network by following fellow learners and educators.

### 🛠 Administrative Control (Laravel Nova)
- **Customized Dashboard:** Real-time platform analytics with value metrics for New Users and New Notes.
- **Resource Management:** Full CRUD capabilities for Users, Notes, Categories, and Raises with optimized search and filters.
- **Community Moderation:** Robust system for handling content reports and ensuring community safety.
- **Branded Interface:** Fully customized admin UI with ShareNote branding, custom sidebar, and optimized navigation.

---

## 🚀 Tech Stack

- **Backend:** [Laravel 13](https://laravel.com) (PHP 8.3+)
- **Admin Panel:** [Laravel Nova 5](https://nova.laravel.com)
- **Frontend:** Blade Templates, [Tailwind CSS 4.0](https://tailwindcss.com), Vite
- **Database:** MySQL / SQLite
- **Real-time:** Laravel Events & Notifications
- **Testing:** [Pest PHP](https://pestphp.com)

---

## 🛠 Installation & Setup

Follow these steps to get your local development environment running:

### 1. Clone the Repository
```bash
git clone https://github.com/CodeWithRehan-Stacks/redesigned-palm-tree.git
cd ShareNote-app
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
```bash
cp .env.example .env
```
*Update `.env` with your database and application credentials.*

### 4. Application Setup
```bash
php artisan key:generate
php artisan migrate --seed
php artisan nova:install
```
*Note: Laravel Nova requires a valid license key configured in your `auth.json` or environment.*

### 5. Start Development Server
```bash
npm run dev
```
*This will start both the Vite dev server and the Laravel application.*

---

## 🧪 Testing

Run the test suite using Pest:
```bash
php artisan test
```

---

## 📄 License

The ShareNote application is open-sourced software licensed under the [MIT license](LICENSE).

---

<p align="center">
  Built with ❤️ for the academic community.
</p>
