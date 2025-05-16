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
        <div class="btn-group" role="group" aria-label="Filtro de tiempo">
            <button type="button" class="btn btn-outline-dark active" data-tipo="dia">Hoy</button>
            <button type="button" class="btn btn-outline-dark" data-tipo="mes">Este Mes</button>
            <button type="button" class="btn btn-outline-dark" data-tipo="anio">Este Año</button>
        </div>
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
                    <div class="h4 mb-0 font-weight-bold text-success card-text" id="efectividad">--%</div>
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
                    <div class="h4 mb-0 font-weight-bold text-primary card-text" id="tradesGanados">--</div>
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
                    <div class="h4 mb-0 font-weight-bold text-danger card-text" id="tradesPerdidos">--</div>
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
                    <div class="h4 mb-0 font-weight-bold text-dark card-text" id="gananciaNeta">$ --</div>
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
    // Stats ficticios
    const tradesGanados = 9;
    const tradesPerdidos = 6;
    const totalTrades = tradesGanados + tradesPerdidos;
    const efectividad = ((tradesGanados / totalTrades) * 100).toFixed(2);
    const gananciaNeta = 135.25;

    // Rellenar las cards
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('efectividad').innerText = efectividad + '%';
        document.getElementById('tradesGanados').innerText = tradesGanados;
        document.getElementById('tradesPerdidos').innerText = tradesPerdidos;
        document.getElementById('gananciaNeta').innerText = '$ ' + gananciaNeta;
    });

    // Efectividad Pie
    const efectividadChart = new Chart(document.getElementById('efectividadChart'), {
        type: 'pie',
        data: {
            labels: ['Ganados', 'Perdidos'],
            datasets: [{
                data: [tradesGanados, tradesPerdidos],
                backgroundColor: ['#28a745', '#dc3545'],
            }]
        }
    });

    // Ganancia acumulada Line
    const gananciasChart = new Chart(document.getElementById('gananciasChart'), {
        type: 'line',
        data: {
            labels: ['10 May', '11 May', '12 May', '13 May', '14 May'],
            datasets: [{
                label: 'Ganancia acumulada',
                data: [0, 45.25, 70.10, 90.25, 135.25],
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
            labels: ['10 May', '11 May', '12 May', '13 May', '14 May'],
            datasets: [{
                label: 'Monto invertido ($)',
                data: [50, 100, 75, 60, 80],
                backgroundColor: '#ffc107'
            }]
        }
    });

    // Activos más operados Horizontal Bar
    const activosChart = new Chart(document.getElementById('activosChart'), {
        type: 'horizontalBar',
        data: {
            labels: ['EUR/USD', 'BTC/USD', 'GOLD', 'AAPL', 'ETH/USD'],
            datasets: [{
                label: 'Número de trades',
                data: [6, 4, 2, 2, 1],
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            scales: {
                xAxes: [{ ticks: { beginAtZero: true } }]
            }
        }
    });
</script>
@endsection
