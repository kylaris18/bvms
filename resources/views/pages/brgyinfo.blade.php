@extends('layouts.adminui')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Violations
        <button type="button" class="btn btn-success pull-right" onclick="generateReport()">Generate Report</button>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
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

    // console.log(aViolators);
    // console.log(Object.values(aViolators));
    // console.log(aTypeList);
    // console.log(aUsersList);
    // console.log(aViolations);

    // function formatDate(iTimestamp) {
    //   return new Date(iTimestamp * 1000).toISOString().slice(0,10).split('-').join('/')
    // }

    // function generateReport() {
    //   // console.log(aViolators.1);
    //   var aViolatorList = Object.values(aViolators);
    //   var sViolatorsHtml = '<datalist id="myCustomList">';
    //   var oReverseViolator = {};
    //   Object.keys(aViolators).forEach(function(iKey) {
    //     sViolatorsHtml += '<option data-violatorid="'+ iKey +'" value="'+ aViolators[iKey] +'"/>';
    //     oReverseViolator[aViolators[iKey]] = iKey;
    //   });
    //   console.log(oReverseViolator);
    //   sViolatorsHtml += '</datalist>';
    //   $('body').append(sViolatorsHtml);
    //   Swal.fire({
    //     title: 'Generate violator report.',
    //     // html: sViolatorsHtml,
    //     input: 'text',
    //     inputAttributes: {
    //       autocapitalize: 'off',
    //       list: 'myCustomList',
    //       id: 'reportId'
    //     },
    //     showCancelButton: true,
    //     confirmButtonText: 'Look up',
    //     showLoaderOnConfirm: true,
    //     preConfirm: (login) => {
    //       var sViolatorName = $('#reportId').val();
    //       return fetch(`{{ url("/") }}/report/generate/${oReverseViolator[sViolatorName]}`)
    //         .then(response => {
    //           if (!response.ok) {
    //             throw new Error(response.statusText)
    //           }
    //           return response.json()
    //         })
    //         .catch(error => {
    //           Swal.showValidationMessage(
    //             `Request failed: ${error}`
    //           )
    //         })
    //     },
    //     allowOutsideClick: () => !Swal.isLoading()
    //   }).then((result) => {
    //     if (result.value) {
    //       console.log(result.value);
    //       Swal.fire({
    //         title: 'Download will begin shortly...',
    //         timer: 2000,
    //         onBeforeOpen: () => {
    //           Swal.showLoading()
    //           timerInterval = setInterval(() => {
    //             Swal.getContent().querySelector('strong')
    //               .textContent = Swal.getTimerLeft()
    //           }, 100)
    //         },
    //         onClose: () => {
    //           window.open(`{{ url("/") }}/storage/reports/${result.value.sFilename}`,'_blank');
    //         }
    //       })
    //     }
    //   })
    // }

    // function formatStatus(iStatus) {
    //   var sStatus = '';
    //   var sStatusClass = '';
    //   if (iStatus === 1) {
    //     sStatus = '1st';
    //     sStatusClass = 'info';
    //   } else if (iStatus === 2) {
    //     sStatus = '2nd';
    //     sStatusClass = 'warning';
    //   } else if (iStatus === 3) {
    //     sStatus = '3rd';
    //     sStatusClass = 'danger';
    //   } else {
    //     sStatus = iStatus + 'th';
    //     sStatusClass = 'danger';
    //   }

    //   return '<small class="label label-'+ sStatusClass +'">'+ sStatus +' offence</small>';
    // }

    // function readURL(input) {
    //   if (input.files && input.files[0]) {
    //     var reader = new FileReader();
        
    //     reader.onload = function(e) {
    //       $('#imagePreview').attr('src', e.target.result);
    //     }
        
    //     reader.readAsDataURL(input.files[0]);
    //   }
    // }

    // $("#violationProof").change(function() {
    //   readURL(this);
    // });

    // function fillDetails(iViolationId) {
    //   var aResult = aViolations.filter(obj => {
    //     return obj.violation_id === iViolationId
    //   });
    //   var oViolation = aResult[0];
    //   $('#detailFiled').val(formatDate(oViolation.violation_report)).attr('readonly', true);
    //   $('#detailDate').val(formatDate(oViolation.violation_date)).attr('readonly', bReadonly);
    //   $('#detailStatus').html(formatStatus(oViolation.violation_status));
    //   $('#detailViolation').val(aTypeList[oViolation.type_id]).attr('readonly', true);
    //   $('#detailViolator').val(aViolators[oViolation.violation_violator]).attr('readonly', true);
    //   $('#detailNotes').text(oViolation.violation_notes).attr('readonly', bReadonly);
    //   $('#detailResolution').text(oViolation.violation_resolution === null ? '' : oViolation.violation_resolution).attr('readonly', bReadonly);
    //   if (bReadonly === true) {
    //     $('#detailFooter').html('<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>');
    //   } else {
    //     $('#detailFooter').html('<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button><button type="button" onclick="modifyViolation('+ iViolationId +')" class="btn btn-primary">Save changes</button>');
    //     $('#detailId').val(iViolationId);
    //   }
    // }

    // function modifyViolation(iViolationId) {
    //   var oFormData = new FormData();
    //   oFormData.append('violationId', $('#detailId').val());
    //   oFormData.append('violationDate', $('#detailDate').val());
    //   oFormData.append('violationProof', $('#detailProof')[0].files[0]);
    //   oFormData.append('violationNotes', $('#detailNotes').val());
    //   oFormData.append('violationResolution', $('#detailResolution').val());
    //   Swal.fire({
    //     title: 'Are you sure?',
    //     text: "This action will modify the selected violation.",
    //     type: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes!',
    //     showLoaderOnConfirm: true,
    //     preConfirm: () => {
    //       return fetch('{{ url("/") }}/violations/modify', {
    //         method:'POST',
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         body: oFormData
    //       })
    //         .then(response => {
    //           if (!response.ok) {
    //             throw new Error(response.statusText)
    //           }
    //           return response.json()
    //         })
    //         .catch(error => {
    //           Swal.showValidationMessage(
    //             `Request failed: ${error}`
    //           )
    //         })
    //     },
    //     allowOutsideClick: () => !Swal.isLoading()
    //   }).then((result) => {
    //     console.log(result);
    //     if (result.value.bResult === true) {
    //       Swal.fire(
    //         'Success!',
    //         'Violation modified successfully.',
    //         'success'
    //       ).then(function(){
    //         location.reload();
    //       })
    //     }
    //   });
    // }

    // $('#violationsTable').DataTable({
    //   "order": [[ 0, "desc" ]]
    // });

    // $('#violationDate').datepicker({
    //   autoclose: true
    // });

    // function resolveSelect(iResolution) {
    //   $('#iResolution').val(iResolution);
    // }

    // function resolveViolation() {
    //   var oFormData = new FormData();
    //   oFormData.append('violationResolution', $('#violationResolution').val());
    //   oFormData.append('iResolution', $('#iResolution').val());
    //   Swal.fire({
    //     title: 'Are you sure?',
    //     text: "This action will resolve the offense of this violation and can't be resolved again.",
    //     type: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes!',
    //     showLoaderOnConfirm: true,
    //     preConfirm: () => {
    //       return fetch('{{ url("/") }}/violations/resolve', {
    //         method:'POST',
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         body: oFormData
    //       })
    //         .then(response => {
    //           if (!response.ok) {
    //             throw new Error(response.statusText)
    //           }
    //           return response.json()
    //         })
    //         .catch(error => {
    //           Swal.showValidationMessage(
    //             `Request failed: ${error}`
    //           )
    //         })
    //     },
    //     allowOutsideClick: () => !Swal.isLoading()
    //   }).then((result) => {
    //     console.log(result);
    //     if (result.value.bResult === true) {
    //       Swal.fire(
    //         'Success!',
    //         'Violation resolved successfully.',
    //         'success'
    //       ).then(function(){
    //         location.reload();
    //       })
    //     }
    //   });
    // }

    // function escalateSelect(iViolationId, iViolationType) {
    //   $('#iViolatorId').val(iViolationId);
    //   $('#violationList').val(iViolationType);
    // }

    // function escalateViolation() {
    //   var oFormData = new FormData(document.getElementById('escalateForm'));
    //   // oFormData.append('iViolatorId', $('#iViolatorId').val());
    //   // oFormData.append('violationList', $('#iViolationType').val());
    //   // oFormData.append('violationDate', $('#violationDate').val());
    //   oFormData.append('violationNotes', $('#violationNotes').val());
    //   Swal.fire({
    //     title: 'Are you sure?',
    //     text: "This action will escalate the offense of this violation",
    //     type: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#3085d6',
    //     cancelButtonColor: '#d33',
    //     confirmButtonText: 'Yes!',
    //     showLoaderOnConfirm: true,
    //     preConfirm: () => {
    //       return fetch('{{ url("/") }}/violations/escalate', {
    //         method:'POST',
    //         headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    //         body: oFormData
    //       })
    //         .then(response => {
    //           if (!response.ok) {
    //             throw new Error(response.statusText)
    //           }
    //           return response.json()
    //         })
    //         .catch(error => {
    //           Swal.showValidationMessage(
    //             `Request failed: ${error}`
    //           )
    //         })
    //     },
    //     allowOutsideClick: () => !Swal.isLoading()
    //   }).then((result) => {
    //     if (result.value.bResult === true) {
    //       Swal.fire(
    //         'Success!',
    //         'Violation escalated successfully.',
    //         'success'
    //       ).then(function(){
    //         location.reload();
    //       })
    //     }
    //   });
    // }
</script>
@endsection