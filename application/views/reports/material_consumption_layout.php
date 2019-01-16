<!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Reports
        <small>Material Consumption</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url()?>dashboard/index"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reports</li>
      </ol>
</section>
<section class="content">
	 <div class="row">
	 	 <?php if(validateAccess('Reports-material_consumption_horizonatal_bar_chart',$access)){?> 
	 		<div class="col-md-6">
		        <div class="box box-primary" style="border-top-color: #0C84F4">
		           <div class="box-header with-border">
		                 <div class="col-md-4"> 
			                  <select class="form-control" style="width: 100%" id="month_list" name="month_list">
			                  	<?php foreach($month_list as $key => $val){ 
			                  		 $selected = '';
			                  		 if($last_month == $key){
			                  		 	$selected = 'selected="selected"';
			                  		 }
			                  	?>
			                  		<option value="<?php echo $key?>" <?php echo $selected;?>><?php echo $val?></option>
			                  	<?php }?>
			                  </select>
			             </div>
			             <div class="col-md-4">      
			                  <select class="form-control" style="width: 100%" id="last_years" name="last_years">
			                  	<?php foreach($last_years as $ykey => $yval){ 
			                  		 $selected = '';	
			                  		 if($ykey == $selected_year){
			                  		 	$selected = 'selected="selected"';
			                  		 }
			                  	?>
			                  		<option value="<?php echo $ykey?>" <?php echo $selected;?>><?php echo $yval?></option>
			                  	<?php }?>
			                  </select>
			            </div>
			            <div class="col-md-4">
			            	<button type="button" class="btn btn-primary pull-right" onclick="load_page('reports/material_consumption')">Reset</button>
			            	<button type="button" class="btn btn-primary pull-right" style="margin-right: 10px;" onclick="horizontal_bar_submit()">Submit</button>
			            </div>      
		           </div>
		           <div class="box-body">
		              <div id="horizontal_bar" style="min-width: 310px; max-width: 800px; height: 300px; margin: 0 auto"></div>
		           </div> 
		        </div>  
     		</div>
     	 <?php } ?>	
     	 <?php if(validateAccess('Reports-material_consumption_line_chart',$access)){?> 
     		<div class="col-md-6">
     			 <div class="box box-primary" style="border-top-color: #0C84F4">
		           <div class="box-header with-border">
		           	  <div class="col-md-4">
		           	  	<?php 
		           	  		/*if($sess_dep_id == '21'){
		           	  			 $disabled='';
		           	  		}else if($sess_dep_id == '22'){
		           	  			 $disabled='';
		           	  		}*/
		           	  		if(is_array($access_dep) && in_array($sess_dep_id, $access_dep)){
		           	  			$disabled='';
		           	  		}else{
		           	  			$disabled='disabled="disabled"';
		           	  		}
						?>
		           	  	 <select class="form-control" style="width: 100%" id="dep_id" name="dep_id" <?php echo $disabled;?>>
		           	  	 	<?php foreach($departments_list as $dkey => $dval){ 
		           	  	 				$selected = '';
		           	  	 				if($dep_id == $dval['dep_id']){
		           	  	 					$selected = 'selected="selected"';
		           	  	 				}
		           	  	 	?>
		           	  	 				<option value="<?php echo $dval['dep_id']?>" <?php echo $selected;?>><?php echo $dval['dep_name']?></option>
		           	  	    <?php } ?>		
		           	  	 </select> 	
		           	  </div>
		           	  <div class="col-md-4">      
			                  <select class="form-control" style="width: 100%" id="line_last_years" name="line_last_years">
			                  	<?php foreach($last_years as $ykey => $yval){ 
			                  		 $selected = '';	
			                  		 if($ykey == $selected_line_year){
			                  		 	$selected = 'selected="selected"';
			                  		 }
			                  	?>
			                  		<option value="<?php echo $ykey?>" <?php echo $selected;?>><?php echo $yval?></option>
			                  	<?php }?>
			                  </select>
			           </div>
			           <div class="col-md-4">
			            	<button type="button" class="btn btn-primary pull-right" onclick="load_page('reports/material_consumption')">Reset</button>
			            	<button type="button" class="btn btn-primary pull-right" style="margin-right: 10px;" onclick="line_bar_submit()">Submit</button>
			           </div>	
		           </div>
		           <div class="box-body">
		              <div id="line_bar" style="min-width: 310px; max-width: 800px; height: 300px; margin: 0 auto"></div>
		           </div> 
		        </div>
     	    </div>
     	 <?php } ?>   		
	 </div>
	 <div class="row">
	 		<div class="col-md-6">
		        <div class="box box-primary" style="border-top-color: #0C84F4">
		        	<div class="box-header with-border">
		           	  <div class="col-md-4">      
			                  <select class="form-control" style="width: 100%" id="coloum_last_years" name="coloum_last_years">
			                  	<?php foreach($last_years as $ykey => $yval){ 
			                  		 $selected = '';	
			                  		 if($ykey == $selected_coloum_year){
			                  		 	$selected = 'selected="selected"';
			                  		 }
			                  	?>
			                  		<option value="<?php echo $ykey?>" <?php echo $selected;?>><?php echo $yval?></option>
			                  	<?php }?>
			                  </select>
			           </div>
			           <div class="col-md-4">
			           </div>	
			           <div class="col-md-4">
			            	<button type="button" class="btn btn-primary pull-right" onclick="load_page('reports/material_consumption')">Reset</button>
			            	<button type="button" class="btn btn-primary pull-right" style="margin-right: 10px;" onclick="column_bar_submit()">Submit</button>
			           </div>	
		           </div>
		        	<div class="box-body">
		              	<div id="req_coloumn_bar" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
		        	</div> 
		        </div>
		    </div> 
		    <div class="col-md-6">
		        <div class="box box-primary" style="border-top-color: #0C84F4">
		        	<div class="box-header with-border">
		           	  <div class="col-md-4">      
			                  <select class="form-control" style="width: 100%" id="staked_last_years" name="staked_last_years">
			                  	<?php foreach($last_years as $ykey => $yval){ 
			                  		 $selected = '';	
			                  		 if($ykey == $selected_stacked_year){
			                  		 	$selected = 'selected="selected"';
			                  		 }
			                  	?>
			                  		<option value="<?php echo $ykey?>" <?php echo $selected;?>><?php echo $yval?></option>
			                  	<?php }?>
			                  </select>
			           </div>
			           <div class="col-md-4">
			           </div>	
			           <div class="col-md-4">
			            	<button type="button" class="btn btn-primary pull-right" onclick="load_page('reports/material_consumption')">Reset</button>
			            	<button type="button" class="btn btn-primary pull-right" style="margin-right: 10px;" onclick="staked_bar_submit()">Submit</button>
			           </div>	
		           </div>
		        	<div class="box-body">
		              	<div id="po_stacked_bar" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
		        	</div> 
		        </div>
		    </div>     	
	 </div> 	
