init();

function init() {
    obtenerSolicitudes();

}

function obtenerSolicitudes(busqueda = '') {

    tableSolicitudes = $('#bodyTableSolicitudes');
    if (busqueda == '') {
        $.ajax({
            type: 'POST',
            url: '../../app/Controlador/compradoresControlador.php?operador=obtener_solicitudes',
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
            var botonEliminar = solicitudes.status_solicitud === 'Pendiente' ? '<button type="button" class="btn btn-danger btn-sm m-1" onclick="modalEliminarSolicitud(' + solicitudes.ID_solicitud + ',\'' + solicitudes.tarjeta + '\');"><i class="bi bi-x-octagon-fill">' + ' ' + 'Eliminar</i></button>' : '';
            var botonEvidencias = solicitudes.status_solicitud === 'Entregado' ? '<button type="button" class="btn btn-info btn-sm m-1" onclick="modalVerEvidencias(' + solicitudes.ID_solicitud + ');"><i class="bi bi-image">' + ' ' + ' Evidencias </i></button>' : '';
            var botonMotivo = solicitudes.status_solicitud === 'Rechazado' ? '<button type="button" class="btn btn-info btn-sm m-1" onclick="modalVerAnomalias(' + solicitudes.ID_solicitud + ');"><i class="bi bi-eye-fill">' + ' ' + ' Motivo </i></button>' : '';

            table.append(
                '<tr >' +
                '<td>' + solicitudes.fecha_solicitud + '</td>' +
                '<td>' + solicitudes.tarjeta + '</td>' +
                '<td>' + solicitudes.fecha_requerido + ' ' + solicitudes.hora_requerido + '</td>' +
                '<td>' + solicitudes.nombre + '</td>' +
                '<td>' + observaciones + '</td>' +
                '<td class="status' + solicitudes.status_solicitud + '">' + solicitudes.status_solicitud + '</td>' +
                '<td>' +
                botonEliminar +
                botonEvidencias +
                botonMotivo +
                '</td>' +
                '</tr>'
            );
        });
    }
}





$(document).ready(function () {

    llenarSelectorCompradores('Agregar');

});


function llenarSelectorCompradores($estado, $ID_comprador) {
    $.ajax({
        type: "GET",
        url: '../../app/Controlador/compradoresControlador.php?operador=obtener_compradores',
        dataType: "json",
        success: function (data) {

            if ($estado === 'Agregar') {

                $('#selectorComprador').empty();
                $('#empresaTarjeta').val('');
                $('#selectorComprador').append('<option value="" selected disabled> Selecciona un comprador </option> ');
                data.forEach(function (comprador) {
                    $('#selectorComprador').append('<option value="' + comprador.ID_comprador + '">' + comprador.nombreComprador + '</option>');

                });

                $('#selectorComprador').change(function () {
                    var selectedValue = $(this).val();
                    var selectedComprador = data.find(function (comprador) {
                        return comprador.ID_comprador == selectedValue;
                    });
                    $('#empresaTarjeta').val(selectedComprador.empresa);
                });

            } else {
                /*
                $('#selectorCompradorEdit').empty();
                $('#empresaTarjetaEdit').val('');
                $('#selectorCompradorEdit').append('<option selected value="" disabled> Selecciona un comprador </option> ');
                data.forEach(function (comprador) {
                    $('#selectorCompradorEdit').append('<option value="' + comprador.ID_comprador + '">' + comprador.nombreComprador + '</option>');

                });

                $('#selectorCompradorEdit').change(function () {
                    var selectedValue = $(this).val();
                    var selectedComprador = data.find(function (comprador) {
                        return comprador.ID_comprador == selectedValue;
                    });

                    $('#empresaTarjetaEdit').val(selectedComprador.empresa);
                });

*/

      $('#selectorCompradorEdit').empty();
                $('#empresaTarjetaEdit').val('');
                $('#selectorCompradorEdit').append('<option value="" disabled>Selecciona un comprador</option>');
                
                data.forEach(function (comprador) {
                    $('#selectorCompradorEdit').append('<option value="' + comprador.ID_comprador + '">' + comprador.nombreComprador + '</option>');
                });
    
                // Establecer el valor seleccionado basado en el ID_comprador proporcionado
                if ($ID_comprador !== '') {
                    $('#selectorCompradorEdit').val($ID_comprador);
                    var selectedComprador = data.find(function (comprador) {
                        return comprador.ID_comprador == $ID_comprador;
                    });
                    $('#empresaTarjetaEdit').val(selectedComprador.empresa);
                }
    
                $('#selectorCompradorEdit').change(function () {
                    var selectedValue = $(this).val();
                    var selectedComprador = data.find(function (comprador) {
                        return comprador.ID_comprador == selectedValue;
                    });
    
                    $('#empresaTarjetaEdit').val(selectedComprador.empresa);
                });



            }
        },
        error: function () {
            toastr.error('Error al obtener los compradores');
        }
    });
}




