@extends('layouts.adminui')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Account
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">New User Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form id="userForm" role="form" enctype="multipart/form-data">
                <!-- text input -->

                <!-- Offender's Name -->
                <div class="form-group">
                  <label>Last Name:</label>
                  <input id="nameLast" name="nameLast" type="text" class="form-control" placeholder="Enter Last Name...">
                </div>
                <div class="form-group">
                  <label>First Name:</label>
                  <input id="nameFirst" name="nameFirst" type="text" class="form-control" placeholder="Enter First Name...">
                </div>

                <div class="form-group">
                  <label>Contact Info:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <input id="contactNo" name="contactNo" type="text" class="form-control" placeholder="Enter Contact Number...">
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label>Username:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input id="userName" name="userName" type="text" class="form-control" placeholder="Enter Username...">
                  </div>
                  <!-- /.input group -->
                </div>

                <!-- User Photo Upload -->
                <div class="form-group">
                  <label for="userPhoto">User Photo:</label>
                  <input type="file" name="userPhoto" id="userPhoto" accept="image/x-png,image/gif,image/jpeg">
                  <img id="imagePreview" class="img-thumbnail" style="max-height: 200px; max-width: 200px" src="{{ url('/') . '/storage/uploads/preview.png' }}" alt="Image Preview"/>
                </div>

                <!-- Submit -->
                <div class="box-footer">
                  <button id="addUser" class="btn btn-primary pull-right">Submit</button>
                </div>

              </form>
            </div>
            <!-- /.box-body -->
          </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('localjs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#userPhoto").change(function() {
    readURL(this);
  });

  $(document).on('submit', '#userForm', function (e) {
    e.preventDefault();
    var oFormData = new FormData(this);

    Swal.fire({
        title: 'Are you sure?',
        text: "This action will add new baranggay tanod.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return fetch('{{ url("/") }}/users/addUser', {
            method:'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            body: oFormData
          })
            .then(response => {
              if (!response.ok) {
                throw new Error(response.statusText)
              }
              return response.json()
            })
            .catch(error => {
              Swal.showValidationMessage(
                `Request failed: ${error}`
              )
            })
        },
        allowOutsideClick: () => !Swal.isLoading()
      }).then((result) => {
        if (result.value.bResult === true) {
          Swal.fire(
            'Success!',
            'User added successfully.',
            'success'
          ).then(function(){
            location.reload();
          })
        } else {
          Swal.fire(
            'Something went wrong!',
            result.value.sMessage,
            'warning'
          )
        }
      });
  });


</script>
@endsection