<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    /**
     * Nombre de la tabla asociada
     */
    protected $table = 'users';

    /**
     * Clave primaria de la tabla
     */
    protected $primaryKey = 'id';

    /**
     * Campos permitidos para inserciones y actualizaciones
     */
    protected $allowedFields = ['username', 'password', 'role'];

    /**
     * Encuentra un usuario por su nombre de usuario
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Encuentra un usuario por su ID
     */
    public function getUserById($id)
    {
        return $this->find($id);
    }
}
