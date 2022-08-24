<div class="modal fade" id="modalNotaSecuestro" tabindex="-1" role="dialog"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#299CBD">
                <h5 class="modal-title"><b>DETALLE COMPLETO DE LA NOTA DE SECUESTRO</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="background-color:#f2f4f7">
                <div class="row">
                    <div class="col-md-3" style="text-align: left;">
                        <label>NOTA</label>
                        <p>{{$secuestro->nro_nota}}</p>
                    </div>
                    <div class="col-md-3" style="text-align: center;">
                        <label>FECHA NOTA</label>
                        <p>{{date("d-m-Y",strtotime($secuestro->fecha_nota_sec))}}</p>
                    </div>
                    <div class="col-md-3" style="text-align: center;">
                        <label>FECHA CARGA</label>
                        <p>{{date("d-m-Y",strtotime($secuestro->fecha_carga_sec))}}</p>
                    </div>
                    <div class="col-md-3" style="text-align: right;">
                        <label>USUARIO CARGA</label>
                        <p>{{$secuestro->usuario_carga->name}}</p>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-md-4" style="text-align: left;">
                        <label>IMPUTADO</label>
                        <p>{{$secuestro->imputado}}</p>
                    </div>
                    <div class="col-md-4" style="text-align: center;">
                        <label>DETENIDO</label>
                        <p>{{$secuestro->detenido}}</p>
                    </div>
                    <div class="col-md-4" style="text-align: right;">
                        <label>VICTIMA</label>
                        <p>{{$secuestro->victima}}</p>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-4" style="text-align: left;">
                        <label>SUMARIANTE</label>
                        <p>{{$secuestro->sumariante}}</p>
                    </div>
                    <div class="col-md-4" style="text-align: center;">
                        <label>FISCAL</label>
                        <p>{{$secuestro->fiscal}}</p>
                    </div>
                    <div class="col-md-4" style="text-align: right;">
                        <label>JUZGADO</label>
                        <p>{{$secuestro->juzgado}}</p>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-6" style="text-align: left;">
                        <label>CUIJ</label>
                        <p>{{$secuestro->cuij}}</p>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
                        <label>OBSERVACIONES / COMENTARIOS</label>
                        <p>{{$secuestro->obs_secuestro}}</p>
                    </div>
                </div>             
            </div>
            <div class="modal-footer" style="background-color:#f2f4f7">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"><i class="fas fa-times"></i> CERRAR</button>
            </div>
        </div>
    </div>
</div>
