<!-- views/layouts/footer.php -->
</div>
<footer class="bg-secondary text-light py-4 mt-5">
    <div class="container">
        <div class="row">
            <!-- Información del sistema -->
            <div class="col-md-6">
                <h5>Gestión de Tareas</h5>
                <p>Organiza tus tareas con eficiencia. Crea, edita y prioriza para mantenerte al día.</p>
                <ul class="list-unstyled">
                    <li><i class="bi bi-check-circle"></i> Tareas Pendientes</li>
                    <li><i class="bi bi-calendar2-event"></i> Gestión de Vencimientos</li>
                    <li><i class="bi bi-exclamation-circle"></i> Priorización Inteligente</li>
                </ul>
            </div>

            <!-- Derechos reservados y enlaces -->
            <div class="col-md-6 text-end">
                <p>&copy; <?= date('Y') ?> - Todos los derechos reservados</p>
                <p>
                    <a href="#" class="text-light text-decoration-none">Contacto</a> |
                    <a href="#" class="text-light text-decoration-none">Acerca de</a> |
                    <a href="#" class="text-light text-decoration-none">Privacidad</a>
                </p>
            </div>
        </div>
        <hr class="bg-light">
        <!-- Créditos -->
        <div class="text-center">
            <small>Desarrollado con ❤️ por el equipo de gestión de tareas utilizando PHP, MySQL y Bootstrap.</small>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>/assets/js/tarea.js"></script>
</body>
</html>
