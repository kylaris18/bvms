@extends('layouts.adminui')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Baranggay Details
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List of Officials and General Info about our Baranggay</h3>
              <?php if (Session::get('userSession')['account_id'] === 1) echo '<button class="btn btn-primary pull-right" id="updateBrgyDetails">Update Details</button>'?>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" id="brgyForm">
                <?php
                  $bReadonly = 'readonly';
                  if (Session::get('userSession')['account_id'] === 1) {
                    $bReadonly = '';
                  }
                ?>
                <!-- text input -->
                <div class="form-group">
                  <label>Brgy Name:</label>
                  <input type="text" class="form-control" name="brgyName" placeholder="Enter Brgy Name..." value="<?=$aBrgy->brgy_name?>" <?=$bReadonly?>>
                </div>
                <div class="form-group">
                  <label>Brgy Address</label>
                  <input type="text" class="form-control" name="brgyAddress" placeholder="Enter Brgy Address..."  value="<?=$aBrgy->brgy_address?>" <?=$bReadonly?>>
                </div>
                <div class="form-group">
                  <label>Brgy Captain:</label>
                  <input type="text" class="form-control" name="brgyCaptain" placeholder="Enter ..." value="<?=$aBrgy->brgy_captain?>" <?=$bReadonly?>>
                </div>
                <div class="form-group">
                  <label>Brgy Councilors</label>
                  <?php
                    foreach ($aCouncilors as $aCouncilor) {
                      echo '<input type="text" name="brgyCouncilor[]" class="form-control" placeholder="Enter Councilor ..." value="'. $aCouncilor->councilor_name .'" '. $bReadonly .'>';
                    }
                  ?>
                </div>
                <div class="form-group">
                  <label>S.K. Chairman</label>
                  <input type="text" name="brgySk" class="form-control" placeholder="Enter ..." value="<?=$aBrgy->brgy_sk?>" <?=$bReadonly?>>
                </div>
                <div class="form-group">
                  <label>Current Tanod Count:</label>
                  <input type="text" class="form-control" placeholder="Enter ..." value="<?=$iTanod?>" readonly>
                </div>
              </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Modal for details -->
  <div class="modal modal-default fade in" id="modal-details">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Violation Details</h4>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="box-body">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="detailFiled" class="col-sm-2 control-label">Date filed:</label>
                  <div class="col-sm-4">
                    <input type="text" class="form-control" id="detailFiled">
                  </div>
                </div>
                <br/>
                <br/>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="detailDate" class="col-sm-4 control-label">Violation Date:</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="detailDate">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="detailStatus" class="col-sm-4 control-label">Status:</label>
                    <div class="col-sm-8">
                      <p id="detailStatus" class="form-control"></p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="detailViolation" class="col-sm-4 control-label">Violation:</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="detailViolation">
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="detailViolator" class="col-sm-4 control-label">Offender:</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="detailViolator">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="detailProof">Evidence Photo:</label>
                  <input type="file" name="detailProof" id="detailProof">
                </div>
                <div class="form-group">
                  <label>Notes:</label>
                  <textarea class="form-control" id="detailNotes" rows="5" placeholder="Enter notes"></textarea>
                </div>
                <div class="form-group">
                  <label>Resolution:</label>
                  <textarea class="form-control" id="detailResolution" rows="5"></textarea>
                </div>
                <input type="hidden" name="detailId" id="detailId">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer" id="detailFooter">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- Modal for resolution -->
  <div class="modal modal-info fade in" id="modal-resolution">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Resolve Violation</h4>
        </div>
        <div class="modal-body">
          <!-- Reporter notes -->
          <div class="form-group">
            <label>Resolution:</label>
            <textarea class="form-control" id="violationResolution" rows="5" placeholder="Enter resolution..."></textarea>
          </div>
        </div>
        <input type="hidden" name="iResolution" id="iResolution">
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="button" onclick="resolveViolation()" class="btn btn-outline">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- Modal for escalation -->
  <div class="modal modal-danger fade in" id="modal-escalate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
          <h4 class="modal-title">Escalate Violation</h4>
        </div>
        <div class="modal-body">
          <!-- Violation Date -->
          <form id="escalateForm" role="form" enctype="multipart/form-data">
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
              <textarea class="form-control" id="violationNotes" rows="5" placeholder="Enter notes..."></textarea>
            </div>

            <!-- Evidence Photo Upload -->
            <div class="form-group">
              <label for="violationProof">Evidence Photo:</label>
              <input type="file" name="violationProof" id="violationProof" accept="image/x-png,image/gif,image/jpeg">
              <img id="imagePreview" class="img-thumbnail" style="max-height: 200px; max-width: 200px" src="{{ url('/') . '/storage/uploads/preview.png' }}" alt="Image Preview"/>
            </div>

            <input type="hidden" name="iViolatorId" id="iViolatorId">
            <input type="hidden" name="violationList" id="violationList">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
          <button type="button" onclick="escalateViolation()" class="btn btn-outline">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('localjs')
<script src="{{ url('/') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('/') }}/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
  $(document).on('click', '#updateBrgyDetails', function(event) {
    event.preventDefault();
    var oFormData = new FormData(document.getElementById('brgyForm'));
      Swal.fire({
        title: 'Are you sure?',
        text: "This action will modify details of the baranggay.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return fetch('{{ url("/") }}/info/modify', {
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
            'Baranggay details modified successfully.',
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