# Brownclaw Asset Management

The marketing site, design references, and brand assets for **Brownclaw Asset Management** (brownclawam.ca) — an independent reliability and asset-management practice for mining and energy operators, led by Connor Schriver, P.Eng, CMRP.

## Repository layout

```
brand/                              Source brand assets (logo, claw, hero photo)
pitch.html                          Working design reference (single-file mockup)
pitch-v1-design-reference.html      Immutable archive of the approved design
site/                               Laravel 13 application — the live site
```

## Getting started

The Laravel app lives in `site/`. See [site/README.md](site/README.md) for full local-development and deployment instructions.

```bash
cd site
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev          # in one terminal
php artisan serve    # in another
```

Public site at `http://localhost:8000`. Admin at `http://localhost:8000/admin`.

## Design

The original design pitch lives at `pitch.html` at the root of this repository, and is preserved as `pitch-v1-design-reference.html` for posterity. The Laravel application in `site/` is the productionised version of that design.
