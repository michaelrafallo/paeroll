@extends('layouts.app')

@section('content')


<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Leave Requests</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.leaves.manager.file') }}" class="btn blue margin-top-20"> 
                <i class="fa fa-plus"></i> File a Leave
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->

@include('notification')

<div class="portlet light bordered">

    @if(Input::get('type') == 'trash')
    <a href="{{ URL::route('app.leaves.manager.index', query_vars('type=0&s=0')) }}">All ({{ number_format($all) }})</a> | 
    <b>Trashed ({{ number_format($trashed) }})</b>
    @else
    <b>All ({{ number_format($all) }})</b> | 
    <a href="{{ URL::route('app.leaves.manager.index', query_vars('type=trash&s=0')) }}">Trashed ({{ number_format($trashed) }})</a>
    @endif

    <small class="pull-right uppercase text-muted"><b>{{ number_format($count) }}</b> Record{{ is_plural($count) }} Found</small>

    <hr>

    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Leave Type</th>
                <th>Days</th>
                <th>Date</th>
                <th>Remarks</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <?php $postmeta = get_meta( $row->postMetas()->get() ); ?>
            <tr>
                <td>
                    {{ name_formatted($row->post_name, 'f l') }}<br>
                    <small class="text-muted">ID : {{ $row->id }}</small>
                </td>
                <td>{{ $row->post_title }}</td>
                <td>
                    {{ @$postmeta->days }}
                </td>
                <td>
                    {{ date_formatted(date_formatted_b(@$postmeta->date_start)) }} <i class="fa fa-long-arrow-right"></i>
                    {{ date_formatted(date_formatted_b(@$postmeta->date_end)) }}
                </td>
                <td>
                    {{ status_ico($row->post_status) }} on {{ date_formatted($row->updated_at) }} by
                    {{ name_formatted($row->post_author, 'f l') }}
                </td>
                <td>
                    <div class="text-right">                    

                    @if( Input::get('type') == 'trash')
                        <a href="#" class="popup btn btn-xs btn-primary uppercase"
                            data-href="{{ URL::route('app.leaves.manager.restore', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Restore"
                            data-body="Are you sure you want to restore ID: <b>#{{ $row->id }}</b>?">Restore</a> 

                        <a href="#" class="popup btn btn-xs btn-default uppercase"
                            data-href="{{ URL::route('app.leaves.manager.destroy', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Delete Permanently"
                            data-body="Are you sure you want to delete permanently ID: <b>#{{ $row->id }}</b>?">Delete Permanently</a>
                    @else
                        
                        <a href="{{ URL::route('app.leaves.manager.edit', $row->id) }}" class="btn green btn-xs uppercase">Edit</a>

                        @if($row->post_status != 'approved')
                        <a href="#" class="popup btn btn-xs btn-default uppercase"
                            data-href="{{ URL::route('app.leaves.manager.delete', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Delete"
                            data-body="Are you sure you want to move to trash ID: <b>#{{ $row->id }}</b>?">Move to trash</a> 
                        @else
                        <button class="btn btn-xs btn-default uppercase" disabled>Move to trash</button>
                        @endif    
                    @endif  


                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>        

    @if( ! $count )
    <p class="well">No record found!</p>
    @endif

    </div>

</div>

@endsection


@section('top_style')
@stop

@section('bottom_style')
@stop

@section('bottom_plugin_script') 
@stop

@section('bottom_script')
<script>
$(document).on('click','.popup', function() {
    var $this  = $(this);
    var $title = $this.data('title');
    var $body  = $this.data('body');
    var $href  = $this.data('href');
    var $target = $(this).attr('target');

    $target = ($target == '_blank') ? '_blank' : '';

    $('.popup-modal a.confirm').attr('data-target', $target);
    $('.popup-modal a.confirm').attr('data-href', $href);
    $('.popup-modal .modal-title').html($title);
    $('.popup-modal .modal-body').html($body);
});

$(document).on('click','.popup-modal .modal-footer a', function(e) {
    e.preventDefault();
    $(this).html('Processing ...').attr('disabled', 'disabled');

    var $target = $(this).attr('data-target');
    var $href = $(this).attr('data-href');

    location.href = $href;   

});
    
</script>
@stop
