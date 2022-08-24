<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/{any}', 'PagesController@index')->where('any', '.*');

Route::get('/', function () {
  return view('auth.login');
});

Auth::routes();
Route::post('usuario/resetpass', 'UsuarioController@updateresetpass');

// ERORRS

// RUTAS NUEVAS PARA SISTEMA UOM
//RUTAS DE RECURSOS GENERALES

Route::get('419', function () {
  return view('errors.419');
})->name('419');

Route::middleware(['auth'])->group(function () {

  Route::get('/home', 'HomeController@index')->name('home');

  // EMPRESAS
  Route::get('empresas', 'EmpresaController@indexEmpresa')->name('indexEmpresa');
  Route::get('empresa/resultado', 'EmpresaController@getEmpresas');
  Route::get('nuevaEmpresa', 'EmpresaController@create')->name('nuevaEmpresa');
  Route::post('guardarEmpresa', 'EmpresaController@store')->name('guardarEmpresa');
  Route::post('empresa/edit', 'EmpresaController@edit');
  Route::post('editEmpresa', 'EmpresaController@update')->name('editEmpresa');
  Route::post('empresa/show', 'EmpresaController@show')->name('showEmpresa');

  // DEUDAS Y PAGOS
  Route::get('nuevaDeuda', 'DeudaController@createDeuda')->name('nuevaDeuda');
  Route::post('guardarDeuda', 'DeudaController@storeDeuda')->name('guardarDeuda');
  Route::get('procesaDeuda', 'DeudaController@procesaDeuda')->name('procesaDeuda');
  Route::post('procesarDeuda', 'DeudaController@procesarDeuda')->name('procesarDeuda');
  Route::get('consultaDeuda', 'ConsultaController@consultaDeuda')->name('consultaDeuda');
  Route::get('consultadeuda/resultado','ConsultaController@getResultadoConsultaDeuda');
  Route::get('erroresPagos', 'ConsultaController@erroresPagos')->name('erroresPagos');
  Route::get('consultaerrores/resultado','ConsultaController@getResultadoConsultaErrores');
  Route::get('consultaConvenio', 'ConsultaController@consultaConvenio')->name('consultaConvenio');
  Route::get('consultaconvenio/resultado','ConsultaController@getResultadoConsultaConvenio');

  Route::get('archivosProcesados', 'ExcelArchivoController@indexArchivos')->name('archivosProcesados');

  // PAGOS MANUALES
  Route::get('imputacionManual', 'PagoManualController@pagoManualDeuda')->name('imputacionManual');
  Route::get('pagosManuales', 'PagoManualController@indexPagoManualDeuda')->name('pagosManuales');
  Route::get('deuda/resultado', 'PagoManualController@getDeudaManual');
  Route::get('indexDeudaManual', 'PagoManualController@indexPagoManualDeuda')->name('indexDeudaManual');

  Route::post('guardaPagoManual', 'PagoManualController@store')->name('guardaPagoManual');
  Route::post('eliminaDeuda', 'PagoManualController@delete')->name('eliminaDeuda');
  

   //EXCEL
  Route::post('/import', 'DeudaController@importarExcel');
  Route::post('/procesaPagos', 'DeudaController@saveData');
  Route::get('archivos/resultado', 'ExcelArchivoController@getArchivos');

  // TITULARES
  Route::get('titulares', 'TitularController@indexTitular')->name('indexTitular');
  Route::get('titular/resultado', 'TitularController@getTitulares');
  Route::get('nuevoTitular', 'TitularController@create')->name('nuevoTitular');
  Route::post('guardarTitular', 'TitularController@store')->name('guardarTitular');
  Route::post('titular/edit', 'TitularController@edit');
  Route::post('editTitular', 'TitularController@update')->name('editTitular');
  Route::post('titular/show', 'TitularController@show')->name('showTitular');

  // FAMILIARES
  Route::get('familiares', 'FamiliarController@indexFamiliar')->name('indexFamiliar');
  Route::get('familiar/resultado', 'FamiliarController@getFamiliares');

  Route::match(['get', 'post'], 'listado/familiares', 'FamiliarController@listadoFamiliar')->name('listadoFamiliar');
  Route::match(['get', 'post'], 'listadoFamiliar/resultado', 'FamiliarController@getListadoFamiliares');

  Route::get('nuevoFamiliar', 'FamiliarController@create')->name('nuevoFamiliar');
  Route::post('guardarFamiliar', 'FamiliarController@store')->name('guardarFamiliar');
  Route::post('familiar/edit', 'FamiliarController@edit');
  Route::post('editFamiliar', 'FamiliarController@update')->name('editFamiliar');
  Route::post('familiar/show', 'FamiliarController@show')->name('showFamiliar');

  //ORDENES OBRA SOCIAL
  route::get('nuevaOrden', 'OrdenController@create')->name('nuevaOrden');
  Route::post('guardarOrden', 'OrdenController@store')->name('guardarOrden');
  Route::get('/buscar_beneficiario', 'OrdenController@buscarBeneficiario');
  Route::get('getPrecioPmo','OrdenController@getPrecioPmo'); 
  Route::get('ordenes', 'OrdenController@indexOrden')->name('indexOrden');
  Route::get('orden/resultado', 'OrdenController@getOrdenes');
  Route::post('orden/show', 'OrdenController@show')->name('showOrden');
  Route::post('orden/edit', 'OrdenController@edit');
  Route::post('editOrden', 'OrdenController@update')->name('editOrden');

  //IMPRESION
  Route::get('orden_impresion', 'ImpresionController@ordenImpresion')->name('ordenImpresion');
  Route::post('orden/imprimirpdf', 'ImpresionController@ordenImpresion')->name('ordenImpresion');

  // USUARIOS
  Route::get('listadoUsuarios', 'UsuarioController@index')->name('listadoUsuarios');
  Route::get('usuarios/create', 'UsuarioController@create');
  Route::post('guardar/usuario', 'UsuarioController@store');
  Route::post('usuariopdf', 'UsuarioController@usuario');

  // BLANQUEAR PASSWORD
  Route::get('usuario/password/blanquear', 'UsuarioController@passwordBlanquear');
  Route::post('usuario/cambiarpass', 'UsuarioController@updatepass');
  Route::get('cambiar/password', 'UsuarioController@cambioPassword')->name('cambiarPassword');
  Route::post('editar/usuario', 'UsuarioController@edit')->name('editarUsuario');
  Route::post('update/usuario', 'UsuarioController@update');

  // ACERCA DE...
  Route::get('acercade', 'HomeController@acercade')->name('acercade');

  // GRAFICOS Y ETIQUETAS 
  Route::match(['get', 'post'], '/total_general_empresas', 'GraficoYEtiquetaController@getDataEtiquetaTotalEmpresas');
  Route::match(['get', 'post'], '/total_titulares', 'GraficoYEtiquetaController@getDataEtiquetaTitulares');
  Route::match(['get', 'post'], '/elementos_remitidos', 'GraficoYEtiquetaController@getDataEtiquetaElementosRemitidos');
  Route::match(['get', 'post'], '/ordenes_allanamiento', 'GraficoYEtiquetaController@getDataOrdenesAllanamiento');
  ///excel  

}); // cierra grupo de rutas autenticadas

Route::group(['middleware' => 'auth'], function () {
  Route::get('{page}', ['as' => 'page.index', 'uses' => 'PagesController@index']);
});
