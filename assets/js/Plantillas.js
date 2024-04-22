init();

function init(){

}

function obtnerPlantillas(){
    $.ajax({
        type : 'GET',
        dataType : 'json',
        url : '../../app/Controlador/ChecksControlador.php?operador=obtener_plantillas_checks', 
        success : function(response){
            switch (response.response) {
                case 'success':
                    
                    break;
                case 'no-data':
                    
                    break;
                case 'error':
                    
                    break;
            }
        }
    });
}

function modalAgregarPlantilla(){
    $('#modal_agregar_plantilla_check').modal('show');
}