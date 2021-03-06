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
        <div class="col-xs-12">
        	<div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Violators</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php
                // Get top violations
                $aTopViolations = [];

                // Set aViolatorList
                $aViolatorList = [];
                foreach ($aViolators as $aTempViolator) {
                  if ($aTempViolator->violator_mname === 'N/A') {
                    $aTempViolator->violator_mname = '';
                  }
                  $aViolatorList[$aTempViolator->violator_id] = $aTempViolator->violator_lname . ', ' . $aTempViolator->violator_fname . ' ' . $aTempViolator->violator_mname;
                }

                // Set violation types
                $aTypeList = [];

                foreach ($aTypes as $aTempType) {
                  $aTypeList[$aTempType->type_id] = $aTempType->type_name;
                }

                // Set users list
                $aUsersList = [];
                foreach ($aUsers as $aTempUsers) {
                  $aUsersList[$aTempUsers->account_id] = $aTempUsers->user_lname . ', ' . $aTempUsers->user_fname;
                }
              ?>
              <table id="violationsTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date Filed</th>
                  <th>Offender</th>
                  <th>Violation</th>
                  <th>Filed by</th>
                  <th>Date of Violation</th>
                  <th>Status</th>
                  <th>Evidence</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    foreach ($aViolations as $iKey => $aViolation) {
                      $sCurrentKey = $aViolation->violation_violator . '-' . $aViolation->type_id;
                      if (array_key_exists($sCurrentKey, $aTopViolations) === false) {
                        $aTopViolations[$sCurrentKey] = $iKey;
                      } else {
                        if ($aViolation->violation_status > $aViolations[$aTopViolations[$sCurrentKey]]->violation_status) {
                          $aTopViolations[$sCurrentKey] = $iKey;
                        }
                      }
                  ?>
                  <tr>
                    <td data-order="<?=$aViolation->violation_report?>"><a href="#" data-toggle="modal" data-target="#modal-details" onclick="fillDetails(<?=$aViolation->violation_id?>)"><?=date('Y/m/d', $aViolation->violation_report)?></a></td>
                    <td><?=$aViolatorList[$aViolation->violation_violator]?></td>
                    <td><?=$aTypeList[$aViolation->type_id]?></td>
                    <td><?=$aUsersList[$aViolation->account_id]?></td>
                    <td><?=$aViolation->violation_year . '/' . $aViolation->violation_month . '/' . $aViolation->violation_date?></td>
                    <td data-order="<?=$aViolation->violation_status?>">
                      <?php
                        // Set Status
                        if ($aViolation->violation_status === 1) {
                          $sStatus = '1st';
                          $sStatusClass = 'info';
                        } elseif ($aViolation->violation_status === 2) {
                          $sStatus = '2nd';
                          $sStatusClass = 'warning';
                        } elseif ($aViolation->violation_status === 3) {
                          $sStatus = '3rd';
                          $sStatusClass = 'danger';
                        } else {
                          $sStatus = $aViolation->violation_status . 'th';
                          $sStatusClass = 'danger';
                        }
                      ?>
                      <small class="label label-<?=$sStatusClass?>"><?=$sStatus?> offence</small>
                    </td>
                    <td><?php
                      if ($aViolation->violation_photo === 'N/A') {
                        echo 'N/A';
                      } else {
                      ?>
                        <img class="img-thumbnail" style="max-height: 200px; max-width: 200px" src="<?=url('/') . $aViolation->violation_photo?>" alt="Image Preview"/>
                      <?php
                      }
                      ?>
                    </td>
                    <td>
                      <?php
                        if ($aViolation->violation_resolution === null && $aViolation->account_id === Session::get('userSession')['account_id']) {
                      ?>
                        <button type="button" onclick="resolveSelect(<?=$aViolation->violation_id?>)" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-resolution">Resolve</button>
                      <?php
                        }
                      ?>
                      
                      <button type="button" onclick="escalateSelect(<?=$aViolation->violation_violator?>, <?=$aViolation->type_id?>)" class="btn btn-block btn-danger" data-toggle="modal" data-target="#modal-escalate">Escalate</button>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Offender</th>
                  <th>Violation</th>
                  <th>Date Filed</th>
                  <th>Filed by</th>
                  <th>Date of Violation</th>
                  <th>Status</th>
                  <th>Evidence</th>
                  <th>Action</th>
                </tr>
                </tfoot>
              </table>
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
<!-- <script src="{{ url('/') }}/js/jquery.dataTables.min.js"></script> -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="{{ url('/') }}/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('/') }}/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">

    var aViolators = JSON.parse('<?=json_encode($aViolatorList, true)?>');
    var aTypeList = JSON.parse('<?=json_encode($aTypeList, true)?>');
    var aUsersList = JSON.parse('<?=json_encode($aUsersList, true)?>');
    var aViolations = JSON.parse('<?=json_encode($aViolations, true)?>');

    var oTopViolations = JSON.parse('<?=json_encode($aTopViolations, true)?>');
    console.log(oTopViolations);
    Object.keys(oTopViolations).forEach(function(sKey) {
      console.log(sKey);
      console.log(aViolations[oTopViolations[sKey]]);

    });
    

    function formatDate(iTimestamp) {
      return new Date(iTimestamp * 1000).toISOString().slice(0,10).split('-').join('/')
    }

    function generateSelect(aValues, aDisplay, sFirst) {
      var sSelect = `<select id='select` + sFirst + `' class="swal2-input"><option selected value=''>--Select ` + sFirst + `--</option>`;
      var iValuesLength = aValues.length;
      for (var iCounter = 0; iCounter < iValuesLength; iCounter++) {
        sSelect += '<option value="'+aValues[iCounter]+'">'+aDisplay[iCounter]+'</option>';
      }
      return sSelect += '</select>';
    }

    function generateReport() {
      var aViolatorList = Object.values(aViolators);
      // var aViolations = Object.values(aViolations);
      console.log(aTypeList);
      var sViolatorsHtml = '<datalist id="myCustomList">';
      var oReverseViolator = {};
      Object.keys(aViolators).forEach(function(iKey) {
        sViolatorsHtml += '<option data-violatorid="'+ iKey +'" value="'+ aViolators[iKey] +'"/>';
        oReverseViolator[aViolators[iKey]] = iKey;
      });
      sViolatorsHtml += '</datalist>';
      $('body').append(sViolatorsHtml);

      var sTypesHtml = '<datalist id="typesList">';
      var oReverseType = {};
      Object.keys(aTypeList).forEach(function(iKey) {
        sTypesHtml += '<option data-typeid="'+ iKey +'" value="'+ aTypeList[iKey] +'"/>';
        oReverseType[aTypeList[iKey]] = iKey;
      });
      sTypesHtml += '</datalist>';
      $('body').append(sTypesHtml);


      var aYearSelect = [];
      var oCurrDate = new Date();
      var iYear = oCurrDate.getFullYear();
      var iEndYear = iYear - 20;
      for (var iCurrYear = iYear; iCurrYear > iEndYear; iCurrYear--) {
        aYearSelect.push(iCurrYear);
      }
      var sYearSelect = generateSelect(aYearSelect, aYearSelect, 'Year');
      var sMonthSelect = generateSelect([1,2,3,4,5,6,7,8,9,10,11,12], ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'], 'Month');
      Swal.fire({
        title: 'Generate violator report.',
        html:  `<input type="text" list="myCustomList" id="reportId" class="swal2-input" placeholder="Choose Violator">` +
        `<input type="text" list="typesList" id="typeId" class="swal2-input" placeholder="Choose Violation Type">` +
        sMonthSelect + sYearSelect,
        // input: 'text',
        // inputAttributes: {
        //   autocapitalize: 'off',
        //   list: 'myCustomList',
        //   id: 'reportId'
        // },
        showCancelButton: true,
        confirmButtonText: 'Look up',
        showLoaderOnConfirm: true,
        preConfirm: (login) => {
          var sViolatorName = $('#reportId').val();
          if (oReverseViolator[sViolatorName] === undefined) {
            oReverseViolator[sViolatorName] = 0;
          }
          var sTypeId = $('#typeId').val();
          if (oReverseType[sTypeId] === undefined) {
            oReverseType[sTypeId] = 0;
          }
          var sYear = $('#selectYear').children('option:selected').val();
          var sMonth = $('#selectMonth').children('option:selected').val();
          return fetch(`{{ url("/") }}/report/generate/${oReverseViolator[sViolatorName]}?typeId=${oReverseType[sTypeId]}&&year=${sYear}&&month=${sMonth}`)
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
        if (result.value) {
          Swal.fire({
            title: 'Download will begin shortly...',
            timer: 2000,
            onBeforeOpen: () => {
              Swal.showLoading()
              timerInterval = setInterval(() => {
                Swal.getContent().querySelector('strong')
                  .textContent = Swal.getTimerLeft()
              }, 100)
            },
            onClose: () => {
              window.open(`{{ url("/") }}/storage/reports/${result.value.sFilename}`,'_blank');
            }
          })
        }
      })
    }

    function formatStatus(iStatus) {
      var sStatus = '';
      var sStatusClass = '';
      if (iStatus === 1) {
        sStatus = '1st';
        sStatusClass = 'info';
      } else if (iStatus === 2) {
        sStatus = '2nd';
        sStatusClass = 'warning';
      } else if (iStatus === 3) {
        sStatus = '3rd';
        sStatusClass = 'danger';
      } else {
        sStatus = iStatus + 'th';
        sStatusClass = 'danger';
      }

      return '<small class="label label-'+ sStatusClass +'">'+ sStatus +' offence</small>';
    }

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

    function fillDetails(iViolationId) {
      var aResult = aViolations.filter(obj => {
        return obj.violation_id === iViolationId
      });
      var oViolation = aResult[0];
      var bDeletable = oViolation.violation_status === aViolations[oTopViolations[oViolation.violation_violator + '-' + oViolation.type_id]].violation_status && <?=session()->get('userSession')['account_id']?> === 1;
      var bReadonly = oViolation.account_id === <?=session()->get('userSession')['account_id']?> ||  <?=session()->get('userSession')['account_id']?> === 1? false : true;
      $('#detailFiled').val(formatDate(oViolation.violation_report)).attr('readonly', true);
      $('#detailDate').val(formatDate(oViolation.violation_date)).attr('readonly', bReadonly);
      $('#detailStatus').html(formatStatus(oViolation.violation_status));
      $('#detailViolation').val(aTypeList[oViolation.type_id]).attr('readonly', true);
      $('#detailViolator').val(aViolators[oViolation.violation_violator]).attr('readonly', true);
      $('#detailNotes').text(oViolation.violation_notes).attr('readonly', bReadonly);
      $('#detailResolution').text(oViolation.violation_resolution === null ? '' : oViolation.violation_resolution).attr('readonly', bReadonly);
      if (bReadonly === true) {
        $('#detailFooter').html('<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>');
      } else {
        $('#detailFooter').html('<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button><button type="button" onclick="modifyViolation('+ iViolationId +')" class="btn btn-primary">Save changes</button>');
        $('#detailId').val(iViolationId);
      }
      if (bDeletable === true) {
        $('#detailFooter').append('<button type="button" onclick="deleteViolation('+ iViolationId +')" class="btn btn-danger">Delete Violation</button>');
      }
    }

    function modifyViolation(iViolationId) {
      var oFormData = new FormData();
      oFormData.append('violationId', $('#detailId').val());
      oFormData.append('violationDate', $('#detailDate').val());
      oFormData.append('violationProof', $('#detailProof')[0].files[0]);
      oFormData.append('violationNotes', $('#detailNotes').val());
      oFormData.append('violationResolution', $('#detailResolution').val());
      Swal.fire({
        title: 'Are you sure?',
        text: "This action will modify the selected violation.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return fetch('{{ url("/") }}/violations/modify', {
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
            'Violation modified successfully.',
            'success'
          ).then(function(){
            location.reload();
          })
        } else {
          Swal.fire(
            'Error!',
            result.value.sMessage,
            'warning'
          );
        }
      });
    }

    $('#violationsTable thead tr').clone(true).appendTo( '#violationsTable thead' );
    $('#violationsTable thead tr:eq(1) th').each( function (i) {
        var title = $(this).text();
        if (title !== "Action") {
          $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
          $( 'input', this ).on( 'keyup change', function () {
              if ( table.column(i).search() !== this.value ) {
                  table
                      .column(i)
                      .search( this.value )
                      .draw();
              }
          } );
        } else {
          $(this).text('');
        }
    } );
 
    var table = $('#violationsTable').DataTable({
      "order": [[ 0, "desc" ]],
      orderCellsTop: true,
      fixedHeader: true
    });

    $('#violationDate').datepicker({
      autoclose: true
    });

    function resolveSelect(iResolution) {
      $('#iResolution').val(iResolution);
    }

    function resolveViolation() {
      var oFormData = new FormData();
      oFormData.append('violationResolution', $('#violationResolution').val());
      oFormData.append('iResolution', $('#iResolution').val());
      Swal.fire({
        title: 'Are you sure?',
        text: "This action will resolve the offense of this violation and can't be resolved again.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return fetch('{{ url("/") }}/violations/resolve', {
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
            'Violation resolved successfully.',
            'success'
          ).then(function(){
            location.reload();
          })
        } else {
          Swal.fire(
            'Error!',
            result.value.sMessage,
            'warning'
          );
        }
      });
    }

    function escalateSelect(iViolationId, iViolationType) {
      $('#iViolatorId').val(iViolationId);
      $('#violationList').val(iViolationType);
    }

    function escalateViolation() {
      var oFormData = new FormData(document.getElementById('escalateForm'));
      oFormData.append('violationNotes', $('#violationNotes').val());
      Swal.fire({
        title: 'Are you sure?',
        text: "This action will escalate the offense of this violation",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return fetch('{{ url("/") }}/violations/escalate', {
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
            'Violation escalated successfully.',
            'success'
          ).then(function(){
            location.reload();
          })
        } else {
          Swal.fire(
            'Error!',
            result.value.sMessage,
            'warning'
          );
        }
      });
    }

    function deleteViolation(iViolationId) {
        var oFormData = new FormData();
        oFormData.append('violationId', iViolationId);
        Swal.fire({
          title: 'Are you sure?',
          text: "This action will delete the selected violation.",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes!',
          showLoaderOnConfirm: true,
          preConfirm: () => {
            return fetch('{{ url("/") }}/violations/delete', {
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
              'Violation deleted successfully.',
              'success'
            ).then(function(){
              location.reload();
            })
          } else {
            Swal.fire(
              'Error!',
              result.value.sMessage,
              'warning'
            );
          }
        });
      }
</script>
@endsection