function modalAgregarTarjeta() {
    $('#form_agregar_tarjeta')[0].reset();
    $('#modal_agregar_tarjeta').modal('show');
}

$(document).on("submit", "#form_agregar_tarjeta", function (e) {
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
        url: '../../app/Controlador/compradoresControlador.php?operador=agregar_tarjeta',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se rechazo la solicitud');
                $('#modal_agregar_tarjeta').modal('hide');
                //     obtenerUsuarios();

                obtenerTarjetas();
                llenarSelectorProvedoresAgregarPedido();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});





function modalEliminarSolicitud(ID_solicitud, tarjeta) {
    $('#modal_eliminar').modal('show');
    $('#ID_elim').val(ID_solicitud);
    $('#tituloEliminacion').text("Eliminar Solicitud");
    $('#textoEliminacion').text("¿Seguro deseas eliminar la solicitud de: " + tarjeta + " ?");


}

$(document).on("submit", "#form_eliminar", function (e) {
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
        url: '../../app/Controlador/compradoresControlador.php?operador=eliminar_solicitud',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se entregó la solicitud');
                $('#modal_eliminar').modal('hide');
                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});







function modalVerAnomalias(ID_solicitud) {
    $('#modal_mostrar_anomalias').modal('show');
    obtenerAnomalias(ID_solicitud);

}

/*
function obtenerAnomalias(busqueda = '') {
    tableAnomalias = $('#bodyTableAnomalias');
    $.ajax({
        type: 'POST',
        url: '../../app/Controlador/compradoresControlador.php?operador=obtener_anomalias?busqueda='+busqueda+'',
        success: function (response) {
            procesarRespuestaAnomalias(response, tableAnomalias);
        }
    });
}
*/
function obtenerAnomalias(ID_solicitud, busqueda = '') {
    tableAnomalias = $('#bodyTableAnomalias');
    $.ajax({
        type: 'POST',
        url: '../../app/Controlador/compradoresControlador.php?operador=obtener_anomalias',
        data: { ID_solicitud: ID_solicitud }, // Aquí pasamos los datos
        success: function (response) {
            procesarRespuestaAnomalias(response, tableAnomalias);
        }
    });
}


function procesarRespuestaAnomalias(response, table) {
    table.empty();
    if (response.trim() == 'no-data') {
        toastr.info('No hay datos para mostrar');
    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Anomalias');
    } else {
        $.each(JSON.parse(response), function (ID_anomalia, anomalias) {
            table.append(
                '<tr>' +
                '<td>' + anomalias.ID_anomalia + '</td>' +
                '<td>' + anomalias.observaciones + '</td>' +
                '<td>' + anomalias.nombre + '</td>' +
                '</tr>'
            );
        });
    }
}




/*

function llenarSelectorCompradoresAgregarPedido() {
    $.ajax({
        type: "GET",
        url: '../../app/Controlador/compradoresControlador.php?operador=obtener_compradores',
        dataType: "json",
        success: function (data) {


            $('#solicitante').empty();
            $('#solicitante').append('<option value="" selected disabled> Selecciona un comprador </option> ');
            data.forEach(function (comprador) {
                $('#solicitante').append('<option value="' + comprador.ID_comprador + '">' + comprador.nombreComprador +' </option>');

            });
        },
        error: function () {
            toastr.error('Error al obtener los compradores');
        }
    });
}
*/


function llenarSelectorProvedoresAgregarPedido() {
    $.ajax({
        type: "GET",
        url: '../../app/Controlador/compradoresControlador.php?operador=obtener_tarjetas',
        dataType: "json",
        success: function (data) {


            $('#proovedorAgendado').empty();
            $('#proovedorAgendado').append('<option value="" selected disabled> Selecciona un proveedor </option> ');
            data.forEach(function (comprador) {
                $('#proovedorAgendado').append('<option value="' + comprador.ID_tarjeta + '">' + comprador.nombre_proveedor + '  </option>');

            });
            $('#proovedorAgendado').change(function () {
                var selectedValue = $(this).val();
                var selectedComprador = data.find(function (comprador) {
                    return comprador.nombre == selectedValue;
                });

                $('#nombreCompradorSeleccionado').val(selectedComprador.nombreComprador);
                $('#solicitante').val(selectedComprador.ID_comprador);
            });


        },
        error: function () {
            toastr.error('Error al obtener los compradores');
        }
    });
}


function modalAgendarPedido() {
    $('#form_agendar_pedido')[0].reset();
    $('#modal_agendar_pedido').modal('show');
    //  llenarSelectorCompradoresAgregarPedido();
    llenarSelectorProvedoresAgregarPedido();
}

