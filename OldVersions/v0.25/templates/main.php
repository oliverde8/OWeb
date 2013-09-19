<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>oliverde8 - Website</title>

        <link href="sources/css/main.css" rel="stylesheet" type="text/css" />

        <?php
		OWeb\Gerer\enTete::ajoutEnTete(OWeb\Gerer\enTete::javascript, 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js');
		OWeb\Gerer\enTete::ajoutEnTete(OWeb\Gerer\enTete::javascript, OWEB_DIR_MAIN.'/defaults/'.OWEB_DIR_EXTENSIONS.'/Javascript/ajaxPageLoader.js');
        OWeb\Gerer\enTete::ajoutEnTete(OWeb\Gerer\enTete::css, 'Sources/css/menu.css'); ?>
		
        <?php $this->enTete(); ?>

    </head>

    <body>

        <!-- Le Header -->
        <div id="header">

            <div>
                <div class="logo"></div>

                <!-- Login Panel -->
                <div class="login_panel ">
					<?php
						$connection = \Extension\utilisateur\connection\TypeConnection::getInstance();
						if(!$connection->isConnected())
							echo $connection->getConnectionCodeHtml();
						else
							echo '<p>Welcome '.$connection->getLogin().'</p>';
					?>
                </div>

            </div>
        </div>

        <!-- Le Menu -->
        <div id="menu" ><div>
                <ul class="menu">
                    <li><a href="index.php?ctr=home" class="OWeb_nav">Home</a>	</li>
                    <li><a href="index.php?ctr=articles" class="OWeb_nav">Blog</a>	</li>

                    <li><a href="index.php?ctr=myBooks" class="OWeb_nav">My Books</a></li>
                    <li><a href="http://forum.mlepp.com/index.php" class="OWeb_nav">Test</a></li>

                    <li><a href="#">Coming Soon</a></li>
                </ul>
        </div></div>

        <!-- Le Contenu -->
        <div id="contenuFull"><div id="contenuFullJS">
				
                <?php
                $this->afficher();
                ?>
				
        </div></div><!-- Fin du Contenu -->

    </body>
</html>