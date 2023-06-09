@extends('layouts.app')
@section('content')
<!doctype html>
<html lang="en">
  <head>
    <title>Google Bar Chart</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
  <body>
  <!-- <div class="row mb-3">
      <label for="created_by" class="col-md-4 col-form-label text-md-end">{{ __('Developer') }}</label>
      <div class="col-md-6">
          <select class="form-control select2" name='created_by' id='created_by'>
              <option value=""></option>
              @foreach($users as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
              @endforeach 
          </select>
      </div>
  </div> -->
    <h2 style="text-align: center;">Laravel Google Bar Charts</h2>
    <div class="container-fluid p-5">
    <div id="barchart_material" style="width: 100%; height: 500px;"></div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Project Name : <?php echo $projectName ?>", 'Assigned User', 'Hours Logged', 'Deadline Hours'],

            @php
              foreach($taksChartData as $data) {
                  echo "[".$data['task_id'].", '".$data['task_name']."', ".$data['hours'].", ".$data['deadline_hours']."],";
              }
            @endphp
        ]);

        var options = {
          chart: {
            title: 'Bar Graph | hours',
            subtitle: 'Hours, consumed for each task',
          },
          bars: 'vertical'
        };
        var chart = new google.charts.Bar(document.getElementById('barchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

</body>
</html>
@endsection
