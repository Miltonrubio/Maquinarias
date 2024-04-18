init();

function init() {
    obtenerMaquinas();

}


document.addEventListener("DOMContentLoaded", function () {
    const buscador = document.getElementById("buscadorMaquinas");

    buscador.addEventListener("input", function () {
        obtenerMaquinas();
    });
});



function obtenerMaquinas() {

    var filtro = document.getElementById("buscadorMaquinas");
    var data = {"buscadorMaquinas": filtro.value };

    tableUsuarios = $('#contenedorCardsMaquinas');
    $.ajax({
        type: 'POST',
        data: data,
        url: '../../app/Controlador/MaquinasControlador.php?operador=obtener_maquinas',
        success: function (response) {
            //     $('#inputBusquedaUsuarios').val('');
            procesarRespuestaMaquinas(response, tableUsuarios);
        }
    });
}

function procesarRespuestaMaquinas(response, table) {
    table.empty();
    if (response.trim() == 'no-data') {
        table.append(

            '<div class="container"> ' +
            '<div class="text-center">' +
            '<div class="card mt-3 p-4">' +
            '<div class="card-content">' +
            '<div  class="container" id="lottieSinMaquinasReg" name="lottieSinMaquinasReg"  style="height: 350px; width: 350px; z-index:999;">' +
            '</div>' +
            '<H4> NO SE HAN REGISTRADO MAQUINAS </H4>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );


        const animationContainer = document.getElementById('lottieSinMaquinasReg');
        const animationOptions = {
            container: animationContainer,
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '../../assets/img/lotties/no_maquinas.json'
        };


        const anim = lottie.loadAnimation(animationOptions);



    } else if (response.trim() == 'error') {
        table.append(

            '<div class="container"> ' +
            '<div class="text-center">' +
            '<div class="card mt-3 p-4">' +
            '<div class="card-content">' +
            '<div  class="container" id="lottieSinMaquinasEncontradas" name="lottieSinMaquinasEncontradas"  style="height: 350px; width: 350px; z-index:999;">' +
            '</div>' +
            '<H4> NO SE HAN ENCONTRARON RESULTADOS </H4>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );


        const animationContainer = document.getElementById('lottieSinMaquinasEncontradas');
        const animationOptions = {
            container: animationContainer,
            renderer: 'svg',
            loop: true,
            autoplay: true,
            path: '../../assets/img/lotties/noresultados.json'
        };


        const anim = lottie.loadAnimation(animationOptions);





    } else {
        $.each(JSON.parse(response), function (ID, maquina) {
            table.append(

                '<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-2 mt-2">' +
                '<div class="card h-100 p-1">' +
                '<div class="dropdown bg-light">' +
                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-list"></i>' +
                '</button>' +

                '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">' +
                '<li class="dropdown-item" onclick="modalEditarMaquina(' + maquina.ID_maquina + ',\'' + maquina.nombre_maquina + '\'' + ',\'' + maquina.marca + '\'' + ',\'' + maquina.modelo + '\'' + ',\'' + maquina.observaciones + '\'' + ',\'' + maquina.foto_maquina + '\'' + ',\'' + maquina.fecha_compra + '\' , ' + maquina.nserie + ' )" >Editar Maquina</li>' +
                '<li class="dropdown-item" onclick="modalAsignarAlarma(' + maquina.ID_maquina + ',\'' + maquina.nombre_maquina + '\')" >Asignar Mantenimiento</li>' +
                '<li class="dropdown-item" onclick="CrearChecks(' + maquina.ID_maquina + ')" >Crear Checks</li>' +
                '<li class="dropdown-item" onclick="CrearChecks(' + maquina.ID_maquina + ')" >Generar PDF de revisiones</li>' +
                '<li class="dropdown-item" onclick="ModalEliminarMaquina(' + maquina.ID_maquina + ',\'' + maquina.nombre_maquina + '\');" >Eliminar Maquina</li>' +
                '</ul>' +

                '<div class="bg-white" >' +
                '<img src="http://tallergeorgio.hopto.org:5613/tallergeorgio/imagenes/maquinas/' + maquina.foto_maquina + '" class="card-img-top" alt="...">' +
                '<div class="card-body">' +
                '<h3 class="text-center text-primary">' + maquina.nombre_maquina.toUpperCase() + ' </h3>' +

                '<div class="col-md-12">'+

                '<div class="row ">'+
                '<div class="col-md-6 text-center p-2 bg-primary">'+
                '<p class="card-text text-white "> Marca: ' + maquina.marca.toUpperCase()  + '</p>' +
                '</div>' +
                '<div class="col-md-6 text-center p-2 bg-success">'+
                '<p class="card-text text-white  "> Modelo: ' + maquina.modelo.toUpperCase() + '</p>' +
                '</div>' +
                '</div>' +


                '<p class="card-text text-dark">' + maquina.observaciones + '</p>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '</div>'
                
                /*
                '<tr>'+
                '<td>'+usuario.nombre_usuario+'</td>'+
                '<td>'+usuario.telefono+'</td>'+
                '<td>'+usuario.empresa+'</td>'+
                '<td>'+usuario.rol_usuario+'</td>'+
                '<td>'+
                '<button type="button" class="btn btn-success btn-sm m-1" onclick="modalEditar('+usuario.ID_usuario+');"> <i class="bi bi-pen"></i></button>'+
                '<button type="button" class="btn btn-warning btn-sm m-1" onclick="obtenerPassword('+usuario.ID_usuario+');"> <i class="bi bi-eye-fill"></i></button>'+
                '<button type="button" class="btn btn-danger btn-sm m-1" onclick="modalEliminarUsuario('+usuario.ID_usuario+');"> <i class="bi bi-person-x-fill"></i></button>'+
                '</td>'+
                '</tr>'
            */
            );
        });
    }
}

function ModalEliminarMaquina(ID_maquina, nombre_maquina) {

    Swal.fire({
        title: "¿Estas seguro?",
        text: "¿ Deseas eliminar la maquina " + nombre_maquina + " ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Cancelar",
        cancelButtonColor: "#d33",
        confirmButtonText: "Aceptar",
        reverseButtons: true
    }).then((result) => {
        if (result.value) {

            setTimeout(function () {
                EliminarMaquina(ID_maquina, nombre_maquina);
            }, 1600); //
        }
    });

}


function EliminarMaquina(ID_maquina, nombre_maquina) {

    var data = { "ID_maquina": ID_maquina };

    $.ajax({
        type: "POST",

        data: data,

        url: '../../app/Controlador/MaquinasControlador.php?operador=eliminar_maquina',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se eliminó la maquina ' + nombre_maquina);
                obtenerMaquinas();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error(response);
            }
        }
    });

}





