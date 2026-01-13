@include('rm.header');
@section('content')
<div class="main-wrapper">

    @include('rm.Sidebar');

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">

            @include('rm.breadcum')

            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="card kpi-card kpi-card-success">
                        <div class="card-body">
                            <h5 class="kpi-card-title">Cipla Brands</h5>
                            <div class="kpi-chart-wrapper">
                                <canvas id="ciplaChart" width="150" height="150"></canvas>
                                <div id="ciplaChartText" class="kpi-chart-text"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="card kpi-card kpi-card-danger">
                        <div class="card-body">
                            <h5 class="kpi-card-title">Non-Cipla Brands</h5>
                            <div class="kpi-chart-wrapper">
                                <canvas id="nonCiplaChart" width="150" height="150"></canvas>
                                <div id="nonCiplaChartText" class="kpi-chart-text"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-bar me-1"></i> Monthly Counseling
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
                                <i class="fas fa-user-check me-1"></i> Top Educators
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="topEducatorsChart">
                                <ul class="list-group list-group-flush"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="card card-success card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-users me-1"></i> Educators Camp
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="campChart" style="height: 180px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-prescription-bottle-alt me-1"></i> Doctors Prescribed Cipla Brands
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
                                <i class="fas fa-ban me-1"></i> Doctors Not Prescribed Cipla Brands
                            </h3>
                        </div>
                        <div class="card-body">
                            <canvas id="bpChart" style="height: 150px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('rm.footer');

<style>
    /* Custom styles for KPI chart cards */
    .kpi-card {
        border-radius: 10px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
        margin-bottom: 20px !important;
        border: none !important;
        color: #fff !important;
    }
    .kpi-card-success { background-color: #28a745 !important; }
    .kpi-card-danger { background-color: #dc3545 !important; }

    .kpi-card-title {
        font-weight: 600 !important;
        margin-bottom: 1rem !important;
        text-align: center !important;
        color: #fff !important;
    }

    .kpi-chart-wrapper {
        position: relative !important;
        height: 150px !important;
        width: 150px !important;
        margin: 0 auto !important;
    }

    .kpi-chart-text {
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        font-size: 2.5rem !important;
        font-weight: bold !important;
        color: #fff !important;
    }

    /* AdminLTE-like Styles for other elements */
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
    .me-1 { margin-right: 0.25rem; }
    .card-title .fas { font-size: 1rem; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const API_BASE_URL = "{{ url('Charts') }}/rm/";

        // A new, more attractive color array for bar charts
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
                if (!data.success) throw new Error(data.message || 'Failed to fetch data');
                return data.data;
            } catch (error) {
                console.error(`Error fetching ${endpoint}:`, error);
                return null;
            }
        }

        async function initializeCharts() {
            const [
                monthlyData,
                educatorsData,
                brandData,
                campData,
                docData,
                docNotData,
            ] = await Promise.all([
                fetchChartData('monthly_counseling'),
                fetchChartData('top_educators', { limit: 5 }),
                fetchChartData('brand_distribution'),
                fetchChartData('camp_distribution'),
                fetchChartData('doc_metrics', { days: 30 }),
                fetchChartData('docnot_metrics', { days: 30 }),
            ]);

            if (monthlyData) renderMonthlyChart(monthlyData);
            if (educatorsData) renderEducatorsChart(educatorsData);
            if (campData) renderCampChart(campData);
            if (brandData) renderBrandChart(brandData);
            if (docData) renderDocCipla(docData);
            if (docNotData) renderDocnotChart(docNotData);
        }

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

        function renderMonthlyChart(data) {
            const ctx = document.getElementById('monthlyCounselingChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.month.trim()),
                    datasets: [{
                        label: 'Counseling Sessions',
                        data: data.map(item => item.count),
                        backgroundColor: dynamicColors.slice(0, data.length),
                        borderColor: dynamicColors.slice(0, data.length).map(c => c.replace('0.7', '1')),
                        borderWidth: 1,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, title: { display: true, text: 'Month' } },
                        y: { beginAtZero: true, title: { display: true, text: 'Number of Sessions' } }
                    }
                }
            });
        }

        function renderEducatorsChart(data) {
            const listContainer = document.querySelector('#topEducatorsChart ul');
            if (listContainer) {
                listContainer.innerHTML = data.map((e, index) => `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        ${e.educator_name}
                        <span class="badge bg-primary rounded-pill">${e.session_count}</span>
                    </li>
                `).join('');
            }
        }

        function renderBrandChart(data) {
            const ciplaData = data.find(d => d.type === 'Brand');
            const nonCiplaData = data.find(d => d.type === 'Non-brand');
            const ciplaCount = parseInt(ciplaData?.count || 0);
            const nonCiplaCount = parseInt(nonCiplaData?.count || 0);
            const total = ciplaCount + nonCiplaCount || 1;

            new Chart(document.getElementById('ciplaChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [ciplaCount, total - ciplaCount],
                        backgroundColor: ['#fff', 'rgba(255, 255, 255, 0.2)'],
                        cutout: '80%',
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: false,
                    customText: ciplaCount.toString(),
                    plugins: { legend: { display: false }, tooltip: { enabled: false } }
                },
                plugins: [centerTextPlugin]
            });

            new Chart(document.getElementById('nonCiplaChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [nonCiplaCount, total - nonCiplaCount],
                        backgroundColor: ['#fff', 'rgba(255, 255, 255, 0.2)'],
                        cutout: '80%',
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: false,
                    customText: nonCiplaCount.toString(),
                    plugins: { legend: { display: false }, tooltip: { enabled: false } }
                },
                plugins: [centerTextPlugin]
            });
        }

        function renderCampChart(data) {
            const ctx = document.getElementById('campChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.date),
                    datasets: [{
                        label: 'Camps',
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
                        y: { beginAtZero: true, title: { display: true, text: 'Number of Camps' } },
                        x: { title: { display: true, text: 'Date' } }
                    }
                }
            });
        }

        function renderDocCipla(data) {
            const ctx = document.getElementById('obesityChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        label: 'Count',
                        data: data.map(item => parseInt(item.count, 10)),
                        backgroundColor: dynamicColors.slice(0, data.length),
                        borderColor: dynamicColors.slice(0, data.length).map(c => c.replace('0.7', '1')),
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Count' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        function renderDocnotChart(data) {
            const ctx = document.getElementById('bpChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(item => item.name),
                    datasets: [{
                        label: 'Count',
                        data: data.map(item => parseInt(item.count, 10)),
                        backgroundColor: dynamicColors.slice(0, data.length),
                        borderColor: dynamicColors.slice(0, data.length).map(c => c.replace('0.7', '1')),
                        borderWidth: 1,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, title: { display: true, text: 'Count' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        }

        initializeCharts();
    });
</script>
