<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>

    <br><br><p><strong>Supported Shortcodes:</strong> <a href="javascript:void(0)" onclick="jQuery(this).parent().next().slideToggle()">Show/Hide</a>
    </p>

    <ul style="display:none;list-style-type:disc;margin-left:20px;">
        <li><strong>Exclude from parsing</strong> - [glossary_exclude] text [/glossary_exclude]</li>
        <li><del><strong>Show glossary category index</strong> - [glossary cat="cat name"]</del> - Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
        <li><del><strong>Show Merriam-Webster Dictionary</strong> - [glossary_dictionary term="term name"]</del>- Only in <a href="http://tooltip.cminds.com" target="_blank">Pro+</a></li>
        <li><del><strong>Show Merriam-Webster Thesaurus</strong> - [glossary_thesaurus term="term name"]</del>- Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
        <li><del><strong>Translate</strong> - [glossary_translate term="text-to-translate" source="english" target="spanish"]</del>- Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</a></li>
		<li><del><strong>Custom glossary tooltip</strong> - [glossary_tooltip content="text"] term [/glossary_tooltip]</del> - Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</li>
        <li><del><strong>Apply tooltip</strong> - [cm_tooltip_parse] text [/cm_tooltip_parse] <sup>1</sup></del>- Only in <a href="http://tooltip.cminds.com"  target="_blank">Pro+</li>
        <li><del><strong>Wikipedia</strong> - [glossary_wikipedia term="term name"]</del> - Only in <a href="http://tooltip.cminds.com"  target="_blank">Ecommerce version</a></li>
		</ul>
 	   <p>
        <strong>Upgrade Options:</strong> <a href="javascript:void(0)" onclick="jQuery(this).parent().next().slideToggle()">Show/Hide</a>
    </p>

    <ul style="display:none;list-style-type:disc;margin-left:20px;">
         <li><strong><a href="http://tooltip.cminds.com/pricing/" target="new">Pro Version</a></strong> - 50% of the Pro license cost and 1 year of free updates</li>
        <li><strong><a href="http://tooltip.cminds.com/pricing/" target="new">Pro+ Version</a></strong> - 50% of the Pro+ license cost and 1 year of free updates</li>
        <li><strong><a href="http://tooltip.cminds.com/pricing/" target="new">Ecommerce Version</a></strong> - 50% of the Ecommerce license cost and 1 year of free updates</li>
        <li>Coming Soon - Glossary Server (share your glossary items)</li>
    </ul>

		<p><strong>Link to the Glossary index page:</strong> <a href="<?php echo home_url('/' . get_option('red_glossaryPermalink') . '/'); ?>" target="_blank"><?php echo home_url('/' . get_option('red_glossaryPermalink') . '/'); ?></a></p>

<?php
// check permalink settings 
if (get_option('permalink_structure') == '') {
      echo '<span style="color:red">Your WordPress Permalinks needs to be set to allow plugin to work correctly. Please Go to <a href="'.admin_url().'options-permalink.php" target="new">Settings->Permalinks</a> to set Permalinks to Post Name.</span><br><br>';
}

