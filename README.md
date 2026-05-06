# Brownclaw Asset Management — site

Marketing site + content engine for **Brownclaw Asset Management** (brownclawam.ca). Laravel 13 application backed by Filament v5 admin and an SQLite (dev) / MySQL (prod) database.

The design pitch and brand source assets live in `_design/` (`pitch.html`, `pitch-v1-design-reference.html`, `brand/`) and are preserved as the design reference. This Laravel app is the productionised version of that design.

---

## Stack

- **Laravel 13** (PHP 8.2+, runs on 8.4)
- **Filament v5** — single-login admin at `/admin`
- **Blade** templates + hand-written CSS (no Tailwind)
- **Spatie**: `laravel-medialibrary`, `laravel-sluggable`, `laravel-sitemap`, `laravel-feed`
- **league/commonmark** — markdown rendering for body content
- **Vite** for asset compilation
- **SQLite** for dev, **MySQL** for prod (via Forge)

---

## Local development

Prerequisites: PHP 8.2+, Composer 2, Node 18+.

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm run dev          # in one terminal
php artisan serve    # in another
```

The site is at `http://localhost:8000`. The admin is at `http://localhost:8000/admin`.

Default seeded admin: **connor@brownclawam.ca** / **changeme-now** (change this immediately on production).

---

## Content model

Four Eloquent models, all admin-managed via Filament:

| Model               | Public route                  | Filament label        |
|---                  |---                            |---                    |
| `Capability`        | `/capabilities/{slug}`        | Capabilities          |
| `CaseStudy`         | `/work/{slug}`                | Work / Case studies   |
| `Insight`           | `/briefings/{slug}`           | Briefings / Writing   |
| `ContactSubmission` | (none — admin inbox only)     | Inbox                 |

Body fields are markdown. Methods/deliverables on `Capability` are tag-input arrays. KPI stats on `CaseStudy` are a repeater of `value / unit / label / note`.

To suppress something from the public site without deleting it, clear `published_at`.

---

## Public routes

| Path                                | Name                  |
|---                                  |---                    |
| `/`                                 | `home`                |
| `/capabilities`                     | `capabilities.index`  |
| `/capabilities/{slug}`              | `capabilities.show`   |
| `/work`                             | `work.index`          |
| `/work/{slug}`                      | `work.show`           |
| `/briefings`                        | `briefings.index`     |
| `/briefings/{slug}`                 | `briefings.show`      |
| `/firm`                             | `firm`                |
| `/contact` (GET, POST)              | `contact`, `contact.store` |
| `/sitemap.xml`                      | `sitemap`             |
| `/briefings.atom`                   | (RSS feed)            |
| `/robots.txt`                       | —                     |

Contact form is rate-limited to 6/min/IP and includes a honeypot field.

---

## Deploying to Forge

The site is sized for a small Forge site on a single $5–10/mo box.

### 1. Provision

- Create a new Forge **PHP 8.4 site** for `brownclawam.ca`.
- Database: create a MySQL database named `brownclawam` (or whatever you prefer).
- SSL: enable LetsEncrypt for the domain.

### 2. Repository

- Connect Forge to the GitHub repo. The Laravel app is at the repo root, so no subdirectory configuration is needed.
- Set the deploy script to the contents of `deploy.sh` (or paste it directly into Forge's deploy script editor).

### 3. Environment

- Copy `.env.production.example` to Forge's environment editor as `.env`.
- Generate `APP_KEY` (Forge has a button) or run `php artisan key:generate` once.
- Fill in `DB_PASSWORD` and the mail provider keys.

### 4. First deploy

After deploying once via Forge's "Deploy Now":

```bash
# SSH into the Forge box once to confirm the admin user exists
cd /home/forge/brownclawam.ca
php artisan tinker --execute="\App\Models\User::firstOrCreate(['email'=>'connor@brownclawam.ca'],['name'=>'Connor Schriver','password'=>bcrypt(env('ADMIN_PASSWORD','changeme-now'))]);"
```

Then log in at `https://brownclawam.ca/admin`, change the password, and start publishing.

### 5. Optional: queue worker + scheduler

Not required at launch — the site uses synchronous mail and there are no scheduled jobs yet. If you add either later:

- Add a Forge **daemon** running `php artisan queue:work` (queue connection can stay `database`).
- Add the Forge **scheduler** crontab one-liner to `/home/forge/brownclawam.ca` to run `* * * * * php artisan schedule:run`.

---

## Adding content

In the admin:

1. **Capabilities** are usually a one-time edit. Three are seeded.
2. **Work / Case studies** — write the title, summary, and KPI stats first; the body fills in over time. Mark `is_featured` on the case you want to appear in the home page hero card.
3. **Briefings** — markdown body. `is_lead` promotes one briefing to the lead spot on `/briefings`. `kicker` controls the tag (Reliability / Method / Field-note etc.).
4. **Inbox** — incoming contact submissions. Mark them handled when you've replied.

---

## Design notes

- The CSS is hand-written and lives in `resources/css/app.css`. It is NOT Tailwind — do not re-introduce a utility framework or it will fight the design tokens at the top of the file.
- Brand assets (logo, claw mark, hero photo) are in `public/img/`.
- Fonts are loaded from Google Fonts CDN in `resources/views/layouts/site.blade.php`. Switch to self-hosting via Bunny later if needed for privacy.
- The bear-paw mark in the topbar is inline SVG so it's sharp at any size and always matches the brand amber.

The design reference is `_design/pitch.html` (and `_design/pitch-v1-design-reference.html` as the immutable archived copy). Keep them in sync philosophically; the live site is the source of truth.
