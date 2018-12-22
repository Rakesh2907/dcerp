<div class="clsTableParent" style="width:100%; clear:both; font-weight:bold;"> 
        <table style="width: 80%;border-collapse:collapse;font-family:'Arial, Helvetica, sans-serif';" border="0">
            <tr>
                <td style="width: 240pt; color: #E4882C; font-size: 20px;" align="center"><b>PURCHASE ORDER</b></td>
                <td align="right" style="width: 70%">
                            <table border="0" style="width:400pt">
                                <tr><td align="right">
                                    <img src="<?php echo $this->config->item("cdn_css_image")?>dist/img/dcgl_logo_pdf.png" style="margin-top:2%;max-height:100%; height:30pt; float: right; margin-right: 10px;" />
                                </td></tr>
                                <tr><td style="text-align: right;font-size: 11px;">F-8,D-Road,MIDC Ambad, Nasik, Maharashtra-422101, India</td></tr>
                                <tr><td style="text-align: right;font-size: 11px;"><img style="width:10px;" src="<?php echo $this->config->item('cdn_css_image')?>dist/img/telephone.png"/>+91-253-660 4828, <img style="width:10px;" src="<?php echo $this->config->item('cdn_css_image')?>dist/img/mail.png"/>purchase@datarpgx.com, <img style="width:10px;" src="<?php echo $this->config->item('cdn_css_image')?>dist/img/fax-machine.png"/>+91-253-660 4848</td></tr>
                            </table> 
                </td> 
            </tr>
            <tr>
               <td style="text-align: center; background-color: #E4882C; color: #FFFFFF" colspan="2"><b style="font-size: 12px;">P.O. DETAILS</b></td> 
            </tr>
            <tr>
                <td colspan="2">
                    <table border="0" style="width:600pt; margin-top: 15pt; margin-bottom: 10pt: " align="center">
                        <tr>
                            <td style="width: 25%; text-align: center; font-size: 12px;"><?php echo $po_number;?></td>
                            <td style="width: 25%; text-align: center; font-size: 12px;"><?php echo $po_date;?></td>
                            <td style="width: 25%; text-align: center; font-size: 12px;"><?php echo $dep_name;?></td>
                            <td style="width: 25%; text-align: center; font-size: 12px;"><?php echo $quotation_number;?></td>
                        </tr>
                        <tr>
                            <td style="width: 25%; text-align: center; border-top: 1px solid gray;"><b style="font-size: 11px;">P.O.No.</b></td>
                            <td style="width: 25%; text-align: center; border-top: 1px solid gray;"><b style="font-size: 11px;">P.O.Date.</b></td>
                            <td style="width: 25%; text-align: center; border-top: 1px solid gray;"><b style="font-size: 11px;">Department</b></td>
                            <td style="width: 25%; text-align: center; border-top: 1px solid gray;"><b style="font-size: 11px;">Quotation No.</b></td>
                        </tr>
                    </table>
                </td>
            </tr>        
        </table>  
        <table style="width: 100%;border-collapse:collapse; margin-bottom: 10pt;font-family:'Arial, Helvetica, sans-serif';" border="0">
              <tr>
               <td style="text-align: center; background-color: #E4882C; color: #FFFFFF" colspan="2"><b style="font-size: 12px;">VENDOR DETAILS</b></td> 
              </tr>
              <tr>
                  <td style="width: 50%">
                    <div class="column-vendor" style="float: left;width: 50%;padding: 10px;">
                       <table style="border-collapse:collapse; width: 300pt;" border="0">
                         <tr>
                            <td style="height: 20pt;"><b style="font-size: 11px;">Name:</b> <span style="width: 150px; float: right; clear: both; font-size: 11px;"><?php echo $supplier_name?></span></td>
                         </tr>
                         <tr>
                            <td style="height: 20pt;"><b style="font-size: 11px;">Address:</b> <span style="width: 150px; float: right; clear: both; font-size: 11px;"><?php echo $supplier_address?></span></td>
                         </tr>
                         <tr>
                            <td style="height: 20pt;"><span style="width: 150px; float: right; clear: both; font-size: 11px;"><?php echo $supplier_city?></span></td>
                         </tr>
                         <tr>
                            <td style="height: 20pt;"><span style="width: 150px; float: right; clear: both; font-size: 11px;"><?php echo $supplier_pin?>, <?php echo $supplier_state?>, <?php echo $supplier_country?></span></td>
                         </tr>
                         <tr>
                            <td style="height: 20pt;"><b style="font-size: 11px;">Phone:</b> <span style="width: 150px; float: right; clear: both; font-size: 11px;"><?php echo $supplier_mobile?></span></td>
                         </tr>
                         <tr>
                            <td style="height: 20pt;"><b style="font-size: 11px;">Job Ref:</b> <span style="width: 150px; float: right; clear: both; font-size: 11px;">&nbsp;</span></td>
                         </tr>
                         <tr>
                            <td style="height: 20pt;"><b style="font-size: 11px;">Contact Person:</b> <span style="width: 150px; float: right; clear: both; font-size: 11px;"><?php echo $supplier_contact_person?></span></td>
                         </tr>
                       </table>     
                    </div>
                  </td>
                  <td style="width: 50%">
                     <div style="font-weight: bold; font-size: 11px;">Special Notes:-</div>
                     <ul style="font-size: 11px;">
                         <li><span style="font-size: 11px;">Excise Gate Pass required with Material.</span></li>
                         <li><span style="font-size: 11px;">Test certificate to be sentwith each lot.</span></li>
                         <li><span style="font-size: 11px;">Mention our P.O Number in your invoice.</span></li>
                         <li><span style="font-size: 11px;">Please incorporate our ECC Number in your invoices.</span></li>
                         <li><span style="font-size: 11px;">Dispatch the goods on extra copy of invoice while original and duplicate copies to be sent by courier to us.</span></li>
                         <li><span style="font-size: 11px;">Expiry date of above materials should not be less than 6 months from receiving date.</span></li>
                     </ul> 
                  </td>
              </tr> 
        </table>
        <table width="100%" style="width: 100%;border-collapse:collapse; font-family:'Arial, Helvetica, sans-serif';" border="0" align="center">
              <tr>
               <td style="text-align: center; background-color: #E4882C; color: #FFFFFF"><b style="font-size: 12px;">DESCRIPTION</b></td> 
              </tr>   
              <tr>
                 <td align="center">
                     <table width="100%" autosize="1" style="margin-top: 5px;border-collapse:collapse;" cellpadding="0" cellspacing="0" border="0" align="center">
                            <tr>
                              <th align="center" style="width:1%;text-align: center;border-top: 1px solid black;border-right: 1px solid black; font-size: 11px;">Sr No.</th>
                              <th style="width:2%;text-align: center;border-top: 1px solid black;border-right: 1px solid black; font-size: 11px;">Material<br>Code</th>
                              <th style="width:50%;text-align: center;border-top: 1px solid black;border-right: 1px solid black; font-size: 11px;">Material<br>Description</th>
                              <th style="width:5%;text-align: center;border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;">HSN Code</th>
                              <th style="width:25%;text-align: center;border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;">Unit</th>
                              <th style="width:25%;text-align: center;border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;">Qty</th>
                              <th style="width:25%;text-align: center;border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;">Rate</th>
                              <th style="width:5%;text-align: center;border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;">Disc.<br>Rate</th>
                              <th style="width:5%;text-align: center;border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;">Disc.<br>(%)</th>
                              <th style="width:5%;text-align: center;border-top: 1px solid black;border-right: 1px solid black;font-size: 11px;">Amount</th>
                              <th colspan="2" style="width:5%;border-bottom: 1px;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;font-size: 11px;">CGST</th>
                              <th colspan="2" style="width:5%;border-bottom: 1px;text-align: center;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;font-size: 11px;">SGST</th>
                              <th colspan="2" style="width:5%;border-bottom: 1px;text-align: center;border-top: 1px solid black;border-bottom: 1px solid black;font-size: 11px;">IGST</th>
                            </tr>
                              <tr>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="border-right: 1px solid black;border-bottom: 1px solid black;"></td>
                                <td style="text-align: center; font-weight: bold;border-right: 1px solid black;border-bottom: 1px solid black;font-size: 12px;font-size: 11px;">%</td>
                                <td style="text-align: center; font-weight: bold;border-right: 1px solid black;border-bottom: 1px solid black;font-size: 12px;font-size: 11px;">Amt.</td>
                                <td style="text-align: center; font-weight: bold;border-right: 1px solid black;border-bottom: 1px solid black;font-size: 12px;font-size: 11px;">%</td>
                                <td style="text-align: center; font-weight: bold;border-right: 1px solid black;border-bottom: 1px solid black;font-size: 12px;font-size: 11px;">Amt.</td>
                                <td style="text-align: center; font-weight: bold;border-right: 1px solid black;border-bottom: 1px solid black;border-bottom: 1px solid black;font-size: 12px;font-size: 11px;">%</td>
                                <td style="text-align: center; font-weight: bold;border-bottom: 1px solid black;font-size: 12px;font-size: 11px;">Amt.</td>
                              </tr>
                              <?php
                               $sr_no = 1;
                               if(!empty($po_details))
                               { 
                                    foreach ($po_details as $key => $mvalue) { ?>   
                                      <tr>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $sr_no;?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['mat_code']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo wordwrap($mvalue['mat_name'], 35, "<br />\n");?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['hsn_code']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['unit_description']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['qty']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['rate']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['discount']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['discount_per']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['mat_amount']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['cgst_per']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['cgst_amt']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['sgst_per']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['sgst_amt']?></td>
                                            <td style="border-right: 1px solid black;font-size: 11px;"><?php echo $mvalue['igst_per']?></td>
                                            <td style="font-size: 11px;"><?php echo $mvalue['igst_amt']?></td>
                                      </tr>   
                                  <?php
                                    $sr_no ++; 
                                    }
                              } ?>
                          </table>
                 </td>
              </tr>  
        </table> 
        <table style="border-collapse:collapse;width: 600pt;" cellpadding="0" cellspacing="0" border="0">
            <tr>
                                <td colspan="7" style="font-size: 14px; font-weight: bold;border-top: 1px solid black;font-size: 10px; padding-left: 240pt;">Total Amount</td>
                                <td style="border-top: 1px solid black;width:17pt;">&nbsp;</td>
                                <td align="right" style="border-top: 1px solid black; font-size: 12px;">Rs.</td>
                                <td style="border-top: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;width:51pt;"><?php echo $purchase_order[0]['total_amt'];?></td>
                                <td rowspan="8" colspan="6" style="border-bottom: 1px solid black;border-top: 1px solid black;">
                                   <div style="font-weight: bold;font-size: 11px;">Terms and Conditions:-</div>
                                   <ul style="padding-left:13px; font-size: 11px;">
                                     <li><span style="font-size: 10px;"><b>Delivery Schedule:</b> <?php echo $purchase_order[0]['delievery_schedule'];?></span></li>
                                     <li><span style="font-size: 10px;"><b>Transport:</b> <?php echo $purchase_order[0]['transport'];?></span></li>
                                     <li><span style="font-size: 10px;"><b>Freight:</b> <?php echo $purchase_order[0]['freight_charges'];?></span></li>
                                     <li><span style="font-size: 10px;"><b>Test Certificate:</b> <?php echo $purchase_order[0]['test_certificate'];?></span></li>
                                     <li><span style="font-size: 10px;"><b>Custom Duty:</b> <?php echo $purchase_order[0]['custom_duty'];?></span></li>
                                     <li><span style="font-size: 10px;"><b>Payment Terms:</b> <?php echo $purchase_order[0]['payment_terms'];?></span></li>
                                     <li><span style="font-size: 10px;"><b>Remark:</b> <?php echo $purchase_order[0]['remarks'];?></span></li>
                                   </ul>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="7" style="font-size: 10px; font-weight: bold; padding-left: 240pt;">Total CGST</td>
                                <td style="width:5pt;">&nbsp;</td>
                                <td align="right" style="font-size: 11px;">Rs.</td>
                                <td style="border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;"><?php echo $purchase_order[0]['total_cgst'];?></td>
                              </tr>
                               <tr>
                                <td colspan="7" style="font-size: 10px; font-weight: bold; padding-left: 240pt;">Total SGST</td>
                                <td style="width:5pt;">&nbsp;</td>
                                <td align="right" style="font-size: 11px;">Rs.</td>
                                <td style="border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;"><?php echo $purchase_order[0]['total_sgst'];?></td>
                              </tr>
                               <tr>
                                <td colspan="7" style="font-size: 10px; font-weight: bold; padding-left: 240pt;">Total IGST</td>
                                <td style="width:5pt;">&nbsp;</td>
                                <td align="right" style="font-size: 11px;">Rs.</td>
                                <td style="border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;"><?php echo $purchase_order[0]['total_igst'];?></td>
                              </tr>
                              <tr>
                                <td colspan="7" style="font-size: 10px; font-weight: bold; padding-left: 240pt;">Freight</td>
                                <td style="width:5pt;">&nbsp;</td>
                                <td align="right" style="font-size: 11px;">Rs.</td>
                                <td style="border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;"><?php echo $purchase_order[0]['freight_amt'];?></td>
                              </tr>
                              <tr>
                                <td colspan="7" style="font-size: 10px; font-weight: bold; padding-left: 240pt;">Other Charges</td>
                                <td style="width:5pt;">&nbsp;</td>
                                <td align="right" style="font-size: 11px;">Rs.</td>
                                <td style="border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;"><?php echo $purchase_order[0]['other_amt'];?></td>
                              </tr>
                              <tr>
                                <td colspan="7" style="font-size: 10px; font-weight: bold; padding-left: 240pt;">Total Bill Amount</td>
                                <td style="width:5pt;">&nbsp;</td>
                                <td align="right" style="font-size: 11px;">Rs.</td>
                                <td style="border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;"><?php echo $purchase_order[0]['total_bill_amt'];?></td>
                              </tr>
                              <tr>
                                <td colspan="7" style="font-size: 10px; font-weight: bold;border-bottom: 1px solid black; padding-left: 240pt;">Round Up Amount</td>
                                <td style="border-bottom: 1px solid black;width:5pt;">&nbsp;</td>
                                <td align="right" style="border-bottom: 1px solid black; font-size: 11px;width:15pt;">Rs.</td>
                                <td style="border-bottom: 1px solid black;border-right: 1px solid black;border-left: 1px solid black;font-size: 10px;"><?php echo $purchase_order[0]['rounded_amt'];?></td>
                              </tr>
                              <tr>
                                <td colspan="2" style="font-size: 11px; font-weight: bold;border: none; height: 30pt;">Amount(In Word):</td>
                                <td colspan="14" style="border: none;">
                                  <p style="height: 0px; font-size: 10px;">
                                    <?php
                                      if(empty($purchase_order[0]['rounded_amt'])){
                                         echo convertToIndianCurrency($purchase_order[0]['total_bill_amt']);
                                      }else{
                                         echo convertToIndianCurrency($purchase_order[0]['rounded_amt']);
                                      }   
                                    ?>
                                  </p>
                                </td>
                              </tr>
        </table>       
        <table border="0" style="width:600pt; margin-top: 100pt; margin: 5px; font-family:'Arial, Helvetica, sans-serif';" align="center">
                        <tr>
                            <td style="width: 190pt; text-align: center; font-size: 12px; border: 1px solid black; height: 55pt;"><span><?php echo $prepared_by[0]['name'];?></span><br><b>Prepare By</b></td>
                            <td>&nbsp;</td>
                            <td style="width: 190pt; text-align: center; font-size: 12px; border: 1px solid black; height: 55pt;"><span><?php echo $checked_by[0]['name'];?></span><br><b>Checked By</b></td>
                            <td>&nbsp;</td>
                            <td style="width: 190pt; text-align: center; font-size: 12px; border: 1px solid black; height: 55pt;"><span><?php echo $authorized_by[0]['name'];?></span><br><b>Authorized By</b></td>
                        </tr>
       </table>
       <table style="margin-top: 50pt;font-family:'Arial, Helvetica, sans-serif';">
           <tr>
                            <td style="width: 190pt; text-align: left; font-size: 12px;"><b>Vendor GST No:</b><?php echo $supplier_gst_number;?></td>
                            <td>&nbsp;</td>
                            <td style="width: 190pt; text-align: left; font-size: 12px;"><b>State Code:</b></td>
                            <td>&nbsp;</td>
                            <td style="width: 190pt; text-align: left; font-size: 12px;"><b>Company GST No:</b></td>
           </tr>
       </table>
       <div class="row layer" style="margin-top: 50pt; height: 10px; background-color: #EA8D2E; text-align: center; color: #ffffff; clear: both;font-family:'Arial, Helvetica, sans-serif'; font-size: 8px;">
          <span>Note:Supplier is requested to contact purchaser if any differance in Qty, Rate, Tax and Other Financial Terms.</span>
      </div>
</div>