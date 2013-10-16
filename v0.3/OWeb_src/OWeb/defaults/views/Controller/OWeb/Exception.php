<?php

$this->addHeader('jquery_theme/jquery-ui-1.9.2.custom.min.css',\OWeb\manage\Headers::css); 
$this->addHeader('jquery-ui-1.9.2.custom.min.js',\OWeb\manage\Headers::javascript); 
$this->addHeader('2Collone.css',\OWeb\manage\Headers::css); 
?>

<div id="twoCollone">
<?php 
	$h='
		 <script>
    $(function() {
        $( "#exception_trace" ).accordion({
            collapsible: true,
			 heightStyle: "content",
			 active : "false"
        });
    });
    </script>';
	$this->addHeader($h,\OWeb\manage\Headers::code);
?>
	
	<div class="contenuMain">


        <?php

        $error_view = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\OWeb\Error');

        //Fatal error: Call to undefined function gets_class() in C:\ption.php on line 28
        foreach($this->userException as $ex){

            $error_view->addParams('Title', $ex->getMessage())
                    ->addParams('Description', $ex->getUserDescription())
                    ->addParams('img', $ex->getUserImage())
                    ->display();
        }
        ?>


        <div id="Errors">

		    <?php echo '<h2>'.$this->l('title').'</h2>'; ?>
		
            <div id="exception_trace">
            <?php
            //Fatal error: Call to undefined function gets_class() in C:\ption.php on line 28
            foreach($this->messages as $ex){
                $ex = new \OWeb\Exception();
                ?>
                <h3><?php echo get_class($ex); ?></h3>
                <div>
                    <h4><?php echo $ex->getMessage(); ?></h4>
                    <ul>
                        <li><strong> File : </strong><?php echo $ex->getFile(); ?></li>
                        <li><strong> Message : </strong><?php echo $ex->getLine(); ?></li>
                        <li><strong> Line : </strong><?php echo $ex->getLine(); ?></li>
                        <li><strong> Trace : </strong>
                            <ul>
                                <?php foreach($ex->getTrace() as $t){ ?>
                                <li>
                                    <strong><?php echo $t['file']; ?></strong>
                                    <ul>
                                        <?php
                                        unset($t['file']);
                                        foreach($t as $n=>$v){?>
                                            <li><strong><?php echo $n; ?> : </strong><?php echo $v;?></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            <?php } ?>
		</div>
        </div>
	
	</div>
</div>




