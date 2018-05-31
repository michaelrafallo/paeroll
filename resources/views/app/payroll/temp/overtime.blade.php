<label class="sbold">Overtime</label>

<div class="table-responsive">
<table class="table table-striped table-condensed table-overtime">
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
            $overtimes = json_decode(@$payroll->overtime);
            $e=0; 
        ?>

        @foreach($post->where('post_type', 'overtime')->get() as $overtime)
        
        <input type="hidden" name="overtime[{{ $e }}][item]" value="{{ @$overtime->post_name }}">

        <tr class="breakdown" style="display:none;">
            <td>{{ @$overtime->post_name }}</td>
            <td>
                <small class="uppercase">{{ @$overtime->post_title }}</small>
            </td>
            <td><input type="text" class="form-control numeric text-right input-sm ot-h" data-target=".ot" name="overtime[{{ $e }}][hours]" placeholder="0.00" value="{{ @$overtimes[$e]->hours }}" maxlength="12" min="0"></td>
            <td>
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control numeric text-right input-sm ot sum"  name="overtime[{{ $e }}][amount]" placeholder="0.00" value="{{ @$overtimes[$e]->amount }}" min="0">
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
                    <input type="checkbox" name="status" value="actived" class="show" data-target=".table-overtime .breakdown"> Show OT items
                    <span></span>
                </label>

                <h5 class="pull-right">Total Overtime : </h5>
            </td>
            <td width="31%">
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control numeric text-right input-sm sum is-total" name="total[overtime]" placeholder="0.00" 
                value="{{ @$total->overtime }}" min="0">
            </div>
            </td>
            <td width="1">
                <button type="button" class="btn btn-xs btn-default btn-clear"><i class="fa fa-close"></i></button>                          
            </td>
        </tr>
    </tbody>
</table>
    
</div>
