init();

function init() {
    obtenerMaquinas();

}

function obtenerMaquinas() {

    tableUsuarios = $('#contenedorCardsMaquinas');
    $.ajax({
        type: 'POST',
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
            '<div class="card mt-3 p-4">'+
            '<div class="card-content">'+
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
        toastr.error('Error al cargar los datos', 'Usuarios');
    } else {
        $.each(JSON.parse(response), function (ID, maquina) {
            table.append(

                '<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 mb-2 mt-2">' +
                '<div class="card h-90 p-1">' +
                '<div class="dropdown bg-light">' +
                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-list"></i>' +
                '</button>' +

                '<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">' +
                '<li class="dropdown-item" onclick="EditarMaquina(' + maquina.ID_maquina + ')" >Editar Maquina</li>' +
                '<li class="dropdown-item" onclick="AsignarAlertaMant(' + maquina.ID_maquina + ')" >Asignar Mantenimiento</li>' +
                '<li class="dropdown-item" onclick="ModalEliminarMaquina(' + maquina.ID_maquina + ',\'' + maquina.nombre_maquina + '\');" >Eliminar Maquina</li>' +
                '</ul>' +

                '<div class="card" >' +
                '<img src="http://tallergeorgio.hopto.org:5613/tallergeorgio/imagenes/maquinas/' + maquina.foto_maquina + '" class="card-img-top" alt="...">' + 
                '<div class="card-body">' +
                '<h3 class="text-center text-primary">' + maquina.nombre_maquina.toUpperCase() + ' </h3>' +
                '<p class="card-text">' + maquina.marca.toUpperCase() + " " + maquina.modelo.toUpperCase() + '</p>' +
                '<p class="card-text">' + maquina.observaciones + '</p>' +
                '</div>' +
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
        /*
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        */
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

    // Verificar si se ha seleccionado un archivo
    if (!file) {
        preview.innerHTML = 'No hay imagen seleccionada';
        return;
    }

    // Verificar si el archivo seleccionado es una imagen
    if (!file.type.match('image.*')) {
        // Limpiar el input de archivo
        fileInput.value = "";
        // Mostrar mensaje de error
        toastr.error("Solo se permiten imágenes");
        return;
    }

    reader.onloadend = function () {
        var img = document.createElement('img');
        img.src = reader.result;
        img.style.maxWidth = '350px';
        img.style.maxHeight = '350px';
        preview.innerHTML = '';
        preview.appendChild(img);
    }

    reader.readAsDataURL(file);
}




function validarTipoArchivo(fileType) {
    var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/jijf'];
    return allowedTypes.includes(fileType);
}




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

/*

function modalEliminarUsuario(idUsuario) {
    $('#modal_eliminar_usuario').modal('show');
    $('#ID_usuario').val(idUsuario);
}

$(document).on("submit", "#form_eliminar_usuario", function (e) {
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
        url: '../../app/Controlador/AdminControlador.php?operador=eliminar_usuario',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Usuario eliminado');
                $('#modal_eliminar_usuario').modal('hide');
                obtenerUsuarios();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});

function modalEditar(ID_usuario) {
    $('#modal_editar_usuario').modal('show');
    $('#form_editar_usuario').trigger('reset');
    $('#ID_usuarioEditar').val(ID_usuario);
    data = {
        'ID_usuario': ID_usuario
    };
    $.ajax({
        data: data,
        type: 'POST',
        url: '../../app/Controlador/AdminControlador.php?operador=obtener_info_usuario',
        success: function (response) {
            usuario = JSON.parse(response);
            $('#editar_nombre_usuario').val(usuario.nombre);
            $('#telefono_usuarioEdit').val(usuario.telefono);
            $('#emailEdit').val(usuario.email);
            $('#empresaEdit').val(usuario.empresa);
            $('#permisosEdit').val(usuario.permisos);



        }
    });
}

$(document).on("submit", "#form_editar_usuario", function (e) {
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
        url: '../../app/Controlador/AdminControlador.php?operador=editar_usuario',
        success: function (response) {
            response = response.trim();
            if (response === 'success') {
                toastr.success('Datos actualizados');
                $('#modal_editar_usuario').modal('hide');
                obtenerUsuarios();
            } else if (response === 'required') {
                toastr.info('Faltan datos');
            } else {
                toastr.error('Error en la operación');
            }
        }
    });
});

function obtenerPassword(ID_usuario) {
    $('#modal_ver_password').modal('show');
    bodyModal = $('#body_modal_password');
    data = {
        'ID_usuario': ID_usuario
    };
    $.ajax({
        data: data,
        type: 'POST',
        url: '../../app/Controlador/AdminControlador.php?operador=ver_password_usuario',
        success: function (response) {
            bodyModal.empty();
            bodyModal.append(
                '<h4 class="text-center">' + response + '</h4>'
            );
        }
    });
}
*/