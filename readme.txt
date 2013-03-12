=== Plugin Name ===
Name: CM Enhanced Tooltip Glossary
Contributors: CreativeMinds. Based on jatls TooltipGlossary
Donate link: http://www.cminds.com/plugins
Tags: glossary, pages, posts, definitions, tooltip, automatic, hints, hint, tip, tool-tip
Requires at least: 3.2
Tested up to: 3.5
Stable tag: 2.0.2

Parses posts for defined glossary terms and adds links to the static glossary page containing the definition and a tooltip with the definition.

== Description ==

Parses posts for defined glossary terms and adds links to the static glossary page containing the definition.  The plugin also creates a tooltip containing the definition which is displayed when users mouseover the term.  Based on [automatic-glossary](http://wordpress.org/extend/plugins/automatic-glossary/) and on [TooltipGlossary] (http://wordpress.org/extend/plugins/tooltipglossary/).

The code has been bug fixed based on TooltipGlossary and many new features added. A new tag was introduced to avoid using the Tooltip [glossary_exclude] text [/glossary_exclude].  

The tooltip is created with JavaScript based on the article written by [Michael Leigeber](http://www.leigeber.com/author/michael/) [here](http://sixrevisions.com/tutorials/javascript_tutorial/create_lightweight_javascript_tooltip/) and can be customized and styled through the tooltip.css and tooltip.js files.

Alphabetical index for glossary list is based on [jQuery ListNav Plugin](http://www.ihwy.com/labs/jquery-listnav-plugin.aspx)

**Demo** 

See basic demo of the plug [here](http://www.cminds.com/glossary/)


**Pro Version**	

[Pro Version Page](http://www.cminds.com/downloads/cm-enhanced-tooltip-glossary-premium-version/)
The Pro version adds a layer of powerful features to the Enhanced Tooltip Glossary

* Pagination - Ability to add pagination for the glossary page in both server side and client side (Support for large glossaries). Admin can also control pagination size [Demo](http://jumpstartcto.com/glossary/)
* Widget - Glossary widget which shows a random number of terms with link to Glossary index [Demo](http://jumpstartcto.com/glossary/) (Scroll down and look at the right side for Glossary), [image](http://static.cminds.com/wp-content/uploads/edd/04-03-2013-15-40-16.png)
* Link Style - Ability to change term link style [image that shows settings](http://static.cminds.com/wp-content/uploads/edd/04-03-2013-15-42-01.png)
* Tooltip Style - Ability to change tooltip shape, colors, border [Demo](http://jumpstartcto.com/glossary/) (Highlight any term) , [image that shows settings](http://static.cminds.com/wp-content/uploads/edd/04-03-2013-15-42-01.png)
* Import / Export - Import / Export glossary file to/from CSV format. [image](http://static.cminds.com/wp-content/uploads/edd/04-03-2013-15-41-33.png)
* Internal Links - Option to add a link back to glossary page from each term page [Demo](http://jumpstartcto.com/glossary/minimal-viable-product/)
* Editor Button - Editor button to support glossary exclude. [image](http://static.cminds.com/wp-content/uploads/edd/glossarypro11.jpg)
* Synonyms - Can add several Synonyms per each term, tooltip will appear for all Synonyms in posts and glossary index  [Demo](http://jumpstartcto.com/glossary/minimal-viable-product/), Glossary Term Page: [image](http://static.cminds.com/wp-content/uploads/edd/glossarypro10.jpg)
* Related Post - Show all related posts for each glossary term, this option is cached to enhance performance [image](http://jumpstartcto.com/glossary/minimal-viable-product/), [image that shows settings](http://static.cminds.com/wp-content/uploads/edd/glossarypro9.jpg)
* Multisite - Support Multisite.

	
**More Plugins by CreativeMinds**

* [CM Email Blacklist](http://wordpress.org/extend/plugins/cm-email-blacklist/) - Block users using blacklists domain from registering to your WordPress site.. 

* [CM Multi MailChimp List Manager](http://wordpress.org/extend/plugins/multi-mailchimp-list-manager/) - Allows users to subscribe/unsubscribe from multiple MailChimp lists. 

* [CM Invitation Codes](http://wordpress.org/extend/plugins/cm-invitation-codes/) - Allows more control over site registration by adding managed groups of invitation codes. 

* [CM Answers](http://wordpress.org/extend/plugins/cm-answers/) - Allow users to post questions and answers in stackoverflow style. 

== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Define your glossary terms under the glossary menu item in the administration interface.  The title of the page should be the term.  The body content should be the definition.
4. Create a main glossary page (example "Glossary") with no body content if you wish to.  If you do not create this page then your terms will still be highlighted but there will not be a central listing of all your terms.
5. In the plugin's dashboard preferences, enter the main glossary page's id (optional as above)
6. There are a handful of other optional preferences available in the dashboard.

Note: You must have a call to wp_head() in your template in order for the tooltip js and css to work properly.  If your theme does not support this you will need to link to these files manually in your theme (not recommended).

== Frequently Asked Questions ==

= Does my main glossary page need to be titled "Glossary"? =

No.  It can be called anything.  In fact you don't even need to have a main glossary page.

= Do I need to manually type in an unordered list of my glossary terms on the glossary page? =

No.  Just leave that page blank.  The plugin creates the unordered list of terms automatically.

= How do I add glossary terms? =

Simply add a term under the 'Glossary' section in the adminstration interface.  Title it the glossary term (ex. "WordPress") and put the term's definition into the body (ex. "A neato Blogging Platform").

= What if I need to add or change a glossary term? =

Just add it or change it.  The links for your glossary terms are added to your page and post content on the fly so your glossary links will always be up to date.

= How do I prevent the glossary from parsing a paragraph =

Just wrap the paragraph with [glossary_exclude] paragraph text [/glossary_exclude].  

= How do I define the Glossary link style =

You can use glossaryLink. You can also define glossaryLinkMain if you wish to have a different style in the main glossary page

== Screenshots ==

1. List of terms in Glossary
2. Tooltip for one term inside glossary page
3. Tooltip for one term inside a post
4. Glossary terms page in Admin panel
5. Glossary setting page in Admin

== Changelog ==
= 2.0.2 =
* Install bug fix and add comments to glossary

= 2.0 =
* Minor fix in styling
* Allow users with "edit_posts" capability to add/edit glossary terms
* Added "/u" (UTF8) flag to regex to force UTF8 encoding
* Glossary main page is now automatically created upon activation if not exists

= 1.6 =
* Added "open glossary description in new window/tab" option to settings panel
* Added onclick event on tooltip, so if you using touch device, you just need to click on the tooltip to hide it.
* Changed parsing mechanism
* Added www.cminds.com backlink

= 1.5 =
* Added "case-sensitive" option to settings panel
* Fixed bug when slash character inside glossary term was causing problems
* Added default z-index:100 to tooltip CSS

= 1.4 =
* Fixed bug when multiline tooltips were not displayed correctly on Glossary List
* Fixed bug when glossary list was displayed in the bottom of all pages/posts when Glossary Page ID was not set in Settings
* Terms that are substrings of current glossary item are not highlighted now on glossary definition page
* Fixed bug when term with brackets inside was not highlighted
* Added "Published/Trash" filter for glossary terms

= 1.31 =
* Bug fix with escaped single qoutations

= 1.3 =
* Reorganize admin menu
* Added 'with_front'=false for rewrite item

= 1.2 =
* Added alphabetical letter index for glossary list
* Added option to style glossary list as tiles instead of regular list
* Do not show glossary explanation tooltip when on its explanation page
* Do not show [glossary_exclude] tag in tooltips
* Fix bug when excluded tags were embedded into other excluded tags
* Fix bug when glossary terms were substrings of other glossary terms and only the shortest was caught (Thanks to Torsten Keil)
* Fix bug when HTML code in tooltip content causes page to break
* Thanks for Paul Ryan (prar@hawaii.edu) for his code contribution and Sebastian Palus for his addition and bug fixes

= 1.1 =
* Add A tag to the list of tags to ignore (Thanks to Robert Gilman)
* Change activation mechanisim  (Thanks to Robert Gilman)
* Fix bug when using excerpt (Thanks to Robert Gilman)

= 1.0 =
* First release nased on revised version on TooltipGlossary
* Optimized code and bug fix from TooltipGlossary
* Added [glossary_exclude] text [/glossary_exclude]
* Added filters to clean tooltip text
* Avoid changing URL using this format: href='url' in adition to href=""
* Add extended functionality including excluding H1, H2, H3, Script, Object tags
* Use the excerpt (if it exists) as hover text.
* Remove term link to the glossary page
* Limit tooltip length
