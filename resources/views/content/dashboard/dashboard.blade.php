@include('content.dashboard.index', [
        'title'=> 'Dashboard',
        'user'=> true,
        'dashboardDataUrl'=> route('user.dashboard-data'),
        'statisticsDataUrl'=> route('user.statistics-data'),
        'withdrawalRequestUrl'=> route('withdrawal-request.index')
    ]
)