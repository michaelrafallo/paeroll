@extends('layouts.app')

@section('content')


<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">{{ $label }}</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.taxes.add', ['post_type' => $type]) }}" class="btn blue margin-top-20"> 
                <i class="fa fa-plus"></i> Add {{ $single }}
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->


@include('notification')

<div class="portlet light bordered">
    @include('app.taxes.search')


    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Column</th>
                <th width="300">Details</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
         @foreach($rows as $row)
            <tr>            
                <td>
                    {{ $row->post_title }}<br>
                    <small class="text-muted">
                    ID : {{ $row->id }}
                    </small>
                </td>
                <td>{{ $row->post_name }}</td>
                <td> {{ $row->post_order }}</td>
                <td>
                    <small>
                    <?php 
                        $post_content = (array)json_decode($row->post_content);
                        unset($post_content['name']);
                        unset($post_content['code']);
                    ?>
                    @foreach($post_content as $dk => $dv)
                    <div class="col-md-6 text-muted">{{ ucwords(str_replace('_', ' ', $dk))  }}</div> 
                    <div class="col-md-6">{!! array_val_formatted($dk, $dv) !!}</div>
                    @endforeach                        
                    </small>
                </td>
                <td>{{ status_ico($row->post_status) }}</td>
                <td>
                    <div class="text-right">                    

                    @if( Input::get('type') == 'trash')
                        <a href="#" class="popup btn btn-xs btn-primary uppercase"
                            data-href="{{ URL::route('app.taxes.restore', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Restore"
                            data-body="Are you sure you want to restore ID: <b>#{{ $row->id }}</b>?">Restore</a> 

                        <a href="#" class="popup btn btn-xs btn-default uppercase"
                            data-href="{{ URL::route('app.taxes.destroy', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Delete Permanently"
                            data-body="Are you sure you want to delete permanently ID: <b>#{{ $row->id }}</b>?">Delete Permanently</a>
                    @else
                        
                        <a href="{{ URL::route('app.taxes.edit', [$row->id, query_vars()]) }}" class="btn green btn-xs uppercase">Edit</a>

                        @if($row->post_status != 'actived')
                        <a href="#" class="popup btn btn-xs btn-default uppercase"
                            data-href="{{ URL::route('app.taxes.delete', [$row->id, query_vars()]) }}" 
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
