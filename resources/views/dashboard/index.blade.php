
@extends('layouts.dashboard')


@section('breadcrumbs')
    <x-dashboard.dashboard-breadcrumb :breadcrumbs="[
        ['label' => __('Dashboard'), 'url' => route('dashboard.index')],
    ]" :pageName="__('DASHBOARD')" />
@endsection
@section('content')





                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="warning-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-navigation font-warning">
                                                    <polygon points="3 11 22 2 13 21 11 13 3 11"></polygon>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="media-body media-doller">
                                            <span class="m-0">Earnings</span>
                                            <h3 class="mb-0">$ <span class="counter">6659</span><small> This
                                                    Month</small>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="secondary-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-box font-secondary">
                                                    <path
                                                        d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                                                    </path>
                                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                    <line x1="12" y1="22.08" x2="12"
                                                        y2="12"></line>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="media-body media-doller">
                                            <span class="m-0">Products</span>
                                            <h3 class="mb-0">$ <span class="counter">9856</span><small> This
                                                    Month</small>
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="primary-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-message-square font-primary">
                                                    <path
                                                        d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg></div>
                                        </div>
                                        <div class="media-body media-doller"><span class="m-0">Messages</span>
                                            <h3 class="mb-0">$ <span class="counter">893</span><small> This
                                                    Month</small></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-md-6 xl-50">
                            <div class="card o-hidden widget-cards">
                                <div class="danger-box card-body">
                                    <div class="media static-top-widget align-items-center">
                                        <div class="icons-widgets">
                                            <div class="align-self-center text-center"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-users font-danger">
                                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="9" cy="7" r="4"></circle>
                                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                                </svg></div>
                                        </div>
                                        <div class="media-body media-doller"><span class="m-0">New Vendors</span>
                                            <h3 class="mb-0">$ <span class="counter">5631</span><small> This
                                                    Month</small></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Market Value</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="market-chart"><svg
                                            xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%"
                                            height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;">
                                            <g class="ct-grids">
                                                <line y1="273" y2="273" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="244.33333333333334" y2="244.33333333333334" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="215.66666666666666" y2="215.66666666666666" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="187" y2="187" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="158.33333333333331" y2="158.33333333333331" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="129.66666666666666" y2="129.66666666666666" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="101" y2="101" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="72.33333333333334" y2="72.33333333333334" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="43.66666666666666" y2="43.66666666666666" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                                <line y1="15" y2="15" x1="40"
                                                    x2="407.8999938964844" class="ct-grid ct-vertical"></line>
                                            </g>
                                            <g>
                                                <g class="ct-series ct-series-a">
                                                    <line x1="56.99374961853027" x2="56.99374961853027"
                                                        y1="273" y2="129.66666666666666" class="ct-bar"
                                                        ct:value="2.5"></line>
                                                    <line x1="102.98124885559082" x2="102.98124885559082"
                                                        y1="273" y2="101" class="ct-bar"
                                                        ct:value="3"></line>
                                                    <line x1="148.96874809265137" x2="148.96874809265137"
                                                        y1="273" y2="101" class="ct-bar"
                                                        ct:value="3"></line>
                                                    <line x1="194.9562473297119" x2="194.9562473297119"
                                                        y1="273" y2="221.4" class="ct-bar"
                                                        ct:value="0.9"></line>
                                                    <line x1="240.94374656677246" x2="240.94374656677246"
                                                        y1="273" y2="198.46666666666664" class="ct-bar"
                                                        ct:value="1.3"></line>
                                                    <line x1="286.931245803833" x2="286.931245803833"
                                                        y1="273" y2="169.8" class="ct-bar"
                                                        ct:value="1.8"></line>
                                                    <line x1="332.91874504089355" x2="332.91874504089355"
                                                        y1="273" y2="55.133333333333326" class="ct-bar"
                                                        ct:value="3.8"></line>
                                                    <line x1="378.9062442779541" x2="378.9062442779541"
                                                        y1="273" y2="187" class="ct-bar"
                                                        ct:value="1.5"></line>
                                                </g>
                                                <g class="ct-series ct-series-b">
                                                    <line x1="68.99374961853027" x2="68.99374961853027"
                                                        y1="273" y2="55.133333333333326" class="ct-bar"
                                                        ct:value="3.8"></line>
                                                    <line x1="114.98124885559082" x2="114.98124885559082"
                                                        y1="273" y2="169.8" class="ct-bar"
                                                        ct:value="1.8"></line>
                                                    <line x1="160.96874809265137" x2="160.96874809265137"
                                                        y1="273" y2="26.466666666666697" class="ct-bar"
                                                        ct:value="4.3"></line>
                                                    <line x1="206.9562473297119" x2="206.9562473297119"
                                                        y1="273" y2="141.13333333333333" class="ct-bar"
                                                        ct:value="2.3"></line>
                                                    <line x1="252.94374656677246" x2="252.94374656677246"
                                                        y1="273" y2="66.6" class="ct-bar"
                                                        ct:value="3.6"></line>
                                                    <line x1="298.931245803833" x2="298.931245803833"
                                                        y1="273" y2="112.46666666666667" class="ct-bar"
                                                        ct:value="2.8"></line>
                                                    <line x1="344.91874504089355" x2="344.91874504089355"
                                                        y1="273" y2="112.46666666666667" class="ct-bar"
                                                        ct:value="2.8"></line>
                                                    <line x1="390.9062442779541" x2="390.9062442779541"
                                                        y1="273" y2="112.46666666666667" class="ct-bar"
                                                        ct:value="2.8"></line>
                                                </g>
                                            </g>
                                            <g class="ct-labels">
                                                <foreignObject style="overflow: visible;" x="40" y="278"
                                                    width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">100</span></foreignObject>
                                                <foreignObject style="overflow: visible;" x="85.98749923706055"
                                                    y="278" width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">200</span></foreignObject>
                                                <foreignObject style="overflow: visible;" x="131.9749984741211"
                                                    y="278" width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">300</span></foreignObject>
                                                <foreignObject style="overflow: visible;" x="177.96249771118164"
                                                    y="278" width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">400</span></foreignObject>
                                                <foreignObject style="overflow: visible;" x="223.9499969482422"
                                                    y="278" width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">500</span></foreignObject>
                                                <foreignObject style="overflow: visible;" x="269.93749618530273"
                                                    y="278" width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">600</span></foreignObject>
                                                <foreignObject style="overflow: visible;" x="315.9249954223633"
                                                    y="278" width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">700</span></foreignObject>
                                                <foreignObject style="overflow: visible;" x="361.9124946594238"
                                                    y="278" width="45.98749923706055" height="20"><span
                                                        class="ct-label ct-horizontal ct-end"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="width: 46px; height: 20px;">800</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="244.33333333333334" x="0"
                                                    height="28.666666666666668" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">0</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="215.66666666666669" x="0"
                                                    height="28.666666666666668" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">0.5</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="187" x="0"
                                                    height="28.666666666666664" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">1</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="158.33333333333331" x="0"
                                                    height="28.66666666666667" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">1.5</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="129.66666666666663" x="0"
                                                    height="28.66666666666667" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">2</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="101" x="0"
                                                    height="28.666666666666657" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">2.5</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="72.33333333333334" x="0"
                                                    height="28.666666666666657" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">3</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="43.66666666666666" x="0"
                                                    height="28.666666666666686" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">3.5</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="15" x="0"
                                                    height="28.666666666666657" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 29px; width: 30px;">4</span></foreignObject>
                                                <foreignObject style="overflow: visible;" y="-15" x="0"
                                                    height="30" width="30"><span
                                                        class="ct-label ct-vertical ct-start"
                                                        xmlns="http://www.w3.org/2000/xmlns/"
                                                        style="height: 30px; width: 30px;">4.5</span></foreignObject>
                                            </g>
                                        </svg></div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard"
                                            data-clipboard-target="#example-head" title="Copy"><i
                                                class="icofont icofont-copy-alt"></i></button>
                                        <pre class=" language-html">
                                                <code class=" language-html" id="example-head">
                                                    <span class="token comment" spellcheck="true">&lt;!-- Cod Box Copy begin --&gt;</span>
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;</span>div
                                                    </span>
                                                    <span class="token attr-name">class</span>
                                                    <span class="token attr-value">
                                                        <span class="token punctuation">=</span>
                                                        <span class="token punctuation">"</span>market-chart
                                                        <span class="token punctuation">"</span>
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;/</span>div
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>
                                                <span class="token comment" spellcheck="true">&lt;!-- Cod Box Copy end --&gt;</span>
                                            </code>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Latest Orders</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive latest-order-table">
                                        <table class="table table-bordernone">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Order ID</th>
                                                    <th scope="col">Order Total</th>
                                                    <th scope="col">Payment Method</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td class="digits">$120.00</td>
                                                    <td class="font-danger">Bank Transfers</td>
                                                    <td class="digits">On Way</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td class="digits">$90.00</td>
                                                    <td class="font-secondary">Ewallets</td>
                                                    <td class="digits">Delivered</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td class="digits">$240.00</td>
                                                    <td class="font-warning">Cash</td>
                                                    <td class="digits">Delivered</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td class="digits">$120.00</td>
                                                    <td class="font-primary">Direct Deposit</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td class="digits">$50.00</td>
                                                    <td class="font-primary">Bank Transfers</td>
                                                    <td class="digits">Delivered</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <a href="order.html" class="btn btn-primary mt-4">View All Orders</a>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard"
                                            data-clipboard-target="#example-head1" title=""
                                            data-original-title="Copy"><i
                                                class="icofont icofont-copy-alt"></i>
                                        </button>
                                        <pre class="  language-html">
                                            <code class="  language-html" id="example-head1">
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;</span>div
                                                    </span>
                                                    <span class="token attr-name">class</span>
                                                    <span class="token attr-value">
                                                        <span class="token punctuation">=</span>
                                                        <span class="token punctuation">"</span>user-status table-responsive latest-order-table
                                                        <span class="token punctuation">"</span>
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;</span>table
                                                    </span>
                                                    <span class="token attr-name">class</span>
                                                    <span class="token attr-value">
                                                        <span class="token punctuation">=</span>
                                                        <span class="token punctuation">"</span>table table-bordernone
                                                        <span class="token punctuation">"</span>
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;</span>thead
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;</span>tr
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;</span>th
                                                    </span>
                                                    <span class="token attr-name">scope</span>
                                                    <span class="token attr-value">
                                                        <span class="token punctuation">=</span>
                                                        <span class="token punctuation">"</span>col
                                                        <span class="token punctuation">"</span>
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>Order ID
                                                <span class="token tag">
                                                    <span class="token tag">
                                                        <span class="token punctuation">&lt;/</span>th
                                                    </span>
                                                    <span class="token punctuation">&gt;</span>
                                                </span>
                                                <span class="token tag">
                                                    <span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Order Total<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Payment Method<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Status<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>thead</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tbody</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>1<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$120.00<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Bank Transfers<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Delivered<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>2<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$90.00<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Ewallets<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Delivered<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>3<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$240.00<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Cash<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Delivered<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>4<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$120.00<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Direct Deposit<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Delivered<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>5<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$50.00<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Bank Transfers<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Delivered<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tbody</span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>table</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                            </code>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Total Sales</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder"
                                                    id="simple-line-chart-sparkline-3">
                                                    <canvas width="100" height="60"
                                                        style="display: inline-block; width: 100px; height: 60px; vertical-align: top;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>42% <span><i class="fa fa-angle-up font-primary"></i></span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Sales Last Month</span>
                                            <h2 class="mb-0">9054</h2>
                                            <p>0.25% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>

                                        <div class="bg-primary b-r-8">
                                            <div class="small-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-briefcase">
                                                    <rect x="2" y="7" width="20" height="14" rx="2"
                                                        ry="2"></rect>
                                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Gross sales of August</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Total purchase</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder"
                                                    id="simple-line-chart-sparkline">
                                                    <canvas width="100" height="60"
                                                        style="display: inline-block; width: 100px; height: 60px; vertical-align: top;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>20% <span><i class="fa fa-angle-up font-secondary"></i></span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Monthly purchase</span>
                                            <h2 class="mb-0">2154</h2>
                                            <p>0.13% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>
                                        <div class="bg-secondary b-r-8">
                                            <div class="small-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-credit-card">
                                                    <rect x="1" y="4" width="22" height="16" rx="2"
                                                        ry="2"></rect>
                                                    <line x1="1" y1="10" x2="23"
                                                        y2="10"></line>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Avg Gross purchase</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Total cash transaction</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder"
                                                    id="simple-line-chart-sparkline-2">
                                                    <canvas width="100" height="60"
                                                        style="display: inline-block; width: 100px; height: 60px; vertical-align: top;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>28% <span><i class="fa fa-angle-up font-warning"></i></span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Cash on hand</span>
                                            <h2 class="mb-0">4672</h2>
                                            <p>0.8% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>
                                        <div class="bg-warning b-r-8">
                                            <div class="small-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-shopping-cart">
                                                    <circle cx="9" cy="21" r="1"></circle>
                                                    <circle cx="20" cy="21" r="1"></circle>
                                                    <path
                                                        d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Details about cash</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 xl-50">
                            <div class="card order-graph sales-carousel">
                                <div class="card-header b-header">
                                    <h6>Daily Deposits</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="small-chartjs">
                                                <div class="flot-chart-placeholder"
                                                    id="simple-line-chart-sparkline-1">
                                                    <canvas width="100" height="60"
                                                        style="display: inline-block; width: 100px; height: 60px; vertical-align: top;"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="value-graph">
                                                <h3>75% <span><i class="fa fa-angle-up font-danger"></i></span></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body">
                                            <span>Security Deposits</span>
                                            <h2 class="mb-0">0782</h2>
                                            <p>0.25% <span><i class="fa fa-angle-up"></i></span></p>
                                        </div>
                                        <div class="bg-danger b-r-8">
                                            <div class="small-box">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" class="feather feather-calendar">
                                                    <rect x="3" y="4" width="18" height="18" rx="2"
                                                        ry="2"></rect>
                                                    <line x1="16" y1="2" x2="16"
                                                        y2="6"></line>
                                                    <line x1="8" y1="2" x2="8"
                                                        y2="6"></line>
                                                    <line x1="3" y1="10" x2="21"
                                                        y2="10"></line>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="sales-contain">
                                        <h5 class="f-w-600">Gross sales of June</h5>
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Buy / Sell</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body sell-graph">
                                    <canvas id="myGraph" width="1200" height="312"
                                        style="width: 960px; height: 250px;">
                                    </canvas>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard"
                                            data-clipboard-target="#example-head3" title=""
                                            data-original-title="Copy">
                                            <i class="icofont icofont-copy-alt"></i>
                                        </button>
                                        <pre class="  language-html">
                                            <code class="  language-html" id="example-head3">
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>card-body sell-graph<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>canvas</span> <span class="token attr-name">id</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>myGraph<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>canvas</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                            </code>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card height-equal" style="min-height: 527px;">
                                <div class="card-header">
                                    <h5>Goods return</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive products-table">
                                        <table class="table table-bordernone mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Details</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Simply dummy text of the printing</td>
                                                    <td class="digits">1</td>
                                                    <td class="font-primary">Pending</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Long established</td>
                                                    <td class="digits">5</td>
                                                    <td class="font-secondary">Cancle</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                                <tr>
                                                    <td>sometimes by accident</td>
                                                    <td class="digits">10</td>
                                                    <td class="font-secondary">Cancle</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Classical Latin literature</td>
                                                    <td class="digits">9</td>
                                                    <td class="font-primary">Return</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                                <tr>
                                                    <td>keep the site on the Internet</td>
                                                    <td class="digits">8</td>
                                                    <td class="font-primary">Pending</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Molestiae consequatur</td>
                                                    <td class="digits">3</td>
                                                    <td class="font-secondary">Cancle</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                                <tr>
                                                    <td>Pain can procure</td>
                                                    <td class="digits">8</td>
                                                    <td class="font-primary">Return</td>
                                                    <td class="digits">$6523</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard"
                                            data-clipboard-target="#example-head4" title=""
                                            data-original-title="Copy"><i
                                                class="icofont icofont-copy-alt"></i></button>
                                        <pre class="  language-html">
                                            <code class="  language-html" id="example-head4">
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>user-status table-responsive products-table<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>table</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>table table-bordernone mb-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>thead</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Details<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Quantity<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Status<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Price<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>thead</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tbody</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Simply dummy text of the printing<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>1<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Pending<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$6523<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Long established<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>5<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Cancle<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$6523<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>sometimes by accident<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>10<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Cancle<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$6523<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Classical Latin literature<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>9<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Return<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$6523<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>keep the site on the Internet<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>8<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Pending<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$6523<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Molestiae consequatur<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>3<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Cancle<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$6523<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Pain can procure<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>8<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>font-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Return<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$6523<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tbody</span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>table</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                            </code>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 xl-100">
                            <div class="card height-equal" style="min-height: 527px;">
                                <div class="card-header">
                                    <h5>Empolyee Status</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-status table-responsive products-table">
                                        <table class="table table-bordernone mb-0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Designation</th>
                                                    <th scope="col">Skill Level</th>
                                                    <th scope="col">Experience</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img
                                                                class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded"
                                                                src="assets/images/dashboard/user2.jpg"
                                                                alt="" data-original-title=""
                                                                title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">John Deo <span
                                                                        class="text-muted digits">(14+
                                                                        Online)</span></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Designer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-primary"
                                                                    role="progressbar" style="width: 30%"
                                                                    aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">2 Year</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img
                                                                class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded"
                                                                src="assets/images/dashboard/user1.jpg"
                                                                alt="" data-original-title=""
                                                                title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Holio Mako <span
                                                                        class="text-muted digits">(250+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Developer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-secondary"
                                                                    role="progressbar" style="width: 70%"
                                                                    aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">3 Year</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img
                                                                class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded"
                                                                src="assets/images/dashboard/user3.jpg"
                                                                alt="" data-original-title=""
                                                                title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Mohsib lara<span
                                                                        class="text-muted digits">(99+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Tester</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-primary"
                                                                    role="progressbar" style="width: 60%"
                                                                    aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">5 Month</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img
                                                                class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded"
                                                                src="assets/images/dashboard/user.jpg"
                                                                alt="" data-original-title=""
                                                                title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Hileri Soli <span
                                                                        class="text-muted digits">(150+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Designer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-secondary"
                                                                    role="progressbar" style="width: 30%"
                                                                    aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">3 Month</td>
                                                </tr>
                                                <tr>
                                                    <td class="bd-t-none u-s-tb">
                                                        <div class="align-middle image-sm-size"><img
                                                                class="img-radius align-top m-r-15 rounded-circle blur-up lazyloaded"
                                                                src="assets/images/dashboard/designer.jpg"
                                                                alt="" data-original-title=""
                                                                title="">
                                                            <div class="d-inline-block">
                                                                <h6 class="mb-0">Pusiz bia <span
                                                                        class="text-muted digits">(14+ Online)</span>
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>Designer</td>
                                                    <td>
                                                        <div class="progress-showcase">
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-primary"
                                                                    role="progressbar" style="width: 90%"
                                                                    aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="digits">5 Year</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard"
                                            data-clipboard-target="#example-head5" title=""
                                            data-original-title="Copy"><i
                                                class="icofont icofont-copy-alt"></i>
                                        </button>
                                        <pre class="  language-html">
                                            <code class="  language-html" id="example-head5">
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>user-status table-responsive products-table<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>table</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>table table-bordernone mb-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>thead</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Name<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Designation<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Skill Level<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>th</span> <span class="token attr-name">scope</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Experience<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>th</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>thead</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tbody</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>bd-t-none u-s-tb<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>align-middle image-sm-size<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>img</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>img-radius align-top m-r-15 rounded-circle blur-up lazyloaded<span class="token punctuation">"</span></span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>assets/images/dashboard/user2.jpg<span class="token punctuation">"</span></span> <span class="token attr-name">alt</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">data-original-title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>d-inline-block<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>John Deo <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>text-muted digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>(14+ Online)<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Designer<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-showcase<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">height</span><span class="token punctuation">:</span> 8px<span class="token punctuation">;</span></span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-bar bg-primary<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progressbar<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">width</span><span class="token punctuation">:</span> 30%</span><span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuenow</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>50<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemin</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>0<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemax</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>100<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>2 Year<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>bd-t-none u-s-tb<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>align-middle image-sm-size<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>img</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>img-radius align-top m-r-15 rounded-circle blur-up lazyloaded<span class="token punctuation">"</span></span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>assets/images/dashboard/user1.jpg<span class="token punctuation">"</span></span> <span class="token attr-name">alt</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">data-original-title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>d-inline-block<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>Holio Mako <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>text-muted digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>(250+ Online)<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Developer<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-showcase<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">height</span><span class="token punctuation">:</span> 8px<span class="token punctuation">;</span></span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-bar bg-secondary<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progressbar<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">width</span><span class="token punctuation">:</span> 70%</span><span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuenow</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>50<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemin</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>0<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemax</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>100<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>3 Year<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>bd-t-none u-s-tb<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>align-middle image-sm-size<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>img</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>img-radius align-top m-r-15 rounded-circle blur-up lazyloaded<span class="token punctuation">"</span></span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>assets/images/dashboard/user3.jpg<span class="token punctuation">"</span></span> <span class="token attr-name">alt</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">data-original-title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>d-inline-block<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>Mohsib lara<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>text-muted digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>(99+ Online)<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Tester<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-showcase<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">height</span><span class="token punctuation">:</span> 8px<span class="token punctuation">;</span></span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-bar bg-primary<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progressbar<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">width</span><span class="token punctuation">:</span> 60%</span><span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuenow</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>50<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemin</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>0<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemax</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>100<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>5 Month<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>bd-t-none u-s-tb<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>align-middle image-sm-size<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>img</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>img-radius align-top m-r-15 rounded-circle blur-up lazyloaded<span class="token punctuation">"</span></span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>assets/images/dashboard/user.jpg<span class="token punctuation">"</span></span> <span class="token attr-name">alt</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">data-original-title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>d-inline-block<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>Hileri Soli <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>text-muted digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>(150+ Online)<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Designer<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-showcase<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">height</span><span class="token punctuation">:</span> 8px<span class="token punctuation">;</span></span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-bar bg-secondary<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progressbar<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">width</span><span class="token punctuation">:</span> 30%</span><span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuenow</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>50<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemin</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>0<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemax</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>100<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>3 Month<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>bd-t-none u-s-tb<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>align-middle image-sm-size<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>img</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>img-radius align-top m-r-15 rounded-circle blur-up lazyloaded<span class="token punctuation">"</span></span> <span class="token attr-name">src</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>assets/images/dashboard/designer.jpg<span class="token punctuation">"</span></span> <span class="token attr-name">alt</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">data-original-title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span> <span class="token attr-name">title</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>d-inline-block<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>Pusiz bia <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>text-muted digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>(14+ Online)<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>Designer<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-showcase<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">height</span><span class="token punctuation">:</span> 8px<span class="token punctuation">;</span></span><span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progress-bar bg-primary<span class="token punctuation">"</span></span> <span class="token attr-name">role</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>progressbar<span class="token punctuation">"</span></span><span class="token style-attr language-css"><span class="token attr-name"> <span class="token attr-name">style</span></span><span class="token punctuation">="</span><span class="token attr-value"><span class="token property">width</span><span class="token punctuation">:</span> 90%</span><span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuenow</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>50<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemin</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>0<span class="token punctuation">"</span></span> <span class="token attr-name">aria-valuemax</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>100<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>td</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>digits<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>5 Year<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>td</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tr</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>tbody</span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>table</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                            </code>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Sales Status</h5>
                                    <div class="card-header-right">
                                        <ul class="list-unstyled card-option">
                                            <li><i class="icofont icofont-simple-left"></i></li>
                                            <li><i class="view-html fa fa-code"></i></li>
                                            <li><i class="icofont icofont-maximize full-card"></i></li>
                                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                                            <li><i class="icofont icofont-error close-card"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-sm-6 xl-50">
                                            <div class="order-graph">
                                                <h6>Orders By Location</h6>
                                                <div class="chart-block chart-vertical-center">
                                                    <canvas id="myDoughnutGraph" width="258" height="128"
                                                        style="width: 207px; height: 103px;"></canvas>
                                                </div>
                                                <div class="order-graph-bottom">
                                                    <div class="media">
                                                        <div class="order-color-primary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Saint Lucia <span
                                                                    class="pull-right">$157</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-secondary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Kenya <span
                                                                    class="pull-right">$347</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-danger"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Liberia<span
                                                                    class="pull-right">$468</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-warning"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Christmas Island<span
                                                                    class="pull-right">$742</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-color-success"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0">Saint Helena <span
                                                                    class="pull-right">$647</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 xl-50">
                                            <div class="order-graph sm-order-space">
                                                <h6>Sales By Location</h6>
                                                <div class="peity-chart-dashboard text-center">
                                                    <span class="pie-colours-1"
                                                        style="display: none;">4,7,6,5</span><svg class="peity"
                                                        height="180" width="250">
                                                        <path
                                                            d="M 125 0 A 74 74 0 0 1 192.31276765623437 43.25928903786041 L 125 74"
                                                            fill="#ff4c3b"></path>
                                                        <path
                                                            d="M 192.31276765623437 43.25928903786041 A 74 74 0 0 1 125 148 L 125 74"
                                                            fill="#02cccd"></path>
                                                        <path
                                                            d="M 125 148 A 74 74 0 0 1 51.75321330081097 63.468701967776916 L 125 74"
                                                            fill="#ffbc58"></path>
                                                        <path
                                                            d="M 51.75321330081097 63.468701967776916 A 74 74 0 0 1 124.99999999999999 0 L 125 74"
                                                            fill="#a5a5a5"></path>
                                                    </svg>
                                                </div>
                                                <div class="order-graph-bottom sales-location">
                                                    <div class="media">
                                                        <div class="order-shape-primary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Germany <span
                                                                    class="pull-right">25%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-secondary"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Brasil <span
                                                                    class="pull-right">10%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-danger"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">United Kingdom<span
                                                                    class="pull-right">34%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-warning"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Australia<span
                                                                    class="pull-right">5%</span></h6>
                                                        </div>
                                                    </div>
                                                    <div class="media">
                                                        <div class="order-shape-success"></div>
                                                        <div class="media-body">
                                                            <h6 class="mb-0 me-0">Canada <span
                                                                    class="pull-right">25%</span></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 xl-100">
                                            <div class="order-graph xl-space">
                                                <h6>Revenue for last month</h6>
                                                <div class="ct-4 flot-chart-container"><svg
                                                        xmlns:ct="http://gionkunz.github.com/chartist-js/ct"
                                                        width="100%" height="100%" class="ct-chart-line"
                                                        style="width: 100%; height: 100%;">
                                                        <g class="ct-grids">
                                                            <line x1="50" x2="50" y1="15"
                                                                y2="365" class="ct-grid ct-horizontal"></line>
                                                            <line x1="96.61249923706055" x2="96.61249923706055"
                                                                y1="15" y2="365"
                                                                class="ct-grid ct-horizontal"></line>
                                                            <line x1="143.2249984741211" x2="143.2249984741211"
                                                                y1="15" y2="365"
                                                                class="ct-grid ct-horizontal"></line>
                                                            <line x1="189.83749771118164" x2="189.83749771118164"
                                                                y1="15" y2="365"
                                                                class="ct-grid ct-horizontal"></line>
                                                            <line x1="236.4499969482422" x2="236.4499969482422"
                                                                y1="15" y2="365"
                                                                class="ct-grid ct-horizontal"></line>
                                                            <line x1="283.06249618530273" x2="283.06249618530273"
                                                                y1="15" y2="365"
                                                                class="ct-grid ct-horizontal"></line>
                                                            <line x1="329.6749954223633" x2="329.6749954223633"
                                                                y1="15" y2="365"
                                                                class="ct-grid ct-horizontal"></line>
                                                            <line x1="376.2874946594238" x2="376.2874946594238"
                                                                y1="15" y2="365"
                                                                class="ct-grid ct-horizontal"></line>
                                                            <line y1="365" y2="365" x1="50"
                                                                x2="422.8999938964844" class="ct-grid ct-vertical">
                                                            </line>
                                                            <line y1="326.1111111111111" y2="326.1111111111111"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical">
                                                            </line>
                                                            <line y1="287.22222222222223" y2="287.22222222222223"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical"></line>
                                                            <line y1="248.33333333333331" y2="248.33333333333331"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical"></line>
                                                            <line y1="209.44444444444446" y2="209.44444444444446"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical"></line>
                                                            <line y1="170.55555555555554" y2="170.55555555555554"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical"></line>
                                                            <line y1="131.66666666666666" y2="131.66666666666666"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical"></line>
                                                            <line y1="92.77777777777777" y2="92.77777777777777"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical">
                                                            </line>
                                                            <line y1="53.888888888888914" y2="53.888888888888914"
                                                                x1="50" x2="422.8999938964844"
                                                                class="ct-grid ct-vertical"></line>
                                                            <line y1="15" y2="15" x1="50"
                                                                x2="422.8999938964844" class="ct-grid ct-vertical">
                                                            </line>
                                                        </g>
                                                        <g>
                                                            <g class="ct-series ct-series-a">
                                                                <path
                                                                    d="M50,365L50,170.556C65.537,118.704,81.075,15,96.612,15C112.15,15,127.687,92.778,143.225,92.778C158.762,92.778,174.3,53.889,189.837,53.889C205.375,53.889,220.912,139.444,236.45,170.556C251.987,201.667,267.525,248.333,283.062,248.333C298.6,248.333,314.137,170.556,329.675,170.556C345.212,170.556,360.75,196.481,376.287,209.444L376.287,365Z"
                                                                    class="ct-area"></path>
                                                                <path
                                                                    d="M50,170.556C65.537,118.704,81.075,15,96.612,15C112.15,15,127.687,92.778,143.225,92.778C158.762,92.778,174.3,53.889,189.837,53.889C205.375,53.889,220.912,139.444,236.45,170.556C251.987,201.667,267.525,248.333,283.062,248.333C298.6,248.333,314.137,170.556,329.675,170.556C345.212,170.556,360.75,196.481,376.287,209.444"
                                                                    class="ct-line"></path>
                                                                <line x1="50" y1="170.55555555555554"
                                                                    x2="50.01" y2="170.55555555555554"
                                                                    class="ct-point" ct:value="5"></line>
                                                                <line x1="96.61249923706055" y1="15"
                                                                    x2="96.62249923706055" y2="15"
                                                                    class="ct-point" ct:value="9"></line>
                                                                <line x1="143.2249984741211" y1="92.77777777777777"
                                                                    x2="143.23499847412108" y2="92.77777777777777"
                                                                    class="ct-point" ct:value="7"></line>
                                                                <line x1="189.83749771118164"
                                                                    y1="53.888888888888914" x2="189.84749771118163"
                                                                    y2="53.888888888888914" class="ct-point"
                                                                    ct:value="8"></line>
                                                                <line x1="236.4499969482422" y1="170.55555555555554"
                                                                    x2="236.45999694824218" y2="170.55555555555554"
                                                                    class="ct-point" ct:value="5"></line>
                                                                <line x1="283.06249618530273"
                                                                    y1="248.33333333333331" x2="283.0724961853027"
                                                                    y2="248.33333333333331" class="ct-point"
                                                                    ct:value="3"></line>
                                                                <line x1="329.6749954223633" y1="170.55555555555554"
                                                                    x2="329.6849954223633" y2="170.55555555555554"
                                                                    class="ct-point" ct:value="5"></line>
                                                                <line x1="376.2874946594238" y1="209.44444444444446"
                                                                    x2="376.2974946594238" y2="209.44444444444446"
                                                                    class="ct-point" ct:value="4"></line>
                                                            </g>
                                                        </g>
                                                        <g class="ct-labels">
                                                            <foreignObject style="overflow: visible;" x="50" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">1</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                x="96.61249923706055" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">2</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                x="143.2249984741211" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">3</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                x="189.83749771118164" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">4</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                x="236.4499969482422" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">5</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                x="283.06249618530273" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">6</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                x="329.6749954223633" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">7</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                x="376.2874946594238" y="370"
                                                                width="46.61249923706055" height="20"><span
                                                                    class="ct-label ct-horizontal ct-end"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="width: 47px; height: 20px;">8</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="326.1111111111111" x="10"
                                                                height="38.888888888888886" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">0</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="287.2222222222222" x="10"
                                                                height="38.888888888888886" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">1</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="248.33333333333331" x="10"
                                                                height="38.8888888888889" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">2</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="209.44444444444446" x="10"
                                                                height="38.88888888888887" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">3</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="170.55555555555554" x="10"
                                                                height="38.888888888888914" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">4</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="131.66666666666666" x="10"
                                                                height="38.888888888888886" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">5</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="92.77777777777777" x="10"
                                                                height="38.888888888888886" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">6</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;"
                                                                y="53.888888888888914" x="10"
                                                                height="38.88888888888886" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">7</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;" y="15" x="10"
                                                                height="38.888888888888914" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 39px; width: 30px;">8</span>
                                                            </foreignObject>
                                                            <foreignObject style="overflow: visible;" y="-15" x="10"
                                                                height="30" width="30"><span
                                                                    class="ct-label ct-vertical ct-start"
                                                                    xmlns="http://www.w3.org/2000/xmlns/"
                                                                    style="height: 30px; width: 30px;">9</span>
                                                            </foreignObject>
                                                        </g>
                                                    </svg></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="code-box-copy">
                                        <button class="code-box-copy__btn btn-clipboard"
                                            data-clipboard-target="#example-head2" title=""
                                            data-original-title="Copy">
                                            <i class="icofont icofont-copy-alt"></i>
                                        </button>
                                        <pre class="  language-html">
                                            <code class="  language-html" id="example-head2">
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>row<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col-xl-3 col-sm-6 xl-50<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-graph<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>Orders By Location<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>chart-block chart-vertical-center<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>canvas</span> <span class="token attr-name">id</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>myDoughnutGraph<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>canvas</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-graph-bottom<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-color-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Saint Lucia <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$157<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-color-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Kenya <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$347<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-color-danger<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Liberia<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$468<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-color-warning<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Christmas Island<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$742<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-color-success<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Saint Helena <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>$647<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col-xl-3 col-sm-6 xl-50<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-graph sm-order-space<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>Sales By Location<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>peity-chart-dashboard text-center<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pie-colours-1<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>4,7,6,5<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-graph-bottom sales-location<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-shape-primary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0 me-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Germany <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>25%<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-shape-secondary<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0 me-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Brasil <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>10%<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-shape-danger<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0 me-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>United Kingdom<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>34%<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-shape-warning<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0 me-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Australia<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>5%<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-shape-success<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>media-body<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>mb-0 me-0<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>Canada <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>span</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>pull-right<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>25%<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>span</span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                            <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>col-xl-6 xl-100<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>order-graph xl-space<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>h6</span><span class="token punctuation">&gt;</span></span>Revenue for last month<span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>h6</span><span class="token punctuation">&gt;</span></span>
                                                        <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;</span>div</span> <span class="token attr-name">class</span><span class="token attr-value"><span class="token punctuation">=</span><span class="token punctuation">"</span>ct-4 flot-chart-container<span class="token punctuation">"</span></span><span class="token punctuation">&gt;</span></span><span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                    <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                                <span class="token tag"><span class="token tag"><span class="token punctuation">&lt;/</span>div</span><span class="token punctuation">&gt;</span></span>
                                            </code>
                                        </pre>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Container-fluid Ends-->

@endsection