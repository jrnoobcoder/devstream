@extends('layout.admin_template')
@section('content')


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Genre Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Genre Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                <!-- left column -->
                    <div class="col-md-6 m-auto">
                        <!-- general form elements -->
                        <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Quick Example</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
        
                        <form id="genreForm">
                        @csrf
                        <div class="card-body">
                          <div class="form-group">
                            <label for="genrename">Genre Name</label>
                            <input type="text" name="genre_name" id="genrename" class="form-control" placeholder="Name">
                            <span class="text-danger" id="genre_name"></span>
                          </div>
                    
                          <div class="form-group">
                            <label for="genrestatus">Genre Status</label>
                            <select name="status" id="genrestatus" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0" >In Active</option>
                            </select>
                            <span class="text-danger" id="status"></span>
                          </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                          <div class="row">
                            <!-- <div class="col-4"> -->
                                <!-- <input type="submit" class="btn btn-primary" value="Submit"/> -->
                                <button type="submit" class="btn btn-primary">Submit</button>
                            <!-- </div> -->
                            
                            </div>
                        </div>
                      </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

@endsection

@section('externaljs')
<script>
    $(document).ready(function(){
        Toast = Swal.mixin({
            toast : true,
            position : 'top-end',
            showConfirmButton : false,
            timer : 5000
        });
       $('#genreForm').submit(function(e){
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '{{url("admin/storegenre")}}',
                type: "POST",
                data: formData,
                processData : false,
                contentType : false,
                success: function(response){
                    $('span').text('');
                    if(response.status_code == 301){
                        $.each(response.errors, function(key, value){
                            $("#genreForm #"+key).text(value[0]);
                            // toastr.error(value[0]);
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