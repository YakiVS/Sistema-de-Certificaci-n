<div id="modalmantenimiento" class="modal fade" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 id="lbltitulo" class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Nuevo Registro</h6>
            </div>
            
            <!-- Formulario Mantenimiento -->
            <form method="post" id="detalle_form">
                <div class="modal-body">

                    <input type="hidden" name="curd_id" id="curd_id" />
                    
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Curso: <span class="tx-danger">*</span></label>
                            <select class="form-control select2" style="width:100%" name="cur_id" id="cur_id" data-placeholder="Seleccione">
                                <option label="Seleccione"></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label"> DNI: <span class="tx-danger">*</span></label>
                            <input class="form-control tx-uppercase" id="usu_dni" type="text" name="usu_dni" required />
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Nota: <span class="tx-danger">*</span></label>
                            <input class="form-control tx-uppercase" id="curd_nota" type="text" name="curd_nota" required />
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label">Fecha Emision: <span class="tx-danger">*</span></label>
                            <input class="form-control tx-uppercase" id="curd_fechemi" type="date" name="curd_fechemi" required />
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" name="action" value="add" class="btn btn-outline-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium"><i class="fa fa-check"></i> Guardar</button>
                    <button type="reset" class="btn btn-outline-secondary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" aria-label="Close" aria-hidden="true" data-dismiss="modal"><i class="fa fa-close"></i> Cancelar</button>
                </div>
            </form>
        </div>
    </div>

</div>