$(document).on("submit", "#form_agendar_pedido", function (e) {
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
        url: '../../app/Controlador/compradoresControlador.php?operador=agendar_pedido',

        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se agendó el pedido');
                $('#modal_agendar_pedido').modal('hide');
                //     obtenerUsuarios();

                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else if (response === 'fechamenor') {
                toastr.info('No puedes ingresar una fecha anterior');
            } else if (response === 'horamenor') {
                toastr.info('No puedes ingresar una hora anterior');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});





function modalVerTarjetas() {
    $('#modal_mostrar_tarjetas').modal('show');
    obtenerTarjetas();

}

function obtenerTarjetas(busqueda = '') {
    tableTarjetas = $('#bodyTableTarjetas');
    $.ajax({
        type: 'POST',
        url: '../../app/Controlador/compradoresControlador.php?operador=obtener_tarjetas',
        success: function (response) {
            procesarRespuestaTarjetas(response, tableTarjetas);
        }
    });
}


function procesarRespuestaTarjetas(response, table) {
    table.empty();
    if (response.trim() == 'no-data') {
        toastr.info('No hay datos para mostrar');
    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Tarjetas');
    } else {
        $.each(JSON.parse(response), function (ID_tarjeta, tarjetas) {
            var botonEditar = '<button type="button" class="btn btn-info btn-sm m-1" onclick="modalEditarTarjeta('+ tarjetas.ID_comprador+',' + tarjetas.ID_tarjeta + ',\'' + tarjetas.nombre_proveedor + '\');"> <i class="bi bi-pen"></i></button>';
            var botonEliminar = '<button type="button" class="btn btn-danger btn-sm m-1" onclick="modalEliminarProveedor(' + tarjetas.ID_tarjeta + ',\'' + tarjetas.nombre_proveedor + '\');"> <i class="bi bi-x-octagon-fill"></i></button>';

            table.append(
                '<tr>' +
                '<td>' + tarjetas.nombre_proveedor + '</td>' +
                '<td> ' + tarjetas.nombreComprador + ' </td>' +
                '<td> ' + tarjetas.empresa + ' </td>' +
                '<td>' +
                botonEditar +
                botonEliminar +
                '</td>' +
                '</tr>'
            );
        });
    }
}




function modalEditarTarjeta( $ID_comprador, $ID_tarjeta, $nombre_proveedor) {
    llenarSelectorCompradores('Editar', $ID_comprador);
    $('#modal_editar_tarjeta').modal('show');
    $('#ID_tarjetaEdit').val($ID_tarjeta);
    $('#EditnombreTarjeta').val($nombre_proveedor);
}

$(document).on("submit", "#form_editar_tarjeta", function (e) {
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
        url: '../../app/Controlador/compradoresControlador.php?operador=editar_tarjeta',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se rechazo la solicitud');
                $('#modal_editar_tarjeta').modal('hide');
                //     obtenerUsuarios();

                obtenerTarjetas();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});







function modalEliminarProveedor(ID_tarjeta, nombre_proveedor) {
    $('#modal_eliminar_proveedor').modal('show');
    $('#ID_elim_proveedor').val(ID_tarjeta);
    $('#nombre_proveedor').text("¿Seguro deseas eliminar el proveedor: " + nombre_proveedor + " ?");

}

$(document).on("submit", "#form_eliminar_proveedor", function (e) {
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
        url: '../../app/Controlador/compradoresControlador.php?operador=eliminar_proveedor',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se entregó la solicitud');
                $('#modal_eliminar_proveedor').modal('hide');
                //     obtenerUsuarios();
                obtenerTarjetas();
                obtenerSolicitudes();

            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});










function modalVerEvidencias(ID_solicitud) {
    $('#modal_mostrar_evidencias').modal('show');
    obtenerEvidencias(ID_solicitud);

}

function obtenerEvidencias(ID_solicitud, busqueda = '' ) {
    contenedorEvidencias = $('#bodyEvidencias');
    $.ajax({
        type: 'POST',
        url: '../../app/Controlador/compradoresControlador.php?operador=obtener_evidencias',
        data: { ID_solicitud: ID_solicitud }, // Aquí pasamos los datos
        success: function (response) {
            procesarRespuestaEvidencias(response, contenedorEvidencias);
        }
    });
}


function procesarRespuestaEvidencias(response, contenedorEvidencias) {
    contenedorEvidencias.empty();
    if (response.trim() == 'no-data') {
        contenedorEvidencias.append(
            '<div class="col-md-12 col-md-12 col-sm-12 mb-4">' +
            '<h5> No se anexaron Evidencias.</h5>' +
        '</div>'
        );

    } else if (response.trim() == 'error') {
        toastr.error('Error al cargar los datos', 'Tarjetas');
    } else {
        $.each(JSON.parse(response), function (ID_evidencias, evidencias) {
       
            contenedorEvidencias.append(
                '<div class="col-md-12 col-md-6 col-sm-12 mb-4">' +
                '<img class="img-fluid" src="../../evidencias/' + evidencias.ruta_evidencia + '">' +
            '</div>'
            );
        });
    }
}