<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>oliverde8 - Website</title>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <?php
			$this->InitLanguageFile();
			$this->addHeader('main.css',\OWeb\manage\Headers::css); 
			$this->addHeader('main.js',\OWeb\manage\Headers::javascript); 
			$this->addHeader('menu.css',\OWeb\manage\Headers::css); 

			$this->headers();
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

    </head>

    <body>

        <!-- Le Header -->
        <div id="header">

            <div>
                <div class="logo"></div>

                <!-- Login Panel -->
                <div class="login_panel ">
					<?php
						$connection = \OWeb\manage\Extensions::getInstance()->getExtension('user\connection\TypeConnection');
						
						if(!$connection->isConnected())
							echo '<form method="post" action="" />
                    <label>Login : </label>
                    <input type="text" name="login"/>

                    <label>Password : </label>
                    <input type="password" name="pwd"/>
					
					<input type="hidden" name="ext_a" value="connect"/>

                    <input type="submit" value="Ok" class="bouton" />
              </form>';
						else
							echo '<p>Welcome Test. <a href="?ext_a=disconnect">Disconnect</a></p>';/**/
					?>
                </div>

            </div>
        </div>

		<?php
			$link_fr = \OWeb\utils\Link::getCurrentLink()->addParam('lang', 'fr');
			$link_eng = \OWeb\utils\Link::getCurrentLink()->addParam('lang', 'eng');
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

                    <li><a href="#"><?php echo $this->l('more'); ?></a></li>
                </ul>
        </div></div>
		
		
		<div id="publicity"><div>
			<div id="leftpublicity">
				<script type="text/javascript"><!--
				google_ad_client = "ca-pub-4916277382923083";
				/* oliver2 */
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
				/* oliver2 */
				google_ad_slot = "8441719598";
				google_ad_width = 120;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
			</div>
		</div></div>
		
        <!-- Le Contenu -->
        <div id="contenuFull"><div id="contenuFullJS">
				
                <?php
                $this->display();
                ?>
				
        </div></div><!-- Fin du Contenu -->

		 <div id="foot" ><div>
			<p class="generated">Generaterd in <?php echo \OWeb\OWeb::getInstance()->get_runTime();   ?> Seconds</p>
			<p class="powered">
				Powered by OWeb
				| <a href="articles.Categorie.html?catId=9">About OWeb</a>
				| <a href="articles.Categorie.html?catId=10">About The Website</a>
			</p>
        </div></div>
		
    </body>
</html>