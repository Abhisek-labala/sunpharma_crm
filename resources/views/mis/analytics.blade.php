@include('mis.header')
@section('content')
<div class="main-wrapper">

    @include('mis.Sidebar');

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">

            @include('mis.breadcum')

            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card dashboard-chart-card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title text-white">Sun Pharma Brands</h5>
                            <div class="chart-container-wrapper">
                                <canvas id="ciplaChart" width="150" height="150"></canvas>
                                <div id="ciplaChartText" class="chart-text text-white"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card dashboard-chart-card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title text-white">Non-Sunpharma Brands</h5>
                            <div class="chart-container-wrapper">
                                <canvas id="nonCiplaChart" width="150" height="150"></canvas>
                                <div id="nonCiplaChartText" class="chart-text text-white"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar mr-1"></i>
                                Monthly Counseling
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyCounselingChart" style="height: 180px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-check mr-1"></i>
                                Top 5 Educators (Prescribed Sun Pharma)
                            </h3>
                        </div>
                        <div class="card-body" id="topEducatorsListContainer">
                            <ul class="list-group list-group-flush"></ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card card-warning card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-times mr-1"></i>
                                Top 5 Educators (Not Prescribed)
                            </h3>
                        </div>
                        <div class="card-body" id="notEducatorsListContainer">
                            <ul class="list-group list-group-flush"></ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users mr-1"></i>
                                Educators Camp
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="campChart" style="height: 120px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-prescription-bottle-alt mr-1"></i>
                                Doctors Prescribed Sun Pharma Brands
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="obesityChart" style="height: 150px;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card card-danger card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-ban mr-1"></i>
                                Doctors Not Prescribed Sun Pharma Brands
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="docnot" style="height: 150px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('mis.footer');

