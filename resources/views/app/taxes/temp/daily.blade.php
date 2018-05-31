<div class="table-responsive">
<table class="table table-bordered table-striped table-condensed table-hover">
    <thead>
        <?php 
         $search['payroll_period'] = 1;
        ?>
        <tr class="info">
            <th>DAILY</th>
            @foreach(range(0, 8) as $d)
                <th class="text-center">{{ $d }}</th>
            @endforeach
        </tr>
        <tr>
            <td>
                <h5>Exemption</h5>
                Status
            </td>
            <?php
            $taxes_period = $post->search($search, [], ['payroll_period'])
                                ->where('post_type', $type)
                                ->where('post_name', 'Z')
                                ->orderBy('post_order', 'ASC')
                                ->get();
            ?>
            @foreach($taxes_period as $period)
                <?php $periodmeta = get_meta( $period->postMetas()->get() ); ?>
                <td class="text-right">
                    <h5>{{ number_format($periodmeta->exemption_amount, 2) }}</h5>
                    +{{ $periodmeta->exemption_rate }}% over
                </td>
            @endforeach                
        </tr>
    </thead>
    <tr class="active">
        <td colspan="10">A. Table for employees without qulified dependent</td>
    </tr>

    <?php $c=1; ?>
    @foreach(['Z', 'S', 'ME'] as $tax_code)
    <?php

    $taxes_period = $post->search($search, [], ['payroll_period'])
                        ->where('post_type', $type)
                        ->where('post_name', $tax_code)
                        ->orderBy('post_order', 'ASC')
                        ->get();
    ?>
    <tr>
        <td><h4><sup>{{ $c }}.</sup> {{ $tax_code }}</h4></td>
        @foreach($taxes_period as $period)
            <?php $periodmeta = get_meta( $period->postMetas()->get() ); ?>
            <td class="text-right editable post-{{ $period->id }}" 
            data-target=".post-{{ $period->id }}"
            data-id="{{ $period->id }}" 
            data-val="{{ json_encode($periodmeta) }}">

            <span class="text-muted uppercase" style="font-size:.7em;">
            {{ number_format($periodmeta->exemption_amount, 2) }}<br>
                +{{ $periodmeta->exemption_rate }}% over<br>
            </span>

            <b>{{ number_format($periodmeta->excess) }}</b>
            </td>
        @endforeach                
    </tr>
    <?php $c++; ?>
    @endforeach

    <tr class="active">
        <td colspan="10">B. Table for single / married employees with qulified dependent child(ren)</td>
    </tr>

    <?php $c=1; ?>
    @foreach(['S1', 'S2', 'S3', 'S4', 'ME1', 'ME2', 'ME3', 'ME4'] as $tax_code)
    <?php

    $taxes_period = $post->search($search, [], ['payroll_period'])
                        ->where('post_type', $type)
                        ->where('post_name', $tax_code)
                        ->orderBy('post_order', 'ASC')
                        ->get();
    ?>
    <tr>
        <td><h4><sup>{{ $c }}.</sup> {{ $tax_code }}</h4></td>
        @foreach($taxes_period as $period)
            <?php $periodmeta = get_meta( $period->postMetas()->get() ); ?>
            <td class="text-right editable post-{{ $period->id }}" 
            data-target=".post-{{ $period->id }}"
            data-id="{{ $period->id }}" 
            data-val="{{ json_encode($periodmeta) }}">
            <span class="text-muted uppercase" style="font-size:.7em;">
            {{ number_format($periodmeta->exemption_amount, 2) }}<br>
                +{{ $periodmeta->exemption_rate }}% over<br>
            </span>

            <b>{{ number_format($periodmeta->excess) }}</b>
            </td>
        @endforeach                
    </tr>
    <?php $c++; ?>
    @endforeach

</table>
</div>