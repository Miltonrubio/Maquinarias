<div class="modal fade modal-bg-over modal-dialog-scrollable" id="modal_editar_maquina">
    <div class="modal-dialog modal-dialog-centered ">
    
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">EDITAR MAQUINA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_editar_maquina" enctype="multipart/form-data">
                <div class="modal-body">
                    
                <input placeholder="Ingresa el nombre" type="text" class="form-control" name="id_maquinaEdit" id="id_maquinaEdit" hidden>

                    <div class="mb-3">
                        <label for="nombre_maquinaEdit" class="form-label">Nombre * </label>
                        <input placeholder="Ingresa el nombre" type="text" class="form-control" name="nombre_maquinaEdit" id="nombre_maquinaEdit" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto_maquinaEdit" class="form-label">Foto Maquina *</label>
                        <input placeholder="Ingresa alguna observacion" type="file" class="form-control mb-3" name="foto_maquinaEdit" id="foto_maquinaEdit" onchange="previewImageEdit()">
                    </div>
                    <div class="row">
                    <div class="col-12">
                        
                    <div class="prev_imagen container-fluid text-center"  id="prev_imagenEd">
                    </div>
                    </div>
                    </div>

                    <div class="mb-3">
                        <label for="marca_maquinaEdit" class="form-label">Marca *</label>
                        <input placeholder="Ingresa la marca" type="text" class="form-control" name="marca_maquinaEdit" id="marca_maquinaEdit" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo_maquinaEdit" class="form-label">Modelo *</label>
                        <input placeholder="Ingresa el modelo" type="text" class="form-control" name="modelo_maquinaEdit" id="modelo_maquinaEdit" required>
                    </div>

                    <div class="mb-3">
                        <label for="num_serieEdit" class="form-label">No. Serie *</label>
                        <input type="number" required class="form-control" placeholder="Ingresa el numero de serie" name="num_serieEdit" id="num_serieEdit">
                    </div>
                    <div class="mb-3">
                        <label for="observaciones_maqEdit" class="form-label">Observaciones</label>
                        <input placeholder="Ingresa alguna observacion" type="text" class="form-control mb-3" name="observaciones_maqEdit" id="observaciones_maqEdit">
                    </div>

                    <div class="mb-3">
                        <label for="fecha_adquiEdit" class="form-label">Fecha De Adquisición</label>
                        <input placeholder="Ingresa alguna observacion" type="date" class="form-control mb-3" name="fecha_adquiEdit" id="fecha_adquiEdit">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
            </form>
        </div>
    </div>
</div>


