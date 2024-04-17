<div class="modal fade modal-bg-over modal-dialog-scrollable" id="modal_agregar_maquina">
    <div class="modal-dialog modal-dialog-centered ">
    
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary">AGREGAR MAQUINA</h5>
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

                    <div class="prev_imagen container-fluid text-center" id="prev_imagen">
                    </div>

                    <div class="mb-3">
                        <label for="marca_maquina" class="form-label">Marca *</label>
                        <input placeholder="Ingresa la marca" type="text" class="form-control" name="marca_maquina" id="marca_maquina" required>
                    </div>
                    <div class="mb-3">
                        <label for="modelo_maquina" class="form-label">Modelo *</label>
                        <input placeholder="Ingresa el modelo" type="text" class="form-control" name="modelo_maquina" id="modelo_maquina" required>
                    </div>

                    <div class="mb-3">
                        <label for="num_serie" class="form-label">No. Serie *</label>
                        <input type="number" required class="form-control" placeholder="Ingresa el numero de telefono" name="num_serie" id="num_serie">
                    </div>
                    <div class="mb-3">
                        <label for="observaciones_maq" class="form-label">Observaciones</label>
                        <input placeholder="Ingresa alguna observacion" type="text" class="form-control mb-3" name="observaciones_maq" id="observaciones_maq">
                    </div>

                    <div class="mb-3">
                        <label for="fecha_adqui" class="form-label">Fecha De Adquisición</label>
                        <input placeholder="Ingresa alguna observacion" type="date" class="form-control mb-3" name="fecha_adqui" id="fecha_adqui">
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




<!--
                    <div class="mb-3">
                        <label for="empresa" class="form-label">Empresa</label>
                        <select class="form-select" name="empresa" id="empresa" required>
                            <option value="" disabled selected>Selecciona una opción...</option>
                            <option value="BITALA">BITALA</option>
                            <option value="CORONA">CORONA</option>
                            <option value="HIDALGO">HIDALGO</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="permisos" class="form-label">Rol</label>
                        <select class="form-select" name="permisos" id="permisos" required>
                            <option value="" disabled selected>Selecciona una opción...</option>
                            <option value="SUPERADMIN">SUPERADMIN</option>
                            <option value="INVENTARIO">INVENTARIO</option>
                            <option value="COMPRADOR">COMPRADOR</option>
                        </select>
                    </div>

-->