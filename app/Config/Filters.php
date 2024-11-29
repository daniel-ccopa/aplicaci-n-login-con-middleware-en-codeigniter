<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\AuthFilter; // Importa el filtro personalizado

class Filters extends BaseConfig
{
    /**
     * Aliases para las clases de filtros.
     *
     * Esto hace que las referencias a los filtros sean más limpias y comprensibles.
     *
     * @var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => AuthFilter::class, // Alias para el filtro personalizado
    ];

    /**
     * Filtros globales que se aplican a todas las solicitudes.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            // Descomenta 'csrf' si deseas protección contra ataques CSRF.
            // 'csrf',
            // 'honeypot',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar', // Activa la barra de depuración para el entorno de desarrollo.
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * Filtros aplicados según el método HTTP (GET, POST, etc.).
     *
     * Ejemplo:
     * 'post' => ['foo', 'bar']
     */
    public array $methods = [];

    /**
     * Filtros específicos para ciertas rutas (URI patterns).
     *
     * Aquí configuramos el filtro `auth` para proteger las rutas específicas.
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [
        // Aplica el filtro 'auth' a todas las rutas que comiencen con 'admin/' o 'user/'
        'auth' => ['before' => ['admin/*', 'user/*']],
    ];
}

