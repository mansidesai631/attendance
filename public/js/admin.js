document.querySelector(".navbar-toggler").addEventListener("click", function(){
    document.querySelector("body").classList.toggle("hide-navbar");
});
$('.cs-filter .dropdown-menu').on('click', function(event){
    event.stopPropagation();
});
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
    document.querySelector("#sidebarMenu").classList.remove("show");
}

$('.staff-listing').DataTable(
    {
    "bLengthChange": false,
    searching: false,
    language: {
        searchPlaceholder: "Search",
        paginate: {
        next:'<i class="icon-item fas fa-angle-right fs-6 pt-1">',
        previous: '<i class="icon-item fas fa-angle-left fs-6 pt-1">'
        }
    }
    }
);
$('.policies-datatable').DataTable(
    {
    "bLengthChange": false,
    searching: false,
    language: {
        searchPlaceholder: "Search",
        paginate: {
        next:'<i class="icon-item fas fa-angle-right fs-6 pt-1">',
        previous: '<i class="icon-item fas fa-angle-left fs-6 pt-1">'
        }
    }
    }
);
$('.example').DataTable(
    {
    "bLengthChange" : false, 
    language: {
        searchPlaceholder: "Search"
    }
    }
);
// $('.manage-staff').DataTable(
//     {
//         searching: false,
//         "sDom": 'Rfrtlip',
//     }
// );

$('.audit-trail').DataTable(
    {
        searching: false,
        "sDom": 'Rfrtlip' 
    }
);

$('.integration-logs').DataTable(
    {
        searching: false,
        "sDom": 'Rfrtlip' 
    }
);

$('.department').DataTable(
    {
        searching: false,
        "sDom": 'Rfrtlip' 
    }
);
// $('.m-challan').DataTable(
//     {
//         searching: false,
//         "sDom": 'Rfrtlip',
//     }
// );

$('.employee-leave').DataTable(
    {
        searching: false,
        "sDom": 'Rfrtlip',
        scrollX: true,
    }
);

$('.leave-approval').DataTable(
    {
        searching: false,
        "sDom": 'Rfrtlip',
        scrollY:        "300px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   {
            left: 1,
            right: 1
        }
    }
);

$('.sms-logs').DataTable(
    {
        searching: false,
        "sDom": 'Rfrtlip' 
    }
);

if ($('#department').length) {
    $('#department').multiselect({
        columns: 1,
        placeholder: 'Select Options',
        search: true
    });
}
if ($('#designation').length) {
    $('#designation').multiselect({
        columns: 1,
        placeholder: 'Select Options',
        search: true
    });
}
// if ($('#leave-department').length) {
//     $('#leave-department').multiselect({
//         columns: 1,
//         placeholder: 'Select Options',
//         search: true
//     });
// }
if ($('#leave-designation').length) {
    $('#leave-designation').multiselect({
        columns: 1,
        placeholder: 'Select Options',
        search: true
    });
}
if ($('#category').length) {
    $('#category').multiselect({
        columns: 1,
        placeholder: 'Select Options',
        search: true
    });
}
if ($('#filters').length) {
    $('#filters').multiselect({
        columns: 1,
        placeholder: 'Select Options',
        search: true
    });
}
if ($('#site').length) {
    $('#site').multiselect({
        columns: 1,
        placeholder: 'Select Options',
        search: true
    });
}

$(".card-header-right .card-option .fa-chevron-right").click(function(){
    $(this).removeClass('fa-chevron-right');
    $(this).addClass('fa-chevron-left');
});
$(".card-header-right .card-option .fa-chevron-left").click(function(){
    $(this).removeClass('fa-chevron-left');
    $(this).addClass('fa-chevron-right');
    return false;
    // $(".card-header-right .card-option").css("width", "35px");
});

if ($('#dob').length) {
    $('#dob').datetimepicker({
        format: 'L',
    });
}

if ($('#fdol').length) {
    $('#fdol').datetimepicker({
        format: 'L',
    });
}

if ($('#ldol').length) {
    $('#ldol').datetimepicker({
        format: 'L',
    });
}

if ($('#from-date').length) {
    $('#from-date').datetimepicker({
        format: 'L',
    });
}

if ($('#to-date').length) {
    $('#to-date').datetimepicker({
        format: 'L',
    });
}


if ($('#s-mt-ye').length) {
    $('#s-mt-ye').datetimepicker({
        format: 'L',
    });
}

if ($('#joining_date').length) {
    $('#joining_date').datetimepicker({
        format: 'L',
    });
}

if ($('#deactive_date').length) {
    $('#deactive_date').datetimepicker({
        format: 'L',
    });
}

if ($('#rintime').length) {
    $('#rintime').datetimepicker({
        format: 'LT',
    });
}

if ($('#routtime').length) {
    $('#routtime').datetimepicker({
        format: 'LT',
    });
}

if ($('#expire-date').length) {
    $('#expire-date').datetimepicker({
        format: 'L',
    });
}



