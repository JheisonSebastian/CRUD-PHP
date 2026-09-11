<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/libro.php';

/**
 * Clase CrudLibro — operaciones CRUD sobre la tabla `libros` en PostgreSQL.
 */
class CrudLibro {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Conexion::getInstancia()->getPDO();
    }

    // ── CREATE ────────────────────────────────────────────────────────────────
    public function insertar(Libro $libro): void {
        $sql  = 'INSERT INTO libros (nombre) VALUES (:nombre)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':nombre' => $libro->getNombre()]);
    }

    // ── READ (todos) ──────────────────────────────────────────────────────────
    public function listar(): array {
        $stmt = $this->pdo->query('SELECT * FROM libros ORDER BY id');
        return $stmt->fetchAll();
    }

    // ── READ (uno) ────────────────────────────────────────────────────────────
    public function buscarPorId(int $id): array|false {
        $sql  = 'SELECT * FROM libros WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // ── UPDATE ────────────────────────────────────────────────────────────────
    public function actualizar(Libro $libro): void {
        $sql  = 'UPDATE libros SET nombre = :nombre WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $libro->getNombre(),
            ':id'     => $libro->getId(),
        ]);
    }

    // ── DELETE ────────────────────────────────────────────────────────────────
    public function eliminar(int $id): void {
        $sql  = 'DELETE FROM libros WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}
?>
