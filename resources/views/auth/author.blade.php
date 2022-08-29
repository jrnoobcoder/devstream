@extends('auth.auth_template')
@section('content')
<!-- <div class="main">  	

			<div class="signup">
				<form id="loginForm">
					<label for="chk" aria-hidden="true">Login</label>
					@csrf
					<input type="email" name="email" placeholder="Email">
                    <span class="danger err-message" id="email"></span>
					<input type="password" name="password" placeholder="Password">
                    <span class="danger err-message" id="password"></span>
					<button type="submit">Login</button>
				</form>
			</div>

			<div class="log-sign-link-btn">
				
					<label for="chk" aria-hidden="true"> <a href="{{ url('register') }}">Sign Up</a> </label>
			</div>
	</div> -->
	<div class="main">  	
		<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup">
				<form id="quickForm">
					<label for="chk" aria-hidden="true">Sign up</label>
					@csrf
					<input type="text" name="txt" placeholder="User name">
					<input type="email" name="email" placeholder="Email">
					<input type="password" name="pswd" placeholder="Password">
					<button type="submit">Sign up</button>
				</form>
			</div>

			<div class="login">
				<form id="loginForm">
					<label for="chk" aria-hidden="true">Login</label>
					@csrf
					<input type="email" name="email" placeholder="Email">
					<input type="password" name="pswd" placeholder="Password">
					<button type="submit">Login</button>
				</form>
			</div>
	</div>
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
	        $('#quickForm').submit(function(e){
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
	                            // $("#"+key).text(value[0]);
	                            toastr.error(value[0]);
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
	        $('#loginForm').submit(function(e){
	            e.preventDefault();
	            let formData = new FormData(this);
	            alert(formData.email);
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
	                        
	                    }
	                } 
	            });
	        });

	    });
	    
	</script>
@endsection