@extends('layout.admin_template')
@section('content')
  <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->

    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <div class="row">
		              		<div class="col-9"><h3 class="card-title">DataTable with minimal features & hover style</h3></div>
		              		<!-- <div class="col-3"><span class="text-right"><a href="{{route('add-genre')}}" class="btn btn-block btn-primary">add</a></span></div> -->
		              		<div class="col-3"><span class="text-right"><button class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-default">add</button></span></div>
		              	</div>
               
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Genre Id</th>
                    <th>Genre Nmae</th>
                    <th>Genre Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($data as $d)
                  <tr>
                    <td>{{$d->genre_id}}</td>
                    <td>{{$d->genre_name}}</td>
                  
                    <td>{{($d->status==1) ? "Active" : "In Active" ; }}</td>
                    <td class="gaction">
                      <span><a class="editRecord"  data-id="{{ $d->genre_id }}"><i class="fas fa-edit"></i></a></span>&nbsp
                      <span><a class="deleteRecord " data-id="{{ $d->genre_id }}"><i class="fas fa-trash-alt"></i></a></span>&nbsp
                     
                    </td>
                  </tr>
                  @endforeach
                  
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Genre Id</th>
                    <th>Genre Nmae</th>
                    <th>Genre Status</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="formTitle">Add Genre</h4>
              <button type="button" class="close" data-dismiss="modal" data-backdrop="static" data-keyboard="false" data-target="modal-default" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
                    <div class="col-md-12 m-auto">
                        <form id="genreForm">
                        @csrf
                          <input type="hidden" name="genre_id" value=""/>
                          <div class="form-group">
                            <label for="genrename">Genre Name</label>
                            <input type="text" name="genre_name" id="genrename" class="form-control" placeholder="Name">
                            <span class="text-danger" id="genre_name"></span>
                          </div>
                    
                          <div class="form-group">
                            <label for="genrestatus">Genre Status</label>
                            <select name="status" id="genrestatus" class="form-control">
                                <option value="1" >Active</option>
                                <option value="0" >In Active</option>
                            </select>
                            <span class="text-danger" id="status"></span>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                                <!-- <input type="submit" class="btn btn-primary" value="Submit"/> -->
                                <button type="submit" id="genreBtn" class="btn btn-primary ">Submit</button>
                            </div> 
                            </div>
                      </form>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
   
@endsection
@section('externaljs')
<script>
    $(document).ready(function(){
        $(".deleteRecord").click(function(){
            var id = $(this).data("id");
            var url = "deletegenre/"+id;
            var url2 = '{{url("admin/deletegenre/")}}/'+id;
            alert(url2);
            deleteData(id, url);
        })
        $(".editRecord").click(function(){
            var id = $(this).data("id");
            var url = '{{url("admin/editgenre/")}}/'+id;
            $("#formTitle").text("Edit Genre");
            $("#genreBtn").text("Update");

            $.ajax({
                url: url,
                type: "GET",
                data: {"genre_id":id,},
                processData : false,
                contentType : false,
                success: function(response){
                    $("#genreForm input[name='genre_id']").val("");
                    $("#genreForm input[name='genre_name']").val("");
                    if(response.status_code == 200){
                      if(response.data){
                        var data =response.data;
                        $("#genreForm input[name='genre_id']").val(data['genre_id']);
                        $("#genreForm input[name='genre_name']").val(data['genre_name']);
                        $("#genreForm select[name='status']").val(data['status']);  
                      }
                      $('#modal-default').modal('show');
                    }
                } 
            });
        })

        //$(".close").click(function)
        function deleteData(id, url){
          // alert(url);
          $.ajax({
                url: url,
                type: "GET",
                data: {"genre_id":id,},
                processData : false,
                contentType : false,
                success: function(response){
                    if(response.status_code == 202){
                        Toast.fire({
                            icon : 'success',
                            title : response.message
                        })
                    }
                } 
            });
        }
           
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