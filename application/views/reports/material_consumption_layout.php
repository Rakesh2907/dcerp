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
		           	  	<?php if($sess_dep_id == '21'){$disabled='';}else if($sess_dep_id == '22'){$disabled='';}else{$disabled='disabled="disabled"';}
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
</section>
<script src="<?php echo $this->config->item("cdn_css_image")?>dist/js/reports/material_consumption.js"></script> 
<script type="text/javascript">
   $(document).ready(function(){

   		<?php if(validateAccess('Reports-material_consumption_horizonatal_bar_chart',$access)){?> 
			Highcharts.chart('horizontal_bar', {
		      chart: {
		          type: 'bar'
		      },
		      title: {
		          text: 'Month Wise Report'
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
		          name: 'Consumption',
		          data: [<?php echo $dep_cusumption_val;?>]
		      }]
		    });
		<?php } ?>	

		<?php if(validateAccess('Reports-material_consumption_line_chart',$access)){?> 
			Highcharts.chart('line_bar', {

		    title: {
		        text: 'Department Wise Report'
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
		        name: 'Consumption',
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
   });
</script>

	 	