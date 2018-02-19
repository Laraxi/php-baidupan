<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/Public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Public/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Public/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/Public/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="/Public/dist/css/skins/skin-blue.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="javascript:void(0)" class="logo">
            <span class="logo-lg"><b>后台</b>管理</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="/Public/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">Alexander Pierce</span>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="#" class="btn btn-default btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"></li>
                <!--&lt;!&ndash; Optionally, you can add icons to the links &ndash;&gt;-->
                <!--<li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>-->
                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span>基本信息</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> Link in level 2</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Link in level 2</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span>内部管理</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="#"><i class="fa fa-circle-o"></i> 用户管理</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> 添加用户</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> 角色管理</a></li>
                    </ul>
                </li>

                <li class="treeview <?php if(isset($type) && $type == 'index') echo 'active' ?>">
                    <a href="#"><i class="fa fa-link"></i> <span>测试管理</span>
                        <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                    </a>
                    <ul class="treeview-menu ">
                        <li class=""><a href="<?= U('test/add') ?>"><i class="fa fa-circle-o"></i> 新增</a></li>
                        <li class=""><a href="<?= U('test/index') ?>"><i class="fa fa-circle-o"></i> 列表</a></li>
                    </ul>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <small>测试列表</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <!-- /.box -->
                    <!-- general form elements disabled -->
                    <div class="box box-warning">
                        <!-- /.box-header -->
                        <div class="box-body">
                            <form role="form" method="post" action="<?= U('edit') ?>" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $info['id'] ?>">
                                <!-- text input -->
                                <div class="form-group">
                                    <input type="text" class="form-control " placeholder="请输入测试名称" name="name"
                                           value="<?= $info['name'] ?>">
                                </div>

                                <!-- textarea -->
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" placeholder="请输入测试内容"
                                              name="content"><?= $info['content'] ?></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="file" class="form-control " placeholder="请输入测试名称" name="logo"
                                    >
                                    <img style="width: 100px;" src="<?= IMG_SHOW . $info['logo'] ?>" alt="">
                                </div>

                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="提交">
                                </div>

                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                                <span class="pull-right-container">
                    <span class="label label-danger pull-right">70%</span>
                  </span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<script src="/Public/bower_components/jquery/dist/jquery.min.js"></script>

<script src="/Public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="/Public/dist/js/adminlte.min.js"></script>

</body>
</html>