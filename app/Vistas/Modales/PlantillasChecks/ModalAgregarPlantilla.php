<div class="modal fade modal-bg-over modal-dialog-scrollable" id="modal_agregar_plantilla_check">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">AGREGAR Plantilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_agregar_maquina" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nombre_maquina" class="form-label">Nombre * </label>
                        <input placeholder="Ingresa el nombre" type="text" class="form-control" name="nombre_maquina" id="nombre_maquina" required>
                    </div>

                    <div class="mb-3">
                        <label for="foto_maquina" class="form-label">Foto Maquina *</label>
                        <input placeholder="Ingresa alguna observacion" type="file" class="form-control mb-3" name="foto_maquina" id="foto_maquina" onchange="previewImage()" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>