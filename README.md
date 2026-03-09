# 🍎 SmartPantry

SmartPantry is a modern, minimal, and user-friendly SaaS application designed to help you manage your kitchen inventory and recipes with ease. Built with a focus on clean aesthetics and intuitive user experience, it allows you to track ingredients, monitor nutritional balance, and discover new culinary possibilities.

## 🚀 Features

- **Inventory Management**: Keep track of what's in your pantry with status indicators for freshness.
- **Recipe Creation**: Easily add and organize your favorite meals with detailed nutrition and preparation steps.
- **Wellness Insights**: Monitor your nutritional balance through dedicated wellness scores.
- **SaaS Aesthetic**: A premium, minimal design system used consistently across all pages.
- **Responsive Design**: Fully optimized for various screen sizes, from desktop to mobile.

## 🛠️ Technologies Used

- **Framework**: [Laravel 12](https://laravel.com)
- **Frontend**: [Blade Templates](https://laravel.com/docs/blade) & [Vite](https://vitejs.dev/)
- **Styling**: [Tailwind CSS 4](https://tailwindcss.com/)
- **Icons**: [Font Awesome](https://fontawesome.com/)
- **Database**: SQLite (default)

## 📦 Installation

To get a local copy up and running, follow these simple steps:

1. **Clone the repository**
   ```bash
   git clone https://github.com/samyaFZ/SmartPantry-.git
   cd SmartPantry-
   ```

2. **Install Composer dependencies**
   ```bash
   composer install
   ```

3. **Set up the environment file**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Prepare the database**
   ```bash
   # Run migrations
   php artisan migrate
   ```

5. **Install and build frontend assets**
   ```bash
   npm install
   npm run build
   ```

## ⚙️ Usage

After installation, you can start the development server:

1. **Start the Laravel server**
   ```bash
   php artisan serve
   ```

2. **Start the Vite dev server** (optional for development)
   ```bash
   npm run dev
   ```

3. **Access the application**
   Open your browser and navigate to `http://localhost:8000`.

## 🖼️ Pages Overview

- **Welcome**: A high-quality SaaS landing page introducing SmartPantry's value.
- **Dashboard**: Your nerve center for quick insights into your pantry and favorites.
- **Pantry**: A detailed view of your inventory with "Fresh" and "Expiring Soon" status badges.
- **Add Meal**: A guided, icon-driven form to create professional-quality recipes.
- **Profile**: A personalized space for wellness metrics and account preferences.

## 🤝 Contributing

Contributions make the open-source community an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

Distributed under the MIT License. See `LICENSE` for more information.
