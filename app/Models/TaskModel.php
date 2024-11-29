<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    /**
     * Nombre de la tabla asociada
     */
    protected $table = 'tasks';

    /**
     * Clave primaria de la tabla
     */
    protected $primaryKey = 'id';

    /**
     * Campos permitidos para inserciones y actualizaciones
     */
    protected $allowedFields = ['user_id', 'title', 'description', 'created_at', 'updated_at'];

    /**
     * Activar manejo automático de timestamps
     */
    protected $useTimestamps = true;

    /**
     * Configuración de los campos de timestamps
     */
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Obtiene todas las tareas de un usuario
     */
    public function getTasksByUser($userId)
    {
        return $this->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Obtiene una tarea específica por su ID y usuario
     */
    public function getTaskById($taskId, $userId)
    {
        return $this->where('id', $taskId)->where('user_id', $userId)->first();
    }

    /**
     * Crea una nueva tarea
     */
    public function createTask($data)
    {
        return $this->insert($data);
    }

    /**
     * Actualiza una tarea existente
     */
    public function updateTask($taskId, $data)
    {
        return $this->update($taskId, $data);
    }

    /**
     * Elimina una tarea específica
     */
    public function deleteTask($taskId, $userId)
    {
        return $this->where('id', $taskId)->where('user_id', $userId)->delete();
    }
}
