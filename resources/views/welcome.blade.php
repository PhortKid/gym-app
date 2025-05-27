@extends('workspace_layout.app')
@section('content')

<div class="container pt-2 pb-4">
<h1>Members</h1>
    <div class="row g-4">

    <div class="col-md-6 col-xl-4">
    <div class="card small-card">
        <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
            <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="Today" class="rounded">
            </div>
            <div class="dropdown">
            <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt1">
                <a class="dropdown-item" href="/attendance">View More</a>
            </div>
            </div>
        </div>
        <p class="mb-1">Today</p>
        <h4 class="card-title mb-3">{{ $dailyMember }}</h4>
        </div>
    </div>
    </div>

    <div class="col-md-6 col-xl-4">
    <div class="card small-card">
        <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
            <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="Week" class="rounded">
            </div>
            <div class="dropdown">
            <button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
                <a class="dropdown-item" href="/attendance">View More</a>
            </div>
            </div>
        </div>
        <p class="mb-1">This Month</p>
        <h4 class="card-title mb-3">{{ $monthlyMember }}</h4>
        </div>
    </div>
    </div>

    <div class="col-md-6 col-xl-4">
    <div class="card small-card">
        <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
            <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="Month" class="rounded">
            </div>
            <div class="dropdown">
            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                <a class="dropdown-item" href="/attendance">View More</a>
            </div>
            </div>
        </div>
        <p class="mb-1">This Year</p>
        <h4 class="card-title mb-3">{{ $yearlyMember }}</h4>
        </div>
    </div>
    </div>


    </div>
</div>



<div class="container pt-2 pb-4">
<h1>Attendance</h1>
    <div class="row g-4">

    <div class="col-md-6 col-xl-4">
    <div class="card small-card">
        <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
            <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="Today" class="rounded">
            </div>
            <div class="dropdown">
            <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt1">
                <a class="dropdown-item" href="/customer">View More</a>
            </div>
            </div>
        </div>
        <p class="mb-1">Today</p>
        <h4 class="card-title mb-3">{{ $dailyCount }}</h4>
        </div>
    </div>
    </div>

    <div class="col-md-6 col-xl-4">
    <div class="card small-card">
        <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
            <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="Week" class="rounded">
            </div>
            <div class="dropdown">
            <button class="btn p-0" type="button" id="cardOpt2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt2">
                <a class="dropdown-item" href="/customer">View More</a>
            </div>
            </div>
        </div>
        <p class="mb-1">This Month</p>
        <h4 class="card-title mb-3">{{ $monthlyCount }}</h4>
        </div>
    </div>
    </div>

    <div class="col-md-6 col-xl-4">
    <div class="card small-card">
        <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between mb-4">
            <div class="avatar flex-shrink-0">
            <img src="{{ asset('assets/img/icons/unicons/chart.png') }}" alt="Month" class="rounded">
            </div>
            <div class="dropdown">
            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                <a class="dropdown-item" href="/customer">View More</a>
            </div>
            </div>
        </div>
        <p class="mb-1">This Year</p>
        <h4 class="card-title mb-3">{{ $yearlyCount }}</h4>
        </div>
    </div>
    </div>


    </div>
</div>



<select id="filter" class="form-select mb-3">
  <option value="week">This Week</option>
  <option value="month">This Month</option>
  <option value="year">This Year</option>
</select>

<canvas id="attendanceChart" height="100"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    let chart;

    function loadChart(filter = 'week') {
        fetch(`/attendance/chart?filter=${filter}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(row => row.date);
                const totals = data.map(row => row.total);

                if (chart) chart.destroy();

                chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Attendance',
                            data: totals,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: 'Attendance by ' + filter.charAt(0).toUpperCase() + filter.slice(1)
                            }
                        }
                    }
                });
            });
    }

    document.getElementById('filter').addEventListener('change', function () {
        loadChart(this.value);
    });

    loadChart(); // initial
});
</script>
@endsection
