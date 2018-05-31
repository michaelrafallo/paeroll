@extends('layouts.app')

@section('content')


<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Users</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.users.add') }}" class="btn blue margin-top-20"> 
                <i class="fa fa-plus"></i> Add User
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->

@include('notification')

<div class="portlet light bordered">
    @include('app.users.search')

    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>Details</th>
                <th></th>
                <th>Group</th>
                <th>Status</th>
                <th>Last Login</th>
                <th>Last Registered</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <?php $usermeta = get_meta( $row->userMetas()->get() ); ?>
            <tr>
                <td width="1">
                    <img src="{{ has_photo(@$usermeta->profile_picture) }}" class="img-responsive img-thumb"> 
                </td>
                <td>
                    <h4 class="no-margin"><a href="">{{ $row->firstname.' '.$row->lastname }}</a></h4>
                    
                    <small class="text-muted">ID: {{ $row->id }}</small>
                    <small>{{ $row->email }}</small>

                    <div class="margin-top-5">
                                                
                    @if( Input::get('type') == 'trash')
                        <a href="#" class="popup btn btn-xs btn-primary uppercase margin-top-10"
                            data-href="{{ URL::route('app.users.restore', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Restore"
                            data-body="Are you sure you want to restore ID: <b>#{{ $row->id }}</b>?">Restore</a> 

                        <a href="#" class="popup btn btn-xs btn-default uppercase margin-top-10"
                            data-href="{{ URL::route('app.users.destroy', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Delete Permanently"
                            data-body="Are you sure you want to delete permanently ID: <b>#{{ $row->id }}</b>?">Delete Permanently</a>
                    @else
                        
                        <a href="{{ URL::route('app.users.login', $row->id) }}" class="btn btn-default btn-xs uppercase margin-top-10"><i class="fa fa-sign-in"></i></a>

                        <a href="{{ URL::route('app.users.edit', $row->id) }}" class="btn green btn-xs uppercase margin-top-10">Edit</a>

                        @if($row->status != 'actived')
                        <a href="#" class="popup btn btn-xs btn-default uppercase margin-top-10"
                            data-href="{{ URL::route('app.users.delete', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Delete"
                            data-body="Are you sure you want to move to trash ID: <b>#{{ $row->id }}</b>?">Move to trash</a> 
                        @else
                        <button class="btn btn-xs btn-default uppercase margin-top-10" disabled>Move to trash</button>
                        @endif    
                    @endif  

                    </div>
                </td>
                <td>{{ $row->group_name }}</td>
                <td>{{ status_ico($row->status) }}</td>
                <td>
                    {{ date_formatted($row->last_login) }}<br>
                    <small>{{ time_ago($row->last_login) }}</small>
                </td>
                <td>
                    {{ date_formatted($row->created_at) }}<br>
                    <small>{{ time_ago($row->created_at) }}</small>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if( ! $count )
    <p class="well"><b>No record found!</b> try boardening your search criteria.</p>
    @endif

    </div>

    {{ $rows->links() }}

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
