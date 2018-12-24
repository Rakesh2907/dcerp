<div class="row" style="margin-top: 20px;">
 <?php if(validateAccess('dashboard-store_requisition_donat_chart',$access)){?> 
  <div class="col-md-2">
           <div class="box box-info" style="border-top-color:#975DC1">
              <div class="box-header with-border">
                <h3 class="box-title" style="font-size: 14px;">STORE REQUISITION(S)</h3>

                <div class="box-tools pull-right">
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                      <canvas id="requisationPieChart" height="150"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer no-padding">
                <ul class="nav nav-pills nav-stacked">
                <?php if(validateAccess('dashboard-pending_requisation_count',$access)){ ?>     
                    <li><a href="javascript:void(0)" onclick="load_page('store/material_requisation/tab_1')">Pending<span class="pull-right text-green" style="font-weight: bold;"><?php echo $pending_rquisation_count;?></span></a>
                    </li>
                <?php } ?> 
                <?php if(validateAccess('dashboard-approved_requisation_count',$access)){ ?>       
                  <li><a href="javascript:void(0)" onclick="load_page('store/material_requisation/tab_2')">HOD Approved<span class="pull-right text-yellow" style="font-weight: bold;"><?php echo $approved_requisation_count;?></span></a></li>
               <?php }?> 
              <?php if(validateAccess('dashboard-completed_requisation_count',$access)){ ?>   
                  <li><a href="javascript:void()" onclick="load_page('store/material_requisation/tab_3')">Completed<span class="pull-right text-blue" style="font-weight: bold;"><?php echo $completed_requisation_count;?></span></a></li>
              <?php } ?>
                </ul>
              </div>
              <!-- /.footer -->
            </div>
  </div>
<?php } ?>  
<?php if(validateAccess('dashboard-store_requisition_today',$access)){?> 
  <div class="col-md-4">
            <div class="box box-info" style="border-top-color:#975DC1;">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-size: 14px;">TODAY'S REQUISITION FOR STORE</h3>

                  <div class="box-tools pull-right">
                   <!--  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button> -->
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="height: 250px;overflow: auto;">
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
                          <tr><td colspan="4">No data found</td></tr>
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
                  <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right" onclick="load_page('store/material_requisation')">View All</a>
                 <?php } ?> 
                </div>
                <!-- /.box-footer -->
          </div>
  </div> 
