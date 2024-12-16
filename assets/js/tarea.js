//OBTENER RODUCTO JS
//assets/js/producto.js

document.addEventListener('DOMContentLoaded', function(){
    alert('juan josue');
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
             <!-- falta aqui -->
                <td>${new Date(document.fecha_creacion).toLocaleString()}</td> <!-- Mostrar fecha_creacion -->
                <td>${document.fecha_vencimiento ? new Date(document.fecha_vencimiento).toLocaleString() : 'Sin fecha de vencimiento'}</td> <!-- Mostrar fecha_vencimiento -->
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-primary" onclick="editProduct(${product.id_tareas}, ${JSON.stringify(product).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteProduct(${product.id_tareas})">
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