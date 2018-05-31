<h4 class="uppercase text-muted"> <b class="pull-right">{{ $info->employee_id }}</b> 
<i class="fa fa-user"></i> {{ $info->fullname }}</h4>

<div id="personal-data" class="tab-pane active">
    @include('app.employees.tabs.personal-data')
</div>

<div id="educational-background" class="tab-pane">
    @include('app.employees.tabs.educational-background')
</div>

<div id="organizational-assignment" class="tab-pane">
    @include('app.employees.tabs.organizational-assignment')
</div>

<div id="statutory-data" class="tab-pane">
    @include('app.employees.tabs.statutory-data')
</div>

<div id="salary" class="tab-pane">
    @include('app.employees.tabs.salary')
</div>

<div id="leave" class="tab-pane">
    @include('app.employees.tabs.leave')
</div>

<div id="employment-data" class="tab-pane ">
    @include('app.employees.tabs.employment-data')
</div>
