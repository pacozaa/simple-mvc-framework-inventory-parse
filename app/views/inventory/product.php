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
                <div class="form-group" style="cursor: pointer;">                        
                    <span id="showTable" class="badge"> แสดงสินค้า </span>                           
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
                            <label>เลือกภาพสินค้า</label>
                            <input id="fileToUpload" name="fileToUpload" class="form-control" type="file" multiple=true>
                        </div>                        
                        <div class="form-group">
                            <label>ชื่อสินค้า</label>
                            <input name="productName" class="form-control" placeholder="ชื่อสินค้า">
                        </div>
                        <div class="form-group">
                            <label>ราคาสินค้า</label>
                            <input name="productPrice" class="form-control" placeholder="ราคาสินค้า">
                        </div>
                        <div class="form-group">
                            <label>คำบรรยาย</label>
                            <textarea name="productDescription" class="form-control" rows="5" placeholder="คำบรรยายสินค้า"></textarea>                            
                        </div>
                        <input type="hidden" name="submit">
                        <button type="submit" name="post" class="btn btn-success"><i class="fa fa-check-circle-o fa-lg"></i> บันทึกสินค้า</button>
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