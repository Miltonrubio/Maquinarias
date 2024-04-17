<div class="modal fade modal-bg-over" id="modal_rechazar_solicitud">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rechazar solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_rechazar_solicitud" enctype="multipart/form-data">

                    <div class="mb-3">
                        <input type="text" id="IDRechazo" name="IDRechazo" hidden>
                        <p id="confirmacionRechazo"></p>
                    </div>

                    <div class="mb-3">
                        <label for="motivoRechazo" class="form-label">Agrega el motivo del rechazo</label>
                        <input placeholder="Ingresa el nombre" type="text" class="form-control" name="motivoRechazo" id="motivoRechazo" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                <button type="submit" class="btn btn-primary">Aceptar</button>
            </div>
            </form>
        </div>
    </div>
</div>