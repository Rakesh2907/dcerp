<div class="clsTableParent" style="width:100%; clear:both;font-weight:bold;"> 
        <div style="width:100%; clear:both;float:right;">
            <div style="width: 100%; float:right;"> 
                <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl_logo_pdf.png" style="max-height:100%; height:30pt; float: right;" /> 
            </div>
        </div>
        <div style="width:100%; text-align:center; clear:both; margin-top:20pt; float:left;">
            <table border="1" style="width:400pt; border-collapse:collapse; clear:both; margin:0 auto; border:1px solid black;">
                <tr> 
                    <td colspan="2" style="text-align:center; color:black;font-size:12px; font-weight: bold;"> MATERIAL INDENT FORM </td>   
                </tr>
                <tr> 
                    <td style="text-align:center; color:black;font-size:10px;">STORE</td>  
                    <td style="color:black; text-align:center; font-size:10px;">Version No.: 02</td>  
                </tr>
            </table>
        </div>
        <div style="width:100%;">
            <table width="100%" align="center">
                <tr>
                    <td style="font-size:12px;"><span style="font-weight: bold;">Requisition No:</span>&nbsp;<?php echo $req_number;?></td>
                    <td align="right" style="font-size:12px;"><span style="font-weight: bold;">Requisition Date:</span>&nbsp;<?php echo $req_date;?></td>
                </tr>
            </table>
</div>
<table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse; margin-top: 2%">
               <tr style="padding: 0px;"> 
                    <th style="font-size: 12px; width: 2%;">SR No.</th>
                    <th style="font-size: 12px;">DESCRIPTION OF MATERIAL</th>
                    <th style="font-size: 12px; width: 5%;">PART NO/CAT NO</th>
                    <th style="font-size: 12px; width: 8%;">PACK SIZE/UNIT</th>
                    <th style="font-size: 12px; width: 5%; text-align: center;">QTY</th>
                    <th style="font-size: 12px; width: 15%;">SPECIFIC PROJECT NAME</th>
                    <th style="font-size: 12px;">REMARK</th>
              </tr>
              <?php 
                 if(!empty($indent_material)){
                    $i = 1;
                    foreach ($indent_material as $key => $value) {   
              ?>
                 <tr style="padding: 0px;">
                    <td style="font-size: 12px";><?php echo $i;?>.</td> 
                    <td style="font-size: 12px"><?php echo $value['mat_name'];?></td> 
                    <td style="font-size: 12px"><?php echo $value['mat_code'];?></td>
                    <td></td>
                    <td style="font-size: 12px;text-align: center;"><?php echo $value['require_qty'];?></td>
                    <td></td>
                    <td></td>  
                 </tr> 
              <?php 
                   $i++; 
                    }
               } ?>
</table>   
<table width="100%" align="center" border="1" cellpadding="0" cellpadding="0" style="border-collapse: collapse; margin-top: 80px;">
                <tr style="padding: 0px;">
                   <td style="font-size: 12px; width: 50%;"><span style="font-weight: bold;">Requisition Raised by:</span> <?php echo $req_raised_by;?><br> <span style="font-weight: bold;">Name & Sign</span></td>
                   <td style="font-size: 12px; width: 50%;"><span style="font-weight: bold;">Requisition Received by:</span> <br><span style="font-weight: bold;">Name & Sign</span></td>
                </tr>
                <tr>
                  <td style="font-size: 12px; width: 50%;"><span style="font-weight: bold;">Authorized by:</span> <?php echo $authorized_by;?><br><span style="font-weight: bold;">Name & Sign</span></td>
                  <td style="font-size: 12px; width: 50%;"><span style="font-weight: bold;">Material Received by:</span><br><span style="font-weight: bold;">Name & Sign</span></td>
                </tr>
</table>
</div>       