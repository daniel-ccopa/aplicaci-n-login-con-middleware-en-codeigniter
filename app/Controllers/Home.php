<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends BaseController
{
    /**
     * Página principal
     * Redirige al formulario de inicio de sesión.
     */
    public function index()
    {
        return redirect()->to('/login');
    }

    /**
     * Prueba de conexión a la base de datos
     */
    public function testDatabase()
    {
        $db = \Config\Database::connect();

        try {
            // Ejecutar una consulta simple para probar la conexión
            $query = $db->query('SELECT DATABASE() AS dbname');
            $result = $query->getRow();

            if ($result) {
                echo 'Conexión exitosa a la base de datos: ' . $result->dbname;
            } else {
                echo 'Conexión fallida a la base de datos.';
            }
        } catch (\Exception $e) {
            echo 'Error al conectar: ' . $e->getMessage();
        }
    }

    /**
     * Página de acceso denegado
     */
    public function unauthorized()
    {
        return view('errors/unauthorized', [
            'message' => 'No tienes permiso para acceder a esta página.'
        ]);
    }

    /**
     * Dashboard genérico
     * Muestra una página después del inicio de sesión.
     */
    public function dashboard()
    {
        // Verificar si el usuario está autenticado
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Cargar la vista del dashboard con datos básicos
        return view('dashboard', [
            'username' => session()->get('username'),
            'role' => session()->get('role'),
        ]);
    }
}

