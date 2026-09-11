<?php
require_once __DIR__ . '/../modelo/crud_libro.php';

// Validar que venga un id válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$crud  = new CrudLibro();
$libro = $crud->buscarPorId((int) $_GET['id']);

if (!$libro) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro — Gestión de Libros</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f17;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .container { width: 100%; max-width: 480px; }

        /* ── HEADER ── */
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .header p { color: #64748b; margin-top: .35rem; font-size: .9rem; }

        /* ── CARD ── */
        .card {
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 18px;
            padding: 2rem;
            backdrop-filter: blur(10px);
        }

        /* ── BADGE ID ── */
        .id-badge {
            display: inline-block;
            background: rgba(129,140,248,.15);
            color: #818cf8;
            border: 1px solid rgba(129,140,248,.25);
            padding: .25rem .75rem;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        /* ── FORM ── */
        label {
            display: block;
            font-size: .82rem;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: .5rem;
        }
        input[type="text"] {
            width: 100%;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 10px;
            padding: .75rem 1rem;
            color: #e2e8f0;
            font-size: 1rem;
            font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }
        input[type="text"]:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(129,140,248,.2);
        }

        /* ── ACTIONS ── */
        .actions {
            display: flex;
            gap: .75rem;
            margin-top: 1.5rem;
        }
        .btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .4rem;
            padding: .8rem 1rem;
            border: none;
            border-radius: 10px;
            font-size: .92rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            text-decoration: none;
            transition: transform .15s, opacity .15s;
        }
        .btn:hover  { opacity: .88; transform: translateY(-1px); }
        .btn:active { transform: translateY(0); }

        .btn-primary {
            background: linear-gradient(135deg, #818cf8, #c084fc);
            color: #fff;
            box-shadow: 0 4px 14px rgba(129,140,248,.35);
        }
        .btn-ghost {
            background: rgba(255,255,255,.06);
            color: #94a3b8;
            border: 1px solid rgba(255,255,255,.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>✏️ Editar libro</h1>
        <p>Modifica el título y guarda los cambios</p>
    </div>

    <div class="card">
        <span class="id-badge">ID #<?= $libro['id'] ?></span>

        <form action="../controlador/administra_libro.php" method="POST">
            <!-- Campo oculto con el id del libro -->
            <input type="hidden" name="id" value="<?= $libro['id'] ?>">

            <label for="nombre">Título del libro</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                value="<?= htmlspecialchars($libro['nombre']) ?>"
                required
                maxlength="255"
                autocomplete="off"
            >

            <div class="actions">
                <a href="index.php" class="btn btn-ghost">← Cancelar</a>
                <button type="submit" name="actualizar" class="btn btn-primary">
                    💾 Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
