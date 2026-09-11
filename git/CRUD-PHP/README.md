# 📚 CRUD Libros — PHP + PostgreSQL

Aplicación web para gestionar una colección de libros usando el patrón **MVC**, **PHP** y **PostgreSQL** como base de datos.

---

## 📁 Estructura del proyecto

```
CRUD-PHP/
├── controlador/
│   └── administra_libro.php   # Lógica de enrutamiento (C en MVC)
├── modelo/
│   ├── conexion.php           # Conexión PDO a PostgreSQL (lee .env)
│   ├── crud_libro.php         # Operaciones CRUD (M en MVC)
│   └── libro.php              # Clase entidad Libro
├── Vista/
│   ├── index.php              # Listado + formulario de inserción (V en MVC)
│   └── actualizar.php         # Formulario de edición
├── .env                       # ⚠️ Credenciales locales (NO subir al repo)
├── .env.example               # Plantilla del .env (sí se sube al repo)
├── .gitignore
└── setup.sql                  # Script SQL para crear la BD y tabla
```

---

## ✅ Requisitos previos

| Software | Versión recomendada | Descarga |
|---|---|---|
| **XAMPP** (incluye PHP) | 8.x | [apachefriends.org](https://www.apachefriends.org/es/index.html) |
| **PostgreSQL** | 15+ | [postgresql.org/download/windows](https://www.postgresql.org/download/windows/) |

---

## 🚀 Instalación paso a paso

### Paso 1 — Clonar / copiar el proyecto

```bash
# Con git
git clone <URL-del-repositorio>

# O simplemente copia la carpeta CRUD-PHP en tu máquina
```

---

### Paso 2 — Habilitar extensiones PostgreSQL en XAMPP

1. Abre el archivo `C:\xampp\php\php.ini` con un editor de texto.
2. Busca estas dos líneas (usa `Ctrl+F`):
   ```
   ;extension=pdo_pgsql
   ;extension=pgsql
   ```
3. Quita el `;` del inicio de ambas líneas:
   ```
   extension=pdo_pgsql
   extension=pgsql
   ```
4. Guarda el archivo.

---

### Paso 3 — Crear el archivo `.env`

1. Copia la plantilla:
   ```powershell
   Copy-Item .env.example .env
   ```
2. Abre `.env` y llena tus credenciales de PostgreSQL:
   ```env
   DB_HOST=localhost
   DB_PORT=5432
   DB_NAME=crud_libros
   DB_USER=postgres
   DB_PASS=TU_CONTRASEÑA
   ```

---

### Paso 4 — Crear la base de datos y la tabla

Abre **PowerShell** y ejecuta (reemplaza `TU_CONTRASEÑA`):

```powershell
# Crear la base de datos
$env:PGPASSWORD = 'TU_CONTRASEÑA'
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -c "CREATE DATABASE crud_libros WITH ENCODING 'UTF8' TEMPLATE template0;"

# Crear la tabla
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" -U postgres -d crud_libros -c "CREATE TABLE libros (id SERIAL PRIMARY KEY, nombre VARCHAR(255) NOT NULL);"
```

> **Nota:** Si tu versión de PostgreSQL es diferente a la 18, ajusta la ruta:
> `C:\Program Files\PostgreSQL\<VERSION>\bin\psql.exe`

---

### Paso 5 — Arrancar el servidor PHP

En **PowerShell**, desde la raíz del proyecto:

```powershell
& "C:\xampp\php\php.exe" -S localhost:8000 -t Vista/
```

Deja esta ventana abierta mientras usas la app.

---

### Paso 6 — Abrir la aplicación

Abre tu navegador y ve a:

👉 **http://localhost:8000/index.php**

---

## 🔧 Solución de errores comunes

### ❌ `'php' no se reconoce como nombre de un cmdlet`
PHP no está en el PATH. Usa la ruta completa:
```powershell
& "C:\xampp\php\php.exe" -S localhost:8000 -t Vista/
```

---

### ❌ `'psql' no se reconoce como nombre de un cmdlet`
PostgreSQL no está en el PATH. Usa la ruta completa:
```powershell
& "C:\Program Files\PostgreSQL\18\bin\psql.exe" ...
```

---

### ❌ `SQLSTATE[08006]: autenticación por password falló`
La contraseña en `.env` no coincide con la de PostgreSQL.
Abre `.env` y corrige `DB_PASS`.

---

### ❌ `Archivo .env no encontrado`
Falta crear el `.env`. Vuelve al Paso 3.

---

### ❌ `could not find driver` (pdo_pgsql)
Las extensiones de PostgreSQL en PHP no están habilitadas.
Vuelve al Paso 2.

---

## 📋 Flujo de la aplicación

```
index.php
  |
  +-- [Agregar libro]  --> POST --> administra_libro.php --> insertar()  --> index.php
  +-- [Editar]         --> GET  --> administra_libro.php --> actualizar.php (formulario)
  |                                  +-- [Guardar] --> POST --> actualizar() --> index.php
  +-- [Borrar]         --> GET  --> administra_libro.php --> eliminar()  --> index.php
```
