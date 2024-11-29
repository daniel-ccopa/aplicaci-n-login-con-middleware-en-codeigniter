<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

// Crear una nueva instancia de nuestro RouteCollection
$routes = Services::routes();

// Cargar el archivo de rutas del sistema para que la aplicación y el entorno puedan sobrescribirlas si es necesario
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Configuración del Router
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers'); // Espacio de nombres predeterminado
$routes->setDefaultController('UserController'); // Controlador predeterminado
$routes->setDefaultMethod('login'); // Método predeterminado
$routes->setTranslateURIDashes(false); // No traducir guiones en la URI
$routes->set404Override(); // Manejo de errores 404
$routes->setAutoRoute(false); // Deshabilitar auto-routing para mayor control

/*
 * --------------------------------------------------------------------
 * RUTAS PÚBLICAS: LOGIN, REGISTRO Y LOGOUT
 * --------------------------------------------------------------------
 * Estas rutas no requieren autenticación.
 */
$routes->get('/', 'UserController::login'); // Página principal redirige al login
$routes->get('/login', 'UserController::login'); // Página de login
$routes->post('/login', 'UserController::login'); // Procesar formulario de login
$routes->get('/register', 'UserController::register'); // Página de registro
$routes->post('/register', 'UserController::register'); // Procesar formulario de registro
$routes->get('/logout', 'UserController::logout'); // Cerrar sesión

/*
 * --------------------------------------------------------------------
 * RUTAS PROTEGIDAS: USUARIO
 * --------------------------------------------------------------------
 * Estas rutas son accesibles solo para usuarios autenticados.
 */
$routes->group('user', ['filter' => 'auth:Usuario'], function ($routes) {
    // Panel de usuario (dashboard)
    $routes->get('dashboard', 'UserController::tasks'); // Lista, creación y edición de tareas (todo en dashboard.php)

    // Rutas específicas para acciones en tareas
    $routes->get('tasks/create', 'UserController::createTask'); // Crear tarea
    $routes->post('tasks/create', 'UserController::createTask'); // Guardar nueva tarea
    $routes->get('tasks/edit/(:num)', 'UserController::editTask/$1'); // Editar tarea
    $routes->post('tasks/edit/(:num)', 'UserController::editTask/$1'); // Guardar edición de tarea
    $routes->get('tasks/delete/(:num)', 'UserController::deleteTask/$1'); // Eliminar tarea
});

/*
 * --------------------------------------------------------------------
 * RUTAS PROTEGIDAS: ADMIN (si aplica)
 * --------------------------------------------------------------------
 * Estas rutas son accesibles solo para usuarios con rol "Admin".
 */
$routes->group('admin', ['filter' => 'auth:Admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard'); // Panel de administrador
    $routes->get('tasks', 'AdminController::tasks'); // Listar y gestionar tareas como admin
});

/*
 * --------------------------------------------------------------------
 * Rutas Adicionales
 * --------------------------------------------------------------------
 * Aquí puedes agregar configuraciones adicionales para entornos específicos.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