</section>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/load.js"></script>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/reports/material_consumption.js"></script> 
<script type="text/javascript">
   $(document).ready(function(){

   		<?php if(validateAccess('Reports-material_consumption_horizonatal_bar_chart',$access)){?> 
			Highcharts.chart('horizontal_bar', {
		      chart: {
		          type: 'bar'
		      },
		      title: {
		          text: 'Month Wise Report (Outward)'
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
		          name: 'Consumption / Outward',
		          data: [<?php echo $dep_cusumption_val;?>]
		      }]
		    });
		<?php } ?>	

		<?php if(validateAccess('Reports-material_consumption_line_chart',$access)){?> 
			Highcharts.chart('line_bar', {

		    title: {
		        text: 'Department Wise Report (Outward)'
		    },
		    xAxis: {
		          categories: [<?php echo $month_year_val?>]
		    },
		    yAxis: {
		        title: {
		            text: 'Total Material Consumption (Rs)'
		        }
		    },
		    legend: {
		        layout: 'vertical',
		        align: 'right',
		        verticalAlign: 'middle'
		    },

		    plotOptions: {
		        series: {
		            label: {
		                connectorAllowed: false
		            }
		        }
		    },

		    series: [{
		        name: 'Consumption / Outward',
		        data: [<?php echo $month_cusumption_val;?>]
		    }],

		    responsive: {
		        rules: [{
		            condition: {
		                maxWidth: 500
		            },
		            chartOptions: {
		                legend: {
		                    layout: 'horizontal',
		                    align: 'center',
		                    verticalAlign: 'bottom'
		                }
		            }
		        }]
		    }
		});
	  <?php } ?>


		Highcharts.chart('req_coloumn_bar', {
		    title: {
		        text: 'Purchase Material Requisition'
		    },
		    xAxis: {
		        categories: [<?php echo $store_mat_req_dep;?>]
		    },
		    labels: {
		        items: [{
		            style: {
		                left: '50px',
		                top: '18px',
		                color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
		            }
		        }]
		    },
		    colors: ['#00A65A', '#F39C12', '#00C0EF'],
		    series: [{
		        type: 'column',
		        name: 'Pending',
		        data: [<?php echo $store_mat_pending;?>]
		    }, {
		        type: 'column',
		        name: 'Approved',
		        data: [<?php echo $store_mat_approved;?>]
		    }, {
		        type: 'column',
		        name: 'Completed',
		        data: [<?php echo $store_mat_completed;?>]
		    }, {
		        type: 'pie',
		        data: [{
		            name: 'Pending',
		            y: <?php echo $store_total_pending;?>,
		            color: '#00A65A' 
		        }, {
		            name: 'HOD Approved',
		            y: <?php echo $store_total_approved;?>,
		            color: '#F39C12' 
		        }, {
		            name: 'Completed',
		            y: <?php echo $store_total_completed;?>,
		            color: '#00C0EF' 
		        }],
		        center: [50, 0],
		        size: 100,
		        showInLegend: false,
		        dataLabels: {
		            enabled: false
		        }
		    }]
		});


Highcharts.chart('po_stacked_bar', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Purchase Orders'
    },
    xAxis: {
        categories: [<?php echo $po_dep;?>]
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Number'
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
        name: 'Pending',
        data: [<?php echo $po_pending;?>]
    }, {
        name: 'Approved',
        data: [<?php echo $po_approved;?>]
    }, {
        name: 'Completed',
        data: [<?php echo $po_completed;?>]
    }, {
		        type: 'pie',
		        data: [{
		            name: 'Pending',
		            y: <?php echo $po_total_pending;?>,
		            color: '#95CEFF' 
		        }, {
		            name: 'Approved', 
		            y: <?php echo $po_total_approved;?>,
		             color: '#5C5C61' 
		            
		        }, {
		            name: 'Completed',
		            y: <?php echo $po_total_completed;?>,
		            color: '#A9FF96'
		        }],
		        center: [570, 0],
		        size: 100,
		        showInLegend: false,
		        dataLabels: {
		            enabled: false
		        }
	}]
});


   });
</script>

	 	