
<form method="get">
<div class="row">
    <div class="col-md-3">
        <div class="input-group">
        {{ Form::select('period', ['' => 'Show all Period'] + payroll_period(), Input::get('period'), ['class' => 'form-control']) }}
        <div class="input-group-btn">
        <button type="submit" class="btn btn-primary">Go</button>
        </div>
        </div>
        
    </div>
    
</div>
</form>

<div class="margin-top-20">
@if( Input::get('period') == 1 )
    @include('app.taxes.temp.daily')
@elseif( Input::get('period') == 7 )
    @include('app.taxes.temp.weekly')
@elseif( Input::get('period') == 15 )
    @include('app.taxes.temp.semi-monthly')
@elseif( Input::get('period') == 30 )
    @include('app.taxes.temp.monthly')
@else
    @include('app.taxes.temp.daily')
    @include('app.taxes.temp.weekly')
    @include('app.taxes.temp.semi-monthly')
    @include('app.taxes.temp.monthly')
@endif
</div>