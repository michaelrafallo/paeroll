<div class="form-body margin-top-20">
    <div class="row">
        <form method="get" class="form-horizontal">
            <div class="col-md-12">
                <div class="well">
                    <div class="row">
                        <div class="col-md-6">
                        <div class="input-group">
                            <input class="form-control" type="text" name="s" placeholder="Search Name">
                            <span class="input-group-btn">
                                <button type="submit" class="btn blue"><i class="fa fa-search"></i> Search</button>
                            </span>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <a href="" class="btn btn-default"><i class="fa fa-times"></i> Clear Search</a>
                            <a class="btn btn-outline btn-default" data-toggle="modal" href="#basic"> Advanced Search </a>
                        </div>                        
                    </div>
                </div>
            </div>

            <!-- START ADVANCED SEARCH -->
            <div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <h4 class="modal-title">Advanced Search</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-body">
                            
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Status</label>
                                    <div class="col-md-9">                                    
                                        <select class="select2 form-control" name="status">
                                            <option value="" selected="selected">All Status</option>
                                            <option value="actived">Actived</option>
                                            <option value="inactived">Inactived</option>
                                            <option value="suspended">Suspended</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Per Page</label>
                                    <div class="col-md-9">
                                        <select class="select2 form-control" name="rows">
                                            <option value="15">15</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>                            

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Sort</label>
                                    <div class="col-md-9">
                                        <select class="select2 form-control" name="rows">
                                            <option value="15">Descending</option>
                                            <option value="25">Ascending</option>
                                        </select>
                                    </div>
                                </div>    
                                
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn green">Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END ADVANCED SEARCH -->

        </form>
    </div>
</div>