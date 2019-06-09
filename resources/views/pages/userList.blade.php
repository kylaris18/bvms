@extends('layouts.adminui')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        View Users
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
        	<div class="box">
            <div class="box-header">
              <h3 class="box-title">List of Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="usersTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Contact No.</th>
                  <th>Username</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    $aAccountList = [];
                    foreach ($aAccounts as $aAccount) {
                      $aAccountList[$aAccount->account_id] = $aAccount;
                    }
                  ?>
                  <?php
                    foreach ($aUsers as $aUser) {
                      if ($aAccountList[$aUser->account_id]->account_type === 0) {
                        continue;
                      }
                  ?>
                  <tr>
                    <td><?=$aUser->user_id?></td>
                    <td><img src="http://bvms.com/img/user3-128x128.jpg"></td>
                    <td><?=$aUser->user_lname?>, <?=$aUser->user_fname?></td>
                    <td><?=$aUser->user_contactno?></td>
                    <td><?=$aAccountList[$aUser->account_id]->account_uname?></td>
                    <td>
                      <?php
                        $sStatusClass = 'success';
                        $sStatus = 'Active';
                        if ($aAccountList[$aUser->account_id]->account_suspend === 1) {
                          $sStatusClass = 'danger';
                          $sStatus = 'Suspended';
                        }
                      ?>
                      <small class="label label-<?=$sStatusClass?>"><?=$sStatus?></small>
                    </td>
                    <td>
                      <?php
                        $iSuspend = 1;
                        $sSuspendClass = 'danger';
                        $sSuspendText = 'Suspend';
                        $sSuspendPrompt = 'suspend';
                        if ($sStatus === 'Suspended') {
                          $iSuspend = 0;
                          $sSuspendClass = 'success';
                          $sSuspendText = 'Activate';
                          $sSuspendPrompt = 'activate';
                        }
                      ?>
                      <button type="button" onclick="changeStatus(<?=$aUser->account_id?>, <?=$iSuspend?>, '<?=$sSuspendPrompt?>')" class="btn btn-block btn-<?=$sSuspendClass?>" ><?=$sSuspendText?></button>
                    </td>
                  </tr>
                  <?php
                    }
                  ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Id</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Contact No.</th>
                  <th>Username</th>
                  <th>Status</th>
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
  <!-- /.content-wrapper -->
@endsection
@section('localjs')
<script src="{{ url('/') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('/') }}/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
    $('#usersTable').DataTable({
      "columnDefs": [
        { "orderable": false, "targets": 1 }
      ]
    });

    function changeStatus(iUserId, iSuspend, sPrompt) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This action will " + sPrompt + " the selected user.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return fetch('{{ url("/") }}/users/suspendUser', {
            method:'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),'Content-Type': 'application/json'},
            body: JSON.stringify({iUserId: iUserId, iSuspend: iSuspend})
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
          var sSuccessText = 'activated';
          if (iSuspend === 1) {
            sSuccessText = 'suspended';
          }
          Swal.fire(
            'Success!',
            'User ' + sSuccessText + ' successfully.',
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