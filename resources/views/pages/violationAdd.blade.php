@extends('layouts.adminui')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Violations
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Violations Form</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form id="violationForm" role="form" enctype="multipart/form-data">
                <!-- text input -->

                <!-- Offender's Name -->
                <div class="form-group">
                  <label>Last Name:</label>
                  <input id="nameLast" name="nameLast" type="text" class="form-control" placeholder="Enter Last Name">
                </div>
                <div class="form-group">
                  <label>First Name:</label>
                  <input id="nameFirst" name="nameFirst" type="text" class="form-control" placeholder="Enter First Name">
                </div>
                <div class="form-group">
                  <label>Middle Name:</label>
                  <input id="nameInit" name="nameInit" type="text" class="form-control" placeholder="Enter Middle Name">
                </div>

                <!-- Violations -->
                <div class="form-group">
                  <label>Violation:</label>
                  <select id="violationList" name="violationList" class="form-control select2" style="width: 100%;">
                    <option selected="selected">Please select a violation...</option>
                    <option value="0" id="violationOthers">Others</option>
                    <?php
                      foreach ($aTypes as $aType) {
                      ?>
                        <option value="<?=$aType->type_id?>"><?=$aType->type_name?></option>
                    <?php
                      }
                    ?>
                  </select>
                </div>
                <div id="violationOthersClass" class="form-group" style="display: none;">
                  <label>Violation:</label>
                  <input id="violationOthersField" name="violationOthersField" type="text" class="form-control" placeholder="Enter Violation">
                </div>

                <!-- Violation Date -->
                <div class="form-group">
                  <label>Date of Violation:</label>

                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="violationDate" class="form-control pull-right" id="violationDate">
                  </div>
                  <!-- /.input group -->
                </div>

                <!-- Reporter notes -->
                <div class="form-group">
                  <label>Notes:</label>
                  <textarea class="form-control" id="violationNotes" rows="5" placeholder="Enter notes"></textarea>
                </div>

                <!-- Evidence Photo Upload -->
                <div class="form-group">
                  <label for="violationProof">Evidence Photo:</label>
                  <input type="file" name="violationProof" id="violationProof" accept="image/x-png,image/gif,image/jpeg">
                  <img id="imagePreview" class="img-thumbnail" style="max-height: 200px; max-width: 200px" src="{{ url('/') . '/storage/uploads/preview.png' }}" alt="Image Preview"/>
                </div>

                <!-- Submit -->
                <div class="box-footer">
                  <button id="addViolation" class="btn btn-primary pull-right">Submit</button>
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
<script src="{{ url('/') }}/js/select2.full.min.js"></script>
<script src="{{ url('/') }}/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
  // Autocomplete setup
  var aViolators = JSON.parse('<?=json_encode($aViolators, true)?>');
  var aLastname = [];
  var aFirstname = [];
  var aMiddlename = [];
  aViolators.forEach(function(aViolator) {
    // Setup last name
    if (aLastname.indexOf(aViolator['violator_lname']) === -1) {
      aLastname.push(aViolator['violator_lname']);
      aFirstname[aViolator['violator_lname']] = [];
    }
    // Setup first name
    if (aFirstname.hasOwnProperty(aViolator['violator_lname']) === true) {
      aFirstname[aViolator['violator_lname']].push(aViolator['violator_fname']);
    } else {
      aFirstname[aViolator['violator_lname']] = [aViolator['violator_fname']];
      aMiddlename[aViolator['violator_lname'] + '-' + aViolator['violator_fname']] = [];
    }
    // Setup Middle name
    if (aMiddlename.hasOwnProperty(aViolator['violator_lname'] + '-' + aViolator['violator_fname']) === true) {
      aMiddlename[aViolator['violator_lname'] + '-' + aViolator['violator_fname']].push(aViolator['violator_mname']);
    } else {
      aMiddlename[aViolator['violator_lname'] + '-' + aViolator['violator_fname']] = [aViolator['violator_mname']];
    }
  });
  $('#nameLast').autocomplete({
    source: aLastname
  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#violationProof").change(function() {
    readURL(this);
  });


  $('#nameLast').on('change', function(event) {
    $('#nameFirst').val();
    $('#nameInit').val();
    $('#nameFirst').autocomplete({
      source: aFirstname[$(this).val()]
    });
  });

  $('#nameFirst').on('change', function(event) {
    $('#nameInit').val();
    $('#nameInit').autocomplete({
      source: aMiddlename[$('#nameLast').val() + '-' + $(this).val()]
    });
  });

  $('.select2').select2();
  $('#violationList').on('change', function(event) {
    if ($('#violationOthers').is(':selected')) {
      $('#violationOthersClass').show();
    } else {
      $('#violationOthersClass').hide();
    }
  });
  $('#violationDate').datepicker({
    autoclose: true
  });

  $(document).on('submit', '#violationForm', function (e) {
    e.preventDefault();
    var oFormData = new FormData(this);
    oFormData.append('violationNotes', $('#violationNotes').val());
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This action will add a violation.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return fetch('{{ url("/") }}/violations/addViolation', {
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
            'Violation added successfully.',
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