@yield('bottom_style')

<!--[if lt IE 9]>
<script src="{{ asset('assets/global/plugins/respond.min.js') }}""></script>
<script src="{{ asset('assets/global/plugins/excanvas.min.js') }}""></script> 
<script src="{{ asset('assets/global/plugins/ie8.fix.min.js') }}""></script> 
<![endif]-->


<!-- BEGIN CORE PLUGINS -->
<script src="{{ asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}"" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/js.cookie.min.js') }}"" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}"" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}"" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>

<!-- END CORE PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('assets/global/plugins/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/app.min.js') }}"" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>


<script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/pages/scripts/ui-sweetalert.js') }}"></script>


<link rel="stylesheet" type="text/css" href="{{ asset('plugins/timepicker/mmnt.css') }}"/ >
<script src="{{ asset('plugins/timepicker/mmnt.js') }}"></script>

<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>

<!-- END THEME LAYOUT SCRIPTS -->

<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>




    

@yield('bottom_plugin_script')

@yield('bottom_script')

@yield('filter_script')

<script>
var app_init = function() {

    $('.datepicker').datepicker({
        autoclose: true,
        todayBtn: true,
        clearBtn: true,
        format: "mm-dd-yyyy"
    });
    $(".datepicker").inputmask({
          mask: "99-99-9999",
          placeholder: "MM-DD-YYYY",
    }); 
    $('.daterange-picker').datepicker({
        format: 'mm-dd-yyyy',
        todayHighlight: true,
        todayBtn: true,
        clearBtn: true,
        minDate: true,
        autoclose: true
    });
    $(".daterange-picker input").inputmask({
          mask: "99-99-9999",
          placeholder: "MM-DD-YYYY",
    }); 
    $('.select2').select2({ width: '100%'});
    $('.rtip').tooltip({ placement: 'top', title: 'Required' });

    // $('.modal').modal('hide');
}

