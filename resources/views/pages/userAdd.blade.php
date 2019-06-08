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
                  <label>Middle Name:</label>
                  <input id="nameInit" name="nameInit" type="text" class="form-control" placeholder="Enter Middle Name...">
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
<script type="text/javascript">
  // Autocomplete setup
  // var aLastname = [];
  // var aFirstname = [];
  // var aMiddlename = [];
  // aViolators.forEach(function(aViolator) {
  //   // Setup last name
  //   if (aLastname.indexOf(aViolator['violator_lname']) === -1) {
  //     aLastname.push(aViolator['violator_lname']);
  //     aFirstname[aViolator['violator_lname']] = [];
  //   }
  //   // Setup first name
  //   if (aFirstname.hasOwnProperty(aViolator['violator_lname']) === true) {
  //     aFirstname[aViolator['violator_lname']].push(aViolator['violator_fname']);
  //   } else {
  //     aFirstname[aViolator['violator_lname']] = [aViolator['violator_fname']];
  //     aMiddlename[aViolator['violator_lname'] + '-' + aViolator['violator_fname']] = [];
  //   }
  //   // Setup Middle name
  //   if (aMiddlename.hasOwnProperty(aViolator['violator_lname'] + '-' + aViolator['violator_fname']) === true) {
  //     aMiddlename[aViolator['violator_lname'] + '-' + aViolator['violator_fname']].push(aViolator['violator_mname']);
  //   } else {
  //     aMiddlename[aViolator['violator_lname'] + '-' + aViolator['violator_fname']] = [aViolator['violator_mname']];
  //   }
  // });
  // $('#nameLast').autocomplete({
  //   source: aLastname
  // });


  // $('#nameLast').on('change', function(event) {
  //   $('#nameFirst').val();
  //   $('#nameInit').val();
  //   console.log($(this).val());
  //   $('#nameFirst').autocomplete({
  //     source: aFirstname[$(this).val()]
  //   });
  // });

  // $('#nameFirst').on('change', function(event) {
  //   $('#nameInit').val();
  //   $('#nameInit').autocomplete({
  //     source: aMiddlename[$('#nameLast').val() + '-' + $(this).val()]
  //   });
  // });

  // $('.select2').select2();
  // $('#violationList').on('change', function(event) {
  //   if ($('#violationOthers').is(':selected')) {
  //     $('#violationOthersClass').show();
  //   } else {
  //     $('#violationOthersClass').hide();
  //   }
  // });
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
    // console.log($('#violationForm'));
    e.preventDefault();
    var oFormData = new FormData(this);
    
    $.ajax({
      type:'POST',
      url: '{{ url("/") }}/users/addUser',
      data: oFormData,
      dataType:'JSON',
      contentType: false,
      cache: false,
      processData: false,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success:function(aData){
        console.log(aData);
        // if (aData.bResult === true) {
        //   location.href = '/violations/list';
        // } else {
        //   alert('Wrong username and/or password. Please try again.');
        // }
      }
    });
  });


</script>
@endsection