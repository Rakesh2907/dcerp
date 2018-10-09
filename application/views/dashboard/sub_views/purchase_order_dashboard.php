<div class="col-md-4">
         <div class="box box-info" style="border-top-color:#DD4B39">
            <div class="box-header with-border">
              <h3 class="box-title">Purchase Order - Pie Chart</h3>

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
                <?php if(validateAccess('dashboard-pending_po_count',$access)){ ?>  
                  <li><a href="javascript:void(0)" onclick="load_page('purchase/purchase_order/tab_1')">Pending<span class="pull-right text-green"><?php echo $pending_po;?></span></a>
                  </li>
                <?php } ?>
                <?php if(validateAccess('dashboard-approved_po_count',$access)){ ?>     
                  <li><a href="javascript:void(0)" onclick="load_page('purchase/purchase_order/tab_2')">Approved<span class="pull-right text-yellow"><?php echo $approved_po;?></span></a></li>
                <?php } ?>
                <?php if(validateAccess('dashboard-completed_po_count',$access)){ ?>
                  <li><a href="javascript:void()" onclick="load_page('purchase/purchase_order/tab_3')">Completed<span class="pull-right text-blue"><?php echo $completed_po;?></span></a></li>
                <?php } ?> 
              </ul>
            </div>
            <!-- /.footer -->
          </div>
</div> 
<div class="col-md-8">
          <div class="box box-info" style="border-top-color:#DD4B39">
              <div class="box-header with-border">
                <h3 class="box-title">Today's Purchase Order</h3>

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
                      <th>PO Number</th>
                      <th>PO Date</th>
                      <th>Department</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                     <?php if(!empty($today_po_list)){
                          foreach ($today_po_list as $key => $po) {
                      ?>
                          <tr>
                              <td><?php echo $po['po_number']; ?></td>
                              <td><?php echo $po['po_date']; ?></td>
                              <td><?php echo $po['dep_name']; ?></td>
                              <td><?php echo ucfirst($po['approval_flag']);?></td>
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
                <?php if(validateAccess('dashboard-place_new_purchase_order',$access)){ ?>
                  <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left" onclick="load_page('purchase/add_purchase_order_form')">Place New Purchase Order</a>
                <?php } ?> 
                <?php if(validateAccess('dashboard-all_purchase_order',$access)){ ?> 
                  <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right" onclick="load_page('purchase/purchase_order')">View All Purchase Order</a>
                <?php } ?>  
              </div>
              <!-- /.box-footer -->
        </div>
</div>
<script type="text/javascript">
   $(function() {
       
  var pieChartCanvas = $('#poPieChart').get(0).getContext('2d');
  var pieChart       = new Chart(pieChartCanvas);
  var PieData        = [
    {
      value    : <?php echo $pending_po;?>,
      color    : '#00a65a',
      highlight: '#00a65a',
      label    : 'pending'
    },
    {
      value    : <?php echo $approved_po;?>,
      color    : '#f39c12',
      highlight: '#f39c12',
      label    : 'approved'
    },
    {
      value    : <?php echo $completed_po;?>,
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
   });
</script>