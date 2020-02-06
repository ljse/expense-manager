@extends('layouts.app')
@section('page-title', 'Dashboard')
@section('dash', 'active')
@section('title', 'My Expenses')
@section('dash-content')
@php
    $datatat = [];
    $datalabel = [];
@endphp
<div class="container">
    <div class="row">
        <div class="col-12 col-md-5">
            <div class="row">
                <table>
                    <thead>
                        <th>Expense Categories</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        @foreach ($cats->unique('name') as $cat)
                            @php 
                                $datatat[] = $cat->totalAll;
                                $datalabel[] = $cat->name;
                            @endphp
                            <tr>
                                <td>{{ ucwords($cat->name) }}</td>
                                <td>$ {{ $cat->totalAll }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <h1>GRAPH</h1>
            <canvas id="myChart" width="400" height="400"></canvas>
        </div>
    </div>
</div>
@php 
$newData = json_encode($datatat);
$newDataLabel = json_encode($datalabel);
@endphp

@endsection

@section('scripts')
<script type="application/javascript">
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: {!! $newDataLabel !!},
        datasets: [{
            label: '# of Votes',
            data: {{ str_replace('"', '', $newData) }},
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
@endsection

