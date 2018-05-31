<div class="table-responsive">

    <?php 
    $basic_pay = @$payroll->basic_pay ? $payroll->basic_pay : basic_pay($info, $payroll_period); 
    ?>

    <table class="table table-striped table-condensed">
        <thead>
            <tr>
                <th width="45%">Description</th>
                <th width="80">Hours</th>
                <th width="200">Amount</th>
                <th width="1"></th>
            </tr>
        </thead>
        <tr>
            <td>Basic Pay</td>
            <td>
            <input type="text" class="numeric form-control text-right input-sm" name="basic_hour" placeholder="0.00" maxlength="12" value="{{ @$payroll->basic_hour }}" data-target=".ed">
            </td>
            <td>
                <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="numeric form-control text-right input-sm sbold" name="basic_pay" placeholder="0.00" maxlength="12" value="{{ $basic_pay }}" readonly>
                </div>
            </td>
            <td><button type="button" class="btn btn-xs btn-default btn-edit"><i class="fa fa-edit"></i></button></td>
        </tr>

        <tr>
            <td>Absence</td>
            <td>
            <input type="text" class="numeric form-control text-right input-sm ed-h" name="absence_hour" placeholder="0.00" maxlength="12" value="{{ @$payroll->absence_hour }}" data-target=".ed">
            </td>
            <td>
                <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="numeric form-control text-right input-sm ed sum" name="absence_amount" placeholder="0.00" maxlength="12" value="{{ @$payroll->absence_amount }}">
                </div>
            </td>
            <td><button type="button" class="btn btn-xs btn-default btn-clear"><i class="fa fa-close"></i></button></td>
        </tr>


        <tr>
            <td>Undertime / Tardy</td>
            <td>
            <input type="text" class="numeric form-control text-right input-sm ed-h" name="late_hour" placeholder="0.00" maxlength="12" value="{{ @$payroll->late_hour }}" data-target=".ed">
            </td>
            <td>
                <div class="input-group">
                <span class="input-group-addon">P</span>
                <input type="text" class="numeric form-control text-right input-sm ed sum" name="late_amount" placeholder="0.00" maxlength="12" value="{{ @$payroll->late_amount }}">  
                </div>
            </td>
            <td><button type="button" class="btn btn-xs btn-default btn-clear"><i class="fa fa-close"></i></button></td>
        </tr>
    </table>
</div>
