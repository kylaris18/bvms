@extends('layouts.default')
@section('bodyClass')
<body class="hold-transition login-page">
@endsection
@section('body')
<div class="login-box">
  <div class="login-logo">
    <a href="/"><b>BVMS</b>ystem</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in here.</p>

    <form id="loginForm">
      @csrf
      <div class="form-group has-feedback">
        <input type="text" id="username" class="form-control" placeholder="Username">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" class="form-control" name="password" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button id="loginSubmit" type="button" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
@section('js')
<script type="text/javascript">
  $(document).on('click', '#loginSubmit', function (e) {
    e.preventDefault();
    $.ajax({
       type:'POST',
       url:'/login',
       data:{username: $('#username').val(), password: $('#password').val()},
       dataType: 'json',
       headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
       success:function(aData){
          if (aData.bResult === true) {
            location.href = '/violations/list';
          } else {
            alert('Wrong username and/or password. Please try again.');
          }
       }
    });
  });
</script>
@endsection

