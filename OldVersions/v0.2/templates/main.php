<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>oliverde8 - Website</title>

        <link href="sources/css/main.css" rel="stylesheet" type="text/css" />

        <?php
		OWeb\Gerer\enTete::ajoutEnTete(OWeb\Gerer\enTete::javascript, 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js');
        OWeb\Gerer\enTete::ajoutEnTete(OWeb\Gerer\enTete::css, 'Sources/css/menu.css');
        OWeb\Gerer\enTete::ajoutEnTete(OWeb\Gerer\enTete::javascript, 'Sources/js/menu.js')?>
		
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
						$opeId = \OWeb\Gerer\Extensions::getExtension('Utilisateur\OpenId');
						echo $opeId->formulaireLogin();
					?>
                    <!--<form method="post" action="" />
                    <label>Login : </label>
                    <input type="text" name="login"/>

                    <label>Password : </label>
                    <input type="password" name="pwd"/>

                    <input type="submit" value="Ok" class="bouton" />
                    </form>-->
                </div>

            </div>
        </div>

        <!-- Le Menu -->
        <div id="menu" ><div>
                <ul class="menu">
                    <li><a href="#" class="parent">Menu</a>
						<ul>
							<li><a href="#"><span>Sub Item 1.2</span></a></li>
							<li><a href="#"  class="parent"><span>Sub Item 1.3</span></a>
								<ul>
									 <li><a href="#"><span>Sub Item 1.2</span></a></li>
									<li><a href="#"><span>Sub Item 1.3</span></a></li>
									<li><a href="#"><span>Sub Item 1.4</span></a></li>
									<li><a href="#"><span>Sub Item 1.5</span></a></li>
									<li><a href="#"><span>Sub Item 1.6</span></a></li>
								</ul>
							</li>
							<li><a href="#"><span>Sub Item 1.4</span></a></li>
						</ul>
					</li>

                    <li><a href="#">test</a></li>

                    <li><a href="#">test2</a></li>
                </ul>
        </div></div>

        <!-- Le Contenu -->
        <div id="contenu"><div>
            <!-- Contenu Principale a gauche -->
            <div id="contenu_gauche">

                <?php
                $this->afficher();
                ?>

            </div>

             <!-- Contenu Secondaire a droite -->
            <div id="contenu_droite">
                <div class="block">
                    <div class="titre titre2"><p>Hehe</p></div>

                    <div class="text">
                        <ul>
                            <li>Cat1
                                <ul>
                                    <li>cat1-1</li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="foot"></div>
                </div>
            </div>
        </div></div><!-- Fin du Contenu -->

<div id="copyright">Copyright &copy; 2011 <a href="http://apycom.com/">Apycom jQuery Menus</a></div>
    </body>
</html>