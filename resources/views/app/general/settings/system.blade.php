
<div class="form-group">
    <label class="col-md-3 control-label">Site Title <span class="required">*</span></label>
    <div class="col-md-8">
        <input type="text" class="form-control rtip" name="site_title" placeholder="Site Title" value="{{ @$info->site_title }}">
    </div>
</div>
<div class="form-group">
    <label class="col-md-3 control-label">Copy Right <span class="required">*</span></label>
    <div class="col-md-8">
        <input type="text" class="form-control rtip" name="copy_right" placeholder="Copy Right" value="{{ @$info->copy_right }}"> 
    </div>
</div>



<div class="form-group margin-top-30">
    <label class="col-md-3 control-label">Logo</label>
    <div class="col-md-4">

        <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail setting-logo" data-trigger="fileinput" style="min-width: 150px; min-height: 150px;"> 
                <img src="{{ asset(@$info->logo) }}">
            </div>
            <div>
                <span class="btn blue btn-outline btn-file">
                <span class="fileinput-new"> Select image </span>
                <span class="fileinput-exists"> Change </span>
                <input type="file" name="logo"> </span>
                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
            </div>
        </div>

    </div>
</div>