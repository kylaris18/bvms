@extends('layouts.adminui')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Update Account
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Update your personal info.</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form id="userForm" role="form" enctype="multipart/form-data">
                <!-- text input -->

                <!-- Offender's Name -->
                <div class="form-group">
                  <label>Last Name:</label>
                  <input id="nameLast" name="nameLast" type="text" class="form-control" placeholder="Enter Last Name..." value="<?=Session::get('userSession')['lname']?>">
                </div>
                <div class="form-group">
                  <label>First Name:</label>
                  <input id="nameFirst" name="nameFirst" type="text" class="form-control" placeholder="Enter First Name..." value="<?=Session::get('userSession')['fname']?>">
                </div>

                <div class="form-group">
                  <label>Contact Info:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-phone"></i>
                    </div>
                    <input id="contactNo" name="contactNo" type="text" class="form-control" placeholder="Enter Contact Number..." value="<?=Session::get('userSession')['user_contactno']?>">
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label>Username:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-user"></i>
                    </div>
                    <input id="userName" name="userName" type="text" class="form-control" placeholder="Enter Username..." value="<?=Session::get('userSession')['account_uname']?>">
                  </div>
                  <!-- /.input group -->
                </div>

                <div class="form-group">
                  <label>Current Password:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-lock"></i>
                    </div>
                    <input id="currPass" name="currPass" type="password" class="form-control" placeholder="Enter Current Password...">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>New Password:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-lock"></i>
                    </div>
                    <input id="newPass" name="newPass" type="password" class="form-control" placeholder="Enter New Password...">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label>Repeat Password:</label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-lock"></i>
                    </div>
                    <input id="repeatPass" name="repeatPass" type="password" class="form-control" placeholder="Repeat New Password...">
                  </div>
                  <!-- /.input group -->
                </div>

                <!-- User Photo Upload -->
                <div class="form-group">
                  <label for="userPhoto">User Photo:</label>
                  <input type="file" name="userPhoto" id="userPhoto" accept="image/x-png,image/gif,image/jpeg">
                  <img id="imagePreview" class="img-thumbnail" style="max-height: 200px; max-width: 200px" src="{{ url('/') . Session::get('userSession')['user_photo'] }}" alt="Image Preview"/>
                </div>
                <input type="hidden" name="account_id" id="accountId" value="<?=Session::get('userSession')['account_id']?>">

                <!-- Submit -->
                <div class="box-footer">
                  <button id="updateUser" class="btn btn-primary pull-right">Submit</button>
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
    
    $.ajax({
      type:'POST',
      url: '{{ url("/") }}/users/modify',
      data: oFormData,
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(aData){
        if (aData.bResult === true) {
          Swal.fire(
            'Success!',
            'User profile updated successfully.',
            'success'
          ).then(function(){
            location.reload();
          });
        } else {
          Swal.fire(
            'Error!',
            aData.sMessage,
            'warning'
          );
        }
      }
    });
  });


</script>
@endsection