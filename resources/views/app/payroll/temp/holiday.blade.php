<label class="sbold">Holiday</label>

<div class="table-responsive">
<table class="table table-striped table-condensed table-holiday">
    <thead>
    <tr class="breakdown" style="display:none;">
        <th width="15%">Code</th>
        <th width="30%">Description</th>
        <th width="80">Hours</th>
        <th width="150">Amount</th>
        <th></th>
    </tr>                                           
    </thead>

    <tbody>
        <?php
            $holidays = json_decode(@$payroll->holiday);
            $e=0; 
        ?>

        @foreach($post->where('post_type', 'holiday')->get() as $holiday)
        
        <input type="hidden" name="holiday[{{ $e }}][item]" value="{{ @$holiday->post_name }}">

        <tr class="breakdown" style="display:none;">
            <td>{{ @$holiday->post_name }}</td>
            <td>
                <small class="uppercase">{{ @$holiday->post_title }}</small>
            </td>
            <td><input type="text" class="numeric form-control text-right input-sm hd-h" data-target=".hd" name="holiday[{{ $e }}][hours]" placeholder="0.00" value="{{ @$holidays[$e]->hours }}" maxlength="12" min="0"></td>
            <td>
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="numeric form-control text-right input-sm hd sum"  name="holiday[{{ $e }}][amount]" placeholder="0.00" value="{{ @$holidays[$e]->amount }}" min="0">
            </div>
            </td>
            <td width="1">
                <button type="button" class="btn btn-xs btn-default btn-clear"><i class="fa fa-close"></i></button>                          
            </td>
        </tr>

        <?php $e++; ?>
        @endforeach
        <tr>    
            <td colspan="3">
                <label class="mt-checkbox text-muted">
                    <input type="checkbox" name="status" value="actived" class="show" data-target=".table-holiday .breakdown"> Show HD items
                    <span></span>
                </label>

                <h5 class="pull-right">Total Holiday : </h5>
            </td>
            <td width="31%">
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="numeric form-control text-right input-sm sum is-total" name="total[holiday]" placeholder="0.00" 
                value="{{ @$total->holiday }}" min="0">
            </div>
            </td>
            <td width="1">
                <button type="button" class="btn btn-xs btn-default btn-clear"><i class="fa fa-close"></i></button>                          
            </td>
        </tr>
    </tbody>
</table>
    
</div>
