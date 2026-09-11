-- =============================================================
-- Script de configuración: CRUD PHP + PostgreSQL
-- Ejecutar con: psql -U postgres -f setup.sql
-- =============================================================

-- 1. Crear la base de datos
CREATE DATABASE crud_libros
    WITH ENCODING 'UTF8'
    LC_COLLATE = 'es_ES.UTF-8'
    LC_CTYPE   = 'es_ES.UTF-8'
    TEMPLATE   = template0;

-- 2. Conectarse a la nueva base de datos
\c crud_libros;

-- 3. Crear la tabla libros
CREATE TABLE libros (
    id     SERIAL       PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL
);

-- 4. Datos de prueba (opcional)
INSERT INTO libros (nombre) VALUES
    ('Cien años de soledad'),
    ('El Quijote'),
    ('1984');
