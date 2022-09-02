@extends('auth.auth_template')
@section('content')
<div class="main">  	
		<!-- <input type="checkbox" id="chk" aria-hidden="true"> -->

			<div class="signup">
				<form id="quickForm">
					<label for="chk" aria-hidden="true">Sign up</label>
                    @csrf
					<input type="text" name="name" placeholder="User name" >
                    <span class="danger err-message" id="name"></span>
					<input type="email" name="email" placeholder="Email">
                    <span class="danger err-message" id="email"></span>
					<input type="password" name="password" placeholder="Password">
                    <span class="danger err-message" id="password"></span>
					<button type="submit" >Sign up</button>
				</form>
			</div>

			<div class="log-sign-link-btn">
					<label for="chk" aria-hidden="true"> <a href="{{url('login')}}"> Login </a></label>					
			</div>
	</div>
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
    });
    
    </script>
@endsection