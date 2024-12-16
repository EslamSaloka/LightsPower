<div class="card custom-card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <div class="m-0">
                        <h6 class="main-content-label mb-1">{{$title}}</h6>
                        <p class="text-muted  card-sub-title">{{$description}}</p>
                    </div>
                    <div class="m-0">
                        {{-- <select class="form-control select2-with-search" id="filterId"></select> --}}
                    </div>
                </div>
                <div class="chartjs-wrapper-demo">
                    <canvas id="chartLine"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <!-- Internal Chartjs charts js-->
    <script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endpush
@push('scripts')
<script>
    var ctx = document.getElementById('chartLine').getContext('2d');

    $( function(){
        
        const chart_js_data = JSON.parse(@json($chartjs_line));
        $.each(chart_js_data.filterData, function(key, value){
            $('#filterId').append(`
                <option value=${value}>${value}</option>
            `);
        })
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chart_js_data.xLine,
                datasets: [{
                    label: chart_js_data.yLineLabel,
                    data: chart_js_data.yLine,
                    borderWidth: 2,
                    backgroundColor: 'transparent',
                    borderColor: '#6259ca',
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointRadius: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        ticks: {
                            fontColor: "#77778e",
                            },
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)'
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            fontColor: "#77778e",
                            },
                        display: true,
                        gridLines: {
                            color: 'rgba(119, 119, 142, 0.2)'
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Thousands',
                            fontColor: 'rgba(119, 119, 142, 0.2)'
                        }
                    }]
                },
                legend: {
                    labels: {
                        fontColor: "#77778e"
                    },
                },
            }
        });
    });

</script>
    
@endpush