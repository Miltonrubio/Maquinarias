<div class="modal fade" id="modal_agendar_pedido">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" >AGENDAR SOLICITUD</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_agendar_pedido" enctype="multipart/form-data">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="fechaAgendada" class="form-label">Fecha de Entrega </label>
                                <input type="date" class="form-control" id="fechaAgendada" name="fechaAgendada" required>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="horaAgendada" class="form-label">Hora de Entrega </label>
                                <input type="time" class="form-control" id="horaAgendada" name="horaAgendada" required>
                            </div>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="proovedorAgendado" class="form-label">Proveedor: </label>
                    </div>


                    <div class="row">
                        <div class="mb-3 col-md-10">
                            <select class="form-control" id="proovedorAgendado" name="proovedorAgendado" required></select>
                        </div>
                        <div class="mb-3 col-md-2">
                            <button class="btn btn-primary" type="button" onclick="modalAgregarTarjeta()"> + </button>
                        </div>
                    </div>



                    <div class="mb-3">
                        <label for="solicitante" class="form-label">Solicita: </label>

                        <input type="text" class="form-control" id="nombreCompradorSeleccionado" name="nombreCompradorSeleccionado" placeholder="Debes seleccionar un proovedor" disabled>
                        <input type="text" class="form-control" id="solicitante" name="solicitante" placeholder="Debes seleccionar un proovedor" hidden>

                    </div>



                    <div class="mb-3">
                        <label for="textObservaciones" class="form-label">Observaciones </label>
                        <input type="text" class="form-control" id="textObservaciones" name="textObservaciones" placeholder="Separar lacteos, agregar existencias, etc.">
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