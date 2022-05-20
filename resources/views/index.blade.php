<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel Ajax CRUD Tutorial</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" > -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" >

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>
<body>

<div class="container mt-2">
    <div class="row">
        <div class="col-md-12 card-header text-center font-weight-bold">
            <h2>Laravel Ajax Student CRUD Tutorial</h2>
        </div>
        <div class="col-md-12 mt-1 mb-2"><button type="button" id="addNewStudent" class="btn btn-success">Add New Student</button></div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Student Age</th>
                    <th scope="col">Student Subject</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody> 
                    @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->age }}</td>
                        <td>{{ $student->subject }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $student->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-danger delete" data-id="{{ $student->id }}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>        
</div>

<!-- boostrap model -->
<div class="modal fade" id="student-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="studentModel">Add Student</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>            
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="editStudent" name="editStudent" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Student Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Student Name" value="" maxlength="50" required="">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label for="name" class="col-sm-6 control-label">Student Age</label>
                        <div class="col-sm-12">
                            <input type="number" min="10" max="30" class="form-control" id="age" name="age" placeholder="Enter Student Age" value="" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-6 control-label">Student Subject</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter Student Subject" value="" required="">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary" id="btn-save" value="addNewStudent">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->

<script type="text/javascript">
    $(document).ready(function($){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#addNewStudent').click(function () {
            $('#editStudent').trigger("reset");
            $('#student-model').modal('show');
        });
 
        $('body').on('click', '.edit', function () {
            var id = $(this).data('id'); 
            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('edit-student') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#studentModel').html("Edit Student");
                    $('#student-model').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#age').val(res.age);
                    $('#subject').val(res.subject);
                }
            });
        });

        $('body').on('click', '.delete', function () {
            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id'); 
                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-student') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        window.location.reload();
                    }
                });
            }
        });

        $('body').on('click', '#btn-save', function (event) {
            var id = $("#id").val();
            var name = $("#name").val();
            var age = $("#age").val();
            var subject = $("#subject").val();

            $("#btn-save").html('Please Wait...');
            $("#btn-save"). attr("disabled", true);
         
            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('student') }}",
                data: {
                    id:id,
                    name:name,
                    age:age,
                    subject:subject,
                },
                dataType: 'json',
                success: function(res){
                    window.location.reload();
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                }
            });
        });
    });
</script>

<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>
</html>