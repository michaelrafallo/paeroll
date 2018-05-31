<h4 class="uppercase page-title">Leave Balances</h4>

<table class="table">
<thead>
    <tr>
        <th width="30%" class="text-right">Leave Type : </th>
        <th>Balance</th>
    </tr>
</thead>
@foreach($post->where('post_type', 'leave')->where('post_status', 'actived')->get() as $leave)
<?php $leavemeta = get_meta( $leave->postMetas()->get() ); ?>
<tr>
    <td class="text-right">
        <a href="javascript:;" class=" mt-sweetalert" data-title="{{ $leave->post_title }}" data-message="{{ $leave->post_content }}" data-allow-outside-click="true" data-confirm-button-class="btn-info">{{ $leave->post_title }}</a> : 
    </td>
    <td>
        <?php 
            $leave_name = str_replace(' ', '_', strtolower($leave->post_title)); 
            $balance = @$info->$leave_name ? $info->$leave_name : $leavemeta->balance ;
        ?>
        <input type="hidden" name="{{ $leave_name }}" value="{{ $balance }}">
        {{ $balance }}
    </td>
</tr>
@endforeach
</table>

<hr>
<h4 class="uppercase page-title">Leave History</h4>

<table class="table table-striped table-hover datatable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Days</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach($post->where('post_type', 'leave-history')->where('post_name', $info->id)->get() as $leave)
        <?php $leavemeta = get_meta( $leave->postMetas()->get() ); ?>
        <tr>
            <td>{{ $leave->post_title }}</td>
            <td>{{ @$leavemeta->days }}</td>
            <td>
                <h5>Date : {{ date_formatted(date_formatted_b(@$leavemeta->date_start)) }} <i class="fa fa-long-arrow-right"></i>
                {{ date_formatted(date_formatted_b(@$leavemeta->date_end)) }}</h5>                

                {{ status_ico($leave->post_status) }} on {{ date_formatted($leave->created_at) }} by
                {{ name_formatted($leave->post_author, 'f l') }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
