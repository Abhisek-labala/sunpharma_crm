@include('educator.head')
@include('educator.header')
@section('content')
<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('educator.Sidebar')

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('educator.breadcum')

            <div class="row">
                <div class="col-md-5">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar me-1"></i> Monthly Counseling
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyCounselingChart" height="200"></canvas>
                        </div>
                    </div>

                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-venus-mars me-1"></i> Gender Distribution
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="genderChart" height="150"></canvas>
                        </div>
                    </div>

                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-prescription-bottle-alt me-1"></i> Doctors Prescribed Sun pharma Brands
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="doctorChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users me-1"></i> Camp
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="campChart" height="150"></canvas>
                        </div>
                    </div>

                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-weight me-1"></i> Obesity Metrics
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="obesityChart" height="150"></canvas>
                        </div>
                    </div>

                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-heartbeat me-1"></i> Blood Pressure
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="bpChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('educator.footer')

<style>
    /* AdminLTE-like Styles */
    body {
        font-family: 'Source Sans Pro', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: left;
        background-color: #f4f6f9;
    }
    .card {
        box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
        border-radius: .25rem;
        border: 0;
        margin-bottom: 1.5rem;
    }
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding: .75rem 1.25rem;
        position: relative;
    }
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
    }
    .card-outline {
        border-top: 3px solid #dee2e6;
    }
    .card-primary.card-outline { border-top-color: #007bff; }
    .card-success.card-outline { border-top-color: #28a745; }
    .card-info.card-outline { border-top-color: #17a2b8; }
    .card-warning.card-outline { border-top-color: #ffc107; }
    .card-danger.card-outline { border-top-color: #dc3545; }
    .list-group-flush .list-group-item {
        border-width: 0 0 1px;
        border-color: rgba(0, 0, 0, 0.125);
        padding: .75rem 0;
    }
    .list-group-flush .list-group-item:last-child {
        border-bottom-width: 0;
    }
    /* Chart and icon styling */
    .me-1 { margin-right: 0.25rem; }
    .card-title .fas { font-size: 1rem; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const API_BASE_URL = "{{ url('charts') }}/";

        // A clean, modern color palette
        const palette = {
            primary: 'rgba(0, 123, 255, 0.7)',
            secondary: 'rgba(23, 162, 184, 0.7)',
            success: 'rgba(40, 167, 69, 0.7)',
            danger: 'rgba(220, 53, 69, 0.7)',
            warning: 'rgba(255, 193, 7, 0.7)'
        };

        // A new, more attractive color array for bar and pie charts
        const dynamicColors = [
            'rgba(59, 130, 246, 0.7)', // a vibrant blue
            'rgba(163, 191, 250, 0.7)', // a lighter blue
            'rgba(104, 211, 145, 0.7)', // a refreshing green
            'rgba(245, 158, 11, 0.7)', // a warm orange
            'rgba(239, 68, 68, 0.7)', // a soft red
            'rgba(128, 90, 213, 0.7)', // a deep purple
            'rgba(76, 81, 191, 0.7)', // an indigo
            'rgba(56, 178, 172, 0.7)', // a teal
            'rgba(214, 158, 46, 0.7)', // an ochre
        ];

        async function fetchChartData(endpoint, params = {}) {
            try {
                const url = new URL(`${API_BASE_URL}${endpoint}`);
                Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
                const response = await fetch(url);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();
                if (!data.success) {
                    throw new Error(data.message || 'Failed to fetch data');
                }
                return data.data;
            } catch (error) {
                console.error(`Error fetching ${endpoint} data:`, error);
                return null;
            }
        }

        async function initializeCharts() {
            const [
                monthlyData,
                genderData,
                campData,
                bpData,
                obesityData,
                doctorData
            ] = await Promise.all([
                fetchChartData('monthly_counseling'),
                fetchChartData('gender_distribution'),
                fetchChartData('camp_distribution'),
                fetchChartData('blood_pressure', { days: 5 }),
                fetchChartData('obesity_metrics', { days: 5 }),
                fetchChartData('doctor_metrics', { days: 5 })
            ]);

            if (monthlyData) renderMonthlyChart(monthlyData);
            if (genderData) renderGenderChart(genderData);
            if (campData) renderCampChart(campData);
            if (bpData) renderBPChart(bpData);
            if (obesityData) renderObesityChart(obesityData);
            if (doctorData) renderDoctorChart(doctorData);
        }

        function renderMonthlyChart(data) {
            const ctx = document.getElementById('monthlyCounselingChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.month),
                    datasets: [{
                        label: 'Counseling Sessions',
                        data: data.map(item => item.count),
                        backgroundColor: dynamicColors.slice(0, data.length),
                        borderColor: dynamicColors.slice(0, data.length).map(c => c.replace('0.7', '1')),
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function renderGenderChart(data) {
            const ctx = document.getElementById('genderChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.map(item => `${item.gender} (${item.count})`),
                    datasets: [{
                        data: data.map(item => item.count),
                        backgroundColor: [
                            dynamicColors[0],
                            dynamicColors[4],
                            dynamicColors[2]
                        ],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'right' },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((context.raw / total) * 100);
                                    return `${context.label}: ${percentage}%`;
                                }
                            }
                        }
                    }
                }
            });
        }

        function renderCampChart(data) {
            const ctx = document.getElementById('campChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => `${item.date}`),
                    datasets: [{
                        label: 'Participants',
                        data: data.map(item => item.count),
                        backgroundColor: dynamicColors.slice(0, data.length),
                        borderColor: dynamicColors.slice(0, data.length).map(c => c.replace('0.7', '1')),
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function renderBPChart(data) {
            const ctx = document.getElementById('bpChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => new Date(item.date).toLocaleDateString()),
                    datasets: [
                        {
                            label: 'Systolic (mmHg)',
                            data: data.map(item => item.systolic),
                            borderColor: dynamicColors[4].replace('0.7', '1'),
                            backgroundColor: dynamicColors[4].replace('0.7', '0.2'),
                            borderWidth: 2,
                            tension: 0.1,
                            fill: false
                        },
                        {
                            label: 'Diastolic (mmHg)',
                            data: data.map(item => item.diastolic),
                            borderColor: dynamicColors[0].replace('0.7', '1'),
                            backgroundColor: dynamicColors[0].replace('0.7', '0.2'),
                            borderWidth: 2,
                            tension: 0.1,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: { mode: 'index', intersect: false },
                        legend: { position: 'top' }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: false, title: { display: true, text: 'Blood Pressure (mmHg)' } }
                    }
                }
            });
        }

        function renderObesityChart(data) {
            const ctx = document.getElementById('obesityChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.map(item => new Date(item.date).toLocaleDateString()),
                    datasets: [
                        {
                            label: 'Average BMI',
                            data: data.map(item => item.bmi),
                            borderColor: dynamicColors[2].replace('0.7', '1'),
                            backgroundColor: dynamicColors[2].replace('0.7', '0.2'),
                            borderWidth: 2,
                            tension: 0.1,
                            fill: false
                        },
                        {
                            label: 'Average WHR',
                            data: data.map(item => item.whr),
                            borderColor: dynamicColors[3].replace('0.7', '1'),
                            backgroundColor: dynamicColors[3].replace('0.7', '0.2'),
                            borderWidth: 2,
                            tension: 0.1,
                            fill: false,
                            yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: { mode: 'index', intersect: false },
                        legend: { position: 'top' }
                    },
                    scales: {
                        x: { grid: { display: false } },
                        y: { type: 'linear', display: true, position: 'left', title: { display: true, text: 'BMI' } },
                        y1: { type: 'linear', display: true, position: 'right', title: { display: true, text: 'Waist-Hip Ratio' }, grid: { drawOnChartArea: false } }
                    }
                }
            });
        }
        function renderDoctorChart(data) {
            const ctx = document.getElementById('doctorChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        label: 'Count',
                        data: data.map(item => parseInt(item.count, 10)),
                        backgroundColor: dynamicColors.slice(0, data.length),
                        borderColor: dynamicColors.slice(0, data.length).map(c => c.replace('0.7', '1')),
                        borderWidth: 1
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        }

        initializeCharts();
    });
</script>