?>

    <table class="form-table">
        <tr>
            <th scope="row"><strong>Pro Version</strong></th>
            <td><p><strong><a href="http://tooltip.cminds.com/" target="_blank">Upgrade</a></p></td>
            <td colspan="2" bgcolor="#CCFFCC"> Professional version of CM Super Glossary Pro which which adds SEO support, Import/Export tools, Multisite support, Sidebar Widget, Synonyms, Support for huge glossaries, tooltip customization options and much more</td>
        </tr>
        <tr valign="top">
            <th scope="row">Main Glossary Page ID</th>
            <td><input type="text" name="red_glossaryID" value="<?php echo get_option('red_glossaryID'); ?>" /></td>
            <td colspan="2">Enter the page ID of the page you would like to use as the glossary (list of terms).  The page will be generated automatically for you on the specified page (so you should leave the content blank).  This is optional - terms will still be highlighted in relevant posts/pages but there won't be a central list of terms if this is left blank.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Glossary Permalink</th>
            <td><input type="text" name="red_glossaryPermalink" value="<?php echo get_option('red_glossaryPermalink'); ?>" /></td>
            <td colspan="2">Enter the name you would like to use for the permalink to the glossary.  By default this is glossary, however you can update this if you wish. If you are using a parent please indicate this in path eg. path/glossary, otherwise just leave glossary or the name you choosen </td>
        </tr>
        <tr valign="top">
            <th scope="row">Show tooltip when the user hovers over the term?</th>
            <td><input type="checkbox" name="red_glossaryTooltip" <?php checked(true, get_option('red_glossaryTooltip')); ?> value="1" /></td>
            <td colspan="2">Select this option if you wish for the definition to show in a tooltip when the user hovers over the term.  The tooltip can be style differently using the tooltip.css and tooltip.js files in the plugin folder.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Only show terms on single pages (not Homepage)?</th>
            <td><input type="checkbox" name="red_glossaryOnlySingle" <?php checked(true, get_option('red_glossaryOnlySingle')); ?> value="1" /></td>
            <td colspan="2">Select this option if you wish to only highlight glossary terms when viewing a single page/post.  This can be used so terms aren't highlighted on your homepage for example.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Highlight terms on pages (not just posts)?</th>
            <td><input type="checkbox" name="red_glossaryOnPages" <?php checked(true, get_option('red_glossaryOnPages')); ?> value="1" /></td>
            <td colspan="2">Select this option if you wish for the glossary to highlight terms on pages as well as posts.  With this deselected, only posts will be searched for matching glossary terms.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Style main glossary page differently?</th>
            <td><input type="checkbox" name="red_glossaryDiffLinkClass" <?php checked(true, get_option('red_glossaryDiffLinkClass')); ?> value="1" /></td>
            <td colspan="2">Select this option if you wish for the links in the main glossary listing to be styled differently than the term links.  By selecting this option you will be able to use the class 'glossaryLinkMain' to style only the links on the glossary page otherwise they will retain the class 'glossaryLink' and will be identical to the linked terms.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Show main glossary page as tiles</th>
            <td><input type="checkbox" name="red_glossaryListTiles" <?php checked(true, get_option('red_glossaryListTiles')); ?> value="1" /></td>
            <td colspan="2">Select this option if you wish the main glossary listing to be displayed in tiles. This is not recommended when you have long terms.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Highlight first term occurance only?</th>
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
            <td colspan="2">Select this option if you do not want to show links from posts or pages to the glossary pages. Keep in mind that the plug use a span tag instead of a link tag and if you are using a custom css you should take this into account</td>
        </tr>
        <tr valign="top">
            <th scope="row">Use term excerpt for hover?</th>
            <td><input type="checkbox" name="red_glossaryExcerptHover" <?php checked(true, get_option('red_glossaryExcerptHover')); ?> value="1" /></td>
            <td colspan="2">Select this option if you want to use the term excerpt (if it exists) as hover text.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Avoid parsing protected tags?</th>
            <td><input type="checkbox" name="red_glossaryProtectedTags" <?php checked(true, get_option('red_glossaryProtectedTags')); ?> value="1" /></td>
            <td colspan="2">Select this option if you want to avoid using the glossary for the following tags: Script, A, H1, H2, H3, PRE, Object.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Terms case-sensitive?</th>
            <td><input type="checkbox" name="red_glossaryCaseSensitive" <?php checked(true, get_option('red_glossaryCaseSensitive')); ?> value="1" /></td>
            <td colspan="2">Select this option if you want glossary terms to be case-sensitive.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Open glossary descriptions in a new windows/tab?</th>
            <td><input type="checkbox" name="red_glossaryInNewPage" <?php checked(true, get_option('red_glossaryInNewPage')); ?> value="1" /></td>
            <td colspan="2">Select this option if you want glossary descriptions to open in a new window/tab.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Show HTML "title" attribute for glossary links</th>
            <td><input type="checkbox" name="red_showTitleAttribute" <?php checked(true, get_option('red_showTitleAttribute')); ?> value="1" /></td>
            <td colspan="2">Select this option if you want to use glossary name as HTML "title" for link</td>
        </tr>

    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="red_glossaryID,red_glossaryOnlySingle,red_glossaryOnPages,red_glossaryTooltip,red_glossaryDiffLinkClass,red_glossaryListTiles,red_glossaryPermalink,red_glossaryFirstOnly,red_glossaryLimitTooltip,red_glossaryFilterTooltip,red_glossaryTermLink,red_glossaryExcerptHover,red_glossaryProtectedTags,red_glossaryCaseSensitive,red_glossaryInNewPage,red_showTitleAttribute" />
    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" name="red_glossarySave" />
    </p>
</form>
