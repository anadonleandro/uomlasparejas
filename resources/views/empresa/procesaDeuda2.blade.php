@extends ('layouts.master')

@section ('contenido')
<script src="{{asset('js/jQuery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/scriptValidaDeuda.js')}}"></script>
<script src="{{asset('sweetalert/sweetalert.js') }}"></script>

<style type="text/css">
    label.error {
        height: 17px;
        padding: 1px 1px 0px 1px;
        font-size: 15px;
        color: #DBA901;
    }

</style>
<br>
<div class="row">
    <div class="col-md-12">
        <div class="card border-info mb-3">
            <div class="card-header color-header-nota" style="background-color: #be9096;">
                <!-- <a href="{{url('empresas')}}" class="card-link float-sm-left">
                    <button class="btn btn-outline-info" title="LISTADO GENERAL DE EMPRESAS">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                </a> -->
                <b>PROCESAR DEUDA</b>
            </div>
            <form action="{{route('procesarDeuda')}}" method="POST" id="deuda_create">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12" style="text-align: right;">
                            <input type="file" name="file" class="form-control">
                            <button class="btn btn-block btn-outline-success" type="submit">
                                <div class="iconos-class"><i class="fas fa-check" aria-hidden="true"></i> PROCESAR
                                    DEUDA </div>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- <div class="card-footer text-muted">
                    
                </div> -->
            </form>
        </div>
    </div>
</div>

@endsection
