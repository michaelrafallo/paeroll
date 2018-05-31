<h4 class="uppercase page-title">Statutory Data</h4>


<?php $dep = count(json_decode($info->dependents)); ?>
<h5 class="uppercase sbold text-primary margin-top-30">Tax Exemption</h5>
<h4>{{ $tax_name = tax_exemption($info->civil_status, $dep) }} ( <b>{{ $tax_code = tax_exemption($info->civil_status, $dep, true) }}</b> )</h4> 

<input type="hidden" name="tax_name" value="{{ $tax_name }}">
<input type="hidden" name="tax_code" value="{{ $tax_code }}">

<hr>
<h5 class="uppercase sbold text-primary">Spouse</h5>

<div class="form-group">
    <div class="col-md-12">
        <input type="text" class="form-control" name="spouse" placeholder="Spouse" value="{{ $info->spouse }}">
    </div>
</div>


<hr>
<h5 class="uppercase sbold text-primary">Dependents</h5>

<div class="mt-repeater">
    <div data-repeater-list="dependents">

        @if($info->dependents)
        @foreach( json_decode($info->dependents) as $dependent)
        <div data-repeater-item="" class="mt-repeater-item">
            <div class="row mt-repeater-row">
                <div class="col-md-7">
                    <h5>Name</h5>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $dependent->name }}">
                </div>
                <div class="col-md-3">
                    <h5>Date of birth</h5>
                    <input type="text" class="form-control datepicker" name="birthday" placeholder="MM-DD-YYYY" value="{{ $dependent->birthday }}">
                </div>
                <div class="col-md-1 margin-top-10">
                    <button type="button" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete">
                        <i class="fa fa-close"></i> Remove
                    </button>
                </div>
            </div>
        </div>  
        @endforeach
        @else
        <div data-repeater-item="" class="mt-repeater-item">
            <div class="row mt-repeater-row">
                <div class="col-md-7">
                    <h5>Name</h5>
                    <input type="text" class="form-control" name="name" placeholder="Name" value="">
                </div>
                <div class="col-md-3">
                    <h5>Date of birth</h5>
                    <input type="text" class="form-control datepicker" name="birthday" placeholder="MM-DD-YYYY" value="">
                </div>
                <div class="col-md-1 margin-top-10">
                    <button type="button" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete">
                        <i class="fa fa-close"></i> Remove
                    </button>
                </div>
            </div>
        </div>  
        @endif

    </div>
    <button type="button" data-repeater-create="" class="btn btn-outline blue mt-repeater-add margin-top-20">
        <i class="fa fa-plus"></i> Add Dependent</button>
</div>



<hr>
<h5 class="uppercase sbold text-primary">Bank Crediting Details</h5>

<div class="form-group">
    <div class="col-md-5">
        <h5>Account Number</h5>
        <input type="text" name="bank_account_number" class="form-control" placeholder="Account Number" value="{{ Input::old('bank_account_number', $info->bank_account_number)  }}">
    </div>

    <div class="col-md-7">
        <h5>Bank Name</h5>
        <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" value="{{ Input::old('bank_name', $info->bank_name)  }}">
    </div>
</div>



<hr>
<h5 class="uppercase sbold text-primary">Document Details</h5>

<div class="mt-repeater">
    <div data-repeater-list="my_document">

        @if($info->my_document)
        @foreach( json_decode($info->my_document) as $document)
        <div data-repeater-item="" class="mt-repeater-item">
            <div class="row mt-repeater-row">
                <div class="col-md-5">
                    <h5>Document Type</h5>
                    {{ Form::select('type', ['' => 'Select Document Type'] + $post->select_posts(['post_type' => 'government-deduction']), $document->type, ['class' => 'form-control select2'] )  }}
                </div>
                <div class="col-md-5">
                    <h5>Document Number</h5>
                    <input type="text" class="form-control" name="number" placeholder="Document Number" value="{{ $document->number }}">
                </div>
                <div class="col-md-1 margin-top-10">
                    <button type="button" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete">
                        <i class="fa fa-close"></i> Remove
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <div data-repeater-item="" class="mt-repeater-item">
            <div class="row mt-repeater-row">
                <div class="col-md-5">
                    <h5>Document Type</h5>
                    {{ Form::select('type', ['' => 'Select Document Type'] + $post->select_posts(['post_type' => 'government-deduction']), '', ['class' => 'form-control select2'] )  }}
                </div>
                <div class="col-md-5">
                    <h5>Document Number</h5>
                    <input type="text" class="form-control" name="number" placeholder="Document Number" value="">
                </div>
                <div class="col-md-1 margin-top-10">
                    <button type="button" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete">
                        <i class="fa fa-close"></i> Remove
                    </button>
                </div>
            </div>
        </div>        
        @endif

    </div>
    <button type="button" data-repeater-create="" class="btn btn-outline blue mt-repeater-add">
        <i class="fa fa-plus"></i> Add Document</button>
</div>

