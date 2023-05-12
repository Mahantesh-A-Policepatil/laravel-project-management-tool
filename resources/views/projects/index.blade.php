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
      <h2>Project List</h2>
      <div class="col-sm-12">
        @if(session()->get('success'))
          <div class="alert alert-success">
            {{ session()->get('success') }}  
          </div>
        @endif
      </div>
      @cannot('isUser')
        <div alin="right" style="margin-top:5px;">  <a href="{{ route('projects.create')}}" class="btn btn-primary">Create New Project</a> </div>
      @endcannot
      <div style="margin-top:10px;">
      <table class="table table-busered" id="yajra_project_table">
         <thead>
            <tr>
                <td>Project Name</td>
                <!-- <td>Description</td> -->
                <td>Created By</td>
                <td>Actions</td>
            </tr>
         </thead>
      </table>
    </div>
   </div>
  
   <script>
     $(function() {
           $('#yajra_project_table').DataTable({
           processing: true,
           serverSide: true,
           ajax: '{{ url('show_project_data') }}',
           columns: [
                { data: 'name', name: 'name' },
                // { data: 'description', name: 'description' },                    
                { data: 'created_by', name: 'created_by' },
                { data: 'id', name: 'id', userable: false,
                    render: function( data, type, full, meta ) {
                      var getEditUrl = "http://"+window.location.host+"/projects/"+data+"/edit";
                      var getTasksUrl = "http://"+window.location.host+"/taskList/"+data;
                      var getChartUrl = "http://"+window.location.host+"/chart/"+data;
                      $action_buttons =  "<div><div style='float:left;'><a href='"+getTasksUrl+"' class='btn btn-info '>Show Tasks</a></div>";
                      $action_buttons +=  "<div><div style='float:left;margin-left:2px;'><a href='"+getChartUrl+"' class='btn btn-warning'>Show Chart</a></div>";
                      $action_buttons +=  "<div style='float:left; margin-left:2px;'><a href='"+getEditUrl+"' class='btn btn-success'>Edit</a></div>";
                      $action_buttons += "<div style='float:left; margin-left:2px;'><button class='btn btn-danger delete-project' data-project-id='"+data+"'>Delete</button></div></div>";
                      return $action_buttons;
                    }
                }
              ]
        });
     });
 
     $(document).on('click', '.delete-project', function (e) {
        
        if(confirm("Are you sure you want to DELETE this project?")){
            var project_id = $(this).data('project-id');
            $.ajax({
                   url:"{{ route('deleteProject')}}",
                   type:"post",
                   data:{'project_id':project_id, "_token": "{{ csrf_token() }}"},
                   success: function(response)
                   {
                        if ( $.fn.dataTable.isDataTable( '#yajra_project_table' ) ) {
                            table = $('#yajra_project_table').DataTable();
                            table.ajax.reload( null, false ); // project paging is not reset on reload
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