<?php 
use Core\Error;
use Helpers\Form;
use Parse\ParseQuery;
use Parse\ParseFile;

function iconStatus($st){
    $icon = '';
    if($st == 'F'){
        $icon = '<i class="fa fa-check fa-lg"></i>';
    }
    elseif ($st == 'W'){
        $icon = '<i class="fa fa-refresh fa-lg"></i>';
    }
    elseif ($st == 'N') {
        $icon = '<i class="fa fa-times fa-lg"></i>';
    }
    return $icon;
}
?>
<div class="table-responsive">
    <table style="width:150vw;" class="table table-condensed table-hover table-striped table-responsive">
        <thead>
            <tr>
                <th style="display:none;"></th>
                <th class="col-tb-center">รหัสสินค้า</th>
                <th class="col-tb-center">ชื่อสินค้า</th>
                <th class="col-tb-center">รูปสินค้า</th>
                <th class="col-tb-center">ชื่อผู้ใช้งาน</th>
                <th class="col-tb-center">ชื่อลูกค้า</th>
                <th class="col-tb-center">ข้อมูลติดต่อ</th>                    
                <th class="col-tb-center"><i class="fa fa-home fa-lg"></i><i class="fa fa-truck fa-lg"></i></th>                  
                <th class="col-tb-center"><i class="fa fa-calendar fa-lg"></i><i class="fa fa-truck fa-lg"></i></th>
                <th class="col-tb-status"><i class="fa fa-truck fa-lg"></i></th>
                <th class="col-tb-center"><i class="fa fa-code-fork fa-lg"></i></th>
                <th class="col-tb-center"><i class="fa fa-file-image-o fa-lg"></i><i class="fa fa-money fa-lg"></i></th>
                <th class="col-tb-status col-tb-center"><i class="fa fa-money fa-lg"></i></th>                            
                <th class="col-tb-center"></th>                
            </tr>
        </thead>
        <tbody>
            <?php
                $order = new ParseQuery('Order');
                $query = new ParseQuery('Product');                
                $result = $order->find();
                if (is_array($result) || is_object($result))
                {
                    foreach ($result as $table) 
                    {
                        $objectId = is_null($table->getObjectId())? '':$table->getObjectId();
                        $product = is_null($table->get('productId')) ? '':$table->get('productId');
                        $productName = is_null($table->get('productName'))? '':$table->get('productName');
                        $query->equalTo('objectId', $product);
                        $productInfo = $query->first();
                        $productImage = is_null($productInfo->get('picture')->getURL())? '':$productInfo->get('picture')->getURL();
                        $login = is_null($table->get('customerId'))? '':$table->get('customerId');
                        $name = is_null($table->get('customerName'))? '':$table->get('customerName');
                        $slipPayin = is_null($table->get('slipPayin'))? '':$table->get('slipPayin')->getURL();
                        $transfer = is_null($table->get('transferStatus'))? '':$table->get('transferStatus');
                        $contact = $table->get('contact');
                        $fb = is_null($contact['facebook'])? '': $contact['facebook'];
                        $line = is_null($contact['lineId'])? '': $contact['lineId'];
                        $telephone = is_null($contact['telephone'])? '': $contact['telephone'];
                        $tdate = is_null($table->get('transportDate'))? '': $table->get('transportDate');
                        $tstatus = is_null($table->get('transportStatus'))? '': $table->get('transportStatus');
                        $trackingNumber = is_null($table->get('trackingNumber'))? '': $table->get('trackingNumber');
                        $address = is_null($table->get('address'))? '': $table->get('address');

                        $ROW_HEADER = '<tr class="">';
                        $ROW_ObjectId = '<td class="objectId" style="display:none;">
                                            <input id="'.$objectId.'" type="hidden" value="'.$objectId.'">
                                        </td>';
                        $ROW_ProductId = '<td class="productL product col-xs-1" data-object="'.$objectId.'">'.$product.'</td> ';
                        $ROW_ProductName = '<td class="productNameL product col-xs-1" data-object="'.$objectId.'">'.$productName.'</td>';                        
                        $ROW_ProductImage = '<td class="productPreview product col-xs-1" data-object="'.$objectId.'">
                                                '.($productImage == ''? null:'<a href="'.$productImage.'" target="_blank" title="'.$productName.'">
                                                    <img class="img-rounded" style="witdth:80px;height:80px;" src="'.$productImage.'">
                                                </a>').'
                                                <input style="display:none;" name="fileToUpload" class="form-control" type="file" multiple>
                                            </td> ';
                        $ROW_CustomerId = '<td class="customerId col-xs-1" style="display:none;"><input type="text" class="form-control input-sm" value="'.$login.'"></td>                       
                                            <td class="customerIdL col-xs-1">'.$login.'</td>';
                        $ROW_CustomerName = '<td class="customerName col-xs-1" style="display:none;"><input type="text" class="form-control input-sm" value="'.$name.'"></td>                       
                                            <td class="customerNameL col-xs-1">'.$name.'</td>';
                        $ROW_Contact = '<td class="contact col-xs-1" style="display:none;">
                                            <div class="input-group input-group-sm line">
                                              <span class="input-group-addon"><i class="fa fa-paper-plane fa-fw"></i></span>
                                              <input value="'.$line.'" class="form-control input-sm" type="text" placeholder="Line ID">
                                            </div>
                                            <div class="input-group input-group-sm facebook">
                                              <span class="input-group-addon"><i class="fa  fa-fw fa-facebook-square"></i></span>
                                              <input value="'.$facebook.'" class="form-control input-sm" type="text" placeholder="FACEBOOK">
                                            </div>
                                            <div class="input-group input-group-sm telephone">
                                              <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                              <input value="'.$telephone.'" class="form-control input-sm" type="text" placeholder="เบอร์โทรศัพท์">
                                            </div>                                
                                        </td>                       
                                        <td class="contactL col-xs-1">
                                            '.($line == '' && $facebook == '' && $telephone ==''? '':'<ul class="fa-ul">').'                                            
                                              '.($line == ''? '':'<li><i class="fa-li fa fa-paper-plane"></i>'.$line.'</li>').'
                                              '.($facebook == ''? '':'<li><i class="fa-li fa fa-facebook-square"></i>'.$facebook.'</li>').'
                                              '.($telephone == ''? '':'<li><i class="fa-li fa fa-phone"></i>'.$telephone.'</li>').'
                                            '.($line == '' && $facebook == '' && $telephone ==''? '':'</ul>').'
                                        </td>';
                        $ROW_Address = '<td class="address col-xs-1" style="display:none;"><textarea class="form-control input-sm" rows="5">'.$address.'</textarea></td>                       
                                        <td class="addressL col-xs-1">'.$address.'</td>';
                        $ROW_TransportDate = '<td class="tdate col-xs-1" style="display:none;">                 
                                                <div class="input-group date transportDate">
                                                    <input value="'.$tdate.'" type="text" name="transportDate" class="form-control input-sm" placeholder="mm/dd/yyyy">
                                                    <span class="input-group-addon add-on">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </td>                    
                                            <td class="tdateL col-xs-1">'.$tdate.'</td>';

                        $ROW_TransportStatus = '<td class="tstatus" style="display:none;">
                                                    <div class="radio">
                                                      <label><input type="radio" value="F" '.($tstatus=='F'?'checked':'').'><i class="fa fa-check fa-lg"></i></label>
                                                    </div>
                                                    <div class="radio">
                                                      <label><input type="radio" value="W" '.($tstatus=='W'?'checked':'').'><i class="fa fa-refresh fa-lg"></i></label>
                                                    </div>
                                                    <div class="radio">
                                                      <label><input type="radio" value="N" '.($tstatus=='N'?'checked':'').'><i class="fa fa-times fa-lg"></i></label>
                                                    </div>                                                    
                                                </td>
                                                <td class="tstatusL">'.iconStatus($tstatus).'</td>';
                        $ROW_TrackingNumber = '<td class="trackingNumber col-xs-1" style="display:none;"><input type="text" class="form-control input-sm" value="'.$trackingNumber.'"></td>
                                                <td class="trackingNumberL col-xs-1">'.$trackingNumber.'</td>';
                        $ROW_Slip = '<td class="slipPayin col-xs-1 col-tb-center">
                                        '.($slipPayin == ''? null:'<a href="'.$slipPayin.'" target="_blank" title="'.$productName.'">
                                            <img class="img-rounded" style="witdth:80px;height:80px;" src="'.$slipPayin.'">
                                        </a>').'
                                        <input style="display:none;" name="fileToUpload" class="form-control" type="file" multiple>
                                    </td> ';
                        $ROW_TransferStatus = '<td class="tstatus" style="display:none;">
                                                    <div class="radio">
                                                      <label><input type="radio" value="F" '.($transfer=='F'?'checked':'').'><i class="fa fa-check fa-lg"></i></label>
                                                    </div>
                                                    <div class="radio">
                                                      <label><input type="radio" value="W" '.($transfer=='W'?'checked':'').'><i class="fa fa-refresh fa-lg"></i></label>
                                                    </div>
                                                    <div class="radio">
                                                      <label><input type="radio" value="N" '.($transfer=='N'?'checked':'').'><i class="fa fa-times fa-lg"></i></label>
                                                    </div>                                                    
                                                </td>
                                                <td class="tstatusL">'.iconStatus($transfer).'</td>';
                        $ROW_BUTTON = '<td class="col-tb-center">
                                            <div class="btn-group hidden-xs hidden-sm hidden-md hidden-lg" style="display:none;">            
                                                <button type="button" class="tb-submit btn btn-success" >
                                                   <i class="fa fa-check-circle-o fa-lg"></i> บันทึก
                                                </button> 
                                                <button type="button" class="tb-cancel btn btn-warning">
                                                   <i class="fa fa-times-circle-o fa-lg"></i> ยกเลิก
                                                </button>
                                            </div>
                                            <div class="btn-group hidden-xs hidden-sm hidden-md hidden-lg">
                                                <button type="button" class="tb-edit btn btn-success">
                                                   <i class="fa fa-pencil-square-o fa-lg"></i> แก้ไข
                                                </button> 
                                                <button type="button" class="tb-delete btn btn-danger">
                                                   <i class="fa fa-trash-o fa-lg"></i> ลบ
                                                </button>
                                            </div>
                                            <p class="" style="display:none;">
                                                <button type="button" class="tb-submit btn btn-success" >
                                                   <i class="fa fa-check-circle-o fa-lg"></i> บันทึก
                                                </button> 
                                                <button type="button" class="tb-cancel btn btn-warning">
                                                   <i class="fa fa-times-circle-o fa-lg"></i> ยกเลิก
                                                </button>
                                            </p>
                                            <p class="">
                                                <button type="button" class="tb-edit btn btn-success">
                                                   <i class="fa fa-pencil-square-o fa-lg"></i> แก้ไข
                                                </button> 
                                                <button type="button" class="tb-delete btn btn-danger">
                                                   <i class="fa fa-trash-o fa-lg"></i> ลบ
                                                </button>
                                            </p>
                                        </td>';

                        $ROW_FOOTER ='</tr>';                   
                        echo $ROW_HEADER.
                            $ROW_ProductId.
                            $ROW_ProductName.
                            $ROW_ProductImage.
                            $ROW_CustomerId.
                            $ROW_CustomerName.
                            $ROW_Contact.
                            $ROW_Address.
                            $ROW_TransportDate.
                            $ROW_TransportStatus.
                            $ROW_TrackingNumber.
                            $ROW_Slip.
                            $ROW_TransferStatus.
                            $ROW_BUTTON.
                            $ROW_FOOTER;                       
                    }
                }                
            ?>                            
        </tbody>
    </table>
