<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Método que se ejecuta antes de procesar una solicitud
     *
     * @param RequestInterface $request
     * @param array|null $arguments
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Acceder a la sesión actual
        $session = session();

        // Verificar si el usuario está autenticado
        if (!$session->has('logged_in') || !$session->get('logged_in')) {
            // Redirigir al login con un mensaje de error
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para acceder.');
        }

        // Verificar si se especifican roles en los argumentos
        if ($arguments) {
            $userRole = $session->get('role'); // Obtener el rol del usuario de la sesión
            if (!in_array($userRole, $arguments)) {
                // Si el rol del usuario no está autorizado, redirigir al login con mensaje de error
                return redirect()->to('/login')->with('error', 'No tienes permiso para acceder a esta sección.');
            }
        }
    }

    /**
     * Método que se ejecuta después de procesar una solicitud
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $arguments
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se realizan acciones en este filtro después del procesamiento
    }
}

