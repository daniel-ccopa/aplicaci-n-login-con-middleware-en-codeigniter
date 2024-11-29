<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    // Página de inicio de sesión
    public function login()
    {
        $session = session();

        // Procesar formulario de inicio de sesión
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            // Buscar al usuario en la base de datos
            $userModel = new UserModel();
            $user = $userModel->where('username', $username)->first();

            // Verificar si el usuario existe y la contraseña es correcta
            if ($user && password_verify($password, $user['password'])) {
                // Guardar datos del usuario en sesión
                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'logged_in' => true,
                ]);

                // Redirigir al dashboard según el rol
                if ($user['role'] === 'Admin') {
                    return redirect()->to('/admin/dashboard');
                } else {
                    return redirect()->to('/user/dashboard');
                }
            } else {
                $session->setFlashdata('error', 'Usuario o contraseña incorrectos.');
            }
        }

        // Mostrar la vista de inicio de sesión
        return view('auth/login');
    }

    // Página de registro de usuarios
    public function register()
    {
        $session = session();

        // Procesar formulario de registro
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $role = 'Usuario'; // Los registros desde la vista siempre serán usuarios

            // Validar datos del formulario
            if (empty($username) || empty($password)) {
                $session->setFlashdata('error', 'Todos los campos son obligatorios.');
                return redirect()->back();
            }

            // Guardar el usuario en la base de datos
            $userModel = new UserModel();
            $userModel->save([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT), // Encriptar contraseña
                'role' => $role,
            ]);

            $session->setFlashdata('success', 'Usuario registrado correctamente. Ahora puedes iniciar sesión.');
            return redirect()->to('/login');
        }

        // Mostrar la vista de registro
        return view('auth/register');
    }

    // Cerrar sesión
    public function logout()
    {
        $session = session();
        $session->destroy(); // Destruye la sesión actual
        return redirect()->to('/login'); // Redirige al login
    }
}

