<div class="modal fade" tabindex="-1" id="modal_agregar_plantilla_check">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar plantilla</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="form_agregar_plantilla">
                <div class="mb-3">
                    <label for="nombre_maquina" class="form-label">Nombre * </label>
                    <input placeholder="Ingresa el nombre" type="text" class="form-control" name="nombre_plantilla" id="nombre_plantilla" required>
                </div>
                <div class="mb-3">
                    <label for="foto_maquina" class="form-label">Foto Maquina *</label>
                    <input placeholder="Ingresa alguna observacion" type="file" class="form-control mb-3" name="img_default" id="input_img_default_plantilla" onchange="previewImage(event, '#preview_img_default')" required>
                </div>
                <br><img class="mx-auto preview-img" id="preview_img_default" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>