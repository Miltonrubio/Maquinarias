init();

function init() {
    obtenerSolicitudes();

}

function obtenerSolicitudes(busqueda = '') {

    tableSolicitudes = $('#bodyTableSolicitudes');
    if (busqueda == '') {
        $.ajax({
            type: 'POST',
            url: '../../app/Controlador/inventariosControlador.php?operador=obtener_solicitudes',
            success: function (response) {
                $('#inputBusquedaUsuarios').val('');
                procesarRespuestaSolicitudes(response, tableSolicitudes);
            }
        });
    } else {
        console.log(busqueda);
    }
}

function procesarRespuestaSolicitudes(response, table) {
    table.empty();
    if (response.trim() == 'no-data') {
        toastr.info('No hay datos para mostrar');
    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Solicitudes');
    } else {
        $.each(JSON.parse(response), function (ID_solicitud, solicitudes) {
            var observaciones = solicitudes.observaciones ? solicitudes.observaciones : "No hay observaciones";
            var botonRechazar = solicitudes.status_solicitud === 'Pendiente' ? '<button type="button" class="btn btn-danger btn-sm m-1" onclick="modalRechazarSolicitud(' + solicitudes.ID_solicitud + ', \'' + solicitudes.tarjeta + '\');"> <i class="bi bi-x-octagon-fill">' + ' ' + 'Rechazar</i></button>' : '';
            var botonEntregar = solicitudes.status_solicitud === 'Pendiente' ? '<button type="button" class="btn btn-success btn-sm m-1" onclick="modalEntregarSolicitud(' + solicitudes.ID_solicitud + ');"><i class="bi bi-check-circle-fill">' + ' ' + 'Entregar</i></button>' : '';
            var botonEvidencias = solicitudes.status_solicitud === 'Entregado' ? '<button type="button" class="btn btn-primary btn-sm m-1" onclick="modalAnexarEvidencias(' + solicitudes.ID_solicitud + ');"><i class="bi bi-image">' + ' ' + ' Evidencias </i></button>' : '';
            var botonRestaurar = solicitudes.status_solicitud === 'Rechazado' ? '<button type="button" class="btn btn-info btn-sm m-1"  onclick="modalRestaurarSolicitud(' + solicitudes.ID_solicitud + ');"><i class="bi bi-shield-fill-check">' + ' ' + ' Restaurar </i></button>' : '';

            table.append(
                '<tr >' +
                '<td>' + solicitudes.fecha_solicitud + '</td>' +
                '<td>' + solicitudes.tarjeta + '</td>' +
                '<td>' + solicitudes.fecha_requerido + ' ' + solicitudes.hora_requerido + '</td>' +
                '<td>' + solicitudes.nombre + '</td>' +
                '<td>' + solicitudes.empresa + '</td>' +
                '<td>' + observaciones + '</td>' +
                '<td class="status' + solicitudes.status_solicitud + '">' + solicitudes.status_solicitud + '</td>' +
                '<td>' +
                botonEntregar +
                botonEvidencias +
                botonRechazar +
                botonRestaurar +
                '</td>' +
                '</tr>'
            );
        });
    }
}






function modalAnexarEvidencias(ID_solicitud) {
    $('#modal_anexar_evidencias').modal('show');

    $('#ID_solicitudEvi').val(ID_solicitud);

    obtenerEvidencias(ID_solicitud);

}

function obtenerEvidencias(ID_solicitud, busqueda = '') {
    contenedorEvidencias = $('#bodyEvidencias');
    $.ajax({
        type: 'POST',
        url: '../../app/Controlador/inventariosControlador.php?operador=obtener_evidencias',
        data: { ID_solicitud: ID_solicitud }, // Aquí pasamos los datos
        success: function (response) {
            procesarRespuestaEvidencias(response, contenedorEvidencias);
        }
    });
}

/*
function procesarRespuestaEvidencias(response, contenedorEvidencias) {
    contenedorEvidencias.empty();
    if (response.trim() == 'no-data') {
        contenedorEvidencias.append(
            '<div class="col-md-12 col-md-12 col-sm-12 mb-4">' +
            '<h5> No se han anexado Evidencias.</h5>' +
        '</div>'
        );

    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Tarjetas');
    } else {
        $.each(JSON.parse(response), function (ID_evidencias, evidencias) {
       
            contenedorEvidencias.append(
                '<div class="col-md-12 col-md-6 col-sm-12 mb-4">' +
                '<img class="img-fluid" heigth="auto" src="../../evidencias/' + evidencias.ruta_evidencia + '">' +
            '</div>'
            );
        });
    }
}
*/

