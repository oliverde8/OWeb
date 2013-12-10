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

namespace Extension\bbcode;

require_once OWEB_DIR_MAIN . '/defaults/extensions/bbcode/SBBCodeParser/SBBCodeParser.php';

/**
 * Description of JBBCode
 *
 * @author oliverde8
 */
class SBBCodeParser extends \OWeb\types\Extension {

	public static $tree = array();
	private $parser = null;

	protected function init() {
		$this->addAlias('getBBHtml', 'getBBHtml');
		$this->addAlias('getBBText', 'getBBText');
	}

	public function getNewParser() {
		$parser = new \SBBCodeParser\Node_Container_Document();

		$bbcode = new \SBBCodeParser\BBCode('title',
				function($content, $attribs) {

			$att = $attribs['default'];
			if ($att == 'h1') {
				self::$tree[] = array(1, $content, $tag);
				return "<h1 id=\"$tag\">" . $content . "</h1>";
			}
			else if ($att == 'h2') {
				self::$tree[] = array(2, $content, $tag);
				return "<h2 id=\"$tag\">" . $content . "</h2>";
			}
			else if ($att == 'h3') {
				self::$tree[] = array(3, $content, $tag);
				return "<h3 id=\"$tag\">" . $content . "</h2>";
			}
			else if ($att == 'h4') {
				self::$tree[] = array(4, $content, $tag);
				return "<h4 id=\"$tag\">" . $content . "</h4>";
			}
			else if ($att == 'h5') {
				self::$tree[] = array(5, $content, $tag);
				return "<h4 id=\"$tag\">" . $content . "</h5>";
			}

			print_r($attribs);
		}, \SBBCodeParser\BBCode::BLOCK_TAG, false, array(), array('text_node'),
				\SBBCodeParser\BBCode::AUTO_DETECT_EXCLUDE_ALL);

		$parser->add_bbcode($bbcode);
		
		$parser->add_emoticons(array(
			':D' => OWEB_HTML_URL_IMG.'/icons/01.png',
			'OD' => OWEB_HTML_URL_IMG.'/icons/02.png',
			':)' => OWEB_HTML_URL_IMG.'/icons/03.png',
			';)' => OWEB_HTML_URL_IMG.'/icons/04.png',
			'8)' => OWEB_HTML_URL_IMG.'/icons/05.png',
		));
		
		return $parser;
	}

	public function getParser() {
		return $this->parser == null ? $this->getNewParser() : $this->parser;
	}

	public function getBBHtml($text, $nl2br=true, $htmlEntities = true) {
		return $this->getParser()->parse($text)
						->detect_links()
						->detect_emails()
						->detect_emoticons()
						->get_html($nl2br, $htmlEntities);
	}

	public function getBBText($text) {
		return $this->getParser()->parse($text)->get_text();
	}

}

?>
