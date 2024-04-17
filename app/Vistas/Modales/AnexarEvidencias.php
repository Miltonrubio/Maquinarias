<div class="modal fade bd-example-modal-lg modal-bg-over" id="modal_anexar_evidencias">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">EVIDENCIAS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body ">
                <div class="row cardsmarketing" id="bodyEvidencias">
                </div>


            </div>


            <form id="form_anexar_evidencias" enctype="multipart/form-data">
                <div class="modal-footer">

                <input class="form-control" type="text" name="ID_solicitudEvi" id="ID_solicitudEvi" hidden>

                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-7 ">
                                <input class="form-control" type="file" name="evidencias" id="evidencias" required>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary" type="submit" name="mandarEvidencias" id="mandarEvidencias"> Enviar </button>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cerrar</button>
                            </div>

                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>