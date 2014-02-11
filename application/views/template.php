<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Title: -->
        <title>RPX</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <style>
            .divDialogElements input {
                font-size: 18px;
                padding: 3px; 
                height: 32px; 
                width: 500px; 
            }
            #tengah{
                top: 20%;
                left: 40%;
                position: absolute;
                font-size: 20px;
            }
            #loading{
                position: relative;
                opacity:0.6;
                filter:alpha(opacity=60); /* For IE8 and earlier */
                color: #fff;
                background-color: #000;
                height: 100%;
                width:100%;
                margin: 20px auto;
                overflow: auto;
                padding: 20px 0 20px 20px;
            }
            #sukses{
                position: relative;
                opacity:0.6;
                filter:alpha(opacity=60); /* For IE8 and earlier */
                color: #fff;
                background-color: #000;
                height: 100%;
                width:100%;
                margin: 20px auto;
                overflow: auto;
                padding: 20px 0 20px 20px;
            }
        </style>
        <!-- Bootstrap Styles -->
        <!-- Bootstrap 2.0.4 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/bootstrap/css/bootstrap.min.css" />
        <!-- Font Awesome 2.0 -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/fonts/font-awesome/css/font-awesome.min.css" />

        <!-- /Font Awesome 2.0 -->
        <!-- IcoMoon font pack -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/fonts/icomoon-pack-madmin-1.5/style.css" />

        <!-- /IcoMoon font pack -->
        <!-- /Bootstrap Styles -->

        <!-- Theme Styles -->

        <!-- Libs Styles -->

        <!-- Google Code Prettyfy - source-code highlighter -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/js/libs/google-code-prettify/prettify.css" />
        <!-- jQuery Page Slide Plugin -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/js/libs/jquery.pageslide/jquery.pageslide.css" />      
        <!-- jQuery Table Sorter Plugin -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/js/libs/jquery.tablesorter/themes/blue/style.css" />
        <link rel="stylesheet" href="<?php echo base_url() ?>media/js/libs/jquery.tablesorter/addons/pager/jquery.tablesorter.pager.css" />

        <!-- /Libs Styles -->

        <!-- Core Theme Styles -->
        <!-- <link rel="stylesheet/less" href="media/styles/style.less" /> -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/styles/style.css" />

        <!-- /Theme Styles -->

        <!-- CMS/Framework styles & scripts -->
        <!-- ADD HERE -->
        <!-- /CMS/Framework styles & scripts -->

        <!-- Style tweaks to CMS/plugins/widgets -->
        <!-- ADD HERE -->
        <!-- eg.: <link href="media/css/tweaks.css" rel="stylesheet" /> -->
        <!-- /Style tweaks to CMS/plugins/widgets -->

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements:
             load latest from Google Code, fall back to local if offline -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <script>window.html5 || document.write('<script src="media/js/libs/fixes/html5.js"><\/script>')</script>
        <![endif]-->

        <!-- Icons: place favicon.ico and apple-touch-icon.png in the root directory (more: mathiasbynens.be/notes/touch-icons) -->
        
        <link rel="shortcut icon" href="<?php echo base_url()?>media/images/icon.ico" />
        <!--<link rel="apple-touch-icon-precomposed" sizes="114x114" href="media/bootstrap/ico/apple-touch-icon-114-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="media/bootstrap/ico/apple-touch-icon-72-precomposed.png" />
        <link rel="apple-touch-icon-precomposed" href="media/bootstrap/ico/apple-touch-icon-57-precomposed.png" />
        -->
        <!-- /Icons -->

        <!-- Fonts -->
        <!-- ADD HERE -->
        <!-- /Fonts -->

        <!-- LESS -->
        <!-- <script src="media/_tools/less-1.3.0.min.js"></script> -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

    <body class="sidebar-max">

        <!--============================= Page Body =================================-->





        <!-- #topbar: Top Bar Menu -->
        <ul id="topbar" class="on-click">
            <?php
            $hak = $this->session->userdata('hak_akses');
            if($hak == 1){ ?>
            <li  class="pull-left">
                <a>
                    <i class="icon-calendar"></i>
                    <span>Pilih Tahun</span>
                </a>
            </li>
            <li class="parent pull-left">
                <a href="#" data-toggle="dropdown">
                    <i class=""></i>
                    <span><?php echo "Tahun ".$this->session->userdata('tahun');?></span>
                </a>
                <ul class="dropdown-menu">
                    <?php for ($i = 2000; $i <= 2015; $i++) { ?>
                        <li><a href="<?php echo base_url()?>manager/dashboard/tahun/<?php echo $i; ?>"><?php echo "Tahun ".$i; ?></a></li>
                    <?php } ?>
                </ul>
            </li>
            <li  class="pull-right">
                <a>
                    <i class="icon-user"></i>
                    <span><?php echo "Selamat Datang ".$this->session->userdata('nama');?></span>
                </a>
            </li>
            <?php }else{ ?>
            <li></li>
            <?php } ?>
        </ul>
        <!-- /#topbar: Top Bar Menu -->


        <div class="container-fluid" id="container">

            <!-- #sidebar: Sidebar -->
            <div id="sidebar">

                <div class="search-mini-wrapper">
                    
                </div>      

                <!-- ul.sidebar-menu: Sidebar Menu -->
                <ul class="sidebar-menu on-click" id="main-menu">
                    <?php
                    for ($i = 0; $i < (count($menu)); $i++) {
                        ?>
                        <li class="<?php echo $stat[$i]; ?>">
                            <div class="sidebar-menu-item-wrapper">
                                <a href="<?php echo base_url();
                    echo $link[$i]; ?>">
                                    <i class="<?php echo $icon[$i]; ?>"></i>
                                    <span><?php echo $menu[$i]; ?></span>
                                </a>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <!-- /ul.sidebar-menu: Sidebar Menu -->


                <a href="#" id="sidebar-resizer">
                    <i class="min icon-resize-small"></i>
                    <i class="max icon-resize-full"></i>
                </a>

            </div>
            <!-- /#sidebar: Sidebar -->

            <!-- #content: The Main Content Section
        
              Just add the page content here for a regular page or use .page DIVs for panel pages.
              Use Bootstrap fluid layout for best effect.
        
            -->
            <div id="content">
                <?php $this->load->view($content); ?>
            </div>
            <!-- /#content: The Main Content Section -->

        </div><!-- /.container-fluid#container -->



        <!--============================= /Page Body ================================-->

        <!-- Javascript: placed at the end of the document to speed up page loading
             (generally gives more consistent behavior than 'defer') -->

        <!-- Scripts will most likely break in IE6 and below, so why bother loading them? -->
        <!--[if lte IE 6]><noscript><![endif]-->

        <!-- CMS/Framework scripts -->
        <!-- ADD HERE -->
        <!-- /CMS/Framework scripts -->

        <!-- jQuery -->
        <!-- 1: Grab Google CDN's jQuery, if the CMS/Framework hasn't loaded it -->
        <script>window.jQuery || document.write('<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"><\/script>')</script>  
        <!-- 2: ...fall back to local if offline -->
        <script>window.jQuery || document.write('<script src="<?php echo base_url() ?>media/js/libs/jquery-1.8.3.min.js"><\/script>')</script>
        <!-- 3: if jQuery was loaded in compatibility mode, where you have to use the
                long 'jQuery(...)' instead of '$(...)' (Wordpress does this), revert
                to to "classic" jQuery behavior -->
        <script>if ($ === undefined) $ = jQuery</script>
        <!-- /jQuery -->

        <!-- Bootstrap Components -->
        <script src="<?php echo base_url() ?>media/bootstrap/js/bootstrap.min.js"></script>


        <!-- Theme Scripts -->
        <script src="<?php echo base_url() ?>media/js/madmin.js"></script>
        <script src="<?php echo base_url() ?>media/js/application.js"></script>

        <!-- Flot Plotting -->
        <script src="<?php echo base_url() ?>media/js/libs/flot/excanvas.min.js"></script>
        <script src="<?php echo base_url() ?>media/js/libs/flot/jquery.flot.js"></script>
        <script src="<?php echo base_url() ?>media/js/libs/flot/jquery.flot.resize.min.js"></script>
        <script src="<?php echo base_url() ?>media/js/libs/flot/jquery.flot.pie.min.js"></script>

        <!-- Google Code Prettyfy - source-code highlighter -->
        <script src="<?php echo base_url() ?>media/js/libs/google-code-prettify/prettify.js"></script>

        <!-- jQuery Table Sorter Plugin -->
        <script src="<?php echo base_url() ?>media/js/libs/jquery.tablesorter/jquery.tablesorter.min.js"></script>

        <!-- jQuery Page Slide Plugin -->
        <script src="<?php echo base_url() ?>media/js/libs/jquery.pageslide/jquery.pageslide.min.js"></script>


        <!-- /Javascript -->

    </body>
</html>