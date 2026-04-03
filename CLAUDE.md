# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Setup from scratch
composer setup         # Install deps, generate .env, migrate, build assets

# Development
composer dev           # PHP dev server + Queue listener + Vite (parallel)
npm run dev            # Vite HMR only

# Production assets
npm run build

# Testing
composer test          # Clears config cache, then runs Pest suite
php artisan test       # Run Pest tests directly

# Code style
php artisan pint       # Auto-fix PHP code style (Laravel Pint)

# Database
php artisan migrate
php artisan migrate:fresh   # Destructive — resets all data
php artisan tinker

# Queue (required for async jobs like email)
php artisan queue:listen
```

## Architecture

**Anntix** is a multi-role event ticketing platform (Admin, Organizer, Reseller, Scanner) built with Laravel 12, Blade/Alpine.js, and Tailwind CSS 4.

### Route Organization

Routes are split by role into separate files loaded from `routes/`:
- `web.php` — public pages, checkout, payment callback
- `admin.php` — admin-only CRUD and reports
- `organizer.php` — organizer dashboard, events, withdrawals, resellers
- `reseller.php` — reseller transactions, balance, deposits

All protected routes use role middleware: `IsAdmin`, `IsOrganizer`, `IsReseller`, `IsScanner`. `EnsureUserIsActive` gates all authenticated users.

### Core Data Model

**Event → Ticket → Transaction** is the primary hierarchy.

- `Event` belongs to an `organizer` (User with role=organizer); has many `Ticket`, `Transaction`, `Withdrawal`; pivot tables `event_scanner` and `event_reseller` assign users to events
- `Ticket` defines a variant (price, quota, dates, fee overrides) within an event
- `Transaction` is the purchase record; stores buyer info, all computed fee values at time of purchase (frozen), `status` (pending/paid/failed/expired/canceled), Midtrans `snap_token`, and `reseller_id` if sold via reseller
- `TransactionScan` records each individual QR scan (supports `max_scans` per ticket)
- `TransactionLog` is an audit trail of field changes on transactions
- `Withdrawal` tracks organizer cash-out requests with statuses (pending/approved/rejected)
- `ResellerDeposit` tracks balance top-ups for reseller accounts
- `Setting` is a key-value store for global configuration (fee defaults, etc.)

### Fee System (Hierarchical Override)

Fees are resolved in priority order: **Ticket-level → Event-level → Global Setting**. Each level has `_type` (percent/fixed) and `_value` fields. Key fee types:

- **Handling fee** — platform service fee charged to buyer
- **Organizer fee** — platform's revenue cut from organizer (separate rates for online vs. reseller sales)
- **Reseller fee** — commission added to ticket price for reseller channel
- **Gateway fee** — Midtrans processing fee (QRIS: 0.7%, Bank Transfer: 1.4% default)

Fee values are **locked at checkout** into the `transactions` table columns (`handling_fee`, `service_fee`, `reseller_fee`, `organizer_fee`, `gateway_fee`) so subsequent Setting changes don't affect historical records.

Key methods: `$ticket->getHandlingFee()`, `$ticket->getFeeBreakdown()`, `$ticket->getOrganizerFee($type)`, `$ticket->getResellerFee()`, `$event->calculateSaldo()`.

### Payment Flow

1. Checkout → `CheckoutController` creates a `pending` Transaction and calls Midtrans Snap API
2. User completes payment on Midtrans-hosted page
3. Midtrans posts webhook → `PaymentController` updates transaction status to `paid`/`failed`/`expired`
4. `PaymentSuccess` Mailable is dispatched to buyer's email via queue

### Frontend Stack

- **Tailwind CSS 4** (JIT from Blade files) — entry: `resources/css/app.css`
- **Alpine.js 3** — lightweight reactivity, loaded globally
- **Vite 7** — asset bundler; output to `public/build/`
- No SPA framework; standard Blade templates with Alpine for interactivity

### Soft Deletes & Audit

`Event`, `Ticket`, `Transaction`, `ResellerDeposit` all use `SoftDeletes`. Voided transactions remain in the database. Always use `->withTrashed()` or `->onlyTrashed()` when reports need to include voided records.

### Key Config

- Default DB: SQLite (`database/database.sqlite`)
- Sessions, cache, and queues all use `database` driver
- Payment gateway: `config/midtrans.php` — reads `MIDTRANS_SERVER_KEY` and `MIDTRANS_IS_PRODUCTION` from `.env`
- QR codes generated via `endroid/qr-code`
- Auth scaffolding via `laravel/fortify` (supports 2FA)
