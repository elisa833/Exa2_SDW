let editar;
let btnEditar = false;

const obtener_datos = () => {
    let tablaProducto = document.getElementById('tabla_alumno');
    fetch("app/controller/obtener_datos.php")
    .then(respuesta => respuesta.json())
    .then((respuesta) => {
        let contenido = ''; 
        respuesta.map((dato) => {
            contenido += `
                <tr>
                    <td>${dato['nombre']}</td>
                    <td>${dato['apellido']}</td>
                    <td>${dato['carrera']}</td>
                    <td>${dato['ingreso']}</td>
                    <td>${dato['nacimiento']}</td>
                    <td>
                        <button class="btn btn-warning me-3 editar" data-btn="editar" data-id="${dato['id_alumno']}" data-nombre="${dato['nombre']}" data-apellido="${dato['apellido']}" data-ingreso="${dato['ingreso']}" data-carrera="${dato['carrera']}" data-nacimiento="${dato['nacimiento']}">
                            Editar
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger eliminar" data-btn="eliminar" data-id="${dato['id_alumno']}">
                            Eliminar
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </td>
                </tr>
            `; 
        });
        tablaProducto.innerHTML = contenido;
    });
}

const registrar_alumno = () => {
    let nombrealumno = document.getElementById('nombre').value;
    let apellidoalumno = document.getElementById('apellido').value;
    let carreralumno = document.getElementById('carrera').value;
    let ingresoalumno = document.getElementById('ingreso').value;
    let nacimientoalumno = document.getElementById('nacimiento').value;

    let data = new FormData();
    data.append("nombre_a", nombrealumno); 
    data.append("apellido_a", apellidoalumno); 
    data.append("carrera_a", carreralumno);
    data.append("ingreso_a", ingresoalumno);
    data.append("nacimiento_a", nacimientoalumno);

    fetch("app/controller/registro_alumno.php", {
        method: "POST",
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({ icon: "success", title: `${respuesta[1]}` });
            obtener_datos();
            limpiarFormulario();
        } else {
            Swal.fire({ icon: "error", title: `${respuesta[1]}` });
        }
    });
}

const editar_alumno = () => {
    let nombre_a = document.getElementById('nombre').value;
    let apellido_a = document.getElementById('apellido').value;
    let ingreso_a = document.getElementById('ingreso').value;
    let carrera_a = document.getElementById('carrera').value;
    let nacimiento_a = document.getElementById('nacimiento').value;

    let data = new FormData();
    data.append('idInput', editar);
    data.append("nombre_a", nombre_a); 
    data.append("apellido_a", apellido_a); 
    data.append("ingreso_a", ingreso_a); 
    data.append("carrera_a", carrera_a); 
    data.append("nacimiento_a", nacimiento_a);

    fetch(`app/controller/actualizar_alumno.php`, {
        method: "POST",
        body: data
    })
    .then(res => res.json())
    .then(async (res) => {
        if (res[0] == 1) {
            await Swal.fire({ icon: "success", title: `${res[1]}` });
            obtener_datos();
            limpiarFormulario();
            btnEditar = false;
            actualizarBotonRegistrar();
        } else {
            Swal.fire({ icon: "error", title: `${res[1]}` });
        }
    });
}

const eliminar_alumno = () => {
    let data = new FormData();
    data.append('idInput', editar);
    fetch('app/controller/eliminar_alumno.php', {
        method: 'POST',
        body: data
    })
    .then(respuesta => respuesta.json())
    .then(async respuesta => {
        if (respuesta[0] == 1) {
            await Swal.fire({ icon: "success", title: `${respuesta[1]}` });
            obtener_datos();
        } else {
            await Swal.fire({ icon: "error", title: `${respuesta[1]}` });
        }
    });
}

const limpiarFormulario = () => {
    document.getElementById('nombre').value = '';
    document.getElementById('apellido').value = '';
    document.getElementById('ingreso').value = '';
    document.getElementById('carrera').value = '';
    document.getElementById('nacimiento').value = '';
}

const actualizarBotonRegistrar = () => {
    const btnRegistrar = document.getElementById('btn-registrar-alumno');
    btnRegistrar.classList.remove('editar_alumno');
    btnRegistrar.classList.add('registrar_alumno');
    btnRegistrar.textContent = 'Registrar Alumno';
}

document.addEventListener('DOMContentLoaded', () => {
    obtener_datos();
});

document.getElementById('btn-registrar-alumno').addEventListener('click', () => {
    if (!btnEditar) {
        registrar_alumno();
    } else {
        editar_alumno();
    }
});

document.getElementById('tabla_alumno').addEventListener('click', (e) => {
    if (e.target.classList.contains('editar')) {
        document.getElementById('nombre').value = e.target.dataset.nombre;
        document.getElementById('apellido').value = e.target.dataset.apellido;
        document.getElementById('ingreso').value = e.target.dataset.ingreso;
        document.getElementById('carrera').value = e.target.dataset.carrera;
        document.getElementById('nacimiento').value = e.target.dataset.nacimiento;

        const btnRegistrar = document.getElementById('btn-registrar-alumno');
        btnRegistrar.classList.remove('registrar_alumno');
        btnRegistrar.classList.add('editar_alumno');
        btnRegistrar.textContent = 'Editar Alumno';

        editar = e.target.dataset.id;
        btnEditar = true;
    }
    if (e.target.classList.contains('eliminar')) {
        Swal.fire({
            icon: "warning",
            text: "¿Estás seguro de eliminar este alumno?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sí, eliminar alumno"
        }).then((result) => {
            if (result.isConfirmed) {
                editar = e.target.dataset.id;
                eliminar_alumno();
            }
        });
    }
});
