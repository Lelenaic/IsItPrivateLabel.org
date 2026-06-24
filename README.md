# IsItPrivateLabel.org

A consumer transparency platform that helps identify private-labeled products. We research and catalog products suspected of being manufactured by one company and sold under another's brand, assigning evidence-based suspicion scores to help consumers make informed purchasing decisions.

## Features

- **Product search** by company name, product name, or serial number (powered by Meilisearch)
- **Suspicion scoring** (1-10) based on publicly available evidence such as manufacturer listings, packaging similarities, and supply chain data
- **Evidence & proofs** — text, images, and links to source platforms (AliExpress, Alibaba, Made-in-China)
- **Pricing data** — resale vs source price comparisons in multiple currencies
- **Company profiles** with aggregated suspicion scores across their product catalog
- **Multi-language support** with a database-driven translation system
- **Public API** (v1) with auto-generated documentation via Scramble
- **Admin panel** (Filament) for managing companies, products, proofs, and translations
- **SSR** for improved performance and SEO

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 13, PHP 8.5 |
| Frontend | React 19, Inertia.js v3, HeroUI v3, TailwindCSS v4 |
| Admin | Filament 5 |
| Search | Laravel Scout + Meilisearch |
| Database | SQLite (dev) / MariaDB (prod) |
| Cache / Queue | Redis |
| SSR | Node.js |
| Icons | @tabler/icons-react |
| Build | Vite 8 |
| Deployment | Docker (multi-stage), GitHub Actions, GHCR |

## Requirements

- PHP 8.3+
- Node.js 22+
- Composer
- Docker (recommended for local dev via Sail)

## Getting Started

### Using Docker (recommended)

```bash
# Clone and install
git clone https://github.com/lelenaic/isitprivatelabel.org.git
cd isitprivatelabel.org
composer setup
cp .env.example .env
composer artisan key:generate

# Start the environment
vendor/bin/sail up -d

# Run migrations and seed
vendor/bin/sail artisan migrate --seed

# Import search index
vendor/bin/sail artisan scout:import "App\Models\Product"

# Build frontend
vendor/bin/sail npm run build
```

The app will be available at `http://localhost`.

### Local Setup

```bash
composer install
npm install
cp .env.example .env
composer artisan key:generate
composer artisan migrate --seed
composer artisan scout:import "App\Models\Product"
npm run build
composer artisan serve
```

Ensure MySQL/MariaDB, Meilisearch, and Redis are running and configured in your `.env`.

## Development

```bash
vendor/bin/sail npm run dev     # Vite dev server with HMR
vendor/bin/sail artisan serve   # Laravel dev server
vendor/bin/sail artisan pail    # Log viewer
vendor/bin/sail artisan queue:listen  # Queue worker
```

Or use the combined script:

```bash
vendor/bin/sail composer run dev
```

## Testing

```bash
vendor/bin/sail artisan test --compact
```

## API

The public API is available at `/api/v1` with endpoints for search and product details. API documentation is auto-generated via Scramble and accessible at `/api`.

## Project Structure

```
app/
├── Filament/              # Admin panel resources
├── Http/Controllers/      # Web + API controllers
├── Models/                # Eloquent models (Company, Product, Proof, etc.)
├── Providers/
database/
├── factories/             # Model factories
├── migrations/            # Database migrations
├── seeders/               # Database seeders (with sample data)
resources/
├── js/
│   └── Pages/             # Inertia.js React pages (Home, Product, Company, etc.)
├── css/
routes/
├── web.php                # Web routes
├── api.php                # API routes
```

## Key Concepts

- **Products** belong to a **Company** and have a numeric suspicion rating (1 = verified non-private-label, 10 = confirmed private label)
- **Proofs** are evidence items (text, link, or image) attached to products, with per-language translations
- **Product Links** connect products to source platforms (AliExpress, Alibaba, Made-in-China)
- **Pricings** compare resale and source prices in multiple currencies
- **Translations** are stored in the database, allowing multi-language content management via the admin panel

## License

MIT License. See [LICENSE](LICENSE) for details.
