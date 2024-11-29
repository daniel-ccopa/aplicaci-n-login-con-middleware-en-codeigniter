<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Panel de Tareas</h1>

    <!-- Verificar qué acción realizar -->
    <?php if (isset($action) && $action === 'create'): ?>
        <!-- Formulario para Crear Tarea -->
        <h3>Crear Nueva Tarea</h3>
        <form action="/user/tasks/create" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
            <a href="/user/tasks" class="btn btn-secondary">Cancelar</a>
        </form>

    <?php elseif (isset($action) && $action === 'edit'): ?>
        <!-- Formulario para Editar Tarea -->
        <h3>Editar Tarea</h3>
        <form action="/user/tasks/edit/<?= $task['id'] ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $task['title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description"><?= $task['description'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="/user/tasks" class="btn btn-secondary">Cancelar</a>
        </form>

    <?php else: ?>
        <!-- Lista de Tareas -->
        <h3>Mis Tareas</h3>
        <a href="/user/tasks/create" class="btn btn-success mb-3">Crear Nueva Tarea</a>
        <?php if (!empty($tasks)): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tasks as $task): ?>
                        <tr>
                            <td><?= $task['id'] ?></td>
                            <td><?= $task['title'] ?></td>
                            <td><?= $task['description'] ?></td>
                            <td>
                                <a href="/user/tasks/edit/<?= $task['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="/user/tasks/delete/<?= $task['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta tarea?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No tienes tareas registradas.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>

