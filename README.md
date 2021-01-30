# Diesel Energy

[![GitHub Actions](https://github.com/nikolaynizruhin/dieselenergy/workflows/Laravel/badge.svg)](https://github.com/nikolaynizruhin/dieselenergy/workflows/Laravel/badge.svg)

## Getting started
### Installation

1. Clone this repository:
```
git clone https://github.com/nikolaynizruhin/dieselenergy.git
```
2. Copy .env file and update it with your variables:
```
cp .env.example .env
```
3. Install composer dependencies:
```
composer install
```
4. Install and compile npm dependencies:
```
npm install && npm run dev
```
5. Migrate database (--seed optional):
```
php artisan migrate --seed
```
6. Generate app key:
```
php artisan key:generate
```
7. Create a symbolic link from `public/storage` to `storage/app/public`:
```
php artisan storage:link
```

## Testing

```
php artisan test --parallel
```
