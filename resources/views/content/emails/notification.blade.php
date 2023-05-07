<div class="name">Dear <b>{{$mail_data['name']??'User'}}</b></div>
<div class="body">
    <p>
        You have requested to withdraw ${{number_format($mail_data['withdrawal_request']->request_amount,4)}} at {{date('d M Y h:ia', strtotime($mail_data['withdrawal_request']->created_at))}} ({{$mail_data['timezone']}}).
        @if($mail_data['withdrawal_request']->status==0)
        Your payment request is pending. The payment is being checked by our team.
        @elseif($mail_data['withdrawal_request']->status==1)
        The payment has been approved at {{date('d M Y h:ia', strtotime($mail_data['withdrawal_request']->updated_at))}} ({{$mail_data['timezone']}}) and is waiting to be sent.
        @elseif($mail_data['withdrawal_request']->status==2)
        The payment has been successfully sent to your payment account at {{date('d M Y h:ia', strtotime($mail_data['withdrawal_request']->updated_at))}} ({{$mail_data['timezone']}}).
        @elseif($mail_data['withdrawal_request']->status==3)
        The payment has been cancelled at {{date('d M Y h:ia', strtotime($mail_data['withdrawal_request']->updated_at))}} ({{$mail_data['timezone']}}).
        @else
        The payment has been returned to your account at {{date('d M Y h:ia', strtotime($mail_data['withdrawal_request']->updated_at))}} ({{$mail_data['timezone']}}).
        @endif
    </p>
    {{$mail_data['content']}}
</div>