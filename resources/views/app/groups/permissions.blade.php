@extends('layouts.app')

@section('content')

@include('notification')



<!-- BEGIN PAGE BAR -->
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb uppercase">
        <li>
           <h1 class="page-title">Set Permission</h1>
        </li>
    </ul>
    <div class="page-toolbar">
        <div class="btn-group pull-right">
            <a href="{{ URL::route('app.groups.index') }}" class="btn btn-default margin-top-20"> 
                <i class="fa fa-angle-left"></i> All Groups
            </a>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->

<div class="portlet light bordered">

    <h3>HR Manager</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas commodo nisl risus. Nullam malesuada tempor nisi. Nunc viverra libero metus, non sollicitudin augue vestibulum vitae. Aliquam et rhoncus eros, sed volutpat orci. </p>

    <div class="table-responsive">
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th width="1">
                    <label class="mt-checkbox">
                        <input type="checkbox" id="check_all" value="1">
                        <span></span>
                    </label>                    
                </th>
                <th>Modules</th>
                <th>Roles</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <label class="mt-checkbox">
                        <input type="checkbox" id="users" class="parent_checkbox checkboxes" value="users"> 
                        <span></span>
                    </label>  

                    <input name="main_modules[]" type="checkbox" value="users" class="main_modules" checked="checked">

                </td>
                <td>Users</td>
                <td>
                    <div class="mt-checkbox-inline">
                        <label class="mt-checkbox">
                            <input type="checkbox" name="users[]" class="checkboxes users" data-name="users" value="view"> 
                            <span></span> View
                        </label>                      
                        <label class="mt-checkbox">
                            <input type="checkbox" name="users[]" class="checkboxes users" data-name="users" value="add"> 
                            <span></span> Add
                        </label>                      
                        <label class="mt-checkbox">
                            <input type="checkbox" name="users[]" class="checkboxes users" data-name="users" value="edit"> 
                            <span></span> Edit
                        </label>     
                        <label class="mt-checkbox">
                            <input type="checkbox" name="users[]" class="checkboxes users" data-name="users" value="delete_restore"> 
                            <span></span> Delete / Restore
                        </label>    
                    </div> 
                </td>
            </tr>
        </tbody>
    </table>        
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
    //On Click Check All
    $(document).on('click change','input[id="check_all"]',function() {
        
        var checkboxes = $('.checkboxes');
    
        if ($(this).is(':checked')) {
            checkboxes.prop("checked" , true);
            checkboxes.closest('span').addClass('checked');
        } else {
            checkboxes.prop( "checked" , false );
            checkboxes.closest('span').removeClass('checked');
        }
    });
    
    //Document ready Check All
    $(document).ready(function(){
        
        //Hide all main checkboxes
        $('.main_modules').hide();
    
        var a = $(".checkboxes");
        if(a.length == a.filter(":checked").length){
            $('#check_all').prop("checked" , true);
            $('#check_all').closest('span').addClass('checked');
        }
    });
    
    //Parent checkboxes
    $('.parent_checkbox').click(function() {
        $class = $(this).attr('id');
        var checkboxes = $('.' + $class);
        if ($(this).is(':checked')) {
            checkboxes.prop("checked" , true);
            checkboxes.closest('span').addClass('checked'); 
        } else {
            checkboxes.prop( "checked" , false );
            checkboxes.closest('span').removeClass('checked');
        }
    });
    
    
    //Children checkboxes
    $('.checkboxes').click(function() {
        var name = $(this).data('name');
        var $parent = $('input#' + name);
        var a = $('.' + name);
        if(a.filter(":checked").length > 0){
            $parent.prop("checked" , true);
            $parent.closest('span').addClass('checked');
        } else {
            $parent.prop( "checked" , false );
            $parent.closest('span').removeClass('checked');
        }
    });
</script>
@stop
