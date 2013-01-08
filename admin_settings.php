<form method="post" action="options.php">
    <?php wp_nonce_field('update-options'); ?>
    <table class="form-table">
        <tr valign="top">
            <th scope="row">Main Glossary Page</th>
            <td><input type="text" name="red_glossaryID" value="<?php echo get_option('red_glossaryID'); ?>" /></td>
            <td colspan="2">Enter the page ID of the page you would like to use as the glossary (list of terms).  The page will be generated automatically for you on the specified page (so you should leave the content blank).  This is optional - terms will still be highlighted in relevant posts/pages but there won't be a central list of terms if this is left blank.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Glossary Permalink</th>
            <td><input type="text" name="red_glossaryPermalink" value="<?php echo get_option('red_glossaryPermalink'); ?>" /></td>
            <td colspan="2">Enter the name you would like to use for the permalink to the glossary.  By default this is glossary, however you can update this if you wish. eg. http://mysite.com/<strong>glossary</strong>/term</td>
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

    </table>
    <input type="hidden" name="action" value="update" />
    <input type="hidden" name="page_options" value="red_glossaryID,red_glossaryOnlySingle,red_glossaryOnPages,red_glossaryTooltip,red_glossaryDiffLinkClass,red_glossaryListTiles,red_glossaryPermalink,red_glossaryFirstOnly,red_glossaryLimitTooltip,red_glossaryFilterTooltip,red_glossaryTermLink,red_glossaryExcerptHover,red_glossaryProtectedTags,red_glossaryCaseSensitive" />
    <p class="submit">
        <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" name="red_glossarySave" />
    </p>
</form>
