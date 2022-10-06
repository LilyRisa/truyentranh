@extends('admin.layout')
@section('content')
    <main class="c-main">
        <div class="container-lg">
            <div class="row">
                @if(!empty($count_post_dash))
                <div class="col col-sm-6 col-lg-6">
                    <div class="card mb-4 text-white bg-primary">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="font-weight-bold font-16">Tổng: {{$count_post_dash}} <span class="font-weight-normal font-14">({{$percent_post}}%
                                <svg class="icon">
                                @if($percent_post < 0)
                                <use xlink:href="/admin/images/icon-svg/free.svg#cil-arrow-bottom"></use>
                                @else
                                <use xlink:href="/admin/images/icon-svg/free.svg#cil-arrow-top"></use>
                                @endif
                                </svg>)</span>
                                <span class="font-14 font-weight-normal"> tháng này: </span><span class="font-weight-bold">{{$cout_post_new}}</span>
                            </div>
                            <div>Bài viết</div>
                        </div>
                        </div>
                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                                <canvas class="chart" id="card-chart1" height="70" width="272" style="display: block; box-sizing: border-box; height: 70px; width: 272px;"></canvas>
                            </div>
                        </div>
                </div>
                @endif
                @if(!empty($realtime))
                <div class="col col-sm-3 col-lg-3">
                    <div class="card mb-4 text-white bg-info">
                        <div class="card-body pb-3 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="">Tổng số người đang truy theo thời gian thực <img src="{{asset('admin/images/icon-svg/loading.svg')}}" width="20px" height="20px">
                            </div>
                            <div class="font-18 font-weight-bold" id="user_traffic_realtime">
                                <div>
                                    @if(!empty($realtime))
                                        @foreach ($realtime as $rl)
                                            <div><span>{{$rl['country']}}: </span> {{$rl['count']}}</div>
                                        @endforeach
                                    @endif
                                    
                                </div>
                            </div>
                        </div>
                        </div>
                            
                        </div>
                </div>
                @endif

                @if(!empty($user_traffic))
                <div class="col col-sm-3 col-lg-3">
                    <div class="card mb-4 text-white bg-warning">
                        <div class="card-body pb-3 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="">Tổng số người đã truy cập
                            </div>
                            <div class="font-18 font-weight-bold" id="user_traffic">
                                <span id="user_traffic">{{$user_traffic}}</span>
                            </div>
                        </div>
                        </div>
                            
                        </div>
                </div>
                @endif
            </div>
        </div>
    </main>
@endsection

@section('script')
<script>
Chart.defaults.pointHitDetectionRadius = 1;
Chart.defaults.plugins.tooltip.enabled = false;
Chart.defaults.plugins.tooltip.mode = 'index';
Chart.defaults.plugins.tooltip.position = 'nearest';
Chart.defaults.plugins.tooltip.external = coreui.ChartJS.customTooltips;
Chart.defaults.defaultFontColor = '#646470';
const random = (min, max) => Math.floor(Math.random() * (max - min + 1) + min);
const cardChart1 = new Chart(document.getElementById('card-chart1'), {
    type: 'line',
    data: {
        labels: [@php 
                    if(!empty($char_count_post)):
                    for($i=count($char_count_post) - 1; $i >=0; $i--){
                        if($i == 0){
                            echo '"Tháng '.$char_count_post[$i]['month'].'"';
                        }else{
                            echo '"Tháng '.$char_count_post[$i]['month'].'",';
                        }
                    }
                    endif;
                @endphp],
        datasets: [{
            label: 'Tổng số bài viết',
            backgroundColor: 'transparent',
            borderColor: 'rgba(255,255,255,.55)',
            pointBackgroundColor: coreui.Utils.getStyle('--cui-primary'),
            data: [@php 
                    if(!empty($char_count_post)):
                    for($i=count($char_count_post) - 1; $i >=0; $i--){
                        if($i == 0){
                            echo $char_count_post[$i]['count'];
                        }else{
                            echo $char_count_post[$i]['count'].',';
                        }
                    }
                    endif;
                @endphp]
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        },
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    display: false
                }
            },
            y: {
                min: 0,
                max: 100,
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            }
        },
        elements: {
            line: {
                borderWidth: 1,
                tension: 0.4
            },
            point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart2 = new Chart(document.getElementById('card-chart2'), {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'transparent',
            borderColor: 'rgba(255,255,255,.55)',
            pointBackgroundColor: coreui.Utils.getStyle('--cui-info'),
            data: [0, 0, 0, 0, 0, 0, 0]
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        },
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    display: false
                }
            },
            y: {
                min: -9,
                max: 39,
                display: false,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            }
        },
        elements: {
            line: {
                borderWidth: 1
            },
            point: {
                radius: 4,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart3 = new Chart(document.getElementById('card-chart3'), {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgba(255,255,255,.2)',
            borderColor: 'rgba(255,255,255,.55)',
            data: [78, 81, 80, 45, 34, 12, 40],
            fill: true
        }]
    },
    options: {
        plugins: {
            legend: {
                display: false
            }
        },
        maintainAspectRatio: false,
        scales: {
            x: {
                display: false
            },
            y: {
                display: false
            }
        },
        elements: {
            line: {
                borderWidth: 2,
                tension: 0.4
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4
            }
        }
    }
});
const cardChart4 = new Chart(document.getElementById('card-chart4'), {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'January', 'February', 'March', 'April'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgba(255,255,255,.2)',
            borderColor: 'rgba(255,255,255,.55)',
            data: [78, 81, 80, 45, 34, 12, 40, 85, 65, 23, 12, 98, 34, 84, 67, 82],
            barPercentage: 0.6
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                grid: {
                    display: false,
                    drawTicks: false
                },
                ticks: {
                    display: false
                }
            },
            y: {
                grid: {
                    display: false,
                    drawBorder: false,
                    drawTicks: false
                },
                ticks: {
                    display: false
                }
            }
        }
    }
});
const mainChart = new Chart(document.getElementById('main-chart'), {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--cui-info'), 10),
            borderColor: coreui.Utils.getStyle('--cui-info'),
            pointHoverBackgroundColor: '#fff',
            borderWidth: 2,
            data: [random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200)],
            fill: true
        }, {
            label: 'My Second dataset',
            borderColor: coreui.Utils.getStyle('--cui-success'),
            pointHoverBackgroundColor: '#fff',
            borderWidth: 2,
            data: [random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200), random(50, 200)]
        }, {
            label: 'My Third dataset',
            borderColor: coreui.Utils.getStyle('--cui-danger'),
            pointHoverBackgroundColor: '#fff',
            borderWidth: 1,
            borderDash: [8, 5],
            data: [65, 65, 65, 65, 65, 65, 65]
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                grid: {
                    drawOnChartArea: false
                }
            },
            y: {
                ticks: {
                    beginAtZero: true,
                    maxTicksLimit: 5,
                    stepSize: Math.ceil(250 / 5),
                    max: 250
                }
            }
        },
        elements: {
            line: {
                tension: 0.4
            },
            point: {
                radius: 0,
                hitRadius: 10,
                hoverRadius: 4,
                hoverBorderWidth: 3
            }
        }
    }
});
</script>
@endsection
