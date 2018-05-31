@extends('layouts.app')

@section('content')


<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Employees</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.employees.add') }}" class="btn blue margin-top-20"> 
                <i class="fa fa-plus"></i> Add Employee
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->

@include('notification')

<div class="portlet light bordered">
    @include('app.employees.search')

    <div class="table-responsive">
    <table class="table table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="3">Details</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $row)
            <?php $usermeta = get_meta( $row->userMetas()->get() ); ?>
            <tr>
                <td style="min-width:60px;max-width:60px;">
                    <img src="{{ has_photo(@$usermeta->profile_picture) }}" class="img-responsive"> 
                </td>
                <td>
                    <h4 class="no-margin">
                    <a href="{{ URL::route('app.employees.edit', $row->id) }}">{{ $row->firstname.' '.$row->lastname }}</a></h4>
                    
                    <small class="text-muted">ID: {{ $row->id }}</small>
                    <small>{{ $row->email }}</small>

                    <div class="margin-top-5">
                                                
                    @if( Input::get('type') == 'trash')
                        <a href="#" class="popup btn btn-xs btn-primary uppercase margin-top-10"
                            data-href="{{ URL::route('app.employees.restore', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Restore"
                            data-body="Are you sure you want to restore ID: <b>#{{ $row->id }}</b>?">Restore</a> 

                        <a href="#" class="popup btn btn-xs btn-default uppercase margin-top-10"
                            data-href="{{ URL::route('app.employees.destroy', [$row->id, query_vars()]) }}" 
                            data-toggle="modal"
                            data-target=".popup-modal" 
                            data-title="Confirm Delete Permanently"
                            data-body="Are you sure you want to delete permanently ID: <b>#{{ $row->id }}</b>?">Delete Permanently</a>
                    @else

                        <a href="{{ URL::route('app.employees.edit', $row->id) }}" class="btn green btn-xs uppercase margin-top-10">Edit</a>

                        @if($row->status != 'actived')
                        <a href="#" class="popup btn btn-xs btn-default uppercase margin-top-10"
                            data-href="{{ URL::route('app.employees.delete', [$row->id, query_vars()]) }}" 
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
                <td>
                    <h5>{{ @$post->find($usermeta->job_type)->post_title }} - {{ @$post->find($usermeta->position)->post_title }}</h5>
                    <h5 class="no-margin">{{ @$post->find($usermeta->department)->post_title }}</h5>

                    @if(@$usermeta->gender == 'male')
                    <h5 class="icon-user tooltips" data-placement="left" data-original-title="{{ ucwords(@$usermeta->gender) }}"></h5>
                    @else
                    <h5 class="icon-user-female tooltips" data-placement="left" data-original-title="{{ ucwords(@$usermeta->gender) }}"></h5>
                    @endif  
                     <small class="uppercase"> - {{ @$usermeta->civil_status }}</small>
                </td>
                <td><h5 class="margin-top-30 text-center">{{ status_ico($row->status) }}</h5></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if( ! count($rows) )
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
