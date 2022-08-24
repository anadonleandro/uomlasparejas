{!! Form::open(array('url'=>'/usuarios','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<div class="form-group">
	<div class="input-group">
		<input type="text" class="form-control" name="searchText" placeholder="Buscar usuario..." value="">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary" class="btn btn-search" type="button"><i class="fa fa-search"></i> BUSCAR</button>
		</span>
	</div>
</div>

{{Form::close()}}