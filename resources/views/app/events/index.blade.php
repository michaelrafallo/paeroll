@extends('layouts.app')

@section('content')





<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Events</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.events.add') }}" class="btn blue margin-top-20"> 
                <i class="fa fa-plus"></i> Add Event
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->

@include('notification')

<div class="portlet light bordered">

    @if(Input::get('type') == 'trash')
    <a href="{{ URL::route('app.events.index', query_vars('type=0&s=0')) }}">All ({{ number_format($all) }})</a> | 
    <b>Trashed ({{ number_format($trashed) }})</b>
    @else
    <b>All ({{ number_format($all) }})</b> | 
    <a href="{{ URL::route('app.events.index', query_vars('type=trash&s=0')) }}">Trashed ({{ number_format($trashed) }})</a>
    @endif

    <small class="pull-right uppercase text-muted"><b>{{ number_format($count) }}</b> Record{{ is_plural($count) }} Found</small>

    <hr>

    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Updated At</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <tr>
                <td>
                    {{ $row->post_title }}<br>
                    <small class="text-muted">ID : {{ $row->id }}</small>
                </td>
                <td>
                    {{ date_formatted($row->created_at) }}<br>
                    <small class="text-muted">{{ time_ago($row->created_at) }}</small>
                </td>
                <td>{{ status_ico($row->post_status) }}</td>
                <td>
                    <div class="text-right">                    

                    @if( Input::get('type') == 'trash')
                        <a href="#" class="popup btn btn-xs btn-primary uppercase"
                            data-href="{{ URL::route('app.events.restore', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Restore"
                            data-body="Are you sure you want to restore ID: <b>#{{ $row->id }}</b>?">Restore</a> 

                        <a href="#" class="popup btn btn-xs btn-default uppercase"
                            data-href="{{ URL::route('app.events.destroy', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Delete Permanently"
                            data-body="Are you sure you want to delete permanently ID: <b>#{{ $row->id }}</b>?">Delete Permanently</a>
                    @else
                        
                        <a href="{{ URL::route('app.events.edit', $row->id) }}" class="btn green btn-xs uppercase">Edit</a>

                        @if($row->post_status != 'actived')
                        <a href="#" class="popup btn btn-xs btn-default uppercase"
                            data-href="{{ URL::route('app.events.delete', [$row->id, query_vars()]) }}" 
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

@endsection


@section('top_style')
@stop

@section('bottom_style')
@stop

@section('bottom_plugin_script') 
@stop

@section('bottom_script')
@stop
