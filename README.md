# ERP Texoffice - Module Gestion Commerciale

**Étudiant** : Widad Zakri  
**Encadrant** : Othmane Daif  
**Établissement** : OFPPT – ISTA  
**Année** : 2025-2026

## Description
Application web de gestion commerciale dédiée au secteur textile.
Gestion centralisée des devis clients, du stock, du parc machines et tableau de bord.

## Stack technique
- Laravel 11 (Full Stack)
- MySQL 8
- Bootstrap 5

## Installation locale
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve