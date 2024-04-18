<div class="modal fade bd-example-modal-lg modal-bg-over" id="modal_alarma_mantenimiento">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="tituloGaveta">ASIGNACIÓN DE ALARMA DE INVENTARIOS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="form_alarma_mantenimiento" enctype="multipart/form-data">

                <input type="text" id="id_oculto_alarma" name="id_oculto_alarma" hidden>

                <div class="modal-body">

                    <div class="container">
                        
                    <label for="numAlarmaInventario" class="text-left mb-3">ingresa la frecuencia con la que te gustaria recibir la alarma de mantenimiento</label>
                        <div class="row mt-2">
                            
                            <div class="col-md-3 align-middle">

                                <input type="number" class="form-control mb-2" id="numAlarmaInventario" name="numAlarmaInventario" value="7" required>
                            </div>


                            <div class="col-md-3 align-middle">
                                <select id="select_frecuencia" class="form-control">
                                    <option value="dias" selected>Dia(s)</option>
                                    <option value="semanas">Semana(s)</option>
                                    <option value="meses">Mes(es)</option>
                                </select>
                            </div>

                            <div class="col-md-6 align-middle">
                                <p> entre cada revision de inventario</p>

                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Asignar</button>

                </div>

            </form>

        </div>
    </div>
</div>