<label class="sbold">Allowance</label>

<div class="table-responsive">
<table class="table table-striped table-condensed table-allowance">
    <thead>
    <tr class="breakdown" style="display:none;">
        <th width="15%">Code</th>
        <th width="30%">Description</th>
        <th width="80">Taxable</th>
        <th width="150">Amount</th>
        <th></th>
    </tr>                                           
    </thead>

    <tbody>
        <?php
            $allowances = json_decode(@$payroll->allowance);
            $e=0; 
        ?>

        @foreach($post->where('post_type', 'allowance')->get() as $allowance)
        <?php $allowance_meta = get_meta( $allowance->postMetas()->get() ); ?>
        
        <input type="hidden" name="allowance[{{ $e }}][item]" value="{{ @$allowance->post_name }}">

        <tr class="breakdown" style="display:none;">
            <td>{{ @$allowance->post_name }}</td>
            <td>
                <small class="uppercase">{{ @$allowance->post_title }}</small>
            </td>
            <td>{{ status_ico(@$allowance_meta->taxable) }}</td>
            <td>
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control numeric text-right input-sm aw sum {{ @$allowance_meta->taxable == 'YES' ? 'taxable' : 'non-taxable' }}"  name="allowance[{{ $e }}][amount]" placeholder="0.00" value="{{ @$allowances[$e]->amount }}" min="0">
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
                    <input type="checkbox" name="status" value="actived" class="show" data-target=".table-allowance .breakdown"> Show AW items
                    <span></span>
                </label>

                <h5 class="pull-right">Total allowance : </h5>
            </td>
            <td width="31%">
            <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="form-control numeric text-right input-sm sum is-total" name="total[allowance]" placeholder="0.00" 
                value="{{ @$total->allowance }}" min="0">
            </div>
            </td>
            <td width="1">
                <button type="button" class="btn btn-xs btn-default btn-clear"><i class="fa fa-close"></i></button>                          
            </td>
        </tr>
    </tbody>
</table>
    
</div>