<?php } ?> 
<?php if(validateAccess('dashboard-purchase_requisition_today',$access)){?> 
  <div class="col-md-4">
            <div class="box box-info" style="border-top-color:#00C0EF;">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-size: 14px;">TODAY'S REQUISITION FOR PURCHASE</h3>

                  <div class="box-tools pull-right">
                   <!--  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button> -->
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="height: 250px;overflow: auto;">
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
                        <?php if(!empty($today_purchase_requisation_list)){
                            foreach ($today_purchase_requisation_list as $key => $requisations) {
                        ?>
                            <tr>
                                <td><?php echo $requisations['req_number']; ?></td>
                                <td><?php echo $requisations['req_date']; ?></td>
                                <td><?php echo $requisations['dep_name']; ?></td>
                                <td><?php echo ucfirst($requisations['purchase_approval_flag']);?></td>
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
                 <?php if(validateAccess('dashboard-view_all_requisition',$access)){ ?>
                  <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right" onclick="load_page('purchase/purchase_material_requisition')">View All</a>
                 <?php } ?> 
                </div>
                <!-- /.box-footer -->
          </div>
  </div>
<?php } ?>
<?php if(validateAccess('dashboard-purchase_requisition_donat_chart',$access)){?>   
  <div class="col-md-2">
           <div class="box box-info" style="border-top-color:#00C0EF">
              <div class="box-header with-border">
                <h3 class="box-title" style="font-size: 14px;">PURCHASE REQUISITION(S)</h3>

                <div class="box-tools pull-right">
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="chart-responsive">
                      <canvas id="purRequisationPieChart" height="150"></canvas>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer no-padding">
                <ul class="nav nav-pills nav-stacked">
                <?php if(validateAccess('dashboard-pending_requisation_count',$access)){ ?>     
                    <li><a href="javascript:void(0)" onclick="load_page('purchase/purchase_material_requisition/tab_1')">Pending<span class="pull-right text-green" style="font-weight: bold;"><?php echo $purchase_pending_rquisation_count;?></span></a>
                    </li>
                <?php } ?> 
                <?php if(validateAccess('dashboard-approved_requisation_count',$access)){ ?>       
                  <li><a href="javascript:void(0)" onclick="load_page('purchase/purchase_material_requisition/tab_2')">Approved<span class="pull-right text-yellow" style="font-weight: bold;"><?php echo $purchase_approved_requisation_count;?></span></a></li>
               <?php }?> 
              <?php if(validateAccess('dashboard-completed_requisation_count',$access)){ ?>   
                  <li><a href="javascript:void()" onclick="load_page('purchase/purchase_material_requisition/tab_3')">Completed<span class="pull-right text-blue" style="font-weight: bold;"><?php echo $purchase_completed_requisation_count;?></span></a></li>
              <?php } ?>
                </ul>
              </div>
              <!-- /.footer -->
            </div>
  </div>
<?php } ?>  
</div>
<div class="row" style="margin-top: 20px;">
  <?php if(validateAccess('dashboard-batch_wise_material_expired',$access)){?>  
     <div class="col-md-6">
              <div class="box box-info" style="border-top-color:#0C84F4;">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="font-size: 14px;">BATCH WISE STATUS</h3>

                    <div class="box-tools pull-right">
                     <!--  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button> -->
                      <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body" style="height: 300px;overflow: auto;">
                    <div class="table-responsive">
                      <table class="table no-margin">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Batch Number</th>
                          <th>Material</th>
                          <th>Expire Date</th>
                          <th>Qty</th>
                          <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                          <?php if(!empty($batch_wise_listing)){ 
                              $i = 1;
                             foreach ($batch_wise_listing as $key => $batch_detail) {
                          ?>
                             <tr>
                                  <td><?php echo $i;?></td>
                                  <td><?php echo $batch_detail['batch_number']; ?></td>
                                  <td><?php echo $batch_detail['mat_name']; ?></td>
                                  <td><?php echo date('d/m/Y', strtotime($batch_detail['expire_date'])); ?></td>
                                  <td><?php echo $batch_detail['accepted_qty'];?></td>
                                  <td><?php echo expired_date_status($batch_detail['expire_date']);?></td>
                             </tr> 
                          <?php
                             $i++;     
                             }
                          }else{ ?>
                            <tr><td colspan="4">No data found</td></tr>
                          <?php }?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.table-responsive -->
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer clearfix">
                   <?php //if(validateAccess('dashboard-view_all_requisition',$access)){ ?>
                    <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right" onclick="load_page('purchase/purchase_material_requisition')">View All</a> -->
                   <?php //} ?> 
                  </div>
                  <!-- /.box-footer -->
            </div>
    </div>
  <?php } ?> 
  <?php if(validateAccess('dashboard-material_consumption_horizonatal_bar_chart',$access)){?> 
    <div class="col-md-6">
        <div class="box box-primary" style="border-top-color: #0C84F4">
           <div class="box-header with-border">
                  <i class="fa fa-bar-chart-o"></i>
                  <?php 
                      $currentMonth = date('F');
                      $last_month = date('F', strtotime($currentMonth . " last month"));
                  ?>
                  <h3 class="box-title" style="font-size: 14px;">Material Consumption</h3>
           </div>
           <div class="box-body">
              <div id="horizontal_bar" style="min-width: 310px; max-width: 800px; height: 300px; margin: 0 auto"></div>
           </div> 
        </div>  
     </div> 
  <?php } ?>   
</div>
<div class="row" style="margin-top: 20px;">
<?php if(validateAccess('dashboard-stocks_pie_chart',$access)){?>  
  <div class="col-md-4">
            <div class="box box-primary" style="border-top-color: #0C84F4">
              <div class="box-header with-border">
                <i class="fa fa-pie-chart"></i>

                <h3 class="box-title" style="font-size: 14px;">STOCK(S) STATUS</h3>
              </div>
              <div class="box-body">
                <div id="donut-chart" style="height: 300px;"></div>
              </div>
              <!-- /.box-body-->
            </div>
   </div>
<?php } ?>
<?php if(validateAccess('dashboard-vendor_unpaid_payment_status',$access)){?>     
   <div class="col-md-8">
            <div class="box box-info" style="border-top-color:#F2B307;">
                <div class="box-header with-border">
                  <h3 class="box-title" style="font-size: 14px;">Vendor Payments Status (Pending)</h3>

                  <div class="box-tools pull-right">
                  <!--  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button> -->
                    <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="height: 300px;overflow: auto;">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      <thead>
                      <tr>
                        <th>#</th>
                        <th>Invoice Number</th>
                        <th>Invoice Date</th>
                        <th>Total Amount</th>
                        <th>Installment Amount</th>
                        <th>Balance Amount</th>
                        <th>Due Date</th>
                        <th>Status</th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php if(!empty($payments_status_listing)){ 
                            $i = 1;
                           foreach ($payments_status_listing as $key => $payment_detail) {
                        ?>
                           <tr>
                                <td><?php echo $i;?></td>
                                <td><?php echo $payment_detail['invoice_number']; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($payment_detail['invoice_date'])); ?></td>
                                <td><?php echo $payment_detail['total_bill_amt'];?></td>
                                <td><?php echo $payment_detail['installment_amout'];?></td>
                                <td><?php echo $payment_detail['balance_amount'];?></td>
                                <td><?php echo date('d/m/Y', strtotime($payment_detail['due_date'])); ?></td>
                                <td><?php echo payment_due_date_status($payment_detail['due_date']);?></td>
                           </tr> 
                        <?php
                           $i++;     
                           }
                        }else{ ?>
                          <tr><td colspan="4">No data found</td></tr>
                        <?php }?>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                 <?php //if(validateAccess('dashboard-view_all_requisition',$access)){ ?>
                  <!-- <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right" onclick="load_page('purchase/purchase_material_requisition')">View All</a> -->
                 <?php //} ?> 
                </div>
                <!-- /.box-footer -->
          </div>
  </div>
<?php } ?>  
</div>  
<script type="text/javascript">
   $(function() {
       
     <?php if(validateAccess('dashboard-store_requisition_donat_chart',$access)){?>   
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
          tooltipTemplate      : '<%=value %> <%=label%> Store Requisition'
        };
        // Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);

     <?php } ?>   
     <?php if(validateAccess('dashboard-purchase_requisition_donat_chart',$access)){?>
          var pieChartCanvas1 = $('#purRequisationPieChart').get(0).getContext('2d');
          var pieChart1       = new Chart(pieChartCanvas1);
          var PieData1        = [
            {
              value    : <?php echo $purchase_pending_rquisation_count;?>,
              color    : '#00a65a',
              highlight: '#00a65a',
              label    : 'pending'
            },
            {
              value    : <?php echo $purchase_approved_requisation_count;?>,
              color    : '#f39c12',
              highlight: '#f39c12',
              label    : 'approved'
            },
            {
              value    : <?php echo $purchase_completed_requisation_count;?>,
              color    : '#00c0ef',
              highlight: '#00c0ef',
              label    : 'completed'
            }
          ];
          var pieOptions1     = {
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
            tooltipTemplate      : '<%=value %> <%=label%> Purchase Requisition'
          };
          // Create pie or douhnut chart
          // You can switch between pie and douhnut using the method below.
          pieChart1.Doughnut(PieData1, pieOptions1);
    <?php } ?>   
    <?php if(validateAccess('dashboard-stocks_pie_chart',$access)){?> 
      Highcharts.chart('donut-chart', {
          chart: {
              type: 'pie'
          },
          title: {
              text: ''
          },
          plotOptions: {
            pie: {
              colors: ['#ED561B','#24CBE5']
            } 
          },
          series: [{
              name: 'Stocks',
              data: [
                ['Expired Stocks(QTY)',<?php echo $total_expire_stocks;?>],
                ['Usable Stocks(QTY)',<?php echo $remaining_stocks;?>] 
              ]
          }]
      });
  <?php } ?>
 <?php if(validateAccess('dashboard-material_consumption_horizonatal_bar_chart',$access)){?>      
    Highcharts.chart('horizontal_bar', {
      chart: {
          type: 'bar'
      },
      title: {
          text: '<?php echo $last_month;?>'
      },
      xAxis: {
          categories: [<?php echo $departments?>]
      },
      yAxis: {
          min: 0,
          title: {
              text: 'Total Material Consumption (Rs)'
          }
      },
      legend: {
          reversed: true
      },
      plotOptions: {
          series: {
              stacking: 'normal'
          }
      },
      series: [{
          name: 'Departments',
          data: [<?php echo $dep_cusumption_val;?>]
      }]
    });
<?php } ?>
   });
</script>