<div class="modal fade" id="supplier_documents">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
	        <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">×</span></button>
				<h4 class="modal-title">VENDOR DOCUMENT(S)</h4>
			</div>            
            <div class="modal-body">
                <form role="form" id="supplier_documents_form" action="purchase/save_document_details" enctype="multipart/form-data">
                 <div class="row">
                        <div class="col-md-12" id="document_div">
                            <div class="row" style="border-bottom: 1px solid #ccc">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input id="vendor_file_name0" type="text" name="vendor_file_name[]" placeholder="File Name" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="file" name="vender_doc_file[]" id="vender_doc_file" class="form-control">
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="col-md-12">
                            <div class="form-group" style="margin-top: 15px;">
                                <button type="button" class="btn btn-default btn-small pull-left" style="margin: 0px 5px;" onclick="new_field_vendor_doc('document_div')">
                                    <i class="fa fa-plus"></i>
                                </button>
                                <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo $supplier_id?>">
                                <button type="submit" class="btn btn-primary pull-right" name="submit_doc">Upload Decuments</button>  
                            </div>
                        </div>
                 </div>
               </form>  
            </div>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>