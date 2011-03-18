<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * codeigniter helper responsible of assets and page properties 
 *
 * enable you to add javascript, cascading stylsheet, meta text and dojo files
 * to page header plus creating page title in a good manner 
 *
 * @copyright  2011 Emad Elsaid a.k.a Blaze Boy
 * @license    http://www.gnu.org/licenses/gpl-2.0.txt   GPL License 2.0
 * @link       https://github.com/blazeeboy/Codeigniter-Egypt
 * @package Helpers
 */ 
$CI =& get_instance();
$CI->load->config('theme');

if( ! function_exists('theme_title') ){
	/**
	 * get current page title 
	 * 
	 * @param string $title [html or text] type or returned output
	 * @return string the title as [<title> tag or plain title value]
	 */
	function theme_title( $title='html' ){

		$CI =& get_instance();
		$pagetitle = 	$CI->config->item('page_title');

		if( empty($pagetitle) )
		$titleText = $CI->config->item('site_name');
		else
		$titleText = 	$CI->config->item('site_name').
		$CI->config->item('page_title_prefix').
		$CI->config->item('page_title').
		$CI->config->item('page_title_suffix');

		switch( $title ){
			case 'html';
			return "<title>$titleText</title>\n";
			break;
			case 'text';
			return $titleText;
			break;
		}
	}
}

if( ! function_exists('theme_sitename') ){
	/**
	 * get/set website name, the default returned value is 
	 * site name in theme config file
	 * 
	 * @param string $sitename website name if not null it'll be set 
	 * as current website title
	 * 
	 * @return string the website name
	 */
	function theme_sitename( $sitename=NULL ){
		$CI =& get_instance();
		if( $sitename!==NULL )
		$CI->config->set_item( 'site_name', $sitename );
			
		return $CI->config->item('site_name');
	}
}

if( ! function_exists('theme_pagetitle') ){
	/**
	 * set/get current page title 
	 * 
	 * @param string $pagetitle the page title to be set
	 * @return string the current page name
	 */
	function theme_pagetitle( $pagetitle=NULL ){
		
		$CI =& get_instance();
		if( $pagetitle!==NULL )
		$CI->config->set_item( 'page_title', $pagetitle );
			
		return $CI->config->item('page_title');
		
	}
}

if( ! function_exists('theme_add') ){
	/**
	 * add files and text to the required files array
	 * 
	 * it could be used for adding css files, javascript files, 
	 * dojo required components or even meta tags or any string
	 * to the page header, that function is smart enaugh to know the type
	 * of text (meta tag, script tag, file path, plain text) and
	 * add it to the suitable place.
	 * 
	 * @param string $input 
	 */
	function theme_add( $input=NULL ){

		if( is_array($input) ){
			foreach( $input as $item )
			theme_add( $item );

			return;
		}

		$input = trim($input);
		$extension = substr( $input, strrpos( $input, '.' )+1 );
		switch( $extension ){
			case 'js':
				theme_js( $input );
				return;
			case 'css':
				theme_css( $input );
				return;
		}

		$input = trim($input);
		$prefix = substr($input, 0, 5);
		switch( $prefix ){
			case '<!--[':
			case '<scri':
				theme_js( $input );
				return;

			case '<styl':
			case '<link':
				theme_css( $input );
				return;
					
			case '<meta':
				theme_meta( $input );
				return;
			case 'dojo.':
			case 'dijit':
			case 'dojox':
				theme_dojo( $input );
		}
	}
}

if( ! function_exists('theme_doctype') ){
	/**
	 * return the corrent doctype configured in the theme configuration file
	 * 
	 * @return string doctype tag string.
	 */
	function theme_doctype(){
		
		global $_doctypes;
		$CI =& get_instance();
		$type = $CI->config->item('doctype');

		if ( ! is_array($_doctypes))
			if ( ! require_once(APPPATH.'config/doctypes.php'))
				return FALSE;

		if (isset($_doctypes[$type]))
			return $_doctypes[$type]."\n";
		else
			return FALSE;
			
	}
}

if( ! function_exists('theme_meta') ){
	/**
	 * add/get page meta string to be added to the head tag
	 * 
	 * @param string/array $input to be added to the page meta string
	 */
	function theme_meta( $input=NULL ){

		$CI =& get_instance();
		if ( is_null($input) ){
			$charset = $CI->config->item('charset');
			$meta = "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=$charset\" />\n";
			$mArray = $CI->config->item('meta');
			$mArray = implode( "\n", $mArray);
			return $meta.$mArray;
		}

		if( ! in_array($input, $CI->config->config['meta'] ) )
		array_push( $CI->config->config['meta'], $input);
		
	}
}

