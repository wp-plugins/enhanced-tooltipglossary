<?php
/*
Plugin Name: EnhancedTooltipGlossary
Plugin URI: http://www.creativemindsweb.com/plugins/enhancedtooltipglossary
Description: Parses posts for defined glossary terms and adds links to the static glossary page containing the definition and a tooltip with the definition.
Version: 1.0
Author: CreativeMinds based on jatls tooltipglossary
*/

/*

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Add options needed for plugin
	add_option('red_glossaryOnlySingle', 0); //Show on Home and Category Pages or just single post pages?
	add_option('red_glossaryOnPages', 1); //Show on Pages or just posts?
	add_option('red_glossaryID', 0); //The ID of the main Glossary Page
	add_option('red_glossaryTooltip', 0); //Use tooltips on glossary items?
	add_option('red_glossaryDiffLinkClass', 0); //Use different class to style glossary list
	add_option('red_glossaryPermalink', 'glossary'); //Set permalink name
	add_option('red_glossaryFirstOnly', 0); //Search for all occurances in a post or only one?
	add_option('red_glossaryFilterTooltip', 30); //Clean the tooltip text fromuneeded chars?
	add_option('red_glossaryLimitTooltip', 0); // Limit the tooltip length  ?
	add_option('red_glossaryTermLink', 0); //Remove links to glossary page
	add_option('red_glossaryExcerptHover', 0); //Search for all occurances in a post or only one?
	add_option('red_glossaryProtectedTags', 1); //SAviod the use of Glossary in Protected tags?


// Register glossary custom post type
	function create_post_types(){
		$glossaryPermalink = get_option('red_glossaryPermalink');
		$args = array(
			'label' => 'Glossary',
			'description' => '',
			'public' => true,
			'show_ui' => true,
			'_builtin' => false,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => $glossaryPermalink),
			'query_var' => true,
			'supports' => array('title','editor','author','excerpt'));
		register_post_type('glossary',$args);
		flush_rewrite_rules();
	}
	add_action( 'init', 'create_post_types');

//Function parses through post entries and replaces any found glossary terms with links to glossary term page.

	//Add tooltip stylesheet & javascript to page first
	function red_glossary_js () {
		$glossary_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		wp_enqueue_script('tooltip-js',$glossary_path.'tooltip.js');
	}
	add_action('wp_print_scripts', 'red_glossary_js');

	function red_glossary_css () {
		$glossary_path = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		wp_enqueue_style('tooltip-css',$glossary_path.'tooltip.css');
	}
	add_action('wp_print_styles', 'red_glossary_css');
		
function red_glossary_parse($content){

	//Run the glossary parser
	if (((!is_page() && get_option('red_glossaryOnlySingle') == 0) OR
	(!is_page() && get_option('red_glossaryOnlySingle') == 1 && is_single()) OR
	(is_page() && get_option('red_glossaryOnPages') == 1))){
		$glossary_index = get_children(array(
											'post_type'		=> 'glossary',
											'post_status'	=> 'publish',
											'order'			=> 'DESC',
											'orderby'		=> 'title'
											));	
											
		//the tag:[glossary_exclude]+[/glossary_exclude] can be used to mark text will not be taken into account by the glossary
		if ($glossary_index){
			$timestamp = time();
					
			$excludeGlossary_regex = '/\\['                              // Opening bracket
				. '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
				. "(glossary_exclude)"                     // 2: Shortcode name
				. '\\b'                              // Word boundary
				. '('                                // 3: Unroll the loop: Inside the opening shortcode tag
				.     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
				.     '(?:'
				.         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
				.         '[^\\]\\/]*'               // Not a closing bracket or forward slash
				.     ')*?'
				. ')'
				. '(?:'
				.     '(\\/)'                        // 4: Self closing tag ...
				.     '\\]'                          // ... and closing bracket
				. '|'
				.     '\\]'                          // Closing bracket
				.     '(?:'
				.         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
				.             '[^\\[]*+'             // Not an opening bracket
				.             '(?:'
				.                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
				.                 '[^\\[]*+'         // Not an opening bracket
				.             ')*+'
				.         ')'
				.         '\\[\\/\\2\\]'             // Closing shortcode tag
				.     ')?'
				. ')'
				. '(\\]?)/s';		
	
			// define regular expression of tags Glossary should aviod
			if (get_option('red_glossaryProtectedTags') == 1) {
			$pre_regex = '/<pre[^>]*>(.*?)<\/pre>/si';				
			$object_regex = '/<object[^>]*>(.*?)<\/object>/si';				
			$span_regxH1 = '/<h1[^>]*>(.*?)<\/h1>/si';
			$span_regxH2 = '/<h2[^>]*>(.*?)<\/h2>/si';
			$span_regxH3 = '/<h3[^>]*>(.*?)<\/h3>/si';
			$script_regex = '/<script[^>]*>(.*?)<\/script>/si';
			$pretags = array();
			$objecttags = array();
			$spantagsH1 = array();
			$spantagsH2 = array();
			$spantagsH3 = array();
			$scripttags = array();

				$preTagsCount = preg_match_all($pre_regex,$content,$pretags,PREG_PATTERN_ORDER); 
				$i=0;

				if($preTagsCount>0)
				{
					foreach ($pretags[0] as $pretag)
	    			{	    						
						$content = preg_replace($pre_regex, '#'.$i.'pre', $content,1);
						$i++;
	    			}
				}

				$objectTagsCount = preg_match_all($object_regex,$content,$objecttags,PREG_PATTERN_ORDER); 
				$i=0;

				if($objectTagsCount>0)
				{
					foreach ($objecttags[0] as $objecttag)
	    			{	    						
						$content = preg_replace($object_regex, '#'.$i.'object', $content,1);
						$i++;
	    			}
				}

				
				$spanH1TagsCount = preg_match_all($span_regxH1,$content,$spantagsH1,PREG_PATTERN_ORDER); 
				$i=0;

				if($spanH1TagsCount>0)
				{
					foreach ($spantagsH1[0] as $spantagH1)
	    			{	    						
						$content = preg_replace($span_regxH1, '#'.$i.'H1', $content,1);
						$i++;
	    			}
				}

				$spanH2TagsCount = preg_match_all($span_regxH2,$content,$spantagsH2,PREG_PATTERN_ORDER); 
				$i=0;

				if($spanH2TagsCount>0)
				{
					foreach ($spantagsH2[0] as $spantagH2)
	    			{	    						
						$content = preg_replace($span_regxH2, '#'.$i.'H2', $content,1);
						$i++;
	    			}
				}

				$spanH3TagsCount = preg_match_all($span_regxH3,$content,$spantagsH3,PREG_PATTERN_ORDER); 
				$i=0;

				if($spanH3TagsCount>0)
				{
					foreach ($spantagsH3[0] as $spantagH3)
	    			{	    						
						$content = preg_replace($span_regxH3, '#'.$i.'H3', $content,1);
						$i++;
	    			}
				}
				
								
				$scriptTagsCount = preg_match_all($script_regex,$content,$scripttags,PREG_PATTERN_ORDER); 
				$i=0;

				if($scriptTagsCount>0)
				{
					foreach ($scripttags[0] as $scripttag)
	    			{	    						
						$content = preg_replace($script_regex, '#'.$i.'script', $content,1);
						$i++;
	    			}
				}				
			
			
			}
			
			$excludeGlossaryStrs = array();
							
			//replace exclude tags and content between them in purpose to save the original text as is 
			//before glossary plug go over the content and add its code
			//(later will be returned to the marked places in content) 
			
			$excludeTagsCount = preg_match_all($excludeGlossary_regex,$content,$excludeGlossaryStrs,PREG_PATTERN_ORDER); 
			$i=0;
			
			if($excludeTagsCount>0)
			{
				foreach ($excludeGlossaryStrs[0] as $excludeStr)
				{	    											
					$content = preg_replace($excludeGlossary_regex, '#'.$i.'excludeGlossary', $content,1);
					$i++;
				}
			}
				
				
			foreach($glossary_index as $glossary_item){
				$timestamp++;
				$glossary_title = $glossary_item->post_title;
				//old code bug-doesn't take into account href='' takes into account only href="")
				//$glossary_search = '/\b'.$glossary_title.'s*?\b(?=([^"]*"[^"]*")*[^"]*$)/i';
				$glossary_search = '/\b'.$glossary_title.'s*?\b(?=([^"]*"[^"]*")*[^"]*$)(?=([^\']*\'[^\']*\')*[^\']*$)/i';
				$glossary_replace = '<a'.$timestamp.'>$0</a'.$timestamp.'>';
				
				$origContent = $content;
												
				if (get_option('red_glossaryFirstOnly') == 1) {
					$content_temp = preg_replace($glossary_search, $glossary_replace, $content, 1);
				}
				else {
					$content_temp = preg_replace($glossary_search, $glossary_replace, $content);
				}
				$content_temp = rtrim($content_temp);								

					$link_search = '/<a'.$timestamp.'>('.$glossary_item->post_title.'[A-Za-z]*?)<\/a'.$timestamp.'>/i';
					if (get_option('red_glossaryTooltip') == 1) {
						if(get_option('red_glossaryExcerptHover') && $glossary_item->post_excerpt){
							$glossaryItemContent=$glossary_item->post_excerpt;
						} else {
							$glossaryItemContent=$glossary_item->post_content;
						}
					
						if (get_option('red_glossaryFilterTooltip') == 1) {
					// remove paragraph, bad chars from tooltip text
						$glossaryItemContent = str_replace(chr(10),"",$glossaryItemContent);
						$glossaryItemContent = str_replace(chr(13),"",$glossaryItemContent);
						$glossaryItemContent = str_replace('</p>','<br/>',$glossaryItemContent);
						$glossaryItemContent = strip_only($glossaryItemContent,'<p>');
						$glossaryItemContent = htmlspecialchars($glossaryItemContent);											
						$glossaryItemContent = addslashes($glossaryItemContent);	
						$glossaryItemContent = str_replace("color:#000000", "color:#ffffff", $glossaryItemContent);
						}

						if ((get_option('red_glossaryLimitTooltip') >  30) && (strlen ($glossaryItemContent) > get_option('red_glossaryLimitTooltip'))) {
						$glossaryItemContent = substr($glossaryItemContent,0,get_option('red_glossaryLimitTooltip')).'    <strong>More Details...<strong>';
						}
						
							if (get_option('red_glossaryTermLink') == 1) {
								$link_replace = '<span class="glossaryLink"  title="Glossary: '. $glossary_title . '" onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();">$1</span>';												
							} else {
								$link_replace = '<a class="glossaryLink" href="' . get_permalink($glossary_item) .'" title="Glossary: '. $glossary_title . '" onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();">$1</a>';												
							}

					}
					else {
							if (get_option('red_glossaryTermLink') == 1) {
									$link_replace = '<span class="glossaryLink"  title="Glossary: '. $glossary_title . '">$1</span>';
							} else {
									$link_replace = '<a class="glossaryLink" href="' . get_permalink($glossary_item) . '" title="Glossary: '. $glossary_title . '">$1</a>';
							}
			
					}
					$content_temp = preg_replace($link_search, $link_replace, $content_temp);
					$content = $content_temp;									
			}
					
				
			if($excludeTagsCount>0)
			{
				$i=0;
				foreach ($excludeGlossaryStrs[0] as $excludeStr)
    			{	    						
					$content = str_replace('#'.$i.'excludeGlossary', $excludeStr, $content);					
					$i++;
    			}
				//remove all the exclude signs			
				$content = str_replace('[glossary_exclude]', "", $content);
				$content = str_replace('[/glossary_exclude]', "", $content);
			}	


			if (get_option('red_glossaryProtectedTags') == 1) {

			if($preTagsCount>0)
			{
				$i=0;
				foreach ($pretags[0] as $pretag)
    			{	    						
					$content = str_replace('#'.$i.'pre', $pretag, $content);
					$i++;
    			}
			}
			
			if($objectTagsCount>0)
			{
				$i=0;
				foreach ($objecttags[0] as $objecttag)
    			{	    						
					$content = str_replace('#'.$i.'object', $objecttag, $content);
					$i++;
    			}
			}

			
			if($spanH1TagsCount>0)
			{
				$i=0;
				foreach ($spantagsH1[0] as $spantagH1Content)
	    		{	    	    								
	    			$content = str_replace('#'.$i.'H1', $spantagH1Content, $content);					
					$i++;
	    		}		
			}

			if($spanH2TagsCount>0)
			{
				$i=0;
				foreach ($spantagsH2[0] as $spantagH2Content)
	    		{	    	    								
	    			$content = str_replace('#'.$i.'H2', $spantagH2Content, $content);					
					$i++;
	    		}		
			}

			if($spanH3TagsCount>0)
			{
				$i=0;
				foreach ($spantagsH3[0] as $spantagH3Content)
	    		{	    	    								
	    			$content = str_replace('#'.$i.'H3', $spantagH3Content, $content);					
					$i++;
	    		}		
			}
			
			
			if($scriptTagsCount>0)
			{
				$i=0;
				foreach ($scripttags[0] as $scriptContent)
	    		{	    	    								
	    			$content = str_replace('#'.$i.'script', $scriptContent, $content);					
					$i++;
	    		}		
			}		

		}




			
		}
	}
	return $content;
}

//Make sure parser runs before the post or page content is outputted
add_filter('the_content', 'red_glossary_parse');

//create the actual glossary
function red_glossary_createList($content){
	$glossaryPageID = get_option('red_glossaryID');
	if (is_numeric($glossaryPageID) && is_page($glossaryPageID)){
		$glossary_index = get_children(array(
											'post_type'		=> 'glossary',
											'post_status'	=> 'publish',
											'orderby'		=> 'title',
											'order'			=> 'ASC',
											));
		if ($glossary_index){
			$content .= '<div id="glossaryList">';
			//style links based on option
			if (get_option('red_glossaryDiffLinkClass') == 1) {
				$glossary_style = 'glossaryLinkMain';
			}
			else {
				$glossary_style = 'glossaryLink';
			}
			foreach($glossary_index as $glossary_item){
				//show tooltip based on user option
				if (get_option('red_glossaryTooltip') == 1) {	
					$glossaryItemContent = htmlspecialchars($glossary_item->post_content);
					$glossaryItemContent = addslashes($glossaryItemContent);												
						if (get_option('red_glossaryTermLink') == 1) {
							$content .= '<p><span class="' . $glossary_style . '"  onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();">'. $glossary_item->post_title . '</span></p>';
						} else {
							$content .= '<p><a class="' . $glossary_style . '" href="' . get_permalink($glossary_item) . '" onmouseover="tooltip.show(\'' . $glossaryItemContent . '\');" onmouseout="tooltip.hide();">'. $glossary_item->post_title . '</a></p>';
						}
					}
				else {
						if (get_option('red_glossaryTermLink') == 1) {
							$content .= '<p><span class="' . $glossary_style . '"  >'. $glossary_item->post_title . '</span></p>';
						} else {
							$content .= '<p><a class="' . $glossary_style . '" href="' . get_permalink($glossary_item) . '">'. $glossary_item->post_title . '</a></p>';
						}

							}
			}
			$content .= '</div>';
		}
	}
	return $content;
}

add_filter('the_content', 'red_glossary_createList');


//admin page user interface
add_action('admin_menu', 'glossary_menu');

function glossary_menu() {
  add_options_page('TooltipGlossary Options', 'TooltipGlossary', 8, __FILE__, 'glossary_options');
}

function glossary_options() {
	if (isset($_POST["red_glossarySave"])) {
		//update the page options
		update_option('red_glossaryID',$_POST["red_glossaryID"]);
		update_option('red_glossaryID',$_POST["red_glossaryPermalink"]);
		$options_names = array('red_glossaryOnlySingle', 'red_glossaryOnPages', 'red_glossaryTooltip', 'red_glossaryDiffLinkClass', 'red_glossaryFirstOnly','red_glossaryLimitTooltip','red_glossaryFilterTooltip','red_glossaryTermLink','red_glossaryExcerptHover','red_glossaryProtectedTags');
		foreach($options_names as $option_name){
			if ($_POST[$option_name] == 1) {
				update_option($option_name,1);
			}
			else {
				update_option($option_name,0);
			}
		}
	}
	?>

<div class="wrap">
  <h2>Enhanced TooltipGlossary</h2>
  <form method="post" action="options.php">
    <?php wp_nonce_field('update-options');	?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">Main Glossary Page</th>
        <td><input type="text" name="red_glossaryID" value="<?php echo get_option('red_glossaryID'); ?>" /></td>
        <td colspan="2">Enter the page ID of the page you would like to use as the glossary (list of terms).  The page will be generated automatically for you on the specified page (so you should leave the content blank).  This is optional - terms will still be highlighted in relevant posts/pages but there won't be a central list of terms if this is left blank.</td>
      </tr>
      <tr valign="top">
        <th scope="row">Only show terms on single pages?</th>
        <td><input type="checkbox" name="red_glossaryOnlySingle" <?php checked(true, get_option('red_glossaryOnlySingle')); ?> value="1" /></td>
        <td colspan="2">Select this option if you wish to only highlight glossary terms when viewing a single page/post.  This can be used so terms aren't highlighted on your homepage for example.</td>
      </tr>
      <tr valign="top">
        <th scope="row">Highlight terms on pages?</th>
        <td><input type="checkbox" name="red_glossaryOnPages" <?php checked(true, get_option('red_glossaryOnPages')); ?> value="1" /></td>
        <td colspan="2">Select this option if you wish for the glossary to highlight terms on pages as well as posts.  With this deselected, only posts will be searched for matching glossary terms.</td>
      </tr>
      <tr valign="top">
        <th scope="row">Use tooltip?</th>
        <td><input type="checkbox" name="red_glossaryTooltip" <?php checked(true, get_option('red_glossaryTooltip')); ?> value="1" /></td>
        <td colspan="2">Select this option if you wish for the definition to show in a tooltip when the user hovers over the term.  The tooltip can be style differently using the tooltip.css and tooltip.js files in the plugin folder.</td>
      </tr>
      <tr valign="top">
        <th scope="row">Style main glossary page differently?</th>
        <td><input type="checkbox" name="red_glossaryDiffLinkClass" <?php checked(true, get_option('red_glossaryDiffLinkClass')); ?> value="1" /></td>
        <td colspan="2">Select this option if you wish for the links in the main glossary listing to be styled differently than the term links.  By selecting this option you will be able to use the class 'glossaryLinkMain' to style only the links on the glossary page otherwise they will retain the class 'glossaryLink' and will be identical to the linked terms.</td>
      </tr>
      <tr valign="top">
        <th scope="row">Glossary Permalink</th>
        <td><input type="text" name="red_glossaryPermalink" value="<?php echo get_option('red_glossaryPermalink'); ?>" /></td>
        <td colspan="2">Enter the name you would like to use for the permalink to the glossary.  By default this is glossary, however you can update this if you wish. eg. http://mysite.com/<strong>glossary</strong>/term</td>
      </tr>
      <tr valign="top">
        <th scope="row">Highlight first occurance only?</th>
        <td><input type="checkbox" name="red_glossaryFirstOnly" <?php checked(true, get_option('red_glossaryFirstOnly')); ?> value="1" /></td>
        <td colspan="2">Select this option if you want to only highlight the first occurance of each term on a page/post.</td>
      </tr>
      <tr valign="top">
        <th scope="row">Limit tooltip length?</th>
        <td><input type="text" name="red_glossaryLimitTooltip" value="<?php echo get_option('red_glossaryLimitTooltip'); ?>"  /></td>
        <td colspan="2">Select this option if you want to show only a limited number of chars and add More Details at the end of the tooltip text. Minimum is 30 chars.</td>
      </tr>
     <tr valign="top">
        <th scope="row">Clean tooltip text?</th>
        <td><input type="checkbox" name="red_glossaryFilterTooltip" <?php checked(true, get_option('red_glossaryFilterTooltip')); ?> value="1" /></td>
        <td colspan="2">Select this option if you want to remove extra spaces and special characters from tooltip text.</td>
      </tr>
     <tr valign="top">
        <th scope="row">Remove term link to the glossary page.?</th>
        <td><input type="checkbox" name="red_glossaryTermLink" <?php checked(true, get_option('red_glossaryTermLink')); ?> value="1" /></td>
        <td colspan="2">Select this option if you do not want to show links to glossary pages.</td>
      </tr>
	   <tr valign="top">
        <th scope="row">Use glossary excerpt for hover?</th>
        <td><input type="checkbox" name="red_glossaryExcerptHover" <?php checked(true, get_option('red_glossaryExcerptHover')); ?> value="1" /></td>
        <td colspan="2">Select this option if you want to use the excerpt (if it exists) as hover text.</td>
      </tr>
	   <tr valign="top">
        <th scope="row">Avoid parsing protected tags?</th>
        <td><input type="checkbox" name="red_glossaryProtectedTags" <?php checked(true, get_option('red_glossaryProtectedTags')); ?> value="1" /></td>
        <td colspan="2">Select this option if you want to avoid using the glossary for the following tags: Script, H1, H2, H3, PRE, Object.</td>
      </tr>

    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="red_glossaryID,red_glossaryOnlySingle,red_glossaryOnPages,red_glossaryTooltip,red_glossaryDiffLinkClass,red_glossaryPermalink,red_glossaryFirstOnly,red_glossaryLimitTooltip,red_glossaryFilterTooltip,red_glossaryTermLink,red_glossaryExcerptHover,red_glossaryProtectedTags" />
    <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" name="red_glossarySave" />
    </p>
  </form>
</div>
<?php
}
function strip_only($str, $tags, $stripContent = false) { 
    $content = ''; 
    if(!is_array($tags)) { 
        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags)); 
        if(end($tags) == '') array_pop($tags); 
    } 
    foreach($tags as $tag) { 
        if ($stripContent) 
             $content = '(.+</'.$tag.'[^>]*>|)'; 
         $str = preg_replace('#</?'.$tag.'[^>]*>'.$content.'#is', '', $str); 
    } 
    return $str; 
} 
?>
