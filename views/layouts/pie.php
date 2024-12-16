<!-- views/layouts/header.php -->
<?php
// Asegurarnos de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
$isAuthenticated = isset($_SESSION['id_usuario']);
$userName = $isAuthenticated ? $_SESSION['nombre_completo'] : '';
$userRole = $isAuthenticated ? $_SESSION['rol'] : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-success">
        <div class="container">
            <!-- Logo o nombre del sistema -->
            <a class="navbar-brand text-light fw-bold" href="<?= BASE_URL ?>">
                <i class="fas fa-tasks"></i> Gestión de Tareas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Navegación principal -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="<?= BASE_URL ?>">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <?php if ($isAuthenticated): ?>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?= BASE_URL ?>/tareas">
                                <i class="fas fa-list"></i> Tareas Pendientes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?= BASE_URL ?>/tareas/completadas">
                                <i class="fas fa-check-circle"></i> Tareas Completadas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?= BASE_URL ?>/tareas/prioridades">
                                <i class="fas fa-exclamation-triangle"></i> Prioridades
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <!-- Navegación de usuario -->
                <ul class="navbar-nav">
                    <?php if ($isAuthenticated): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-light" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?= htmlspecialchars($userName) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>/perfil">
                                        <i class="fas fa-user-circle"></i> Perfil
                                    </a>
                                </li>
                                <?php if ($userRole === 'admin'): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?= BASE_URL ?>/admin">
                                            <i class="fas fa-cogs"></i> Administración
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form id="logoutForm" action="<?= BASE_URL ?>/auth/logout" method="POST" style="display: none;"></form>
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?= BASE_URL ?>/login">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light" href="<?= BASE_URL ?>/register">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <!-- Contenedor para alertas -->
        <div id="alertContainer"></div>
