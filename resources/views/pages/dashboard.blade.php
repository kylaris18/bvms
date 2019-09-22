@extends('layouts.adminui')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Baranggay Dashboard
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-lg-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3 id='personels'>0</h3>

              <p>Personels</p>
            </div>
            <div class="icon">
              <i class="fa fa-group"></i>
            </div>
            <a href="#" class="small-box-footer"></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 id='resolved'>0</h3>

              <p>Resolved Cases of This Month</p>
            </div>
            <div class="icon">
              <i class="fa fa-legal"></i>
            </div>
            <a href="#" class="small-box-footer"></a>
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 id="current">0</h3>

              <p>Total Violations This Month</p>
            </div>
            <div class="icon">
              <i class="fa fa-bar-chart"></i>
            </div>
            <a href="#" class="small-box-footer"></a>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Area Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="areaChart" style="height:250px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-6">
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="barChart" style="height:230px"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('localjs')
<script src="{{ url('/') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('/') }}/js/bootstrap-datepicker.min.js"></script>
<script src="{{ url('/') }}/js/Chart.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
  $(function () {
    <?php
      $aViolatorList = [];
      foreach ($aViolators as $aTempViolator) {
        if ($aTempViolator->violator_mname === 'N/A') {
          $aTempViolator->violator_mname = '';
        }
        $aViolatorList[$aTempViolator->violator_id] = $aTempViolator->violator_lname . ', ' . $aTempViolator->violator_fname . ' ' . $aTempViolator->violator_mname;
      }

      // Set violation types
      $aTypeList = [];

      foreach ($aTypes as $aTempType) {
        $aTypeList[$aTempType->type_id] = $aTempType->type_name;
      }

      // Set users list
      $aUsersList = [];
      foreach ($aUsers as $aTempUsers) {
        $aUsersList[$aTempUsers->account_id] = $aTempUsers->user_lname . ', ' . $aTempUsers->user_fname;
      }
    ?>
    var aViolators = JSON.parse('<?=json_encode($aViolatorList, true)?>');
    var aTypeList = JSON.parse('<?=json_encode($aTypeList, true)?>');
    var aUsersList = JSON.parse('<?=json_encode($aUsersList, true)?>');
    var aViolations = JSON.parse('<?=json_encode($aViolations, true)?>');

    console.log(aViolations);

    // fill personels
    $('#personels').text(Object.values(aUsersList).length);


    var aMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var oCurrDate = new Date();
    var iCurrMonth = oCurrDate.getMonth();
    var iCurrYear = oCurrDate.getFullYear();
    var aLabels = [];
    var aFilter = [];
    for (var iCounter = 0; iCounter < 7; iCounter++) {
      aLabels.unshift(aMonths[iCurrMonth] + ' ' + iCurrYear);
      aFilter.unshift([parseInt(iCurrMonth, 10)+1, iCurrYear, [], []]);
      iCurrMonth--;
      if (iCurrMonth == -1) {
        iCurrMonth = 11;
        iCurrYear--;
      }
    }

    var iResolvedCases = 0;
    var iCurrentCases = 0;

    var iFilterLength = aFilter.length;
    aViolations.forEach(function(aViolation){

      // count resolved and current Cases
      if (aViolation.violation_month == aFilter[iFilterLength-1][0] && aViolation.violation_year == aFilter[iFilterLength-1][1]) {
        iCurrentCases++;
        if (aViolation.violation_resolution !== null) {
          iResolvedCases++;
        }
      }

      for (var iCounter = 0; iCounter < iFilterLength; iCounter++) {
        if (aViolation.violation_month == aFilter[iCounter][0] && aViolation.violation_year == aFilter[iCounter][1]) {
          var iIncrementIdx = aFilter[iCounter][2].indexOf(aViolation.type_id);
          if (iIncrementIdx == -1) {
            aFilter[iCounter][2].push(aViolation.type_id);
            aFilter[iCounter][3].push(1);
          } else {
            aFilter[iCounter][3][iIncrementIdx]++;
          }
        }
      }
    });

    // fill resolved Cases
    $('#resolved').text(iResolvedCases);
    $('#current').text(iCurrentCases);


    function getRandomColor(){
      var aColors = [
        '#396AB1',
        '#DA7C30',
        '#3E9651',
        '#CC2529',
        '#535154',
        '#6B4C9A',
        '#922428',
        '#948B3D',
        '#fa8072',
        '#003366'
      ];
      return aColors[Math.floor(Math.random() * 10)];
      // return "#000000".replace(/0/g,function(){return (~~(Math.random()*16)).toString(16);});
    }

    function hexToRgbA(hex){
        var c;
        if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
            c= hex.substring(1).split('');
            if(c.length== 3){
                c= [c[0], c[0], c[1], c[1], c[2], c[2]];
            }
            c= '0x'+c.join('');
            return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+',1)';
        }
        throw new Error('Bad Hex');
    }
    
    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas)
    var aTypeLabels = [];
    var aTypeData = []
    var aTypeEntries = Object.entries(aTypeList);
    aTypeEntries.forEach(function(aTypes){
      aTypeLabels.push(aTypes[1]);
      aTypeData.push([]);
    })
    aFilter.forEach(function(aData){
      aTypeEntries.forEach(function(aTypes, iKey){
        var iIndex = aData[2].indexOf(parseInt(aTypes[0], 10));
        if (iIndex == -1) {
          aTypeData[iKey].push(0);
        } else {
          aTypeData[iKey].push(aData[3][iIndex]);
        }
      })
    });

    console.log(aTypeLabels);
    console.log(aTypeData);

    function getDatasets(aLabels, aDatasets){
      var aData = [];
      var iLabelLength = aLabels.length;
      for (var iCounter = 0; iCounter < iLabelLength; iCounter++) {
        var sRandomColor = getRandomColor();
        var sRgba = hexToRgbA(sRandomColor);
        var oData = {
          label               : aLabels[iCounter],
          fillColor           : sRgba,
          strokeColor         : sRgba,
          pointColor          : sRgba,
          pointStrokeColor    : sRandomColor,
          pointHighlightFill  : '#fff',
          pointHighlightStroke: sRgba,
          data                : aDatasets[iCounter]
        }
        aData.push(oData);
      }
      return aData;
    }

    var areaChartData = {
      labels  : aLabels,
      datasets: getDatasets(aTypeLabels, aTypeData)
    }

    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale               : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : false,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - Whether the line is curved between points
      bezierCurve             : true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension      : 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot                : false,
      //Number - Radius of each point dot in pixels
      pointDotRadius          : 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth     : 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius : 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke           : true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth      : 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill             : true,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio     : true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive              : true
    }

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions)


    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas                   = $('#barChart').get(0).getContext('2d')
    var barChart                         = new Chart(barChartCanvas)
    var barChartData                     = areaChartData
    barChartData.datasets[1].fillColor   = '#00a65a'
    barChartData.datasets[1].strokeColor = '#00a65a'
    barChartData.datasets[1].pointColor  = '#00a65a'
    var barChartOptions                  = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero        : true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines      : true,
      //String - Colour of the grid lines
      scaleGridLineColor      : 'rgba(0,0,0,.05)',
      //Number - Width of the grid lines
      scaleGridLineWidth      : 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines  : true,
      //Boolean - If there is a stroke on each bar
      barShowStroke           : true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth          : 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing         : 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing       : 1,
      //String - A legend template
      legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
      //Boolean - whether to make the chart responsive
      responsive              : true,
      maintainAspectRatio     : true
    }

    barChartOptions.datasetFill = false
    barChart.Bar(barChartData, barChartOptions)
  })
</script>
@endsection