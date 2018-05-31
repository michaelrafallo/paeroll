
<style>
table { border: 1px solid; }
td {
    font-family: monospace;    
    font-size: 12px;
}    
.table-borderless tr td {
    border-bottom: none;    
    padding: 1px 0;
}
.table-borderless { border:none; }
.table-borderless-2 { border:none; }
.table-borderless-2 tr td {
    border-bottom: none;    
    padding: 2px;
}
.border-left { border-left: 1px solid; }
.border-right { border-right: 1px solid; }
.borderless-bottom { border-bottom: none; }

tr td { border-bottom: 1px solid; }
tr:last-child td { border-bottom: none; }
.items { height: 170px; }
.divider { 
    border-bottom: 1px dashed #c6cdd2;
    width: 100%; 
    margin: 10px 0 20px;
    height: 15px;
}
.page-break {
    page-break-after: always;
}
</style>


<?php 
    $p=1; 
    $per_page = 2;
    $i=1;
?>
@foreach($rows as $row)
<?php 
    $postmeta = json_decode($row->post_content); 
    $total    = $postmeta->total;
?>

@if($i % $per_page == 0)
<div class="divider"></div>
@endif

<table cellpadding="3" cellspacing="0" width="100%">
    <tr>
        <td colspan="4" class="border-right">{{ $company_name }}</td>
        <td>NO.</td>
        <td>: {{ @$postmeta->pay_no }}</td>        
    </tr>
    <tr>
        <td width="37">EMP ID.</td>   
        <td width="130" class="border-right">: {{ @$postmeta->employee_id }}</td>
        <td width="50">PAYOUT</td>
        <td width="80" class="border-right">: {{ date('m/d/Y') }}</td>
        <td width="20">DEPT</td>
        <td width="120">: {{ @$postmeta->department }}</td>
    </tr>
    <tr>
        <td>EMP NAME</td>
        <td class="border-right">: {{ @$postmeta->fullname }}</td>
        <td>PAY PERIOD</td>
        <td class="border-right">: {{ date('m/d', strtotime($postmeta->period_start)) }} - {{ date('m/d', strtotime($postmeta->period_end)) }}</td>
        <td>LOC</td>
        <td>: {{ $address }}</td>
    </tr>
</table>


