<div class="col-md-4">
         <div class="box box-info" style="border-top-color:#975DC1">
            <div class="box-header with-border">
              <h3 class="box-title">STORE REQUISITION</h3>

              <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-8">
                  <div class="chart-responsive">
                    <canvas id="requisationPieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-green"></i> Pending</li>
                    <li><i class="fa fa-circle-o text-yellow"></i> Approved</li>
                    <li><i class="fa fa-circle-o text-aqua"></i> Completed</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
              <?php if(validateAccess('dashboard-pending_requisation_count',$access)){ ?>     
                  <li><a href="javascript:void(0)" onclick="load_page('store/material_requisation/tab_1')">Pending<span class="pull-right text-green"><?php echo $pending_rquisation_count;?></span></a>
                  </li>
              <?php } ?> 
              <?php if(validateAccess('dashboard-approved_requisation_count',$access)){ ?>       
                <li><a href="javascript:void(0)" onclick="load_page('store/material_requisation/tab_2')">Approved<span class="pull-right text-yellow"><?php echo $approved_requisation_count;?></span></a></li>
             <?php }?> 
            <?php if(validateAccess('dashboard-completed_requisation_count',$access)){ ?>   
                <li><a href="javascript:void()" onclick="load_page('store/material_requisation/tab_3')">Completed<span class="pull-right text-blue"><?php echo $completed_requisation_count;?></span></a></li>
            <?php } ?>
              </ul>
            </div>
            <!-- /.footer -->
          </div>
</div> 
<div class="col-md-4">
          <div class="box box-info" style="border-top-color:#975DC1;">
              <div class="box-header with-border">
                <h3 class="box-title">TODAY'S STORE REQUISITION</h3>

                <div class="box-tools pull-right">
                 <!--  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button> -->
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                    <tr>
                      <th>Requisition Number</th>
                      <th>Requisition Date</th>
                      <th>Department</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php if(!empty($today_requisation_list)){
                          foreach ($today_requisation_list as $key => $requisations) {
                      ?>
                          <tr>
                              <td><?php echo $requisations['req_number']; ?></td>
                              <td><?php echo $requisations['req_date']; ?></td>
                              <td><?php echo $requisations['dep_name']; ?></td>
                              <td><?php echo ucfirst($requisations['approval_flag']);?></td>
                          </tr>  
                      <?php     
                          }
                      ?>
                      <?php }else{ ?>
                        <tr><td colspan="4">No record found</td></tr>
                      <?php }?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer clearfix">
               <?php if(validateAccess('dashboard-place_new_requisition',$access)){ ?>      
                  <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left" onclick="load_page('store/add_requisation_form')">Place New Requisition</a>
               <?php } ?> 
               <?php if(validateAccess('dashboard-view_all_requisition',$access)){ ?>
                <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right" onclick="load_page('store/material_requisation')">View All Requisition</a>
               <?php } ?> 
              </div>
              <!-- /.box-footer -->
        </div>
</div>
<div class="col-md-4">
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Stocks Status</h3>
            </div>
            <div class="box-body">
              <div id="donut-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
</div>
<script type="text/javascript">
   $(function() {
       
  var pieChartCanvas = $('#requisationPieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [
    {
      value    : <?php echo $pending_rquisation_count;?>,
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'pending'
    },
    {
      value    : <?php echo $approved_requisation_count;?>,
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'approved'
    },
    {
      value    : <?php echo $completed_requisation_count;?>,
      color    : '#00c0ef',
      highlight: '#00c0ef',
      label    : 'completed'
    }
  ];
  var pieOptions     = {
    // Boolean - Whether we should show a stroke on each segment
    segmentShowStroke    : true,
    // String - The colour of each segment stroke
    segmentStrokeColor   : '#fff',
    // Number - The width of each segment stroke
    segmentStrokeWidth   : 1,
    // Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    // Number - Amount of animation steps
    animationSteps       : 100,
    // String - Animation easing effect
    animationEasing      : 'easeOutBounce',
    // Boolean - Whether we animate the rotation of the Doughnut
    animateRotate        : true,
    // Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale         : false,
    // Boolean - whether to make the chart responsive to window resizing
    responsive           : true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio  : false,
    // String - A legend template
    legendTemplate       : '<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
    // String - A tooltip template
    tooltipTemplate      : '<%=value %> <%=label%> Requisation'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
   
  var donutData = [
      { label: 'Expired Stocks(QTY)', data: <?php echo $total_expire_stocks;?>, color: '#3c8dbc' },
      { label: 'Usable Stocks(QTY)', data: <?php echo $remaining_stocks;?>, color: '#0073b7' },
  ]
 $.plot('#donut-chart', donutData, {
      series: {
        pie: {
          show       : true,
          radius     : 1,
          innerRadius: 0.0,
          label      : {
            show     : true,
            radius   : 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }

        }
      },
      legend: {
        show: true
      }
    })
    /*
     * END DONUT CHART
     */
   });

   function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }
</script>