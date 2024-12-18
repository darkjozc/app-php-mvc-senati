//OBTENER RODUCTO JS
//assets/js/producto.js

document.addEventListener('DOMContentLoaded', function(){
    obtenerTarea();
})

async function obtenerTarea() {
    try {
        const respuesta = await fetch('tareas/obtener-todo');
        const resultado = await respuesta.json();
        
        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }

        const tareas = resultado.data;
        console.log(tareas);
        const tbody = document.getElementById('TableTask');
        tbody.innerHTML = '';
        
        tareas.forEach(product => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${product.id_tareas}</td>
                <td>${product.titulo}</td>
                <td>${product.descripcion || '<span class="text-muted">Sin descripción</span>'}</td> 
                <td>${product.completada ? 'Sí' : 'No'}</td>
                <td>${product.prioridad}</td>
                <td>${product.fecha_creacion}</td>
                <td>${product.fecha_vencimiento}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary" onclick="editProduct(${JSON.stringify(product).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarTarea(${product.id_tareas})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
    } catch (error) {
        showAlert('error', 'Error al cargar los productos: ' + error.message);
    }
}

async function crear(){
    try {
        const formData = new FormData();
        
        const titulo = document.getElementById('name').value;
        const descripcion = document.getElementById('description').value;
        const fecha_creacion = document.getElementById('fecha_creacion').value;
        const fecha_vencimiento = document.getElementById('fecha_vencimiento').value;
        const completada = document.getElementById('complet').checked ? 1 : 0;
        const prioridad = document.getElementById('priority').value;

        
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('fecha_creacion', fecha_creacion);
        formData.append('fecha_vencimiento', fecha_vencimiento);
        formData.append('completada', completada);
        formData.append('prioridad', prioridad);

        const respuesta = await fetch('tareas/guardar', {
            method: 'POST',
            body: formData
        });
        const resultado = await respuesta.json();
        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }
        // Cerrar el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();
        // Mostrar mensaje de éxito
        showAlert('success', resultado.message);
        // Recargar la lista de Tipo Documento
        obtenerTarea();
        // Resetear el formulario
        resetForm();   

    } catch (error) {
        showAlert('error', error.message);
    }
}
 
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    alertContainer.appendChild(alertDiv);

    // Auto-cerrar después de 5 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

async function actualizarTarea(){
    try {
        const formData = new FormData();
        const id = document.getElementById('taskId').value;
        const titulo = document.getElementById('name').value;
        const descripcion = document.getElementById('description').value;
        const prioridad = document.getElementById('priority').value;
        const fecha_creacion = document.getElementById('fecha_creacion').value;
        const fecha_vencimiento = document.getElementById('fecha_vencimiento').value;
        const completada = document.getElementById('complet').checked ? 1 : 0; ;

        formData.append('id', id);
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('prioridad', prioridad);
        formData.append('fecha_creacion', fecha_creacion);
        formData.append('fecha_vencimiento', fecha_vencimiento);
        formData.append('completada', completada);


        const response = await fetch('tareas/actualizar', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'error') {
            throw new Error(result.message);
        }

        // Cerrar el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('taskModal'));
        modal.hide();

        // Mostrar mensaje de éxito
        showAlert('success', result.message);

        // Recargar la lista de productos
        obtenerTarea();

        // Resetear el formulario
        resetForm();


    } catch (error) {
        showAlert('error', error.message);
    }
}

async function eliminarTarea(id) {
    try {
        if (!confirm('¿Está seguro de que desea eliminar?')) {
            return;
        }

        const respuesta = await fetch('tareas/eliminar', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_tareas:id })
        });

        const resultado = await respuesta.json();

        if (resultado.status === 'error') {
            throw new Error(resultado.message);
        }

        showAlert('success', resultado.message);
        obtenerTarea();

    } catch (error) {
        showAlert('error', error.message);
    }
}

function editProduct(tareas) {
    console.log(tareas);
    document.getElementById('taskId').value = tareas.id_tareas;
    document.getElementById('name').value = tareas.titulo;
    document.getElementById('description').value = tareas.descripcion;
    document.getElementById('priority').value = tareas.prioridad;
    document.getElementById('fecha_creacion').value = tareas.fecha_creacion;
    document.getElementById('fecha_vencimiento').value = tareas.fecha_vencimiento;
    document.getElementById('complet').value = tareas.completada;
    
    
    // Actualizar título del modal
    document.getElementById('modalTitle').textContent = 'Editar Tarea';
    
    // Abrir el modal
    const modal = new bootstrap.Modal(document.getElementById('taskModal'));
    modal.show();
    }

    function almacenar (){
        if(document.getElementById('taskId').value){
            actualizarTarea();
        }else{
            crear();
        }
    }

    function resetForm() {
        document.getElementById('taskId').value = '';
        document.getElementById('taskForm').reset();
        document.getElementById('modalTitle').textContent = 'Nuevo producto';
    }
    