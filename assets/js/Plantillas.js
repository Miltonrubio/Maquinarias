init();

function init(){
    obtenerPlantillas();
}

function obtenerPlantillas(){
    var bodyTablePlantillas =$('#body_table_plantillas');
    $.ajax({
        type : 'GET',
        dataType : 'json',
        url : '../../app/Controlador/ChecksControlador.php?operador=obtener_plantillas_checks', 
        success : function(response){
            bodyTablePlantillas.empty();
            switch (response.response) {
                case 'success':
                    $.each(response.data, function(index, plantilla){
                        bodyTablePlantillas.append(
                            '<tr>' +
                            '<td>' + plantilla.nombre_plantilla + '</td>' +
                            '<td><button type="button" class="btn btn-warning" onclick="modalChecksPlantillas(' + plantilla.ID_plantilla + ');"><span class="mdi mdi-pencil"></span></button></td>' +
                            '</tr>'
                        );
                    });
                    break;
                case 'no-data':
                    bodyTablePlantillas.append(
                        '<tr>' +
                        '<td>Sin datos</td>' +
                        '<td>Sin datos</td>' +
                        '</tr>'
                    );
                    break;
                case 'error':
                    sweetAlert('ERROR', 'Error en la obtencion de los datos, si el error persiste favor de ontactar con soporte', 'error');
                    console.log(response.message);
                    break;
            }
        }
    });
}

function modalAgregarPlantilla(){
    $('#modal_agregar_plantilla_check').modal('show');
    $('#form_agregar_plantilla').trigger('reset');
    $('#preview_img_default').hide();
}

function previewImage(event, querySelector){
	//Recuperamos el input que desencadeno la acción
	const input = event.target;
	//Recuperamos la etiqueta img donde cargaremos la imagen
	$imgPreview = document.querySelector(querySelector);
	// Verificamos si existe una imagen seleccionada
	if(!input.files.length) return
	//Recuperamos el archivo subido
	file = input.files[0];
	//Creamos la url
	objectURL = URL.createObjectURL(file);
	//Modificamos el atributo src de la etiqueta img
	$imgPreview.src = objectURL;
    $imgPreview.style.display = "block";
}

$(document).on("submit", "#form_agregar_plantilla", async function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    var fotoDefaultPlantilla = document.getElementById("input_img_default_plantilla").files[0];
    
    if (!validarExtensiones(fotoDefaultPlantilla)) {
        sweetAlert('Atención!', 'Por favor, selecciona imágenes válidas para todos los campos', 'warning');
        return;
    }

    try {
        const fotoDefaultPlantillaComprimida = await comprimirImagenes(fotoDefaultPlantilla);

        formData.set("img_default", fotoDefaultPlantillaComprimida);
    } catch (error) {
        toastr.error('Error al comprimir la imagen');
        console.log(error);
    }

    $.ajax({
        type: "POST",
        method: "POST",
        dataType: "html",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        url:'../../app/Controlador/ChecksControlador.php?operador=registrar_plantilla',
        success : function(response) {
            response = JSON.parse(response);
            switch (response.response) {
                case 'success':
                    toastr.success('Registro exitoso');
                    $('#modal_agregar_plantilla_check').modal('hide');
                    obtenerPlantillas();
                    break;
                case 'required':
                    toastr.warning('Datos faltantes');
                    break;
                case 'error':
                    sweetAlert('ERROR', 'Error en el registro, si el error persiste favor de contactar con soporte', 'error');
                    console.log(response.message);
                    break;
            }
        }
    });
});

function modalChecksPlantillas(idPlantilla){
    $('#modal_checks_plantilla').modal('show');

    data = {
        'idPlantilla' : idPlantilla
    };

    $.ajax({
        type : 'POST',
        data : data,
        dataType : 'json',
        url : '../../app/Controlador/ChecksControlador.php?operador=obtener_checks_plantilla',
        success : function(response) {
            switch (response.response) {
                case 'success':
                    
                    break;
                case 'no-data':
                    
                    break;
                case 'required':
                    toastr.warning('Datos faltantes para la operación');
                    break;
                case 'error':
                    sweetAlert('ERROR', 'Se produjo un error durante la operación, si el error persiste favor de contactar con soporte', 'error');
                    console.log(response.message);
                    break;
            }
        }
    });
}


//------------------------Funciones Genericas-----------------------------------------------------

function comprimirImagenes(imagen, quality = 0.9) {
    const WIDTH = 800;
    return new Promise((resolve, reject) => {
        let reader = new FileReader();

        reader.readAsDataURL(imagen);

        reader.onload = (event) => {
        const image_url = event.target.result;
        let image = document.createElement('img');
        image.src = image_url;

        image.onload = () => {
            let canvas = document.createElement('canvas');
            let ratio = WIDTH / image.width;
            canvas.width = WIDTH;
            canvas.height = image.height * ratio;

            let context = canvas.getContext('2d');
            context.drawImage(image, 0, 0, canvas.width, canvas.height);

            canvas.toBlob(
            (blob) => {
                let compressedFile = new File([blob], imagen.name, { type: imagen.type });
                resolve(compressedFile);
            },
            'image/jpeg',
            quality
            );
        };
        };

        reader.onerror = (error) => {
        reject(error);
        };
    });
}

function validarExtensiones(file) {
    var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
    return allowedExtensions.test(file.name);
}

function sweetAlert(titulo, mensaje, icono) {
    Swal.fire({
        title: titulo,
        text: mensaje,
        icon: icono,
        timer: 3500
    });
}