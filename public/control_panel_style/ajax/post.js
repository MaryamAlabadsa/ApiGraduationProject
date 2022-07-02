

function addNew(url,obj) {
    // dd(999);
    $(obj).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $(obj).attr('disabled',true);
    $.get(url,function (data) {
        $(obj).empty().text('add');
        $(obj).attr('disabled',false);
        Swal.fire({
            title: 'add new Post',
            footer: '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>',
            html:data['view'],
            // width:'100',
            showCancelButton: true,
            showConfirmButton: false,
            // confirmButtonText: 'Add',
            showLoaderOnConfirm: false,
            didRender:function () {

            }
        }).then(
            function () {

            }
        );
    });
}
function showImages(url,obj) {
    $(obj).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $(obj).attr('disabled',true);
    $.get(url,function (data) {
        $(obj).empty().append('showImages');
        $(obj).attr('disabled',false);
        console.log(data);

        Swal.fire({
            title: 'update lab',
            // footer: '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-left: auto;">Finish</a>',
            html:data['view'],
            width:'80%',
            showCancelButton: true,
            showConfirmButton: false,
            background:'#ae9cc9',

            // confirmButtonText: 'Add',
            showLoaderOnConfirm: false

        }).then(
            function () {

            }
        );

    });

}

function ShowOrders(url,obj) {
    $(obj).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $(obj).attr('disabled',true);
    $.get(url,function (data) {
        $(obj).empty().append('ShowOrders');
        $(obj).attr('disabled',false);
        console.log(data);
        Swal.fire({
            title: 'post orders',
            // footer: '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="margin-left: auto;">Finish</a>',
            html:data['view'],
            width:'80%',
            showCancelButton: true,
            showConfirmButton: false,
            // confirmButtonText: 'Add',
            showLoaderOnConfirm: false
        }).then(
            function () {

            }
        );
    });
}
function ShowProfileCard(url,obj) {
    $(obj).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    $(obj).attr('disabled',true);
    $.get(url,function (data) {
        // $(obj).empty().append('showProfileCard');
        $(obj).attr('disabled',false);
        console.log(data);
        Swal.fire({
            html:data['view'],
            showCancelButton: true,
            showConfirmButton: false,
            showLoaderOnConfirm: true
        }).then((value) => {
            switch (value) {

                case "btn-show-details":
                    swal("Pikachu fainted! You gained 500 XP!");
                    break;

                case "catch":
                    swal("Gotcha!", "Pikachu was caught!", "success");
                    break;

                default:
                    swal("Got away safely!");
            }
        });
    });
}

function deleteItem(url) {

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then(
        function(result){
            console.log(result);
            if (result.value){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    url: url,
                    type: 'post',
                    data: {_method:'delete'},
                    success: function (result) {
                        Toast.fire({
                            icon: result.type,
                            title: result.msg
                        });
                        $('#dataTable').DataTable().ajax.reload();
                        // return result;
                    },
                    error: function (errors) {
                    }

                });
            }
        });
}

function submitForm(event,obj){

    $('input').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    // console.log($(obj).serializeArray());
    event.preventDefault(); // avoid to execute the actual submit of the form.
    $.ajax({
        url:$(obj).attr('action'),
        type:$(obj).attr('method'),
        data:$(obj).serialize(),
        success:function(result){
            Toast.fire({
                icon: result.type,
                title: result.msg
            });
            $('#dataTable').DataTable().ajax.reload();
        },
        error:function (errors) {
            const entries = Object.entries(errors.responseJSON.errors);
            console.log(entries);
            var errors_message = document.createElement('div');
            for(let x of entries){
                if(x[0].includes('.')){
                    var key = x[0].split('.');
                    errors_message = document.createElement('div');
                    errors_message.classList.add('invalid-feedback');
                    errors_message.classList.add('show');
                    document.querySelectorAll('input[name="' + key[0] + '[]"]')[key[1]].classList.add('is-invalid');
                    errors_message.innerHTML = x[1][0];
                    document.querySelectorAll('input[name="' + key[0] + '[]"]')[key[1]].parentElement.appendChild(errors_message);
                }else {
                    // console.log(document.querySelector('input[name="' + x[0] + '"]'));
                    if (document.querySelector('input[name="' + x[0] + '"]')) {
                        errors_message = document.createElement('div');
                        errors_message.classList.add('invalid-feedback');
                        errors_message.classList.add('show');
                        document.querySelector('input[name="' + x[0] + '"]').classList.add('is-invalid');
                        errors_message.innerHTML = x[1][0];
                        document.querySelector('input[name="' + x[0] + '"]').parentElement.appendChild(errors_message);
                    }
                }
            }
        }

    });
    return false;
}
