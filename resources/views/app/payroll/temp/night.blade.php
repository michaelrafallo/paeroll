<label class="sbold">Night Differencial</label>

<div class="table-responsive">
<table class="table table-striped table-condensed table-night">
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
            $nights = json_decode(@$payroll->night);
            $e=0; 
        ?>

        @foreach($post->where('post_type', 'night')->get() as $night)
        
        <input type="hidden" name="night[{{ $e }}][item]" value="{{ @$night->post_name }}">

        <tr class="breakdown" style="display:none;">
            <td>{{ @$night->post_name }}</td>
            <td>
                <small class="uppercase">{{ @$night->post_title }}</small>
            </td>
            <td><input type="text" class="form-control numeric text-right input-sm nd-h" data-target=".nd" name="night[{{ $e }}][hours]" placeholder="0.00" value="{{ @$nights[$e]->hours }}" maxlength="12" min="0"></td>
            <td>
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control numeric text-right input-sm nd sum"  name="night[{{ $e }}][amount]" placeholder="0.00" value="{{ @$nights[$e]->amount }}" min="0">
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
                    <input type="checkbox" name="status" value="actived" class="show" data-target=".table-night .breakdown"> Show ND items
                    <span></span>
                </label>

                <h5 class="pull-right">Total Night Differencial : </h5>

            </td>
            <td width="31%">
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control numeric text-right input-sm sum is-total" name="total[night]" placeholder="0.00" 
                value="{{ @$total->night }}" min="0">
            </div>
            </td>
            <td width="1">
                <button type="button" class="btn btn-xs btn-default btn-clear"><i class="fa fa-close"></i></button>                          
            </td>
        </tr>
    </tbody>
</table>
</div>