var init_repeater = function() {
    $('.mt-repeater').each(function(){
        $(this).repeater({
            show: function () {
                $(this).slideDown();
               app_init();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this row?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            ready: function (setIndexes) {

            }

        });
    });
}
init_repeater();


var initTable = function () {

var table = $('.datatable');

    table.dataTable({

        // Internationalisation. For more info refer to http://datatables.net/manual/i18n
        "language": {
            "aria": {
                "sortAscending": ": activate to sort column ascending",
                "sortDescending": ": activate to sort column descending"
            },
            "emptyTable": "No data available in table",
            "info": "Showing _START_ to _END_ of _TOTAL_ records",
            "infoEmpty": "No records found",
            "infoFiltered": "(filtered1 from _MAX_ total records)",
            "lengthMenu": "Show _MENU_",
            "search": "Search:",
            "zeroRecords": "No matching records found",
            "paginate": {
                "previous":"Prev",
                "next": "Next",
                "last": "Last",
                "first": "First"
            }
        },

        // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
        // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
        // So when dropdowns used the scrollable div should be removed. 
        //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

        "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
        "pagingType": "bootstrap_extended",

        "lengthMenu": [
            [5, 15, 20, -1],
            [5, 15, 20, "All"] // change per page values here
        ],
        // set the initial value
        "pageLength": 5,
        "columnDefs": [{  // set default column settings
            'orderable': false,
            'targets': [0]
        }, {
            "searchable": false,
            "targets": [0]
        }],
        "order": [
            [1, "asc"]
        ] // set first column as a default sort by asc
    });
}

initTable();

function blockUI(msg) {
    $.blockUI({
        message: '<img src="{{ asset('img/loading-spinner-grey.gif') }}" /> '+msg,
        boxed: true,
        css: { padding: '20px'}
    });

    /* 
       window.setTimeout(function() {
            $.unblockUI();
        }, 1000);    
    */
}


var work_hr = {{  App\Setting::get_setting('work_hours') }};
var work_dy = {{  App\Setting::get_setting('work_days_in_year') }};

$(document).on('click', '.btn-submit', function() {
    $('.form-submit').submit();
});


$('.timepicker').TimePickerAlone({ inputFormat: "hh:mm A" });

$(".timepicker").inputmask("hh:mm t", {
      mask: "h:s t\\M",
      placeholder: "00:00 °M",
      alias: "datetime",
      hourFormat: "12",
      casing:'upper'
}); 


$(document).on('click', '.rate', function() {
    var target = $(this).data('target');
    var n = $('[name='+target+']').val();
    var total_mr = total_dr = total_hr = parseFloat(n);
    var mr = $('[name=monthly_rate]'),
        dr = $('[name=daily_rate]'),
        hr = $('[name=hourly_rate]');
    if( target == 'monthly_rate' ) {
        total_dr = mr.val() * 12 / work_dy;
        total_hr = total_dr / work_hr;
    }
    if( target == 'daily_rate' ) {
        total_mr = dr.val() * work_dy / 12;
        total_hr = n / work_hr;
    }
    if( target == 'hourly_rate' ) {
        total_dr = hr.val() * work_hr;
        total_mr = total_dr * work_dy / 12;
    }
    mr.val( total_mr.toFixed(2) );
    dr.val( total_dr.toFixed(2) );
    hr.val( total_hr.toFixed(2) );   
});

$(document).on('click','.popup', function() {
    var $this  = $(this);
    var $title = $this.data('title');
    var $body  = $this.data('body');
    var $href  = $this.data('href');
    var $target = $(this).attr('target');

    $target = ($target == '_blank') ? '_blank' : '';

    $('.popup-modal a.confirm').attr('data-target', $target);
    $('.popup-modal a.confirm').attr('data-href', $href);
    $('.popup-modal .modal-title').html($title);
    $('.popup-modal .modal-body').html($body);
});

$(document).on('click','.popup-modal .modal-footer a', function(e) {
    e.preventDefault();
    $(this).html('Processing ...').attr('disabled', 'disabled');

    var $target = $(this).attr('data-target');
    var $href = $(this).attr('data-href');

    location.href = $href;   

});

$(document).on('keyup', '.percent', function() {
    var target = $(this).data('target');
    var rate = $(this).val() / 100;
    $(target).val(rate.toFixed(2));
});


// Convert serialized data into JSON
function form_to_json (selector) {
    var ary = $(selector).serializeArray();
    var obj = {};
    for (var a = 0; a < ary.length; a++) obj[ary[a].name] = ary[a].value;
    return obj;
}


function number_format(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

$(document).on('click', '.set-click', function(e) {
    e.preventDefault();
    var target = $(this).data('target');
    var val = $(this).data('val');
    $(target).val(val);
});


$(".form-save").on('submit', function(e) {
    e.preventDefault();

    var formData = $(this),
        url      = formData.attr('action'),
        tab      = $(this).find('li.active a').attr('href');

    blockUI(blockUImsg);

    $.ajax({
        url: url, // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method 
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(response)   // A function to be called if request succeeds
        {
            var IS_JSON = true;
            try {
                var data = JSON.parse(response);
            } catch(err){
                IS_JSON = false;
            } 

            if( IS_JSON ) {
                $.each(data.details, function(key, val) {
                    $('#'+key).html('<span class="text-danger help-inline">'+val+'</div>');
                });
            } else {
                $('.load-details').html( response );
                $('.tab-pane').removeClass('active');
                $(tab).addClass('active');
                init_repeater();
                app_init();
                initTable();
                $.unblockUI();  
            }

        }
    });
});


$('.btn-preview').on('click', function(e) {
    e.preventDefault();

    var formData = $(this).closest('form');
    var href = $(this).attr('href');

    obj = form_to_json(formData);

    var str = Object.keys(obj).map(function(key) {
        return encodeURIComponent(key) + '=' + encodeURIComponent(obj[key]);
    }).join('&');

    window.open(href + str, "_blank", "toolbar=no, scrollbars=no, resizable=no, top=0, left=0, width=800, height=1000, menubar=0, titlebar=0");
});

$(document).on('click', '.ajax-save', function(e) {
    var $this    = $(this),
        target   = $this.data('target'),
        formData = $(target);
    formData.submit();
});   

jQuery(document).ready(function() {    
   app_init();
});
</script>

@include('partials.popup-modal')