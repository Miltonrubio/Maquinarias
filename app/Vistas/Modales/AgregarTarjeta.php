<div class="modal fade modal-bg-over" id="modal_agregar_tarjeta">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">REGISTRAR PROVEEDOR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_agregar_tarjeta" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nombreTarjeta" class="form-label">Nombre de proovedor </label>
                        <input type="text" class="form-control" id="nombreTarjeta" name="nombreTarjeta" placeholder="Proveedor" required>
                    </div>

                    <div class="mb-3">
                        <label for="selectorComprador" class="form-label">Nombre de comprador </label>
                        <select class="form-control" id="selectorComprador" name="selectorComprador" required> 

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="empresaTarjeta" class="form-label">Empresa </label>
                        <input type="text" class="form-control" id="empresaTarjeta" name="empresaTarjeta" placeholder="Primero debes seleccionar un comprador" disabled>
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