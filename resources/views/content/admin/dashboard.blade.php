@include('content.dashboard.index', [
        'title'=> 'Dashboard',
        'user'=> false,
        'dashboardDataUrl'=> route('admin.dashboard-data'),
        'statisticsDataUrl'=> route('admin.statistics-data'),
        'withdrawalRequestUrl'=> route('admin.withdrawal-request.index')
    ]
)