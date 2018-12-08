<div style="width:100%; top: 130px;">
            <table width="100%" align="center" border="1" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
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
        </div>   
        