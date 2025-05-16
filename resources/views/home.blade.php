@extends('layouts.app')

@section('title') Dashboard @endsection
@section('breadcrumb')
<li><span>Dashboard</span></li>
@endsection

@section('metadata')
<title>Dashboard - {{ env('APP_NAME') }}</title>
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-md-6">
        <form method="GET" action="{{ route('home') }}" class="btn-group" role="group" aria-label="Filtro de tiempo">
            <input type="hidden" name="tipo" value="dia">
            <button type="submit" class="btn btn-outline-dark {{ request('tipo', 'dia') === 'dia' ? 'active' : '' }}">Hoy</button>
        </form>
        <form method="GET" action="{{ route('home') }}" class="btn-group" role="group" aria-label="Filtro de tiempo">
            <input type="hidden" name="tipo" value="mes">
            <button type="submit" class="btn btn-outline-dark {{ request('tipo') === 'mes' ? 'active' : '' }}">Este Mes</button>
        </form>
        <form method="GET" action="{{ route('home') }}" class="btn-group" role="group" aria-label="Filtro de tiempo">
            <input type="hidden" name="tipo" value="anio">
            <button type="submit" class="btn btn-outline-dark {{ request('tipo') === 'anio' ? 'active' : '' }}">Este Año</button>
        </form>
    </div>

    <div class="col-md-6 text-right d-flex align-items-center justify-content-end">
        <h6>Bienvenido, {{ auth()->user()->name }}</h6>
    </div>

</div>


<div class="row mt-4">
    <!-- Efectividad -->
    <div class="col-md-3">
        <div class="card border-left-success shadow-sm py-3 px-2 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-bullseye fa-2x text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Efectividad</div>
                    <div class="h4 mb-0 font-weight-bold text-success card-text">{{ $efectividad }}%</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trades Ganados -->
    <div class="col-md-3">
        <div class="card border-left-primary shadow-sm py-3 px-2 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-thumbs-up fa-2x text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Trades Ganados</div>
                    <div class="h4 mb-0 font-weight-bold text-primary card-text">{{ $ganados }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Trades Perdidos -->
    <div class="col-md-3">
        <div class="card border-left-danger shadow-sm py-3 px-2 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-thumbs-down fa-2x text-danger"></i>
                </div>
                <div>
                    <div class="text-muted small">Trades Perdidos</div>
                    <div class="h4 mb-0 font-weight-bold text-danger card-text">{{ $perdidos }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ganancia Neta -->
    <div class="col-md-3">
        <div class="card border-left-dark shadow-sm py-3 px-2 mb-4">
            <div class="card-body d-flex align-items-center">
                <div class="mr-3">
                    <i class="fas fa-dollar-sign fa-2x text-dark"></i>
                </div>
                <div>
                    <div class="text-muted small">Ganancia Neta</div>
                    <div class="h4 mb-0 font-weight-bold text-dark card-text">${{ number_format($gananciaNeta, 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong>Efectividad (Ganados vs Perdidos)</strong>
            </div>
            <div class="card-body">
                <canvas id="efectividadChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong>Ganancias en el tiempo</strong>
            </div>
            <div class="card-body">
                <canvas id="gananciasChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong>Monto Invertido por Día</strong>
            </div>
            <div class="card-body">
                <canvas id="montoChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <strong>Activos más operados</strong>
            </div>
            <div class="card-body">
                <canvas id="activosChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Efectividad Pie
    const efectividadChart = new Chart(document.getElementById('efectividadChart'), {
        type: 'pie',
        data: {
            labels: ['Ganados', 'Perdidos'],
            datasets: [{
                data: @json($chartEfectividadData),
                backgroundColor: ['#28a745', '#dc3545'],
            }]
        }
    });

    // Ganancia acumulada Line
    const gananciasChart = new Chart(document.getElementById('gananciasChart'), {
        type: 'line',
        data: {
            labels: @json($labelsGanancias),
            datasets: [{
                label: 'Ganancia acumulada',
                data: @json($gananciasPorFecha),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.1)',
                fill: true,
                tension: 0.3
            }]
        }
    });

    // Monto invertido Bar
    const montoChart = new Chart(document.getElementById('montoChart'), {
        type: 'bar',
        data: {
            labels: @json($labelsMonto),
            datasets: [{
                label: 'Monto invertido ($)',
                data: @json($montoInvertidoData),
                backgroundColor: '#ffc107'
            }]
        }
    });

    // Activos más operados Horizontal Bar
    const activosChart = new Chart(document.getElementById('activosChart'), {
        type: 'bar',  // horizontalBar está deprecated, ahora se usa 'bar' con indexAxis
        data: {
            labels: @json($activosLabels),
            datasets: [{
                label: 'Número de trades',
                data: @json($activosData),
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
