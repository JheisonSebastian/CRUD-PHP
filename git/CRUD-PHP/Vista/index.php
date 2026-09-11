<?php
require_once __DIR__ . '/../modelo/crud_libro.php';
$crud   = new CrudLibro();
$libros = $crud->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Libros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f17;
            color: #e2e8f0;
            min-height: 100vh;
            padding: 2rem 1rem;
        }

        /* ── HEADER ── */
        .header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }
        .header p {
            color: #94a3b8;
            margin-top: .4rem;
            font-size: .95rem;
        }

        /* ── CONTENEDOR PRINCIPAL ── */
        .container {
            max-width: 860px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        /* ── CARD ── */
        .card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(10px);
        }
        .card h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #c4b5fd;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* ── FORMULARIO ── */
        .form-row {
            display: flex;
            gap: .8rem;
        }
        .form-row input[type="text"] {
            flex: 1;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 10px;
            padding: .7rem 1rem;
            color: #e2e8f0;
            font-size: .95rem;
            font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        .form-row input[type="text"]:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129,140,248,.2);
        }
        .form-row input[type="text"]::placeholder { color: #64748b; }

        /* ── BOTONES ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            padding: .7rem 1.2rem;
            border: none;
            border-radius: 10px;
            font-size: .88rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            transition: transform .15s, opacity .15s, box-shadow .15s;
        }
        .btn:hover { opacity: .88; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .btn-primary {
            background: linear-gradient(135deg, #818cf8, #c084fc);
            color: #fff;
            box-shadow: 0 4px 14px rgba(129,140,248,.35);
        }
        .btn-warning {
            background: rgba(251,191,36,.12);
            color: #fbbf24;
            border: 1px solid rgba(251,191,36,.25);
        }
        .btn-danger {
            background: rgba(248,113,113,.1);
            color: #f87171;
            border: 1px solid rgba(248,113,113,.2);
        }

        /* ── TABLA ── */
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        thead th {
            text-align: left;
            padding: .6rem .9rem;
            font-size: .8rem;
            font-weight: 600;
            color: #94a3b8;
            letter-spacing: .05em;
            text-transform: uppercase;
        }
        tbody tr {
            border-bottom: 1px solid rgba(255,255,255,.05);
            transition: background .15s;
        }
        tbody tr:last-child { border-bottom: none; }
        tbody tr:hover { background: rgba(255,255,255,.03); }
        tbody td {
            padding: .85rem .9rem;
            font-size: .95rem;
        }
        .td-id {
            color: #64748b;
            font-size: .82rem;
            font-weight: 500;
        }
        .td-acciones {
            display: flex;
            gap: .5rem;
        }

        /* ── EMPTY STATE ── */
        .empty {
            text-align: center;
            padding: 2rem;
            color: #64748b;
        }
        .empty span { font-size: 2.5rem; display: block; margin-bottom: .5rem; }

        /* ── ALERT ── */
        .alert {
            padding: .8rem 1rem;
            border-radius: 10px;
            font-size: .88rem;
            margin-bottom: 1rem;
        }
        .alert-error {
            background: rgba(248,113,113,.12);
            border: 1px solid rgba(248,113,113,.25);
            color: #fca5a5;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>📚 Gestión de Libros</h1>
        <p>Administra tu colección de libros fácilmente</p>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">⚠️ <?= htmlspecialchars($_GET['error']) ?></div>
    <?php endif; ?>

    <!-- ── FORMULARIO INSERTAR ── -->
    <div class="card">
        <h2>➕ Agregar nuevo libro</h2>
        <form action="../controlador/administra_libro.php" method="POST">
            <div class="form-row">
                <input
                    type="text"
                    id="nombre"
                    name="nombre"
                    placeholder="Título del libro..."
                    required
                    maxlength="255"
                    autocomplete="off"
                >
                <button type="submit" name="insertar" class="btn btn-primary">
                    Guardar
                </button>
            </div>
        </form>
    </div>

    <!-- ── LISTADO ── -->
    <div class="card">
        <h2>📋 Lista de libros</h2>
        <?php if (empty($libros)): ?>
            <div class="empty">
                <span>🗂️</span>
                Aún no hay libros registrados. ¡Agrega uno!
            </div>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th style="width:60px">#</th>
                    <th>Título</th>
                    <th style="width:150px; text-align:center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $fila): ?>
                <tr>
                    <td class="td-id"><?= $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td>
                        <div class="td-acciones">
                            <a href="../controlador/administra_libro.php?accion=a&id=<?= $fila['id'] ?>"
                               class="btn btn-warning">✏️ Editar</a>
                            <a href="../controlador/administra_libro.php?accion=e&id=<?= $fila['id'] ?>"
                               class="btn btn-danger"
                               onclick="return confirm('¿Eliminar «<?= htmlspecialchars($fila['nombre'], ENT_QUOTES) ?>»?')">
                               🗑️ Borrar
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
