<?php
/**
 * Clase Conexion — Singleton PDO a PostgreSQL.
 * Las credenciales se leen desde el archivo .env en la raíz del proyecto.
 */
class Conexion {
    private static ?Conexion $instancia = null;
    private PDO $pdo;

    private function __construct() {
        $config = self::cargarEnv();

        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $config['DB_HOST'],
            $config['DB_PORT'],
            $config['DB_NAME']
        );

        $this->pdo = new PDO($dsn, $config['DB_USER'], $config['DB_PASS'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    /**
     * Lee y parsea el archivo .env ubicado en la raíz del proyecto.
     * Soporta comentarios (#), líneas vacías y valores con espacios.
     */
    private static function cargarEnv(): array {
        $ruta = __DIR__ . '/../.env';

        if (!file_exists($ruta)) {
            throw new RuntimeException(
                'Archivo .env no encontrado. Copia .env.example como .env y configura tus credenciales.'
            );
        }

        $config = [];
        $lineas = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lineas as $linea) {
            // Ignorar comentarios
            if (str_starts_with(trim($linea), '#')) continue;

            if (str_contains($linea, '=')) {
                [$clave, $valor] = explode('=', $linea, 2);
                $config[trim($clave)] = trim($valor);
            }
        }

        return $config;
    }

    public static function getInstancia(): self {
        if (self::$instancia === null) {
            self::$instancia = new self();
        }
        return self::$instancia;
    }

    public function getPDO(): PDO {
        return $this->pdo;
    }
}
?>
