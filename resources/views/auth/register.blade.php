@extends('auth.auth_template')
@section('content')
   <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-8 m-auto pt-5 p-2">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                      <div class="card-header">
                        <div class="row">
                            <div class="col"><h2>Signup  </h2></div>
                            <div class="col"><p class="text-right"><a class="text-right" href="{{url('login')}}"> Login</a></p></div>
                        </div>
                      </div>
                      <!-- /.card-header -->
                      <!-- form start -->
                      <form id="registerForm">
                        @csrf
                        <div class="card-body">
                          <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name">
                            <span class="text-danger" id="name"></span>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" name="email" class="form-control" placeholder="Email">
                            <span class="text-danger" id="email"></span>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password">
                            <span class="text-danger" id="password"></span>
                          </div>
                          <div class="form-group mb-0">
                            <div class="custom-control custom-checkbox">
                              <input type="checkbox" name="terms" class="custom-control-input" id="exampleCheck1">
                              <label class="custom-control-label" for="exampleCheck1">I agree to the <a href="#">terms of service</a>.</label>
                            </div>
                          </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary">Submit</button>

                            </div>
                            <div class="col-8"><p class="text-right">Existing! <a href="{{url('login')}}">Login</a></p></div>
                            </div>
                        </div>
                      </form>
                    </div>
                    <!-- /.card -->
                            </div>
                        </div>
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection
@section('externjs')
<script>
    $(document).ready(function(){
        Toast = Swal.mixin({
            toast : true,
            position : 'top-end',
            showConfirmButton : false,
            timer : 5000
        });
       $('#registerForm').submit(function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '{{url("store")}}',
                type: "POST",
                data: formData,
                processData : false,
                contentType : false,
                success: function(response){
                    $('span').text('');
                    if(response.status_code == 301){
                        $.each(response.errors, function(key, value){
                            $("#"+key).text(value[0]);
                            //toastr.error(value[0]);
                        });
                    }else if(response.status_code == 200){
                        Toast.fire({
                            icon : 'success',
                            title : response.message
                        })
                        window.location = response.redirect_url;
                        
                    }
                } 
            });
        });
    });
    
    </script>
@endsection