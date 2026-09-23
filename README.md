# Ecommerce App

A full-featured ecommerce application built with Laravel, Livewire, and Tailwind CSS with a customer storefront, online checkout, and a separate admin panel for catalogue, homepage content, and order management.

## Tech Stack

| Layer         | Technology                      |
| ------------- | ------------------------------- |
| Backend       | PHP 8.3+, Laravel 13            |
| Frontend      | Livewire 3, Blade, Tailwind CSS |
| Auth          | Jetstream / Fortify (2FA, Passkeys) |
| Cart          | LaraCart                        |
| Payments      | SSLCommerz                      |
| Notifications | PHP Flasher (Notyf)             |
| Database      | MySQL                           |
| Testing       | Pest                            |

## Features

### Storefront

- CMS-driven homepage with hero sliders, banners, featured categories/brands, and curated product sections
- Product catalogue with category filtering, sorting, and product details
- Session-based shopping cart
- Checkout with cash-on-delivery and SSLCommerz online payments
- Customer accounts with order history, order tracking, and profile management

### Admin Panel (`/admin`)

- Sales dashboard with revenue, orders, low-stock, and top-product insights
- Catalogue management: categories, sub-categories, brands, units, and products
- Homepage management: hero sliders, banners, and flash deals
- Order management with status updates

### Authentication

- Registration, login, password reset, and email verification
- Two-factor authentication and passkeys
- Separate admin guard with dedicated login

## Getting Started

### Prerequisites

- **PHP** ^8.3 (8.4 recommended)
- **Composer** ≥ 2
- **Node.js** ≥ 24 (see `.nvmrc`)
- **MySQL** (or any Laravel-supported database)
- **Laravel Herd** (recommended) or any local server (Valet, Sail, etc.)

### Installation

```bash
git clone https://github.com/Mehedi-Oz/ecommerce-app.git
cd ecommerce-app
composer setup
```

Then seed the database:

```bash
php artisan db:seed
```

Default credentials:

| Role  | Email             | Password   |
| ----- | ----------------- | ---------- |
| Admin | `admin@gmail.com` | `12345678` |
| User  | `user@gmail.com`  | `12345678` |

### Running Locally

With Herd, the app is available at `https://ecommerce-app.test`.

Without Herd:

```bash
composer run dev
```

## Payments

Add your SSLCommerz credentials to `.env`:

```env
SSLCOMMERZ_STORE_ID=your_store_id
SSLCOMMERZ_STORE_PASSWORD=your_store_password
SSLCOMMERZ_SANDBOX=true
SSLCOMMERZ_CURRENCY=BDT
```

Use live credentials and set `SSLCOMMERZ_SANDBOX=false` for production.

## Project Structure

```
app/
├── Actions/            # Fortify & Jetstream action classes
├── Http/
│   ├── Controllers/
│   │   ├── Admin/      # Admin panel controllers (incl. HeroSlider, Banner, FlashDeal)
│   │   └── Frontend/   # Storefront controllers (Ecommerce, Cart, Checkout, Dashboard)
│   ├── Middleware/
│   └── Requests/       # Form request validation (incl. Admin/*Store/Update requests)
├── Models/             # Eloquent models (Category, SubCategory, Brand, Unit,
│                       #   Product, ProductImage, Tag, HeroSlider, Banner,
│                       #   FlashDeal, Order, Admin, User)
├── Providers/          # Service providers (App, Fortify, Jetstream)
├── Services/           # Business logic (SSLCommerz, notifications)
├── Traits/
├── Rules/
└── View/

database/
├── factories/          # Factories for all catalogue + CMS models
├── migrations/         # Includes hero_sliders, banners, tags, flash_deals tables
└── seeders/            # Per-domain seeders + DatabaseSeeder orchestrator

resources/views/
├── admin/              # Admin Blade templates (dashboard, categories,
│                       #   subcategories, brands, units, products, orders,
│                       #   hero-sliders, banners, flash-deals, auth)
├── frontend/           # Storefront Blade templates (home, products, carts,
│                       #   checkout, dashboard)
├── layouts/            # Layout templates
└── auth/               # Authentication views

routes/
├── web.php             # Storefront routes
├── admin.php           # Admin panel routes
├── api.php             # API routes (default Sanctum stub)
└── console.php         # Console commands

tests/Feature/         # Pest tests incl. HomepageCms, HomePageContent,
                       #   ProductSorting, ProductFactory, CatalogSeeder,
                       #   AdminDashboard, AdminSidebar, PageTitles, UserSeeder
```

## Testing

```bash
php artisan test --compact
```

## Code Style

```bash
vendor/bin/pint --dirty
```

## License

This project is open-sourced software licensed under the [MIT license](./LICENSE.md).
