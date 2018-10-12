<div class="col-md-4">
         <div class="box box-info" style="border-top-color:#00A65A">
            <div class="box-header with-border">
              <h3 class="box-title">Quotation - Pie Chart</h3>

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
                    <canvas id="poPieChart" height="150"></canvas>
                  </div>
                  <!-- ./chart-responsive -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <ul class="chart-legend clearfix">
                    <li><i class="fa fa-circle-o text-green"></i> Request Quotation(s)</li>
                    <li><i class="fa fa-circle-o text-yellow"></i> Received Quotation(s)</li>
                    <li><i class="fa fa-circle-o text-aqua"></i> Approved Quotation(s)</li>
                  </ul>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <ul class="nav nav-pills nav-stacked">
                <?php if(validateAccess('dashboard-request_quotation',$access)){ ?>  
                  <li><a href="javascript:void(0)" onclick="load_page('purchase/quotations/tab_1')">Request Quotation(s)<span class="pull-right text-green"><?php echo $count_quotation_request;?></span></a>
                  </li>
                <?php } ?>
                <?php if(validateAccess('dashboard-received_quotation',$access)){ ?>     
                  <li><a href="javascript:void(0)" onclick="load_page('purchase/quotations/tab_2')">Received Quotation(s)<span class="pull-right text-yellow"><?php echo $count_quotation;?></span></a></li>
                <?php } ?>
                <?php if(validateAccess('dashboard-approved_quotation',$access)){ ?>
                  <li><a href="javascript:void()" onclick="load_page('purchase/quotations/tab_3')">Approved Quotation(s)<span class="pull-right text-blue"><?php echo $count_approved_quotation;?></span></a></li>
                <?php } ?> 
              </ul>
            </div>
            <!-- /.footer -->
          </div>
</div> 
<div class="col-md-8">
          <div class="box box-info" style="border-top-color:#00A65A">
              <div class="box-header with-border">
                <h3 class="box-title">Today's Received Quotation(s)</h3>

                <div class="box-tools pull-right">
                 
                </div>
              </div>
             
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table no-margin">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Request Number</th>
                      <th>Action(s)</th>
                    </tr>
                    </thead>
                    <tbody>
                     <?php if(!empty($quotation_req_details)){
                          foreach ($quotation_req_details as $key => $quotation) {
                      ?>
                          <tr>
                              <td><?php echo $quotation['quo_req_id'];?></td>
                              <td><?php echo $quotation['quotation_request_number'];?></td>
                              <td><button class="btn btn-primary" onclick="load_page('purchase/quotations/tab_2/0/<?php echo $quotation['quo_req_id']?>')">Show Quotation(s)</button></td>
                          </tr>  
                      <?php     
                          }
                      ?>
                      <?php }else{ ?>
                        <tr><td colspan="1">No record found</td></tr>
                      <?php }?>
                    </tbody>
                  </table>
                </div>
               
              </div>
        </div>
</div>
<script type="text/javascript">
   $(function() {
       
  var pieChartCanvas = $('#poPieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [
    {
      value    : <?php echo $count_quotation_request;?>,
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'Request Quotations'
    },
    {
      value    : <?php echo $count_quotation;?>,
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'Received Quotations'
    },
    {
      value    : <?php echo $count_approved_quotation;?>,
      color    : '#00c0ef',
      highlight: '#00c0ef',
      label    : 'Approved Quotations'
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
    tooltipTemplate      : '<%=value %> <%=label%>'
  };
  // Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
   });
</script>