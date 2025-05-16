@extends('layouts.app')
@section('title') Trades @endsection

@section('breadcrumb')
<li><span>Reporte de Operaciones</span></li>
@endsection

@section('metadata')
<title>Trades - {{ env('APP_NAME') }}</title>
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-0">
                <strong>Lista de Operaciones</strong>
                <button class="btn btn-dark mb-3" data-toggle="modal" data-target="#modalCrearTrade">Registrar Trade</button>

            </div>
            <div class="card-body">



            </div>
        </div>
    </div>

</div>


<!-- Modal -->
<div class="modal fade" id="modalCrearTrade" tabindex="-1" role="dialog" aria-labelledby="modalCrearTradeLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="{{ route('trades.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
    
      <div class="modal-header">
        <h5 class="modal-title" id="modalCrearTradeLabel">Registrar Trade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
  
      <div class="modal-body row">
        <div class="form-group col-md-6">
            <label for="fecha">Fecha</label>
            <input type="datetime-local" name="fecha" class="form-control" required>
        </div>
    
        <div class="form-group col-md-6">
            <label for="activo">Activo</label>
            <input type="text" name="activo" class="form-control" placeholder="Ej: EUR/USD" required>
        </div>
    
        <div class="form-group col-md-6">
            <label for="monto">Monto ($)</label>
            <input type="number" name="monto" step="0.01" class="form-control" required>
        </div>
    
        <div class="form-group col-md-6 d-flex align-items-center">
            <label for="ganado" class="mb-0">Ganado</label>
            <input type="checkbox" name="ganado" id="ganado" class="ml-2" checked>
        </div>
    
        <div class="form-group col-md-6">
            <label for="pago">Pago recibido ($)</label>
            <input type="number" name="pago" step="0.01" class="form-control" required>
        </div>
    
        <div class="form-group col-md-6">
            <label for="porcentaje">Porcentaje de ganancia (%)</label>
            <input type="number" name="porcentaje" class="form-control" value="80" step="0.01" min="0" max="100">
        </div>
    
        <div class="form-group col-md-6">
            <label for="comentario">Comentario</label>
            <textarea name="comentario" rows="2" class="form-control"></textarea>
        </div>
    
        <div class="form-group col-md-6">
            <label for="imagen">Adjuntar Imagen</label>
            <input type="file" name="imagen" class="form-control-file">
        </div>
      </div>
  
      <div class="modal-footer">
        <button type="submit" class="btn btn-dark">Guardar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>
@endsection