function procesarRespuestaEvidencias(response, contenedorEvidencias) {
    contenedorEvidencias.empty();
    if (response.trim() == 'no-data') {
        contenedorEvidencias.append(
            '<div class="col-md-12 col-md-12 col-sm-12 mb-4">' +
            '<h5> No se han anexado Evidencias.</h5>' +
            '</div>'
        );

    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Tarjetas');
    } else {
        $.each(JSON.parse(response), function (ID_evidencia, evidencias) {
            var extension = evidencias.ruta_evidencia.split('.').pop().toLowerCase();
            if (extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'jfif') {
                contenedorEvidencias.append(
                    '<div class="col-md-12 col-md-6 col-sm-12 mb-4 cardanimation">' +
                    '<img class="img-fluid" height="auto" src="../../evidencias/' + evidencias.ruta_evidencia + '">' +
                    '<div class="card-content">' +
                    /*   '<h2>Opciones</h2>' + */
                    '</div>' +
                    '<div class="card-overlay">' +
                    '<button type="button" class="btn btn-danger" onClick="modalEliminarEvidencia(' + evidencias.ID_evidencia + ')">Eliminar</button>' +
                    '</div>' +
                    '</div>'
                );
            } else if (extension == 'pdf') {
                contenedorEvidencias.append(
                    '<div class="col-md-12 col-md-6 col-sm-12 mb-4 cardanimation">' +
                    '<embed src="../../evidencias/' + evidencias.ruta_evidencia + '" type="application/pdf" width="100%" height="600px" />' +
                    '<div class="card-content">' +
                    /*   '<h2>Opciones</h2>' + */
                    '</div>' +
                    '<div class="card-overlay">' +
                    '<button type="button" class="btn btn-danger" onClick="modalEliminarEvidencia(' + evidencias.ID_evidencia + ')">Eliminar</button>' +
                    '</div>' +
                    '</div>'
                );
            } else if (extension == 'doc' || extension == 'docx') {
                contenedorEvidencias.append(
                    '<div class="col-md-12 col-md-6 col-sm-12 mb-4 cardanimation">' +
                    '<iframe src="https://view.officeapps.live.com/op/embed.aspx?src=' + encodeURIComponent('../../evidencias/evidencias/' + evidencias.ruta_evidencia) + '" width="100%" height="600px" frameborder="0"></iframe>' +
                    '<div class="card-content">' +
                    /*   '<h2>Opciones</h2>' + */
                    '</div>' +
                    '<div class="card-overlay">' +
                    '<button type="button" class="btn btn-danger" onClick="modalEliminarEvidencia(' + evidencias.ID_evidencia + ')">Eliminar</button>' +
                    '</div>' +
                    '</div>'
                );
            }
        });
    }
}



$(document).on("submit", "#form_anexar_evidencias", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var ID_solicitud = $('#ID_solicitudEvi').val();
    var inputFile = $('#evidencias');
    var fileType = inputFile[0].files[0].type;
    if (!validarTipoArchivo(fileType)) {
        toastr.error('Formato de archivo no válido. Se permiten solo archivos JPEG, PNG, Excel, Word y PDF.');
        return;
    }
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=agregar_evidencias',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se agregó la evidencia');
                obtenerEvidencias(ID_solicitud)
                $('#evidencias').val('');

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});

function validarTipoArchivo(fileType) {
    var allowedTypes = ['image/jpeg', 'image/png', 'application/vnd.ms-excel', 'application/msword', 'application/pdf'];
    return allowedTypes.includes(fileType);
}




function modalEliminarEvidencia(ID_evidencia) {
    $('#modal_eliminar').modal('show');
    $('#ID_elim').val(ID_evidencia);
    $('#textoEliminacion').text('¿Estás seguro de que deseas Eliminar la evidencia #' + ID_evidencia + ' ?');
    $('#tituloEliminacion').text('Eliminar evidencia');
}

$(document).on("submit", "#form_eliminar", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    var ID_solicitud = $('#ID_solicitudEvi').val();

    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=eliminar_evidencia',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se eliminó la evidencia');
                $('#modal_eliminar').modal('hide');
                //     obtenerUsuarios();

                obtenerEvidencias(ID_solicitud);

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});










function modalRechazarSolicitud($ID_solicitud, $tarjeta) {
    $('#modal_rechazar_solicitud').modal('show');
    $('#IDRechazo').val($ID_solicitud);
    $('#confirmacionRechazo').text('¿Estás seguro de que deseas Rechazar la solicitud de ' + $tarjeta + ' ?');
}

$(document).on("submit", "#form_rechazar_solicitud", function (e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=rechazar_solicitud',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se rechazo la solicitud');
                $('#modal_rechazar_solicitud').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});




function modalRestaurarSolicitud(ID_solicitud) {
    $('#modal_restaurar_solicitud').modal('show');
    $('#ID_inventario').val(ID_solicitud);
}

$(document).on("submit", "#form_restaurar_solicitud", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=restaurar_solicitud',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se restauró la solicitud');
                $('#modal_restaurar_solicitud').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});



function modalEntregarSolicitud(ID_solicitud) {
    $('#modal_entregar_solicitud').modal('show');
    $('#ID_inventarioEntregar').val(ID_solicitud);
}

$(document).on("submit", "#form_entregar_solicitud", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    for (var entrada of formData.entries()) {
        console.log(entrada[0] + ': ' + entrada[1]);
    }
    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url: '../../app/Controlador/inventariosControlador.php?operador=entregar_solicitud',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se entregó la solicitud');
                $('#modal_entregar_solicitud').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});
