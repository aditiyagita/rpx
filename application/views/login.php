<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <!-- Title: -->
        <title>MADMIN</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="" />

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

        <!-- /Libs Styles -->

        <!-- Core Theme Styles -->
        <!-- <link rel="stylesheet/less" href="<?php echo base_url() ?>media/styles/style.less" /> -->
        <link rel="stylesheet" href="<?php echo base_url() ?>media/styles/style.css" />

        <!-- /Theme Styles -->

        <!-- CMS/Framework styles & scripts -->
        <!-- ADD HERE -->
        <!-- /CMS/Framework styles & scripts -->

        <!-- Style tweaks to CMS/plugins/widgets -->
        <!-- ADD HERE -->
        <!-- eg.: <link href="<?php echo base_url() ?>media/css/tweaks.css" rel="stylesheet" /> -->
        <!-- /Style tweaks to CMS/plugins/widgets -->

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements:
             load latest from Google Code, fall back to local if offline -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
          <script>window.html5 || document.write('<script src="media/js/libs/fixes/html5.js"><\/script>')</script>
        <![endif]-->

        <!-- Icons: place favicon.ico and apple-touch-icon.png in the root directory (more: mathiasbynens.be/notes/touch-icons) -->
        <!--
        <link rel="shortcut icon" href="bootstrap/ico/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="media/bootstrap/ico/apple-touch-icon-114-precomposed.png" />
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

    <body class="no-sidebar-page">

        <!--============================= Page Body =================================-->



        <div class="container-fluid" id="container">

            <!-- #content.row-fluid: The Main Content Section
          
              Just add the page content here for a regular page or use .page DIVs for panel pages.
              Use Bootstrap fluid layout for best effect.
          
            -->
            <div class="panel" id="panel-login">

                <header>
                    <i class="icon-sign-blank"></i>
                    <span>LOG IN</span>
                </header>

                <div class="content">

                    <form action="<?php base_url()?>do_login" method="post"/>


                    <div class="login-fields">

                        <div class="field">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" placeholder="Username" class="login username-field input-xlarge" />
                        </div> <!-- /.field -->

                        <div class="field">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Password" class="login password-field input-xlarge" />
                        </div> <!-- /.field -->

                    </div><!-- /.login-fields -->

                    <div class="login-actions">
                        <br />
                        <button class="button btn btn-large btn-primary btn-madmin">Sign In</button>

                    </div><!-- /.login-actions -->

                    </form>

                </div><!-- /.content -->

            </div><!-- /.panel -->

        </div><!-- /.container-fluid#container -->
    </body>
</html>