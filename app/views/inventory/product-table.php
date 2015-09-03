<?php 
use Core\Error;
use Helpers\Form;
use Parse\ParseQuery;
use Parse\ParseFile;
?>

<div class="table-responsive">
    <table class="table table-condensed table-hover table-striped table-responsive">
        <thead>
            <tr>
                <th style="display:none;"></th>
                <th>รูปภาพ</th>
                <th>ชื่อสินค้า</th>
                <th>รายละเอียด</th>                    
                <th>ราคา</th>
                <th class="col-tb-center"></th>                
            </tr>
        </thead>
        <tbody>
            <?php
                $product = new ParseQuery('Product');
                $result = $product->find();
                foreach ($result as $table) {
                    $objectId = $table->getObjectId();
                    $pic = $table->get('picture')->getURL();
                    $name = $table->get('name');
                    $detail = $table->get('description');
                    $price = $table->get('price');                        
                    echo '<tr class="outEdit">
                            <td class="objectId" style="display:none;">
                                <input type="hidden" value="'.$objectId.'">
                            </td>
                            <td class="pic">
                                <a href="'.$pic.'" target="_blank" title="'.$name.'">
                                <img class="img-rounded" style="witdth:80px;height:80px;" src="'.$pic.'"></a>
                                <input style="display:none;" name="fileToUpload" class="form-control" type="file" multiple>
                            </td>                       
                            <td class="name" style="display:none;"><input type="text" class="form-control input-sm" value="'.$name.'"></td>                       
                            <td class="nameL">'.$name.'</td>                       
                            <td class="detail" style="display:none;"><textarea class="form-control input-sm" rows="5">'.$detail.'</textarea></td>                       
                            <td class="detailL">'.$detail.'</td>                       
                            <td class="price" style="display:none;"><input type="text" class="form-control input-sm" value="'.$price.'"></td>
                            <td class="priceL">'.$price.'</td>
                            <td class="col-tb-center">
                                <div class="btn-group hidden-xs" style="display:none;">            
                                    <button type="button" class="tb-submit btn btn-success" >
                                       <i class="fa fa-check-circle-o fa-lg"></i> บันทึก
                                    </button> 
                                    <button type="button" class="tb-cancel btn btn-warning">
                                       <i class="fa fa-times-circle-o fa-lg"></i> ยกเลิก
                                    </button>
                                </div>
                                <div class="btn-group hidden-xs">
                                    <button type="button" class="tb-edit btn btn-success">
                                       <i class="fa fa-pencil-square-o fa-lg"></i> แก้ไข
                                    </button> 
                                    <button type="button" class="tb-delete btn btn-danger">
                                       <i class="fa fa-trash-o fa-lg"></i> ลบ
                                    </button>
                                </div>
                                <p class="hidden-sm hidden-md hidden-lg" style="display:none;">
                                    <button type="button" class="tb-submit btn btn-success" >
                                       <i class="fa fa-check-circle-o fa-lg"></i> บันทึก
                                    </button> 
                                    <button type="button" class="tb-cancel btn btn-warning">
                                       <i class="fa fa-times-circle-o fa-lg"></i> ยกเลิก
                                    </button>
                                </p>
                                <p class="hidden-sm hidden-md hidden-lg">
                                    <button type="button" class="tb-edit btn btn-success">
                                       <i class="fa fa-pencil-square-o fa-lg"></i> แก้ไข
                                    </button> 
                                    <button type="button" class="tb-delete btn btn-danger">
                                       <i class="fa fa-trash-o fa-lg"></i> ลบ
                                    </button>
                                </p>
                            </td>
                    </tr>';                       
                }
            ?>                            
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var tbEdit = $('.tb-edit');
    var tbSubmit = $('.tb-submit');
    var tbCancel = $('.tb-cancel');
    var tbDelte = $('.tb-delete');
    var btnGroup = $('.btn-group');
    var upload;
    var curRow;
    tbEdit.on('click', function(){                            
        $(this).parent().parent().find(btnGroup).css('display','block');  
        $(this).parent().parent().find('p').css('display','block');  
        $(this).parent().parent().find('p').css('display','block');  
        $(this).parent().css('display','none'); 
        curRow = $(this);             
        var edPic = $(this).parent().parent().parent().find('.pic');
        $(this).parent().parent().parent().find('.name').toggle();
        $(this).parent().parent().parent().find('.nameL').toggle();
        (this).parent().parent().parent().find('.detail').toggle();
        $(this).parent().parent().parent().find('.detailL').toggle();
        $(this).parent().parent().parent().find('.price').toggle();        
        $(this).parent().parent().parent().find('.priceL').toggle();      
        edPic.find('a').hide('fast', function(){
            
        });
        edPic.find('input').show('fast', function() {

        }); 
        edPic.find('input').fileinput({
            dropZoneEnabled: false,
            uploadUrl: url.Product,            
            uploadExtraData: function(){
                var out = { objectId: $(this).parent().parent().parent().find('.objectId input').val(),
                            productName: curRow.parent().parent().parent().find('.name input').val(),
                            productDescription: curRow.parent().parent().parent().find('.detail textarea').val(),
                            productPrice: curRow.parent().parent().parent().find('.price input').val(),
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
        $(this).parent().parent().parent().find('.pic').find('a').show();
        $(this).parent().parent().parent().find('.pic').find('input').fileinput('destroy');
        $(this).parent().parent().parent().find('.pic').find('input').hide();
        var edName = $(this).parent().parent().parent().find('.name').toggle();
        var edNameL = $(this).parent().parent().parent().find('.nameL').toggle();
        var edDetail = $(this).parent().parent().parent().find('.detail').toggle();
        var edDetailL = $(this).parent().parent().parent().find('.detailL').toggle();
        var edPrice = $(this).parent().parent().parent().find('.price').toggle();        
        var edPriceL = $(this).parent().parent().parent().find('.priceL').toggle();      
        $(this).parent().parent().find(btnGroup).css('display','block');  
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
            $.post(url.Product,{del: 'true', objectId: objId},function(data, textStatus, jqXHR){
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

    })

</script>