if( ! function_exists('theme_css') ){
	/**
	 * add/get page CSS string to be added to the head tag
	 * 
	 * @param string/array $input to be added to the page CSS string
	 */
	function theme_css( $input=NULL ){
		
		if( is_array($input) ){
			foreach( $input as $item )
			theme_css($item);
			return;
		}

		$CI =& get_instance();
		if ( is_null($input) ){
			$cssText = '';
			$cssArray = $CI->config->item('css_files');
			foreach( $cssArray as $item )
			if( $item[0]!='<' )
			$cssText .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"$item\">\n";
			else
			$cssText .= $item."\n";

			return $cssText;
		}

		if( $input[0]!='<' )
			$input = $CI->config->slash_item('base_url').$input;
			
		if( ! in_array($input, $CI->config->config['css_files']) )
		array_push( $CI->config->config['css_files'], $input);
		
	}
}

if( ! function_exists('theme_js') ){
	/**
	 * add/get page javascript string to be added to the head tag
	 * 
	 * @param string/array $input to be added to the page javascript string
	 * @return string collection of script tags to be added to header tag
	 */
	function theme_js( $input=NULL ){
		
		if( is_array($input) ){
			foreach( $input as $item )
			theme_js($item);
			return;
		}

		$CI =& get_instance();
		if ( is_null($input) ){
			$jsText = '';
			$jsArray = $CI->config->item('js_files');
			foreach( $jsArray as $item )
			if( $item[0]!='<' ){
				$param = ($item==$CI->config->slash_item('base_url').'dojo/dojo/dojo.js')? 'djConfig="parseOnLoad:true"':'';
				$jsText .= "<script type=\"text/javascript\" src=\"$item\" $param ></script>\n";
			}else
			$jsText .= $item."\n";
			return $jsText;
		}

		if( $input[0]!='<')
			$input = $CI->config->slash_item('base_url').$input;

		if( ! in_array($input, $CI->config->config['js_files']) )
		array_push( $CI->config->config['js_files'], $input);
	}
}

if( ! function_exists('theme_dojotheme') ){
	/**
	 * get dojo theme name specified in theme config file 
	 * 
	 * @return string dojo style folder name
	 */
	function theme_dojotheme(){
		
		$CI =& get_instance();
		return $CI->config->config['dojo_style'];
		
	}
}

if( ! function_exists('theme_dojo') ){
	/**
	 * add/get dojo required components by require() function
	 * 
	 * @param string/array $input to be added to the page meta string
	 * @return string script tag contains dojo require() 
	 * for all dojo reuired components
	 */
	function theme_dojo( $input=NULL ){
		
		if( is_array($input) ){
			foreach( $input as $item )
			theme_dojo($item);
			return;
		}
		
		$CI =& get_instance();
		if ( is_null($input) ){
			if( count($CI->config->item('dojo_files'))==0 )
				return '';
			$dojoText = '<script type="text/javascript">';
			$dojoArray = $CI->config->item('dojo_files');
			foreach( $dojoArray as $item )
				$dojoText .= 'dojo.require("'.$item.'");';
			
			$dojoText .= '</script>';
			return $dojoText;
		}
		
		if( count($CI->config->config['dojo_files'])==0 ){
			theme_css('dojo/dijit/themes/'.$CI->config->config['dojo_style'].'/'.$CI->config->config['dojo_style'].'.css');
			theme_js('dojo/dojo/dojo.js');
		}
		
		if( ! in_array($input, $CI->config->config['dojo_files']) )
		array_push( $CI->config->config['dojo_files'], $input);
	}
}

if( ! function_exists('theme_head')){
	/**
	 * get HTML page header depending on current required files meta
	 * and dojo required components
	 * 
	 * @return string header tag contents (without the header tag itself)
	 */
	function theme_head(){

		$CI =& get_instance();
		$head =	theme_meta().
				theme_title().
				theme_css();

		if( ! $CI->config->item('js_at_foot') )
		$head .= theme_js().theme_dojo();

		return $head;
		
	}
}

if( ! function_exists('theme_foot')){
	/**
	 * get theme footer text before the end of body tag
	 * that will get teh javasript text if js_at_foot is On
	 * in the theme config file
	 * 
	 * @return string collection of script tags 
	 * to be added before body tag close (or empty text if js_on_foot is Off)
	 */
	function theme_foot(){
		
		$CI =& get_instance();

		if( $CI->config->item('js_at_foot') )
		return theme_js().theme_dojo();

		return '';
		
	}
}
?>
