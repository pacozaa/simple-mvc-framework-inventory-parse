<?php 
use Core\Error;
use Helpers\Form;
?>
<div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo DIR;?>">CYN.STORE</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong><?php echo $data['username'];?></strong>                                            
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong><?php echo $data['username'];?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading">
                                            <strong><?php echo $data['username'];?></strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                        <li>
                            <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                        </li>
                        <li>
                            <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">View All</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $data['username'];?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo DIR;?>logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">                
                <ul class="nav navbar-nav side-nav">
                    <?php                        
                        foreach($data['sidemenu'] as $sidemenu) {
                            $name = $sidemenu->get('name');
                            $text = $sidemenu->get('text');
                            $icon = $sidemenu->get('icon');
                            $url = $sidemenu->get('url');
                            if($text == $data['title']){
                                echo '<li class="active"><a href="'.DIR.$url.'"><i class="'.$icon.'"></i> '.$text.'</a></li>';
                            }
                            else{
                                echo '<li><a href="'.DIR.$url.'"><i class="'.$icon.'"></i> '.$text.'</a></li>';
                            }
                            
                        }
                    ?>                                 
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?php echo $data['title'];?>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i><a href="<?php echo DIR;?>">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-pencil-square-o"></i><?php echo $data['title'];?>
                            </li>                            
                        </ol>
                    </div>
                </div>
                <div class="form-group piointer-box">                        
                    <span id="showTable" class="badge"> แสดงรายการสั่งซื้อ </span>                           
                </div>
                <!-- /.row -->
                <div class="panel panel-default" style="display:none;">
                    <div class="panel-heading"><?php echo $data['title'];?></div> 
                    <div class="panel-body" style="display:none;">
                        <div class="row">
                            <div class="col-xs-2 col-xs-offset-5"><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div>
                        </div>
                    </div>                   
                    <div id="table" class="table">                                      
                    </div> 
                </div>                            
                <div id="main" class="row">
                    <div class="col-lg-12">
                        <?php echo Error::display($error); ?>
                        <?php echo Form::open(array('method' => 'post', 'role' => 'form', 'files' => 'files'));?>                                                                       
                        <div class="form-group">
                            <label>เลือกสินค้า</label>
                            <div class="productPreview piointer-box col-lg-12" href="#myModal" data-toggle="modal">
                                <input name="productId" type="hidden">
                                <input name="productName" type="hidden">
                                <h3>
                                    <a href="" target="_blank" title="" style="display:none;">
                                        <img class="img-rounded" style="max-height:200px;max-width:242px;" src="">
                                    </a>
                                    <i class="fa fa-shopping-cart fa-5x" style=" vertical-align: middle;">
                                    </i>&nbsp;&nbsp;
                                    <span class="label label-default"></span>
                                </h3>
                                <!-- <input name="productName" href="#myModal" data-toggle="modal" class="form-control" placeholder="รหัสสินค้า" readonly> -->
                            </div>                            
                        </div>
                        <div class="form-group">
                            <label>ชื่อผู้ใช้งาน</label>
                            <input value="<?php echo $data['username'];?>" name="customerId" class="form-control" placeholder="ชื่อผู้ใช้งาน" readonly>
                        </div>
                        <div class="form-group">
                            <label>ชื่อลูกค้า</label>
                            <input name="customerName" class="form-control" placeholder="ชื่อลูกค้า">
                        </div>                         
                        <div class="form-group">
                            <label>LINE ID</label>
                            <input name="lineId" class="form-control" placeholder="LINE ID">
                        </div>
                        <div class="form-group">
                            <label>FACEBOOK</label>
                            <input name="facebook" class="form-control" placeholder="facebook">
                        </div>
                        <div class="form-group">
                            <label>เบอร์โทรศัพท์</label>
                            <input name="telephone" class="form-control" placeholder="เบอร์โทรศัพท์">
                        </div>
                        <div class="form-group">
                            <label>ที่อยู่จัดส่ง</label>
                            <textarea name="address" class="form-control" rows="5" placeholder="ที่อยู่จัดส่ง"></textarea>
                        </div>
                        <div class="form-group">
                            <label>วันจัดที่ส่งสินค้า</label>                            
                            <div class="input-group date transportDate">
                                <input type="text" name="transportDate" class="form-control" placeholder="mm/dd/yyyy" readonly>
                                <span class="input-group-addon add-on">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>สถานะการจัดส่ง</label>
                            <input name="transportStatus" class="form-control" placeholder="สถานะการจัดส่ง">
                        </div>                     
                        <div class="form-group">
                            <label>tracking number</label>
                            <input name="trackingNumber" class="form-control" placeholder="tracking number">
                        </div>                        
                        <div class="form-group">
                            <label>ใบโอนเงิน</label>
                            <input placeholder="ใบโอนเงิน" id="fileToUpload" name="fileToUpload" class="form-control" type="file" multiple>                         
                        </div>   
                        <div class="form-group">
                            <label>สถานะการโอนเงิน</label>
                            <input name="transferStatus" class="form-control" placeholder="สถานะการโอนเงิน">
                        </div>                                                
                        <input type="hidden" name="submit">
                        <button type="submit" name="post" class="btn btn-success"><i class="fa fa-check-circle-o fa-lg"></i> บันทึกรายการสั่งซื้อ</button>
                        <button type="reset" name="reset" id="reset" class="btn btn-warning"><i class="fa fa-refresh"></i> รีเซ็ต</button>
                        <?php echo Form::close();?>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:100%;overflow-y:hidden;margin:0;">
    <div class="modal-dialog modal-lg" style="width:100vw;margin:0;overflow-x: auto;">
      <div class="modal-content" style="width:100%;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h3 class="modal-title">สินค้า</h3>
        </div>
        <div class="modal-body" id="productTable" style="overflow:auto;max-height:74vh;">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default " data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save Changes</button>
        </div>
                
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->