<?php

namespace Extension\bbcode\JBBCode\myCodes;

/**
 * Description of Titles
 *
 * @author oliverde8
 */
class Titles extends \Extension\bbcode\JBBCode\CodeDefinition{
	
	public static $tree = array();
	
	public function __construct()
    {
        parent::__construct();
        $this->setTagName("title");
		$this->setUseOption(true);
    }
	
	public function asHtml( \Extension\bbcode\JBBCode\ElementNode $el ){		
		$content = "";
        foreach( $el->getChildren() as $child )
            $content .= $child->getAsBBCode();
		
		$att = $el->getAttribute();
		$tag = trim(htmlspecialchars($content));
		
		if($att == 'h1'){
			self::$tree[] = array(1, $content, $tag);
			return "<h1 id=\"$tag\">".$content."</h1>";
		}else if($att == 'h2'){
			self::$tree[] = array(2, $content, $tag);
			return "<h2 id=\"$tag\">".$content."</h2>";
		}else if($att == 'h3'){
			self::$tree[] = array(3, $content, $tag);
			return "<h3 id=\"$tag\">".$content."</h2>";
		}else if($att == 'h4'){
			self::$tree[] = array(4, $content, $tag);
			return "<h4 id=\"$tag\">".$content."</h4>";
		}else if($att == 'h5'){
			self::$tree[] = array(5, $content, $tag);
			return "<h4 id=\"$tag\">".$content."</h5>";
		}
	}
	
}

?>