<style>
    /* Custom styles for the KPI charts */
    .dashboard-chart-card {
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        border: none;
    }
    .dashboard-chart-card .card-body {
        position: relative;
        text-align: center;
        padding: 1.5rem;
    }
    .dashboard-chart-card .card-title {
        font-weight: 600;
        margin-bottom: 1rem;
    }
    .chart-container-wrapper {
        position: relative;
        height: 150px;
        width: 150px;
        margin: 0 auto;
    }
    .chart-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2.5rem;
        font-weight: bold;
    }
    .bg-success { background-color: #28a745 !important; }
    .bg-danger { background-color: #dc3545 !important; }
    .text-white { color: #fff !important; }

    /* AdminLTE-like Styles for other elements (already included from previous versions) */
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
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
      const API_BASE_URL = "{{ url('Charts') }}/admin";

        async function fetchChartData(endpoint, params = {}) {
            const chartContainer = document.getElementById(endpoint.replace(/_/g, '-') + 'Container');
            if (chartContainer) {
                chartContainer.innerHTML = '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2 text-muted">Loading data...</p></div>';
            }

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
                if (chartContainer) {
                    chartContainer.innerHTML = `<div class="text-center py-5 text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                        <p class="mt-2">Failed to load data: ${error.message}</p>
                    </div>`;
                }
                return null;
            }
        }

        async function initializeCharts() {
            const [
                monthlyData,
                educatorsData,
                noteducatorsData,
                genderData,
                campData,
                obesityData,
                docnotData
            ] = await Promise.all([
                fetchChartData('monthly_counseling'),
                fetchChartData('top_educators', { limit: 5 }),
                fetchChartData('noteducator', { days: 5 }),
                fetchChartData('gender_distribution'),
                fetchChartData('camp_distribution'),
                fetchChartData('obesity_metrics', { days: 5 }),
                fetchChartData('doctorNotMetrics', { days: 5 })
            ]);

            if (monthlyData) renderMonthlyChart(monthlyData);
            if (educatorsData) renderEducatorsChart(educatorsData);
            if (noteducatorsData) rendernottopEducatorsChart(noteducatorsData);
            if (genderData) renderBrandChart(genderData);
            if (campData) renderCampChart(campData);
            if (obesityData) renderObesityChart(obesityData);
            if (docnotData) renderDocnotChart(docnotData);
        }

        // Custom plugin to draw text in the center of the doughnut chart
        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw(chart) {
                if (chart.config.options.customText) {
                    const { width, height, ctx } = chart;
                    ctx.restore();
                    const fontSize = (height / 4).toFixed(2);
                    ctx.font = `${fontSize}px Arial`;
                    ctx.textBaseline = 'middle';
                    ctx.textAlign = 'center';
                    ctx.fillStyle = '#fff';
                    const text = chart.config.options.customText;
                    ctx.fillText(text, width / 2, height / 2);
                    ctx.save();
                }
            }
        };

        function renderBrandChart(data) {
            const ciplaData = data.find(d => d.type === 'Brand');
            const nonCiplaData = data.find(d => d.type === 'Non-brand');
            const ciplaCount = parseInt(ciplaData?.count || 0);
            const nonCiplaCount = parseInt(nonCiplaData?.count || 0);
            const total = ciplaCount + nonCiplaCount || 1;

            // Render Cipla Chart
            new Chart(document.getElementById('ciplaChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [ciplaCount, total - ciplaCount],
                        backgroundColor: ['#fff', 'rgba(255, 255, 255, 0.2)'],
                        hoverBackgroundColor: ['#fff', 'rgba(255, 255, 255, 0.3)'],
                        borderWidth: 0,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    customText: ciplaCount.toString(),
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                },
                plugins: [centerTextPlugin]
            });

            // Render Non-Cipla Chart
            new Chart(document.getElementById('nonCiplaChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [nonCiplaCount, total - nonCiplaCount],
                        backgroundColor: ['#fff', 'rgba(255, 255, 255, 0.2)'],
                        hoverBackgroundColor: ['#fff', 'rgba(255, 255, 255, 0.3)'],
                        borderWidth: 0,
                        cutout: '80%'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    customText: nonCiplaCount.toString(),
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                },
                plugins: [centerTextPlugin]
            });
        }

        function renderMonthlyChart(data) {
            const ctx = document.getElementById('monthlyCounselingChart').getContext('2d');
            const color = '#3b82f6';
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.month),
                    datasets: [{
                        label: 'Counseling Sessions',
                        data: data.map(item => item.count),
                        backgroundColor: color,
                        borderColor: color,
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, grid: { display: false } },
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        function renderEducatorsChart(data) {
            data.sort((a, b) => b.session_count - a.session_count);
            const list = document.querySelector('#topEducatorsListContainer ul');
            list.innerHTML = data.slice(0, 5).map(e => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${e.educator_name}
                    <span class="badge badge-primary rounded-pill bg-primary">${e.session_count}</span>
                </li>
            `).join('');
        }

        function rendernottopEducatorsChart(data) {
            const list = document.querySelector('#notEducatorsListContainer ul');
            list.innerHTML = data.slice(0, 5).map(e => `
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${e.educator_name}
                    <span class="badge badge-danger rounded-pill bg-danger">${e.session_count}</span>
                </li>
            `).join('');
        }

        function renderCampChart(data) {
            const ctx = document.getElementById('campChart').getContext('2d');
            const color = '#10b981';
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.date),
                    datasets: [{
                        label: 'Camp',
                        data: data.map(item => item.count),
                        backgroundColor: color,
                        borderColor: color,
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        function renderDocnotChart(data) {
            const ctx = document.getElementById('docnot').getContext('2d');
            const color = '#ef4444';
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        label: 'Count',
                        data: data.map(item => parseInt(item.count, 10)),
                        backgroundColor: color,
                        borderColor: color,
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        function renderObesityChart(data) {
            const ctx = document.getElementById('obesityChart').getContext('2d');
            const color = '#f59e0b';
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        label: 'Count',
                        data: data.map(item => parseInt(item.count, 10)),
                        backgroundColor: color,
                        borderColor: color,
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        initializeCharts();
    });
</script>
