<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TaskModel;

class UserController extends BaseController
{
    /**
     * Método para iniciar sesión
     */
    public function login()
    {
        $session = session();

        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if (empty($username) || empty($password)) {
                $session->setFlashdata('error', 'Por favor, completa todos los campos.');
                return redirect()->back();
            }

            $userModel = new UserModel();
            $user = $userModel->where('username', $username)->first();

            if ($user && password_verify($password, $user['password'])) {
                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'], // Admin o Usuario
                    'logged_in' => true,
                ]);

                return $user['role'] === 'Admin' ?
                    redirect()->to('/admin/dashboard') :
                    redirect()->to('/user/dashboard');
            } else {
                $session->setFlashdata('error', 'Usuario o contraseña incorrectos.');
                return redirect()->to('/login');
            }
        }

        return view('auth/login');
    }

    /**
     * Método para registrar usuarios
     */
    public function register()
    {
        $session = session();

        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if (empty($username) || empty($password)) {
                $session->setFlashdata('error', 'Todos los campos son obligatorios.');
                return redirect()->back();
            }

            $userModel = new UserModel();
            $existingUser = $userModel->where('username', $username)->first();

            if ($existingUser) {
                $session->setFlashdata('error', 'El nombre de usuario ya está registrado.');
                return redirect()->back();
            }

            $userModel->save([
                'username' => $username,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'role' => 'Usuario', // Todos los registros serán usuarios
            ]);

            $session->setFlashdata('success', 'Usuario registrado correctamente. ¡Inicia sesión ahora!');
            return redirect()->to('/login');
        }

        return view('auth/register');
    }

    /**
     * Método para cerrar sesión
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Has cerrado sesión correctamente.');
    }

    /**
     * Método para listar tareas del usuario
     */
    public function tasks()
    {
        $session = session();
        $taskModel = new TaskModel();

        // Obtener las tareas del usuario autenticado
        $tasks = $taskModel->getTasksByUser($session->get('id'));

        return view('user/tasks', ['tasks' => $tasks]);
    }

    /**
     * Método para crear una nueva tarea
     */
    public function createTask()
    {
        $session = session();
        $taskModel = new TaskModel();

        if ($this->request->getMethod() === 'post') {
            $taskModel->save([
                'user_id' => $session->get('id'),
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
            ]);

            return redirect()->to('/user/tasks')->with('success', 'Tarea creada con éxito.');
        }

        return view('user/create_task');
    }

    /**
     * Método para editar una tarea existente
     */
    public function editTask($id)
    {
        $session = session();
        $taskModel = new TaskModel();

        // Verificar si la tarea pertenece al usuario autenticado
        $task = $taskModel->getTaskById($id, $session->get('id'));

        if (!$task) {
            return redirect()->to('/user/tasks')->with('error', 'Tarea no encontrada.');
        }

        if ($this->request->getMethod() === 'post') {
            $taskModel->updateTask($id, [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
            ]);

            return redirect()->to('/user/tasks')->with('success', 'Tarea actualizada con éxito.');
        }

        return view('user/edit_task', ['task' => $task]);
    }

    /**
     * Método para eliminar una tarea
     */
    public function deleteTask($id)
    {
        $session = session();
        $taskModel = new TaskModel();

        // Verificar si la tarea pertenece al usuario autenticado
        $task = $taskModel->getTaskById($id, $session->get('id'));

        if ($task) {
            $taskModel->deleteTask($id, $session->get('id'));
            return redirect()->to('/user/tasks')->with('success', 'Tarea eliminada con éxito.');
        }

        return redirect()->to('/user/tasks')->with('error', 'Tarea no encontrada.');
    }
}
