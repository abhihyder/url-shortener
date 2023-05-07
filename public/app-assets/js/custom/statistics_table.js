
    function generateStatisticsTableBody(days, visitors) {
        let tbody = '';
        let unique_visitor_this_month = 0;
        $.each(days, function(key, day) {
            let total_visitor = 0;
            let unique_visitor = 0;
            let earning = 0;
            if (visitors.length > 0) {
                $.each(visitors, function(key, visitor) {
                    if (visitor.created_date == day) {
                        unique_visitor = visitor.total_unique;
                        total_visitor = visitor.total_visitor;
                        unique_visitor_this_month = parseFloat(parseFloat(unique_visitor_this_month) + parseFloat(visitor.total_unique));
                        earning = parseFloat(parseFloat(earning) + parseFloat(visitor.total_payment)).toFixed(4)
                    }
                })
            }
            tbody += '<tr> <td> <div class="d-flex align-items-center"> <div> <div>Date</div><div class="font-weight-bolder">' + day + '</div></div></div></td><td> <div class="d-flex align-items-center"><div class="avatar bg-light-primary mr-1"> <div class="avatar-content"> <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-link avatar-icon"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg> </div></div> <div> <div><b>' + digitFormat(total_visitor) + '</b> Total Visitor</div><div><b>' + digitFormat(unique_visitor) + '</b> Unique Visitor</div></div></div></td><td> <div class="d-flex align-items-center"> <div> <div>Earning</div><div class="font-weight-bolder">$' + digitFormat(parseFloat(earning).toFixed(4)) + '</div></div></div></td></tr>';
        })

        $("#statistics_table_body").html(tbody);
        $("#unique_visitors").text(digitFormat(unique_visitor_this_month));
    }
