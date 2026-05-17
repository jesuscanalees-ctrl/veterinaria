# 🐾 Sistema de Gestión Veterinaria

Sistema web de gestión para clínica veterinaria desarrollado con **Laravel 12** y la plantilla de administración **SB Admin 2 (StartBootstrap)**.

---

## 📋 Tabla de contenidos

- [Descripción](#descripción)
- [Tecnologías](#tecnologías)
- [Requisitos del sistema](#requisitos-del-sistema)
- [Instalación](#instalación)
- [Configuración de la base de datos](#configuración-de-la-base-de-datos)
- [Usuarios por defecto](#usuarios-por-defecto)
- [Estructura del proyecto](#estructura-del-proyecto)
- [Layouts y plantillas](#layouts-y-plantillas)
- [Rutas disponibles](#rutas-disponibles)
- [Roles del sistema](#roles-del-sistema)

---

## 📖 Descripción

Sistema de administración para clínica veterinaria que permite gestionar pacientes (animales), atenciones/consultas y usuarios del sistema. Cuenta con autenticación de usuarios y control de acceso basado en roles (Administrador / Veterinario).

---

## 🛠 Tecnologías

| Tecnología | Versión | Uso |
|---|---|---|
| PHP | ^8.2 | Lenguaje backend |
| Laravel | ^12.0 | Framework principal |
| MySQL | 5.7 / 8.x | Base de datos |
| SB Admin 2 | 4.x | Plantilla de UI (local en `public/startbootstrap/`) |
| Bootstrap | 4.x | Componentes CSS (incluido en SB Admin 2) |
| jQuery | 3.x | Scripts JS (incluido en SB Admin 2) |
| FontAwesome | 5.x | Íconos |
| Vite | — | Bundler de assets |

---

## ⚙️ Requisitos del sistema

- PHP >= 8.2 con extensiones: `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `bcmath`
- Composer >= 2.x
- MySQL >= 5.7
- Node.js >= 18.x + npm
- Servidor web: Apache o `php artisan serve`

---

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio> veterinaria
cd veterinaria
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias Node.js

```bash
npm install
```

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 5. Configurar la base de datos en `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veterinaria
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

### 7. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

La aplicación estará disponible en: **http://127.0.0.1:8000**

---

## 🗄️ Configuración de la base de datos

La base de datos se llama `veterinaria`. Asegúrate de crearla antes de ejecutar las migraciones:

```sql
CREATE DATABASE veterinaria CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Migraciones incluidas

| Migración | Tabla | Descripción |
|---|---|---|
| `0001_01_01_000000` | `users` | Usuarios del sistema con campo `rol` (enum) |
| `0001_01_01_000001` | `cache` | Caché de la aplicación |
| `0001_01_01_000002` | `jobs` | Cola de trabajos en segundo plano |

### Tabla `users`

| Campo | Tipo | Descripción |
|---|---|---|
| `id` | bigint | Clave primaria |
| `name` | string | Nombre del usuario |
| `email` | string (unique) | Correo electrónico |
| `password` | string | Contraseña encriptada (bcrypt) |
| `rol` | enum | `administrador` \| `veterinario` |
| `remember_token` | string | Token de "recordarme" |
| `timestamps` | — | `created_at`, `updated_at` |

---

## 👤 Usuarios por defecto

Los siguientes usuarios se crean automáticamente al ejecutar `php artisan migrate --seed`:

| Nombre | Correo | Contraseña | Rol |
|---|---|---|---|
| admin | `admin@gmail.com` | `admin` | administrador |
| veterinario | `veterinario@veterinario.com` | `veterinario` | veterinario |

> ⚠️ **Importante:** Cambia estas contraseñas en producción.

---

## 📁 Estructura del proyecto

```
veterinaria/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── AuthController.php       # Lógica de autenticación
│   └── Models/
│       └── User.php                     # Modelo de usuario
├── database/
│   ├── migrations/                      # Migraciones de la BD
│   └── seeders/
│       └── DatabaseSeeder.php           # Usuarios iniciales
├── public/
│   ├── img/
│   │   └── logo1.jpg                    # Logo de la clínica
│   └── startbootstrap/                  # Plantilla SB Admin 2 (NO modificar)
│       ├── css/
│       ├── js/
│       ├── img/
│       └── vendor/                      # Dependencias del tema (jQuery, Bootstrap, etc.)
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── main.blade.php           # Layout principal (panel con sidebar)
│       │   ├── login.blade.php          # Layout de autenticación
│       │   ├── admin.blade.php          # Layout para el administrador
│       │   ├── partials/                # Partials del layout main
│       │   │   ├── sidebar.blade.php
│       │   │   ├── topbar.blade.php
│       │   │   └── footer.blade.php
│       │   └── admin/
│       │       └── partials/            # Partials del layout admin
│       │           ├── sidebar.blade.php
│       │           ├── topbar.blade.php
│       │           └── footer.blade.php
│       └── modules/
│           ├── auth/
│           │   └── login.blade.php      # Vista de inicio de sesión
│           └── dashboard/
│               ├── admin_home.blade.php # Dashboard del administrador
│               └── home.blade.php       # Dashboard del veterinario
└── routes/
    └── web.php                          # Rutas web de la aplicación
```

> **Nota:** La carpeta `public/startbootstrap/vendor/` contiene las dependencias del **tema frontend** (jQuery, Bootstrap, FontAwesome, etc.) y **no debe confundirse** con la carpeta `vendor/` de Composer en la raíz del proyecto.

---

## 🎨 Layouts y plantillas

El proyecto usa la plantilla **SB Admin 2** de StartBootstrap como base visual.

### Layouts disponibles

| Layout | Archivo | Uso |
|---|---|---|
| Login | `layouts/login.blade.php` | Páginas de autenticación |
| Admin | `layouts/admin.blade.php` | Panel del administrador |
| Main | `layouts/main.blade.php` | Panel general (veterinario) |

### Cómo usar un layout en una vista

```blade
@extends('layouts.admin')

@section('titulo_pagina', 'Mi Página')

@section('content')
    {{-- Tu contenido aquí --}}
@endsection

{{-- Scripts adicionales (opcional) --}}
@push('scripts')
    <script src="{{ asset('startbootstrap/vendor/chart.js/Chart.min.js') }}"></script>
@endpush
```

### Assets del tema

Los assets de la plantilla se referencian con `asset('startbootstrap/...')`:

```blade
{{-- CSS --}}
<link href="{{ asset('startbootstrap/css/sb-admin-2.min.css') }}" rel="stylesheet">

{{-- JS --}}
<script src="{{ asset('startbootstrap/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('startbootstrap/js/sb-admin-2.min.js') }}"></script>
```

---

## 🛣️ Rutas disponibles

| Método | URL | Nombre | Middleware | Descripción |
|---|---|---|---|---|
| GET | `/` | `login` | `guest` | Mostrar formulario de login |
| POST | `/logear` | `logear` | `guest` | Procesar inicio de sesión |
| GET | `/home` | `home` | `auth` | Dashboard (redirige según rol) |
| GET | `/admin/home` | `admin.home` | `auth` | Dashboard del administrador |
| GET | `/logout` | `logout` | `auth` | Cerrar sesión |

---

## 👥 Roles del sistema

| Rol | Acceso |
|---|---|
| `administrador` | Dashboard de administrador, gestión de usuarios, atenciones y pacientes |
| `veterinario` | Dashboard de veterinario, atenciones y pacientes |

El control de rol se realiza en el `AuthController` comparando `Auth::user()->rol`.

---

## 🔐 Seguridad

- Las contraseñas se almacenan con **bcrypt** (12 rounds).
- Las rutas protegidas usan el middleware `auth` de Laravel.
- Las rutas de invitado usan el middleware `guest` para evitar acceso duplicado.
- Todos los formularios incluyen `@csrf` para protección contra CSRF.
- El logout usa `Session::flush()` + `Auth::logout()`.

---

## 📝 Notas de desarrollo

- **Motor de plantillas:** Blade (Laravel)
- **Base de datos de desarrollo:** MySQL (`veterinaria`)
- **Sesiones:** Almacenadas en base de datos (`SESSION_DRIVER=database`)
- **Caché:** Base de datos (`CACHE_STORE=database`)

---

## 📄 Licencia

Proyecto académico — Instituto Tecnológico de México Americano (ITMA).
