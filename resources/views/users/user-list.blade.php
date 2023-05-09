@extends('layouts.app')
@section('content')
<html lang="en">
<head>
    <title>Wish List</title>
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">   -->
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
</head>
<body>
   <div class="container" style="margin-top:20px;">
      <h2>Users List</h2>
      <div class="col-sm-12">
        @if(session()->get('success'))
          <div class="alert alert-success">
            {{ session()->get('success') }}  
          </div>
        @endif
      </div>
      <div alin="right" style="margin-top:5px;">  <a href="{{ route('users.create')}}" class="btn btn-primary">Create New User</a> </div>
      <div style="margin-top:10px;">
      <table class="table table-busered" id="yajra_table">
         <thead>
            <tr>
            <td>User Name</td>
            <td>Email</td>
            <td>User Role</td>
            <td>Actions</td>
            </tr>
         </thead>
      </table>
    </div>
   </div>
  
   <script>
     $(function() {
           $('#yajra_table').DataTable({
           processing: true,
           serverSide: true,
           ajax: '{{ url('show_data') }}',
           columns: [

                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },                    
                    { data: 'user_role', name: 'user_role' },
                    { data: 'id', name: 'id', userable: false,
                        render: function( data, type, full, meta ) {
                          var getEditUrl = "http://"+window.location.host+"/users/"+data+"/edit";
                          $action_buttons =  "<div><div style='float:left;'><a href='"+getEditUrl+"' class='btn btn-success '>Edit</a></div>";
                          $action_buttons += "<div style='float:left;margin-left:5px;'><button class='btn btn-danger delete-user' data-user-id='"+data+"'>Delete</button></div></div>";
                          return $action_buttons;
                        }
                    }
                 ]
        });
     });
        
     
     $(document).on('click', '.delete-user', function (e) {
        
        if(confirm("Are you sure you want to DELETE this user?")){
            var user_id = $(this).data('user-id');
            $.ajax({
                   url:"{{ route('deleteUser')}}",
                   type:"post",
                   data:{'user_id':user_id, "_token": "{{ csrf_token() }}"},
                   success: function(response)
                   {
                        if ( $.fn.dataTable.isDataTable( '#yajra_table' ) ) {
                            table = $('#yajra_table').DataTable();
                            table.ajax.reload( null, false ); // user paging is not reset on reload
                            alert(response);
                        }
                   }
           });
        }
        else{
             return false;
        }       
        
     }); 
     

   </script>
 </body>
</html>
@endsection