<table border="0" cellpadding="3" cellspacing="0" style="margin-top:10px;">
    <tr>
        <td align="center" colspan="3" class="border-right" width="195"><b>EARNINGS</b></td>    
        <td align="center" colspan="3" class="border-right"><b>DEDUCTIONS</b></td> 
        <td class="borderless-bottom"></td>
    </tr>

    <tr>
        <td colspan="3" class="border-right items" valign="top" style="height:330px;width:300px;">

            <table class="table-borderless" cellpadding="3" cellspacing="0" border="0">
                <tr>
                    <td width="120">DESC</td>
                    <td width="40" align="right">HOURS</td>
                    <td width="65" align="right">AMOUNT</td>
                </tr>
                <tr>
                    <td>BASIC PAY</td>
                    <td align="right">{{ number_format(@$postmeta->basic_hour, 2) }}</td>
                    <td align="right">{{ number_format(@$postmeta->basic_pay, 2) }}</td>
                </tr>
                
                <tr>
                    <td>LEGAL HOL WAGE</td>
                    <td align="right">0.00</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td>REGULAR OT</td>
                    <td align="right">0.00</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td>LEGAL HOL OT</td>
                    <td align="right">0.00</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td>SUN / SPCL HOL OT</td>
                    <td align="right">0.00</td>
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td>NIGHT PREMIUM</td>
                    <td align="right">0.00</td>                    
                    <td align="right">0.00</td>
                </tr>
                <tr>
                    <td>ALLOWANCE</td>
                    <td></td>
                    <td align="right">0.00</td>
                </tr>

                <?php $ec = $ec_total = 0; ?>
                @foreach($postmeta->add_earnings as $earning)
                    @if( $ec < $limit_other_earnings)
                    <tr>
                        <td>{{ @$earning->name }}</td>
                        <td align="right"></td>
                        <td align="right">{{ number_format(@$earning->amount, 2) }}</td>
                    </tr>
                    @else
                        <?php $ec_total += $earning->amount; ?>
                    @endif
                    <?php $ec++; ?>
                @endforeach

                @if( $ec_total && $ec > $limit_other_earnings )
                <tr>
                    <td>OTHER EARNINGS</td>
                    <td align="right"></td>
                    <td align="right">{{ number_format($ec_total, 2) }}</td>
                </tr>
                @endif

                @if( @$postmeta->absence_amount )
                <tr>
                    <td>LEAVE W/O PAY</td>
                    <td align="right">{{ number_format(@$postmeta->absence_hour, 2) }}</td>
                    <td align="right">-{{ number_format(@$postmeta->absence_amount, 2) }}</td>
                </tr>
                @endif

                @if( @$postmeta->late_amount )
                    <tr>
                        <td>UNDERTIME / TARDY</td>
                        <td align="right">{{ number_format(@$postmeta->late_hour, 2) }}</td>
                        <td align="right">-{{ number_format(@$postmeta->late_amount, 2) }}</td>
                    </tr>
                    @endif

                    <?php $dc = $dc_total = 0; ?>
                    @foreach($postmeta->add_deductions as $deduction)
                        @if( $dc < $limit_other_deductions )
                        <tr>
                            <td>{{ @$deduction->name }}</td>
                            <td align="right"></td>
                            <td align="right">-{{ number_format(@$deduction->amount, 2) }}</td>
                        </tr>
                        @else
                            <?php $dc_total += $deduction->amount; ?>
                        @endif
                        <?php $dc++; ?>
                    @endforeach

                    @if( $dc_total && $dc > $limit_other_deductions )
                    <tr>
                        <td>OTHER DEDUCTIONS</td>
                        <td align="right"></td>
                        <td align="right">-{{ number_format($dc_total, 2) }}</td>
                    </tr>
                    @endif


                <!-- up to 22 items -->

            </table>
    
        </td>
        <td colspan="3" class="border-right" valign="top" style="width:280px;">
        
            <table class="table-borderless" cellpadding="3" cellspacing="0" border="0">
                <tr>
                    <td width="70">DESC</td>
                    <td align="right" width="69">AMOUNT</td>
                    <td align="right" width="69">BALANCE</td>
                </tr>                

                <?php $total_deduction = 0; ?>
                @foreach($postmeta->deductions as $deduction)
                <tr>
                    <td>{{ $deduction->item }}</td>
                    <?php $total_deduction += $deduction->amount; ?>
                    <td align="right">{{ number_format($deduction->amount, 2) }}</td>
                    <td align="right"></td>
                </tr>
                @endforeach                
                <tr>
                    <td>TAX WITHHELD</td>
                    <?php $total_deduction += $total->tax_withheld; ?>
                    <td align="right">{{ number_format($total->tax_withheld, 2) }}</td>
                    <td align="right"></td>
                </tr>
            </table>

        </td>
        <td align="center" valign="top">
        <table width="100%" border="0" class="table-borderless-2" cellspacing="0">
            <tr>
                <td width="20" style="font-size:10px;">LEAVE</td>
                <td width="30" align="right" style="font-size:10px;">USED</td>
                <td width="30" align="right" style="font-size:10px;">BAL</td>
            </tr>
            @foreach($leaves as $leave_k => $leave_v)
            <?php
            $search = [
                'post_type'   => 'leave-history', 
                'post_name'   => $row->post_title, 
                'post_status' => 'approved', 
                'leave_code'  => $leave_k
            ];
            $leaved = $post->search($search, [], ['days', 'leave_code'])->get()->sum('days'); 
            $balance = $usermeta->get_meta($row->post_title, $leave_v);
            ?>
            <tr>
                <td>{{ $leave_k }}</td>
                <td align="right">{{ $leaved }}</td>
                <td align="right">{{ $balance }}</td>
            </tr>
            @endforeach

        </table>
        <br>

        BASIC RATE<br>
        {{ number_format($postmeta->monthly_rate, 2) }}<br><br>

        YTD GRS PAY<br>
        0.00<br><br>

        YTD TAX<br>
        0.00<br><br>

        TAX<br>
        {{ $postmeta->tax_code }}<br><br>

        CIVIL STATUS<br>
        {{ strtoupper($postmeta->civil_status) }}<br><br><br>

        NET PAY
        </td>
    </tr>
    <tr>
        <td>TOTAL</td>
        <td align="right" class="border-right" colspan="2">{{ number_format($total->basic_pay, 2) }}</td>
        <td>TOTAL</td>
        <td align="right">{{ number_format($total_deduction, 2) }}</td>
        <td align="right" class="border-right"></td>  
        <td align="center"  width="82">
            <strong>{{ number_format($total->net_pay, 2) }}</strong>
        </td>   
    </tr>
</table>

@if($i % $per_page == 0)
<div class="page-break"></div>
@endif

<?php $i++; ?>
<?php $p++; ?>
@endforeach

