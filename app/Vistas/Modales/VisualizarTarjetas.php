<div class="modal fade bd-example-modal-lg modal-bg-over" id="modal_mostrar_tarjetas">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" >PROVEEDORES</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-primary mb-3 ml-auto" onclick="modalAgregarTarjeta()">
                    <i class="bi bi-truck"> Registrar Proveedor</i>
                </button>
                <div class="overflow-auto">
                    <table class="table color-de-texto">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Proveedor</th>
                                <th>Comprador</th>
                                <th>Empresa</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTableTarjetas" class="text-center">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
            </div>
        </div>
    </div>
</div>