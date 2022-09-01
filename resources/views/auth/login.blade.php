@extends('auth.auth_template')
@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
          	<div class="row">
          		<div class="col-xl-3 col-lg-4 col col-md-4 col-sm-5 m-auto pt-5 p-2">
		            <!-- jquery validation -->
		            <div class="card card-primary">
		              <div class="card-header">
		                <h3 class="card-title">Quick Example <small>jQuery Validation</small></h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form id="loginForm">
		              	@csrf
		                <div class="card-body">
		                  <div class="form-group">
		                    <label for="exampleInputEmail1">Email address</label>
		                    <input type="email" name="email" class="form-control" placeholder="Enter email">
		                  </div>
		                  <div class="form-group">
		                    <label for="exampleInputPassword1">Password</label>
		                    <input type="password" name="password" class="form-control" placeholder="Password">
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
		                  <button type="submit" class="btn btn-primary">Submit</button>
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

	<script type="text/javascript">
		$(document).ready(function(){
	        Toast = Swal.mixin({
	            toast : true,
	            position : 'top-end',
	            showConfirmButton : false,
	            timer : 5000
	        });

	    });
	    $('#loginForm').submit(function(e){
	            e.preventDefault();
	            let formData = new FormData(this);
	            $.ajax({
	                url: '{{url("userLogin")}}',
	                type: "POST",
	                data: formData,
	                processData : false,
	                contentType : false,
	                success: function(response){
	                    $('span').text('');
	                    if(response.status_code == 301){
	                        $.each(response.errors, function(key, value){
	                            // $("#"+key).text(value[0]);
	                            toastr.error(value[0]);
	                        });
	                    }else if(response.status_code == 200){
	                        Toast.fire({
                            icon : 'success',
                            title : response.message
                        })
	                        window.location = response.redirect_url;
	                        
	                    }else if(response.status_code ==201){
	                    		Toast.fire({
                            icon : 'error',
                            title : response.message
                        })
	                    }
	                } 
	            });
	        });
	</script>
@endsection