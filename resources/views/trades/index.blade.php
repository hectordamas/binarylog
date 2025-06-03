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
    <!-- Efectividad -->
    <div class="col-md-3">
        <div class="card border-left-success shadow-sm py-3 px-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-bullseye fa-2x text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Efectividad</div>
                    <div class="h4 mb-0 font-weight-bold text-success card-text" id="efectividad">
                        {{ $efectividad ?? '--' }}%
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trades Ganados -->
    <div class="col-md-3">
        <div class="card border-left-primary shadow-sm py-3 px-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-thumbs-up fa-2x text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Trades Ganados</div>
                    <div class="h4 mb-0 font-weight-bold text-primary card-text" id="tradesGanados">
                        {{ $tradesGanados ?? '--' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trades Perdidos -->
    <div class="col-md-3">
        <div class="card border-left-danger shadow-sm py-3 px-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-thumbs-down fa-2x text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Trades Perdidos</div>
                    <div class="h4 mb-0 font-weight-bold text-danger card-text" id="tradesPerdidos">
                        {{ $tradesPerdidos ?? '--' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ganancia Neta -->
    <div class="col-md-3">
        <div class="card border-left-dark shadow-sm py-3 px-2">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-dollar-sign fa-2x text-dark"></i>
                </div>
                <div>
                    <div class="text-muted small">Ganancia Neta</div>
                    <div class="h4 mb-0 font-weight-bold text-dark card-text" id="gananciaNeta">
                        $ {{ number_format($gananciaNeta ?? 0, 2) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario de filtros -->
<form method="GET" action="{{ route('trades.index') }}" class="mt-4">
  <div class="form-row align-items-end">
    <div class="col-md-3">
      <label for="fecha_desde">Fecha Desde</label>
      <input type="date" id="fecha_desde" name="fecha_desde" class="form-control" 
             value="{{ request('fecha_desde') }}">
    </div>
    <div class="col-md-3">
      <label for="fecha_hasta">Fecha Hasta</label>
      <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control" 
             value="{{ request('fecha_hasta') }}">
    </div>
    <div class="col-md-3">
      <label for="activo">Activo</label>
      <input type="text" id="activo" name="activo" class="form-control" placeholder="Ej: EUR/USD" 
             value="{{ request('activo') }}">
    </div>
    <div class="col-md-2">
      <label for="ganado">Estado</label>
      <select id="ganado" name="ganado" class="form-control">
        <option value="" {{ request('ganado') === null ? 'selected' : '' }}>Todos</option>
        <option value="1" {{ request('ganado') === '1' ? 'selected' : '' }}>Ganadas</option>
        <option value="0" {{ request('ganado') === '0' ? 'selected' : '' }}>Perdidas</option>
      </select>
    </div>
    <div class="col-md-1">
      <button type="submit" class="btn btn-dark btn-block btn-sm"> <i class="ti-search"></i> Filtrar</button>
    </div>
  </div>
</form>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center border-0 px-4 pt-4">
              <div>
                <h5 class="mb-1">Historial de Operaciones</h5>
                <p class="text-muted pb-0">Listado de las Operaciones Filtradas</p>
              </div>
              <button class="btn btn-dark" data-toggle="modal" data-target="#modalCrearTrade">
                <i class="ti-bar-chart"></i> Registrar Trade
              </button>

            </div>
            <div class="card-body">

              <div class="row">
                <div class="col-md-12 dt-responsive table-responsive">
                  <table id="tablaTrades" class="table table-bordered table-hover table-striped table-sm">
                      <thead class="thead-dark">
                          <tr>
                              <th>#</th>
                              <th>Fecha</th>
                              <th>Activo</th>
                              <th>Monto ($)</th>
                              <th>Ganado</th>
                              <th>Pago ($)</th>
                              <th>Porcentaje (%)</th>
                              <th>Comentario</th>
                              <th>Imagen</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($trades as $trade)
                          <tr>
                              <td>{{ $trade->id }}</td>
                              <td>{{ \Carbon\Carbon::parse($trade->fecha)->format('d/m/Y H:i') }}</td>
                              <td>{{ $trade->activo }}</td>
                              <td>${{ number_format($trade->monto, 2) }}</td>
                              <td>
                                  <span class="badge {{ $trade->ganado ? 'badge-success' : 'badge-danger' }}">
                                      {{ $trade->ganado ? 'Sí' : 'No' }}
                                  </span>
                              </td>
                              <td>${{ number_format($trade->pago, 2) }}</td>
                              <td>{{ $trade->porcentaje ?? '—' }}</td>
                              <td>{{ $trade->comentario ?? '—' }}</td>
                              <td>
                                  @if($trade->imagen)
                                      <button class="btn btn-outline-primary btn-ver-imagen btn-sm" 
                                              data-imagen="{{ asset($trade->imagen) }}" 
                                              data-toggle="modal" 
                                              data-target="#modalImagen">
                                          <i class="ti-gallery"></i>
                                      </button>
                                  @else
                                      <span class="text-muted">Sin imagen</span>
                                  @endif
                              </td>
                              <td>
                                  <div class="btn-group" role="group" aria-label="Acciones">
                                      <a href="{{ route('trades.edit', $trade->id) }}" class="btn btn-sm btn-outline-success">
                                          <i class="ti-pencil"></i>
                                      </a>
                                      <form action="{{ route('trades.destroy', ['id' => $trade->id]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este trade?')">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-sm btn-outline-danger btn-sm">
                                              <i class="ti-trash"></i>
                                          </button>
                                      </form>
                                  </div>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
                </div>
              </div>

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

<!-- Modal único para mostrar imagen -->
<div class="modal fade" id="modalImagen" tabindex="-1" role="dialog" aria-labelledby="modalImagenLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Imagen del Trade</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img src="" id="imagenModalSrc" class="img-fluid rounded" alt="Comprobante">
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(document).ready(function () {
      $('#tablaTrades').DataTable({
          order: [[0, 'desc']],
          responsive: true,
          dom: 'Bfrtip',
          buttons: [
              {
                  extend: 'copyHtml5',
                  text: '<i class="fas fa-copy"></i> Copiar',
                  className: 'btn btn-sm btn-outline-secondary'
              },
              {
                  extend: 'excelHtml5',
                  text: '<i class="fas fa-file-excel"></i> Excel',
                  className: 'btn btn-sm btn-outline-success'
              },
              {
                  extend: 'pdfHtml5',
                  text: '<i class="fas fa-file-pdf"></i> PDF',
                  className: 'btn btn-sm btn-outline-danger',
                  orientation: 'landscape',
                  pageSize: 'A4',
                  exportOptions: {
                      columns: ':visible:not(:last-child)' // excluye columna Acciones
                  }
              },
              {
                  extend: 'print',
                  text: '<i class="fas fa-print"></i> Imprimir',
                  className: 'btn btn-sm btn-outline-primary',
                  exportOptions: {
                      columns: ':visible:not(:last-child)' // excluye columna Acciones
                  }
              }
          ],
      });
  });

  // Imagen modal
  $(document).on('click', '.btn-ver-imagen', function () {
      let imagenUrl = $(this).data('imagen');
      $('#imagenModalSrc').attr('src', imagenUrl);
  });
</script>
@endsection
