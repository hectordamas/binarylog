@extends('layouts.app')
@section('title', 'Editar Trade')

@section('content')
<div class="row mt-4">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0">Editar Trade</h5>
            </div>
            <form action="{{ route('trades.update', $trade->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body row">
                    <!-- Igual al formulario de creación, pero con valores prellenados -->
                    <div class="form-group col-md-6">
                        <label for="fecha">Fecha</label>
                        <input type="datetime-local" name="fecha" class="form-control" 
                               value="{{ \Carbon\Carbon::parse($trade->fecha)->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="activo">Activo</label>
                        <input type="text" name="activo" class="form-control" value="{{ $trade->activo }}" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="monto">Monto ($)</label>
                        <input type="number" name="monto" class="form-control" value="{{ $trade->monto }}" step="0.01" required>
                    </div>

                    <div class="form-group col-md-6 d-flex align-items-center">
                        <label for="ganado" class="mb-0">Ganado</label>
                        <input type="checkbox" name="ganado" id="ganado" class="ml-2" {{ $trade->ganado ? 'checked' : '' }}>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pago">Pago ($)</label>
                        <input type="number" name="pago" class="form-control" value="{{ $trade->pago }}" step="0.01" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="porcentaje">Porcentaje (%)</label>
                        <input type="number" name="porcentaje" class="form-control" value="{{ $trade->porcentaje }}" step="0.01">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="comentario">Comentario</label>
                        <textarea name="comentario" class="form-control" rows="2">{{ $trade->comentario }}</textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="imagen">Actualizar Imagen</label>
                        <input type="file" name="imagen" class="form-control-file">
                        @if($trade->imagen)
                            <small class="form-text text-muted">Imagen actual: {{ $trade->imagen }}</small>
                        @endif
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('trades.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-dark">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection