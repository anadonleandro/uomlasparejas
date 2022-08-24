@extends ('layouts.master')
@section ('contenido')

<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota">
                <a href="{{url('ordenes')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-primary class texto" title="LISTADO GENERAL DE ORDENES">
                        <i class="fas fa-long-arrow-alt-left"></i>
                    </button>
                </a>
                <b> DETALLE DE LA ORDEN </b>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="fuenteNunito">N° BONO </label>
                            <input type="number" value="{{$orden->id}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">TITULAR </label>
                            <input type="text" value="{{$titular->nom_titular}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">BENEFICIARIO </label>
                            @if ($orden->tipo_beneficiario == 0)
                            <input type="text" value="{{$titular->nom_titular}}" class="form-control" readonly>
                            @else
                            <input type="text" value="{{$familiar->nom_familiar}}" class="form-control" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">TIPO Y NRO DE DNI </label>
                            @if ($orden->tipo_beneficiario==0)
                            <input type="text" value="{{$titular->nom_tipo." - ".$titular->nro_doc}}"
                                class="form-control" readonly>
                            @else
                            <input type="text" value="{{$familiar->nom_tipo." - ".$familiar->nro_doc}}"
                                class="form-control" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="fuenteNunito">EDAD </label>
                            @if ($orden->tipo_beneficiario==0)
                            <input type="text" value="{{$edadTitular}}" class="form-control" readonly>
                            @else
                            <input type="text" value="{{$edadFamiliar}}" class="form-control" readonly>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">TIPO ESTUDIO </label>
                            <input type="text" value="{{$tipoEstudio->nom_tipo}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA ESTUDIO </label>
                            @if ( isset($orden->fecha_estudio))
                            <input type="text" value="{{$orden->fecha_estudio}}" class="form-control" readonly>
                            @else
                            <i> <input type="text" value="SIN DATOS" class="form-control" readonly></i>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA REALIZACION </label>
                            @if ( isset($orden->fecha_realizacion))
                            <input type="text" value="{{$orden->fecha_realizacion}}" class="form-control" readonly>
                            @else
                            <i> <input type="text" value="SIN DATOS" class="form-control" readonly></i>
                            @endif

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA VENCIMIENTO </label>
                            @if ( isset($orden->vencimiento))
                            <input type="text" value="{{$orden->vencimiento->format('d-m-Y')}}" class="form-control"
                                readonly>
                            @else
                            <i> <input type="text" value=" SIN DATOS" class="form-control" readonly> </i>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">SOLICITATNTE </label>
                            <input type="text" value="{{$orden->solicitante}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fuenteNunito">DIAGNOSTICO </label>
                            <input type="text" value="{{$orden->diagnostico}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fuenteNunito">DERIVACION </label>
                            <input type="text" value="{{$orden->derivacion}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fuenteNunito">OBSERVACIONES </label>
                            <input type="text" value="{{$orden->obs}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="fuenteNunito">OPERADOR </label>
                            <input type="text" value="{{$orden->getOperador->name}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">FECHA EMISION </label>
                            <input type="text"
                                value="{{$orden->created_at->format('d/m/Y')." - ".$orden->created_at->format('H:m:i')}}"
                                class="form-control" readonly>
                        </div>
                    </div>
                </div>
                @if ($orden->id_opr_anulo)
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label class="fuenteNunito">ESTADO </label>
                            @if ($orden->estado == "PASIVA")
                            <input type="text" style="color:indianred" value="{{$orden->estado}}" class="form-control"
                                readonly>
                            @else
                            <input type="text" value="{{$orden->estado}}" class="form-control" readonly>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="fuenteNunito">ULTIMO CAMBIO </label>
                            <input type="text"
                                value="{{$orden->updated_at->format('d/m/Y')." - ".$orden->updated_at->format('H:m:i')}}"
                                class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="fuenteNunito">OPERADOR </label>
                            <input type="text" value="{{$orden->getOperadorAnulo->name}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="fuenteNunito">MOTIVO DEL CAMBIO DE ESTADO </label>
                            <input type="text" value="{{$orden->obs_anulo}}" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar">
                            <table class="table table-striped table-condensed table-hover mb-0">
                                <thead>
                                    <th class="fuenteNunito" colspan="4" style="text-align: center">DETALLE DE PRACTICAS
                                    </th>
                                </thead>
                                <thead>
                                    <th class="fuenteNunito" style="width:10%;">CODIGO</th>
                                    <th class="fuenteNunito" style="width:60%;">DESCRIPCION</th>
                                    <th class="fuenteNunito" style="width:15%; text-align: center">CANTIDAD</th>
                                    <th class="fuenteNunito" style="width:15%; text-align: right">IMPORTE</th>
                                </thead>
                                <tbody>
                                    @foreach($orden->getDetalle as $detalle)
                                    <tr>
                                        <td>
                                            {{$detalle->getPmo->codigo}}
                                        </td>
                                        <td>
                                            {{$detalle->getPmo->denominacion}}
                                        </td>
                                        <td style="text-align: center">
                                            {{$detalle->cantidad}}
                                        </td>
                                        <td style="text-align: right">
                                            {{$detalle->importe}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot style="height: 10px">
                                    <tr>
                                        <th colspan="3">
                                            <p style="text-align: right;">SUBTOTAL:</p>
                                        </th>
                                        <th>
                                            <p style="text-align: right;"><span>{{$orden->importe_total}}</span>
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">
                                            <p style="text-align: right;">BONIFICACION:</p>
                                        </th>
                                        <th>
                                            <p style="text-align: right;"><span>{{$orden->importe_bonificacion}}</span>
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">
                                            <p style="text-align: right;">TOTAL:</p>
                                        </th>
                                        <th>
                                            <p style="text-align: right;">
                                                <span>{{$orden->importe_total-$orden->importe_bonificacion}}</span>
                                            </p>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                        <form action="{{url('orden/imprimirpdf')}}" method="post" target="_blank">
                            @csrf
                            <input type="hidden" name="orden" id="orden" value="{{$orden->id}} ">
                            <button class="btn btn-block btn-outline-success" type="submit">
                                <div class="iconos-class"><i class="far fa-file-pdf" aria-hidden="true"></i> REIMPRIMIR
                                    ORDEN </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
