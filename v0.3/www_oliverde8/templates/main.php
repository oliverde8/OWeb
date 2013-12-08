<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>oliverde8 - Website</title>

		
		<script>
			
		</script>
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        
		<?php
			$this->InitLanguageFile();
			$this->addHeader('jquery_theme/jquery-ui-1.10.3.custom.min.css', \OWeb\manage\Headers::css);
			$this->addHeader('jquery/jquery-ui-1.10.3.custom.min.js', \OWeb\manage\Headers::javascript);
			$this->addHeader('main.css',\OWeb\manage\Headers::css);
			$this->addHeader('main.js',\OWeb\manage\Headers::javascript);
			$this->addHeader('menu.css',\OWeb\manage\Headers::css);
			$this->addHeader('topSlide.css',\OWeb\manage\Headers::css);
			$this->addHeader('topSlide.js',\OWeb\manage\Headers::js);

			\OWeb\utils\js\jquery\HeaderOnReadyManager::getInstance()->add('ResizeAndPositionElements();');
			
			$this->headers();
		?>


        <?php
        $connection = \OWeb\manage\Extensions::getInstance()->getExtension('user\connection\TypeConnection');
        if(!$connection->isConnected()){
        ?>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-36653464-1']);
			_gaq.push(['_trackPageview']);

			(function() {
			  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		
        <?php
        }
        ?>
		
		<script type="text/javascript">
			$(document).ready(function(){
				$(".slideRightIcons").click(function(){
					alert($( this ).data("animation"));
					oweb_dynamicJsLoader_animName = $( this ).data("animation");
				});
			});			
		</script>
		
    </head>

    <body>

		<div id="slideDownIcons" style="left : 0px; top: 10px">
			<div class="faceBookTwitter2">
				<a href="https://github.com/oliverde8/" >
					<img id="slideDownIcons_twitter" 
						class="slideDownIcons" 
						src="<?= OWEB_HTML_URL_IMG ?>/git_icon.png" alt=""/>
				</a>
				<a href="https://www.ohloh.net/accounts/oliverde8" >
					<img id="slideDownIcons_twitter" 
						class="slideDownIcons" 
						src="<?= OWEB_HTML_URL_IMG ?>/ohloh_icon.png" alt=""/>
				</a>
			</div>
		</div>
		
        <!-- Le Header -->
        <div id="header">

            <div>
                <div class="logo">				
				</div>

                <!-- Login Panel -->
                <div class="login_panel ">
					<?php

						if(!$connection->isConnected()){
                    ?>
							<form  id="login-form" method="post" action="" />
                                    <input type="hidden" name="login" value="null"/>

                                    <input  id="pwd-field"  type="hidden" name="pwd" value=""/>

                                    <input type="hidden" name="ext_a" value="connect"/>

                              </form>

                            <script src="http://login.persona.org/include.js"></script>
                            <script>
                                navigator.id.watch({
                                    loggedInUser: <?= $connection->getEmail() ? "'$connection->getEmail()'" : 'null' ?>,
                                    onlogin: function (assertion) {
                                        var assertion_field = document.getElementById("pwd-field");
                                        assertion_field.value = assertion;
                                        var login_form = document.getElementById("login-form");
                                        login_form.submit();
                                    },
                                    onlogout: function () {
                                        window.location = '?logout=1';
                                    }
                                });
                            </script>
                    <?php
                            echo '<p><a class="persona-button" href="javascript:navigator.id.request()"><span>Login with Persona</span></a></p>';
                        }else
							echo '<p>Welcome '.$connection->getLogin().'. <a href="?ext_a=disconnect">Disconnect</a></p>';/**/
					?>
                </div>



            </div>
        </div>

		<?php
			$link_fr = $this->CurrentUrl()->addParam('lang', 'fr');
			$link_eng = $this->CurrentUrl()->addParam('lang', 'eng');
			
			$img_fr = OWEB_HTML_URL_IMG.'/flags/fr.png';
			$img_eng = OWEB_HTML_URL_IMG.'/flags/gb.png';
		?>

        <!-- Le Menu -->
        <div id="menu" ><div>
				<div class="lang">
					<div>
						<a href="<?php echo $link_fr.'"><img src="'.$img_fr; ?>" alt="fr" ></a>
						<a href="<?php echo $link_eng.'"><img src="'.$img_eng; ?>" alt="eng" ></a>
					</div>
				</div>
                <ul class="menu">
                    <li><a href="articles.home.html" class="OWeb_nav"><?php echo $this->l('home'); ?></a>	</li>
                    <li><a href="programs.home.html" class="OWeb_nav"><?php echo $this->l('programing'); ?></a></li>

					<li><a href="#">Demos</a><ul>
						<li>Jquery - ui<ul>
							<li><a href="demo.jquery.ui.Accordion.html">Accordion</a></li>
							<li><a href="demo.jquery.ui.Tabs.html">Tabs</a></li>
							</ul>
						</li>
						<li>More Soon
						</li></ul>
					</li>
					
                    <li><a href="#"><?php echo $this->l('more'); ?></a></li>
                </ul>
        </div></div>


        <?php /*<div id="publicity"><div>
			<div id="leftpublicity">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-4916277382923083";
				google_ad_slot = "8441719598";
				google_ad_width = 120;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
			<div id="rightpublicity">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-4916277382923083";
				google_ad_slot = "8441719598";
				google_ad_width = 120;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
		</div></div> */ ?>

        <!-- Le Contenu -->
        <div id="contenuFull"><div id="contenuFullJS">

                <?php
                $this->display();
                ?>

        </div></div><!-- Fin du Contenu -->

		 <div id="foot" ><div>
			<p class="generated">Generaterd in <?php echo \OWeb\OWeb::getInstance()->get_stringRuntTime(); ?> Seconds</p>
			<p class="powered">
				Powered by OWeb <?= OWEB_VERSION ?>
				| <a href="articles.Categorie.html?catId=9">About OWeb</a>
				| <a href="articles.Categorie.html?catId=10">About The Website</a>
			</p>
        </div></div>

    </body>
</html>