<div class="row mb-4">
    <div class="col">
        <h2>Listado de Tareas</h2>
    </div>
    <div class="col text-end">
        <a href="<?= BASE_URL ?>/report/pdf" class="btn btn-secondary">
            <i class="fas fa-file-pdf"></i> Exportar PDF
        </a>
        <a href="<?= BASE_URL ?>/reports/excel" class="btn btn-success">
            <i class="fas fa-file-excel"></i> Exportar Excel
        </a>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">
            <i class="fas fa-plus"></i> Nueva Tarea
        </button>
    </div>
</div>

<!-- Filtros -->
<div class="shadow-none p-3 mb-5 bg-body-tertiary rounded">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input
                        type="text"
                        class="form-control"
                        id="searchTask"
                        placeholder="Buscar tarea por nombre..."
                        onkeyup="searchTasks(event)">
                    <button class="btn btn-outline-secondary" type="button" onclick="clearSearch()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Descripción</th>
                <th>Completada</th>
                <th>Prioridad</th>
                <th>Fecha Creación</th> 
                <th>Fecha Vencimiento</th>
                <th>Obciones</th>
            </tr>
        </thead>
        <tbody id="TableTask">
            <!-- Las tareas se cargarán aquí dinámicamente -->
        </tbody>
    </table>
</div>

<!-- Paginación -->
<nav aria-label="Navegación de tareas">
    <ul class="pagination justify-content-center" id="pagination">
        <!-- La paginación se generará dinámicamente -->
    </ul>
</nav>

<!-- Modal para Crear/Editar Tarea -->
<div class="modal fade" id="taskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Nueva Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="taskForm">
                    <input type="hidden" id="taskId">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="form-label">Prioridad</label>
                        <select class="form-control" id="priority">
                            <option value="baja">Baja</option>
                            <option value="media">Media</option>
                            <option value="alta">Alta</option>
                        </select>
                    </div>
                    <div class="mb-3">
            <label for="fecha_creacion" class="form-label">Fecha de Creación</label>
            <input type="datetime-local" class="form-control" id="fecha_creacion" required>
        </div>
        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento</label>
            <input type="datetime-local" class="form-control" id="fecha_vencimiento" required>
        </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="complet">
                        <label class="form-check-label" for="complet">Completada</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cerrar
                </button>
                <button type="button" class="btn btn-primary" onclick="crear()">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación para Eliminar -->
 <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar esta tarea?</p>
                <p class="text-danger"><strong>Esta acción no se puede deshacer.</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Vista Previa -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Tarea</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <dl class="row">
                    <dt class="col-sm-3">Titulo:</dt>
                    <dd class="col-sm-9" id="previewName"></dd>

                    <dt class="col-sm-3">Descripción:</dt>
                    <dd class="col-sm-9" id="previewDescription"></dd>

                    <dt class="col-sm-3">Estado:</dt>
                    <dd class="col-sm-9" id="previewStatus"></dd>

                    <dt class="col-sm-3">Prioridad:</dt>
                    <dd class="col-sm-9" id="previewPriority"></dd>
                    
                    <dt class="col-sm-3">Fecha Creación:</dt>
                    <dd class="col-sm-9" id="previewCreated"></dd> <!-- Mostrar fecha_creacion -->

                     <dt class="col-sm-3">Fecha Vencimiento:</dt>
                    <dd class="col-sm-9" id="previewDueDate"></dd> 


                    <!-- <dt class="col-sm-3">Creado:</dt>
                    <dd class="col-sm-9" id="previewCreated"></dd> -->
                </dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div> 
 </div>
