<?php
global $current_user;
get_currentuserinfo();

	/** Plugin options */
	$options = array(
		array(
			'name' => __( 'Display', $this->textdomain ),
			'type' => 'opentab'
		),
		array(
			'html' => '<h2>Configure options here and use shortcode generated at the bottom of this page to display recent posts boxes on any wordpress page/post...</h2>',
			'type' => 'html'
		),
		array(
			'name' => __( 'Category Title Length', $this->textdomain ),
			'desc' => __( 'Length in number of Characters', $this->textdomain ),
			'std' => 20,
			'id' => 'cat_length',
			'type' => 'number'
		),
		array(
			'name' => __( 'Post Title Length', $this->textdomain ),
			'desc' => __( 'Length in number of Characters', $this->textdomain ),
			'std' => 20,
			'id' => 'post_length',
			'type' => 'number'
		),
		array(
			'name' => __( 'Excerpt Length', $this->textdomain ),
			'desc' => __( 'Length in number of Words', $this->textdomain ),
			'std' => 20,
			'id' => 'excerpt_length',
			'type' => 'number'
		),
		array(
			'name' => __( 'Titles Only', $this->textdomain ),
			'desc' => __( 'Display list of titles only, no thumb, no excerpt, no read more...', $this->textdomain ),
			'std' => 'off',
			'id' => 'title_only',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Display Thumbnail', $this->textdomain ),
			'desc' => __( 'Check to display thumbnail, First image from post content will be used if featured image not found', $this->textdomain ),
			'std' => 'on',
			'id' => 'thumbnail',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Read More.. Text', $this->textdomain ),
			'desc' => __( 'Text to use as "read more.." after post excerpt', $this->textdomain ),
			'std' => 'Read More...',
			'id' => 'read_more',
			'type' => 'text'
		),
		array(
			'name' => __( 'Open in new window', $this->textdomain ),
			'desc' => __( 'Check to open post in new window..', $this->textdomain ),
			'std' => 'off',
			'id' => 'new_window',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Number of posts per category', $this->textdomain ),
			'desc' => __( 'Number of recent posts to display from each category', $this->textdomain ),
			'std' => 2,
			'min' => 1,
			'max' => 20,
			'id' => 'posts',
			'type' => 'number'
		),
		array(
			'name' => __( 'Order Category By', $this->textdomain ),
			'desc' => __( 'Select the way to order the list of categories...', $this->textdomain ),
			'std' => 'name',
			'id' => 'order_by',
			'type' => 'select',
			'options' => Array(
					'name'=>'Category Name',
					'id'=>'Category Id',
					'count'=>'No. of posts in each category',
					'recent'=>'Most recent posts',
					)
		),
		array(
			'name' => __( 'Category Order', $this->textdomain ),
			'desc' => __( 'Select the way (either ascending or descending) to order the list of categories...', $this->textdomain ),
			'std' => 'asc',
			'id' => 'order_by_type',
			'type' => 'select',
			'options' => Array(
					'asc'=>'Ascending',
					'desc'=>'Descending',
					)
		),
		array(
			'name' => __( 'Exclude Categories', $this->textdomain ),
			'desc' => __( 'Comma separated list of category IDs to exclude...', $this->textdomain ),
			'std' => '',
			'id' => 'exclude_cat',
			'type' => 'text'
		),
		array(
			'name' => __( 'Show Only These Categories', $this->textdomain ),
			'desc' => __( 'Comma separated list of category IDs to display posts only from these cats, keep empty for using all cats and other settings', $this->textdomain ),
			'std' => '',
			'id' => 'include_cat',
			'type' => 'text'
		),
		array(
			'name' => __( 'Include Child Categories', $this->textdomain ),
			'desc' => __( 'Check to display child categories also... or uncheck to display parent categories only', $this->textdomain ),
			'std' => 'on',
			'id' => 'child_cats',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Number of Columns', $this->textdomain ),
			'desc' => __( 'Number of columns to display recent posts in box format', $this->textdomain ),
			'std' => 3,
			'id' => 'columns',
			'type' => 'number'
		),
		array(
			'name' => __( 'Limit the Number of Categories', $this->textdomain ),
			'desc' => __( 'Number of categories to display in box format, 0 to display all cats.', $this->textdomain ),
			'std' => 0,
			'id' => 'limit',
			'type' => 'number'
		),
		array(
			'html' => '<strong>Copy the below shortcode, generated automatically based on your above settings and use in your wordpress page/post to display recent post boxes.<h2><textarea id="my_shortcode" style="width:100%;" name="shortcode" onmouseover="this.select()" onclick="this.select();return false;" onblur="this.select();return false;">[shortcode]</textarea></h2></strong>',
			'type' => 'html'
		),
		array(
			'type' => 'closetab'
		),
		array(
			'name' => __( 'Design & Style', $this->textdomain ),
			'type' => 'opentab'
		),
		array(
			'html' => __( '<div><p style="font-size:1.5em;color:green;margin:-15px 0;">Many options on this page are available on <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" target="_blank"><strong><u>pro version</u></strong></a> only. You can see the options here but will have <u><strong>no effect</strong></u> on output generated.</p></div>', $this->textdomain ),
			'type' => 'html'
		),
		array(
			'name' => __( 'Category Title Color ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Select your color for category title, Leave \'#\' to use your theme\'s colors..', $this->textdomain ),
			'std' => '#',
			'id' => 'cat_color',
			'type' => 'color'
		),
		array(
			'name' => __( 'Post Title Color ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Select your color for Post title, Leave \'#\' to use your theme\'s colors..', $this->textdomain ),
			'std' => '#',
			'id' => 'post_color',
			'type' => 'color'
		),
		array(
			'name' => __( 'Excerpt Text Color ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Select your color post excerpt text, Leave \'#\' to use your theme\'s colors..', $this->textdomain ),
			'std' => '#',
			'id' => 'excerpt_color',
			'type' => 'color'
		),
		array(
			'name' => __( 'Read More Link Color ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Select your color for Read More Link, Leave \'#\' to use your theme\'s colors..', $this->textdomain ),
			'std' => '#',
			'id' => 'readmore_color',
			'type' => 'color'
		),
		array(
			'name' => __( 'Show box border?', $this->textdomain ),
			'desc' => __( 'Check to on/off display of category box border.', $this->textdomain ),
			'std' => 'on',
			'id' => 'box_border',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Box border size ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Enter size in pixel for border width, only applies if above is checked', $this->textdomain ),
			'std' => 1,
			'id' => 'box_border_size',
			'type' => 'number'
		),
		array(
			'name' => __( 'Box Border Type? ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Select the border type, this will only apply if above is checked', $this->textdomain ),
			'std' => 'solid',
			'id' => 'box_border_type',
			'options' => array(
					'solid'=>'Solid Single',
					'dotted'=>'Dotted',
					'dashed'=>'Dashed',
					'double'=>'Double Line',
				),
			'type' => 'select'
		),
		array(
			'name' => __( 'Border Color ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Select your color for border of category box, Leave \'#\' to use your theme\'s colors..', $this->textdomain ),
			'std' => '#',
			'id' => 'border_color',
			'type' => 'color'
		),
		array(
			'name' => __( 'Box Background Color ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Select your color for category Box Background, Leave \'#\' to use your theme\'s colors..', $this->textdomain ),
			'std' => '#',
			'id' => 'bg_color',
			'type' => 'color'
		),
		array(
			'name' => __( 'Thumbnail Size', $this->textdomain ),
			'desc' => __( 'Select size of thumbnail..', $this->textdomain ),
			'std' => '50',
			'id' => 'thumb_size',
			'options' => array(
				'50'=>'50px X 50px',
				'75'=>'75px X 75px',
				'100'=>'100px X 100px',
				'125'=>'125px X 125px',
				'150'=>'150px X 150px'),
			'type' => 'select'
		),
		array(
			'name' => __( 'Custom Thumbnail Width ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Enter width in pixel, leave blank to use above selection', $this->textdomain ),
			'std' => '',
			'id' => 'thumb_width',
			'type' => 'number',
		),
		array(
			'name' => __( 'Custom Thumbnail Height ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Enter width in pixel, leave blank to use above selection', $this->textdomain ),
			'std' => '',
			'id' => 'thumb_height',
			'type' => 'number',
		),
		array(
			'name' => __( 'Regenerate Thumbnail Image ? ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Regenerate thumbnail of selected size if does not exists, uncheck to show originals by resize only without generating new image files.', $this->textdomain ),
			'std' => 'no',
			'id' => 'regen_thumb',
			'type' => 'checkbox',
		),
		array(
			'name' => __( 'Align thumbnail...', $this->textdomain ),
			'desc' => __( 'Select how to align thumbnail..', $this->textdomain ),
			'std' => 'left',
			'id' => 'thumb_align',
			'options'=> array(
				'left'=>'Align Left',
				'center'=>'Align Center',
				'right'=>'Align Right'
				),
			'type' => 'select',
		),
		array(
			'name' => __( 'Show Author & Published On info', $this->textdomain ),
			'desc' => __( 'Check to display published by author and published on date/time information, change the template as required below', $this->textdomain ),
			'std' => '',
			'id' => 'author_time',
			'type' => 'checkbox',
		),
		array(
			'name' => __( 'Author/Time Template ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'You can use this custom template for published by author and published on date portion, Tags to use are {author},{on_date},{ago_date}<br>Leave blank to use default template..', $this->textdomain ),
			'std' => '',
			'id' => 'author_template',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom Template ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'You can use this custom template to change the display of post boxes, Tags to use are {title},{excerpt},{thumbnail},{readmore},{author_time},<br>Leave blank to use default template..', $this->textdomain ),
			'std' => '',
			'id' => 'template',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom Header Code', $this->textdomain ),
			'desc' => __( 'You can insert your own custom CSS/JS/HTML Header code, which will be inserted in <strong>header</strong> of the site as it is, only use if you are advanced user and know what you are doing, code will be inserted as it is. This can be used to customize the behavior of recent post boxes using custom CSS and/or JS Code...', $this->textdomain ),
			'std' => '',
			'rows' => 7,
			'id' => 'header_code',
			'type' => 'code'
		),
		array(
			'name' => __( 'Custom Footer Code', $this->textdomain ),
			'desc' => __( 'You can insert your own custom CSS/JS/HTML Header code, which will be inserted in <strong>Footer</strong> of the site as it is, only use if you are advanced user and know what you are doing, code will be inserted as it is. This can be used to customize the behavior of recent post boxes using custom CSS and/or JS Code...', $this->textdomain ),
			'std' => '',
			'rows' => 7,
			'id' => 'footer_code',
			'type' => 'code'
		),
		array(
			'type' => 'closetab'
		),
		array(
			'name' => __( 'Auto Insert', $this->textdomain ),
			'type' => 'opentab'
		),
		array(
			'html' => '<h2>Auto Insert will allow you to automatically insert recent posts boxes in to your wordpress homepage / static page / or posts without using the shortcode generator...</h2>',
			'type' => 'html'
		),
		array(
			'html' => __( '<div><p style="font-size:1.5em;color:green;margin:-15px 0;">Many options on this page are available on <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" target="_blank"><strong><u>pro version</u></strong></a> only. You can see the options here but will have <u><strong>no effect</strong></u> on output generated.</p></div>', $this->textdomain ),
			'type' => 'html'
		),
		array(
			'name' => __( 'Insert into bottom of the homepage', $this->textdomain ),
			'desc' => __( 'This will work only when home page is set to display static page instead of recent blog posts... So you dont have to use shortcode', $this->textdomain ),
			'std' => 'on',
			'id' => 'insert_home',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Wordpress Posts/Pages To Auto Insert ( <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" style="color:red;" target="_blank">PRO</a> )', $this->textdomain ),
			'desc' => __( 'Insert here comma separated IDs of wordpress posts/pages to automatically insert recent posts boxes below the content', $this->textdomain ),
			'std' => '',
			'id' => 'insert_posts',
			'type' => 'text'
		),
		array(
			'type' => 'closetab'
		),
		array(
			'name' => __( 'Instant Support', $this->textdomain ),
			'type' => 'opentab'
		),
		array(
			'name' => 'Submit Bellow form for instant support, the form will be emailed to plugin author',
			'type' => 'title'
		),
		array(
			'name' => __( 'Your Name', $this->textdomain ),
			'desc' => __( '', $this->textdomain ),
			'std' => $current_user->user_firstname." ".$current_user->user_lastname,
			'id' => 'support_name',
			'type' => 'text'
		),
		array(
			'name' => __( 'Your Email', $this->textdomain ),
			'desc' => __( '', $this->textdomain ),
			'std' => $current_user->user_email,
			'id' => 'support_email',
			'type' => 'text'
		),
		array(
			'name' => __( 'Support Request', $this->textdomain ),
			'desc' => __( 'To get quick response, explain your issue in more details and send your admin login details too...', $this->textdomain ),
			'std' => '',
			'id' => 'support_request',
			'type' => 'textarea'
		),
		array(
			'html' => __( '<input id="instant_support" style="margin-left:220px" name="send" type="button" value="Send Support Request">', $this->textdomain ),
			'type' => 'html'
		),
		array(
			'type' => 'closetab'
		)
		
	);
?>