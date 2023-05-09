@extends('layouts.master')

@section('title', 'Settings')

@push('style')
@endpush

@section('content')
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header border-bottom">
                            <h4 class="card-title">Settings</h4>
                        </div>
                        <div class="card-body mt-2">
                            <form class="form" id="adminSettingForm">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="keys[]" value="advertising">
                                <input type="hidden" name="keys[]" value="protected_url">
                                <input type="hidden" name="keys[]" value="qr_code_format">
                                <input type="hidden" name="keys[]" value="payment_per_visit">
                                <input type="hidden" name="keys[]" value="referral_percentage">
                                <input type="hidden" name="keys[]" value="visitor_time_limit">
                                <input type="hidden" name="keys[]" value="mail_notification">
                                <input type="hidden" name="keys[]" value="queue_work">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Advertising</label>
                                            <select class="select2 form-control" name="advertising">
                                                <option value="0" {{getAdminSetting('advertising') == 0 ? 'selected':''}}>Inactive</option>
                                                <option value="1" {{getAdminSetting('advertising') == 1 ? 'selected':''}}>Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>QR Code Format</label>
                                            <select class="select2 form-control" name="qr_code_format">
                                                <option value="svg" {{getAdminSetting('qr_code_format') == 'svg' ? 'selected':''}}>SVG</option>
                                                <option value="png" {{getAdminSetting('qr_code_format') == 'png' ? 'selected':''}}>PNG</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Protected URL</label>
                                            <select class="select2 form-control" name="protected_url">
                                                <option value="0" {{getAdminSetting('protected_url') == 0 ? 'selected':''}}>Inactive</option>
                                                <option value="1" {{getAdminSetting('protected_url') == 1 ? 'selected':''}}>Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Payment Per Visitor</label>
                                            <input type="number" class="form-control" placeholder="Amount per visit" name="payment_per_visit" value="{{getAdminSetting('payment_per_visit')??0}}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Referral Percentage (%)</label>
                                            <input type="number" class="form-control" placeholder="Percentage" name="referral_percentage" value="{{getAdminSetting('referral_percentage')}}" />
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Visitor Time Limit (min)</label>
                                            <input type="number" class="form-control" placeholder="Limit in minutes" name="visitor_time_limit" value="{{getAdminSetting('visitor_time_limit')??720}}" />
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Mail Notification</label>
                                            <select class="select2 form-control" name="mail_notification">
                                                <option value="0" {{getAdminSetting('mail_notification') == 0 ? 'selected':''}}>No</option>
                                                <option value="1" {{getAdminSetting('mail_notification') == 1 ? 'selected':''}}>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Queue Work</label>
                                            <select class="select2 form-control" name="queue_work">
                                                <option value="0" {{getAdminSetting('queue_work') == 0 ? 'selected':''}}>No</option>
                                                <option value="1" {{getAdminSetting('queue_work') == 1 ? 'selected':''}}>Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" onclick="submitSetting()" class="btn btn-primary mr-1">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    function submitSetting() {
        event.preventDefault();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{route('admin.setting.store')}}",
            data: $('#adminSettingForm').serialize(),
            success: function(response) {
                let url = window.location.href;
                window.location.href = url;
            },
            error: function(reject) {
                let errors = $.parseJSON(reject.responseText);
                if (reject.status === 422 || reject.status === 403) {

                    $.each(errors.message, function(key, val) {
                        $("small#" + key + "-error").text(val[0]);
                    });
                } else {}
            }
        });
    }
</script>
@endpush