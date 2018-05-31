<h5 class="uppercase page-title">Employment Data</h5>

<h5 class="uppercase sbold text-primary margin-top-30">Work History</h5>

<div class="mt-repeater">
    <div data-repeater-list="my_work">

        @if($info->my_work)
        @foreach( json_decode($info->my_work) as $work)
        <div data-repeater-item="" class="mt-repeater-item">
            <div class="row mt-repeater-row">
                <div class="col-md-6">
                    <h5>Company Name</h5>
                    <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="{{ $work->company_name }}">
                </div>

                <div class="col-md-6">
                    <h5>Position</h5>
                    <input type="text" class="form-control" name="position" placeholder="Position" value="{{ $work->position }}">
                </div>
                    
                <div class="col-md-6">
                    <h5>Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>

                    <div class="input-group">

                        <input type="text" class="form-control datepicker" name="date_start" placeholder="Start" value="{{ $work->date_start }}">
                        <span class="input-group-addon">
                        <i class="fa fa-arrow-right"></i>
                        </span>
                        <input type="text" class="form-control datepicker" name="date_end" placeholder="End" value="{{ $work->date_end }}">
                    </div>
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
                <div class="col-md-6">
                    <h5>Company Name</h5>
                    <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="">
                </div>

                <div class="col-md-6">
                    <h5>Position</h5>
                    <input type="text" class="form-control" name="position" placeholder="Position" value="">
                </div>
                    
                <div class="col-md-6">
                    <h5>Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>

                    <div class="input-group">

                        <input type="text" class="form-control datepicker" name="date_start" placeholder="Start" value="">
                        <span class="input-group-addon">
                        <i class="fa fa-arrow-right"></i>
                        </span>
                        <input type="text" class="form-control datepicker" name="date_end" placeholder="End" value="">
                    </div>
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
        <i class="fa fa-plus"></i> Add Work History</button>
</div>



<hr class="margin-top-40">
<h5 class="uppercase sbold text-primary margin-top-30">Trainings and Seminars Attended</h5>

<div class="mt-repeater">
    <div data-repeater-list="my_training">

        @if($info->my_training)
        @foreach( json_decode($info->my_training) as $training)
        <div data-repeater-item="" class="mt-repeater-item">
            <div class="row mt-repeater-row">
                <div class="col-md-3">
                    <h5>Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
                    <input type="text" class="form-control datepicker" name="date" placeholder="Date" value="{{ $training->date }}">
                </div>

                <div class="col-md-9">
                    <h5>Training / Seminar Title</h5>
                    <input type="text" class="form-control" name="title" placeholder="Training / Seminar Title" value="{{ $training->title }}">
                </div>

                <div class="col-md-6">
                    <h5>Taken At</h5>
                    <input type="text" class="form-control" name="taken_at" placeholder="Taken At" value="{{ $training->taken_at }}">
                </div>

                <div class="col-md-6">
                    <h5>Sponsored By</h5>
                    <input type="text" class="form-control" name="sponsored_by" placeholder="Sponsored By" value="{{ $training->sponsored_by }}">
                </div>

                <div class="col-md-1">
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
                <div class="col-md-3">
                    <h5>Date <small class="text-muted uppercase">( mm-dd-yyyy )</small></h5>
                    <input type="text" class="form-control datepicker" name="date" placeholder="Date" value="">
                </div>

                <div class="col-md-9">
                    <h5>Training / Seminar Title</h5>
                    <input type="text" class="form-control" name="title" placeholder="Training / Seminar Title" value="">
                </div>

                <div class="col-md-6">
                    <h5>Taken At</h5>
                    <input type="text" class="form-control" name="taken_at" placeholder="Taken At" value="">
                </div>

                <div class="col-md-6">
                    <h5>Sponsored By</h5>
                    <input type="text" class="form-control" name="sponsored_by" placeholder="Sponsored By" value="">
                </div>

                <div class="col-md-1">
                    <button type="button" data-repeater-delete="" class="btn btn-outline red mt-repeater-delete">
                        <i class="fa fa-close"></i> Remove
                    </button>
                </div>
            </div>
        </div>        
        @endif

    </div>
    <button type="button" data-repeater-create="" class="btn btn-outline blue mt-repeater-add margin-top-20">
        <i class="fa fa-plus"></i> Add Trainings & Seminars</button>
</div>