function previewImage() {
    var preview = document.getElementById('prev_imagen');
    var fileInput = document.getElementById('foto_maquina');
    var file = fileInput.files[0];
    var reader = new FileReader();

    if (!file) {
        preview.innerHTML = 'No hay imagen seleccionada';
        return;
    }

    if (!file.type.match('image.*')) {
        fileInput.value = "";
        toastr.error("Solo se permiten imágenes");
        return;
    }

    reader.onloadend = function () {
        var img = document.createElement('img');
        img.src = reader.result;
        img.style.maxWidth = '100%';
        img.style.maxHeight = '100%';
        preview.innerHTML = '';
        preview.appendChild(img);
    }

    reader.readAsDataURL(file);
}


function previewImageEdit() {
    var preview = document.getElementById('prev_imagenEd');
    var fileInput = document.getElementById('foto_maquinaEdit');
    var file = fileInput.files[0];
    var reader = new FileReader();

    if (!file) {
        preview.innerHTML = 'No hay imagen seleccionada';
        return;
    }

    if (!file.type.match('image.*')) {
        fileInput.value = "";
        toastr.error("Solo se permiten imágenes");
        return;
    }

    reader.onloadend = function () {
        var img = document.createElement('img');
        img.src = reader.result;
        img.style.maxWidth = '100%';
        img.style.maxHeight = '100%';
        preview.innerHTML = '';
        preview.appendChild(img);
    }

    reader.readAsDataURL(file);
}




function modalEditarMaquina(ID_maquina, nombre_maquina, marca, modelo, observaciones, foto_maquina, fecha_compra, nserie) {
    $('#modal_editar_maquina').modal('show');
    $('#form_agregar_maquina').trigger('reset');
    $('#nombre_maquinaEdit').val(nombre_maquina);
    $('#id_maquinaEdit').val(ID_maquina);
    $('#marca_maquinaEdit').val(marca);
    $('#modelo_maquinaEdit').val(modelo);
    $('#num_serieEdit').val(nserie);
    $('#observaciones_maqEdit').val(observaciones);
    $('#fecha_adquiEdit').val(fecha_compra);


    var preview = $('#prev_imagenEd');
    preview.html(
        '<img src="http://tallergeorgio.hopto.org:5613/tallergeorgio/imagenes/maquinas/' + foto_maquina + '" heigh="225px"  width="225px" >'
    );
}


$(document).on("submit", "#form_editar_maquina", function (e) {
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
        url: '../../app/Controlador/MaquinasControlador.php?operador=editor_maquina',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Se editó la maquina');
                $('#modal_editar_maquina').modal('hide');
                obtenerMaquinas();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error(response);
            }
        }
    });
})













function modalAgregarMaquina() {
    $('#prev_imagen').empty();
    $('#modal_agregar_maquina').modal('show');
    $('#form_agregar_maquina').trigger('reset');
}

$(document).on("submit", "#form_agregar_maquina", function (e) {

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
        url: '../../app/Controlador/MaquinasControlador.php?operador=registrar_maquina',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Registro exitoso');
                $('#modal_agregar_maquina').modal('hide');
                obtenerMaquinas();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error(response);
            }
        }
    });
})





function modalAsignarAlarma(ID_maquina, nombre_maquina) {
    $('#modal_alarma_mantenimiento').modal('show');
    $('#form_alarma_mantenimiento').trigger('reset');

}