</div>
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%;overflow-y:hidden;margin:0;">
    <div class="modal-dialog modal-lg" style="width:100vw;margin:0;overflow-x: auto;">
      <div class="modal-content" style="width:100%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="modal-title">สินค้า</h3>
        </div>
        <div class="modal-body" id="productTable2" style="overflow:auto;max-height:74vh;">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save Changes</button>
        </div>
                
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    var tbEdit = $('.tb-edit');
    var tbSubmit = $('.tb-submit');
    var tbCancel = $('.tb-cancel');
    var tbDelte = $('.tb-delete');
    var btnGroup = $('.btn-group');
    var product = $('td.product');
    var productTable2 = $('#productTable2');
    var upload;
    var curRow;
    $('.transportDate').datepicker({
        autoclose: true,
        orientation: "auto"
    });
    tbEdit.on('click', function(){                                
        $(this).parent().parent().find(btnGroup).css('display','block');  
        $(this).parent().parent().find('p').css('display','block');  
        $(this).parent().css('display','none'); 
        curRow = $(this);                     
        var edPic = $(this).parent().parent().parent().find('.slipPayin');                         
        $(this).parent().parent().parent().find('.customerName').toggle();
        $(this).parent().parent().parent().find('.customerNameL').toggle();    
        $(this).parent().parent().parent().find('.transfer').toggle();
        $(this).parent().parent().parent().find('.transferL').toggle();
        $(this).parent().parent().parent().find('.contact').toggle();
        $(this).parent().parent().parent().find('.contactL').toggle();
        $(this).parent().parent().parent().find('.tdate').toggle();
        $(this).parent().parent().parent().find('.tdateL').toggle(); 
        $(this).parent().parent().parent().find('.tstatus').toggle();
        $(this).parent().parent().parent().find('.tstatusL').toggle();  
        $(this).parent().parent().parent().find('.address').toggle();
        $(this).parent().parent().parent().find('.addressL').toggle();      
        $(this).parent().parent().parent().find('.trackingNumber').toggle();
        $(this).parent().parent().parent().find('.trackingNumberL').toggle();      
        $(this).parent().parent().find(btnGroup).css('display','block');                                  
        edPic.find('a').hide();
        edPic.find('input').show();
        edPic.find('input').fileinput({
            dropZoneEnabled: false,
            uploadUrl: url.Order,                    
            uploadExtraData: function(){
                var out = { objectId: $(this).parent().parent().parent().find('.objectId input').val(),
                            productId: curRow.parent().parent().parent().find('.productL input').val(),
                            customerId: curRow.parent().parent().parent().find('.customerId input').val(),
                            customerName: curRow.parent().parent().parent().find('.customerName input').val(),
                            lineId: curRow.parent().parent().parent().find('.contact > div.line > input').val(),
                            facebook: curRow.parent().parent().parent().find('.contact > div.facebook > input').val(),
                            telephone: curRow.parent().parent().parent().find('.contact > div.telephone > input').val(),
                            transportDate: curRow.parent().parent().parent().find('.tdate > div.transportDate  > input').val(),
                            address: curRow.parent().parent().parent().find('.address textarea').val(),
                            transportStatus: curRow.parent().parent().parent().find('.tstatus > .radio > label > input[type="radio"]:checked').val(),
                            transferStatus: curRow.parent().parent().parent().find('.transfer input').val(),
                            trackingNumber: curRow.parent().parent().parent().find('.trackingNumber input').val(),
                            update: 'true'};
                return out;
            },
            showUpload: false,
            showCaption: false,
            showRemove: true,
            browseClass: 'btn btn-primary btn-xs',
            removeClass: 'btn btn-primary btn-xs',
            fileType: 'image',
            previewFileIcon: '<i class="glyphicon glyphicon-king"></i>',
            maxFileSize: 50000,
            maxFileCount: 1,
            slugCallback: function(filename) {
                return filename.replace('(', '-').replace(']', '-');
            }
        });
        upload = edPic.find('input');        
        edPic = null;
    });
    tbSubmit.on('click', function() {
        upload.fileinput('upload');
    });
    tbCancel.on('click', function() {        
        $(this).parent().parent().parent().find('.slipPayin').find('a').show();
        $(this).parent().parent().parent().find('.slipPayin').find('input').fileinput('destroy');
        $(this).parent().parent().parent().find('.slipPayin').find('input').hide();      
        $(this).parent().parent().parent().find('.customerName').toggle();
        $(this).parent().parent().parent().find('.customerNameL').toggle();    
        $(this).parent().parent().parent().find('.transfer').toggle();
        $(this).parent().parent().parent().find('.transferL').toggle();
        $(this).parent().parent().parent().find('.contact').toggle();
        $(this).parent().parent().parent().find('.contactL').toggle();
        $(this).parent().parent().parent().find('.tdate').toggle();
        $(this).parent().parent().parent().find('.tdateL').toggle(); 
        $(this).parent().parent().parent().find('.tstatus').toggle();
        $(this).parent().parent().parent().find('.tstatusL').toggle();  
        $(this).parent().parent().parent().find('.address').toggle();
        $(this).parent().parent().parent().find('.addressL').toggle();      
        $(this).parent().parent().parent().find('.trackingNumber').toggle();
        $(this).parent().parent().parent().find('.trackingNumberL').toggle();      
        $(this).parent().parent().find(btnGroup).css('display','block');  
        $(this).parent().parent().find('p').css('display','block');  
        $(this).parent().css('display','none');
    });
    tbDelte.on('click', function(){
        if (confirm('Are you sure to delete?') == true) {
            var objId = $(this).parent().parent().parent().find('.objectId input').val();
            var curRow = $(this);
            var prop = curRow.find('i').prop('class');
            curRow.find('i').removeClass().addClass('fa fa-circle-o-notch fa-lg fa-spin');
            curRow.parent().parent().find('div').find('button').prop('disabled', 'true');
            curRow.parent().parent().parent().css({ 'opacity': '0.4', 'pointer-events': 'none' })        
            $.post(url.Order,{del: 'true', objectId: objId},function(data, textStatus, jqXHR){
                if(data.result === 1){
                    curRow.parent().parent().parent().remove();
                }
                else{
                    console.log('Can not delete');
                }
            }).fail(function(){
                curRow.find('i').removeClass().addClass('fa fa-trash-o fa-lg');
                curRow.parent().parent().find('div').find('button').prop('disabled', 'false');
            });
        } 
    });
    var curProductId = '';
    product.on('click', function(){
        if(window.location.href == '<?php echo DIR.'order'?>'){
            $('#productModal').modal('show');
            curProductId = $(this).data('object');               
        }                
    });
    $('#productModal').on('show.bs.modal', function(e) {
        $('body').css('overflow', 'hidden');
        productTable2.html('');
        productTable2.html('<div class="row"><div class="col-xs-2 col-xs-offset-5"><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div></div>');
        $.post(url.Product, {
            table: true
        }, function(data, textStatus, xhr) {
            /*optional stuff to do after success */
            productTable2.html('');
            productTable2.append(data);
        }).fail(function() {

        }).done(function() {
            afterLoadTable2();
        });
    });
    $('#productModal').on('hidden.bs.modal', function(e) {
        productTable2.html('');
        $('body').css('overflow', 'auto');
    });
    function afterLoadTable2(){
        $('.outEdit').off('click').on('click', function() {
            var objectId = $(this).find('.objectId').find('input').val();
            var imageURL = $(this).find('.pic').find('a').prop('href');
            var name = $(this).find('.pic').find('a').prop('title');
            $('td[data-object="'+curProductId+'"].productL').text(objectId);
            $('td[data-object="'+curProductId+'"].productNameL').text(name);
            $('td[data-object="'+curProductId+'"].productPreview > a > img').prop('src', imageURL);
            $('td[data-object="'+curProductId+'"].productPreview > a').prop({
                href: imageURL,
                title: name
            });
            curProductId = '';
            $('#productModal').modal('hide');
        }); 
    }
</script>