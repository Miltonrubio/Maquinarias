<div class="modal fade modal-bg-over" id="modal_editar_tarjeta">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">EDITAR PROVEEDOR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_editar_tarjeta" enctype="multipart/form-data">

                <div class="mb-3">
                        <input type="text" class="form-control" id="ID_tarjetaEdit" name="ID_tarjetaEdit"  hidden>
                    </div>

                    <div class="mb-3">
                        <label for="EditnombreTarjeta" class="form-label">Nombre de proveedor </label>
                        <input type="text" class="form-control" id="EditnombreTarjeta" name="EditnombreTarjeta" placeholder="Proveedor" required>
                    </div>

                    <div class="mb-3">
                        <label for="selectorCompradorEdit" class="form-label">Nombre de comprador </label>
                        <select class="form-control" id="selectorCompradorEdit" name="selectorCompradorEdit" required> 

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="empresaTarjetaEdit" class="form-label">Empresa </label>
                        <input type="text" class="form-control" id="empresaTarjetaEdit" name="empresaTarjetaEdit" placeholder="primero debes seleccionar un comprador" disabled>
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