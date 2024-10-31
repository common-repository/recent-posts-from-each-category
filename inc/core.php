<?php
function rpfec_obj_start()
{
	global $rpfc;
	$rpfc = new Rpfec_Sunrise_Plugin_Framework;
}

function rpfec_short($text, $limit)
{
	if(strlen($text)>$limit)
	{
		return substr($text,0,$limit).'...';
	}
	return $text;
}

add_shortcode('mycatlist','rpfec_catlist');

function rpfec_catlist($atts)
{
	/*
	if (!is_user_logged_in())
		return '';
	*/
	rpfec_obj_start();
	global $rpfc;
	extract( shortcode_atts( array(
		  'exclude_cat' => '',
	      'posts' => 2,
	      'post_length' => 20,
	      'cat_length' => 20,
	      'excerpt_length' => 20,
	      'read_more' => 'Read more',
	      'thumbnail' => 'yes',
	      'columns' => 3,
	      'title_only' => 'no',
	      'limit' => 0,
	      'new_window' => 'no',
	      'child_cats' => 'yes',
	      'order_by' => 'name',
	      'order_by_type' => 'ASC',
	      'include_cat' => '',
     ), $atts ) );
	
	if ($order_by !== 'recent')
	{
		if(trim($include_cat)=='')
		{
			$cat_args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'parent'                   => ($child_cats=='yes')?'':0,
			'orderby'                  => $order_by,
			'order'                    => $order_by_type,
			'hide_empty'               => 1,
			'hierarchical'             => 0,
			'exclude'                  => $exclude_cat,
			'include'                  => '',
			'number'                   => '',
			'taxonomy'                 => 'category',
			'pad_counts'               => false );
			
			$temp = get_categories($cat_args);
			$cats = array();
			foreach ($temp as $t)
				$cats [] = $t->term_id;
		}
		else
		{
			$cats = explode(',',$include_cat);
		}
			
	}
	else
	{
		// get parent cats only if want to hide child cats...
		$cat_args = array(
			'type'                     => 'post',
			'child_of'                 => 0,
			'parent'                   => ($child_cats=='yes')?'':0,
			'hide_empty'               => 1,
			'hierarchical'             => 0,
			'exclude'                  => $exclude_cat,
			'taxonomy'                 => 'category',
			'pad_counts'               => false );
			
			$temp = get_categories($cat_args);
			$pcats = array();
			foreach ($temp as $t)
				$pcats [] = $t->term_id;
		//print_r($pcats);die();
	
	
		$args = array(
		'posts_per_page'  => 100,
		'offset'          => 0,
		'orderby'         => 'post_date',
		'order'           => $order_by_type,
		'post_type'       => 'post',
		'post_status'     => 'publish',
		'category__not_in'     => explode(',',$exclude_cat),  // exclude selected categories
		'category__in'     => (trim($include_cat)!='')?explode(',',$include_cat):$pcats,  // include selected categories
		'suppress_filters' => true );
		$posts_array = get_posts( $args );
		$cats = array();
		foreach ($posts_array as $p)
		{
			$t = wp_get_post_categories($p->ID);
			foreach($t as $tt)
				if(!in_array($tt,$cats) AND in_array($tt,$pcats))
					$cats[] = $tt;
		}
		//$cats = array_filter(array_unique(explode(',',$dd)));
	}
	
	
	
	$str = "";
	$limit_counter=0;
	if(count($cats)<$columns AND count($cats)>0)
		$columns = count($cats);
	$width2 = (100/$columns)-4;
	$width2 = $width2."%";
	foreach ($cats as $cat)
	{
	
		$cat_title = get_category($cat);
		
		if($cat_title->parent!==0 AND $child_cat == 'no')
			continue; //skip for child categories
		
	
		if($limit_counter == $limit AND $limit>0)
			break;
		else
			$limit_counter++;
		//return "<pre>".print_r(get_category($cat),true)."</pre>";
		
		// get category name and recent numbers of post with thumbnail.....
		 $args = array(
		'posts_per_page'  => $posts,
		'offset'          => 0,
		'category'        => $cat,
		'orderby'         => 'post_date',
		'order'           => 'DESC',
		'post_type'       => 'post',
		'post_status'     => 'publish',
		'suppress_filters' => true );
		
		$post2 = get_posts($args);
		//die(print_r($post2));
		
		$new_window = ($new_window=='yes')?'_blank':'_self';
		
		$str .= "<div class='rpfec_box' style='margin:3px;width:".$width2."'>
			<h2><a id='rpfc_cat_title' href='".get_category_link($cat)."' target='".$new_window."'>
				".rpfec_short($cat_title->name,$cat_length)."
			</a></h2>";
		$counter = 1;
		
		foreach($post2 as $post)
		{
			
			// get template or default template....<span id='rpfec_meta'>Published by {author} on {time}</span>
			$template = "<h3>{title}</h3><p>{thumbnail}{author_time}{excerpt}{readmore}</p>"; //default template
			if($rpfc->get_option('author_time'))
				$author_template = "<span id='rpfec_meta'>Published by {author}, {ago_time}</span><br>"; //default template
			else
				$author_template = ""; //default template
			if($title_only=='yes')
				$template = "<h4>{title}</h4>"; //default template
			
			$author = "<a href='".get_author_posts_url( $post->post_author)."'>".get_the_author()."</a>";
			$ago_time = human_time_diff( get_the_time('U',$post->ID), current_time('timestamp') ) . ' ago';
			$on_date = get_the_date('',$post->ID);
			
			$author_time = str_replace('{author}',$author,$author_template);
			$author_time = str_replace('{ago_time}',$ago_time,$author_time);
			$author_time = str_replace('{on_date}',$on_date,$author_time);
			
			
			if($title_only=='yes')
			{
				$title = "$counter. <a id='rpfc_post_title' href='".get_permalink($post->ID)."' target='".$new_window."'>".rpfec_short($post->post_title,$post_length)."</a>";
				$excerpt = "";
				$readmore = "";
				$author = "";
				$thumb = '';
					
				$template = str_replace('{title}',$title,$template);
				$template = str_replace('{thumbnail}',$thumb,$template);
				$template = str_replace('{excerpt}',$excerpt,$template);
				$template = str_replace('{readmore}',$readmore,$template);
				$template = str_replace('{author}',$author,$template);
				$template = str_replace('{author_time}',$author_time,$template);
				
				$str .= "<div class='rpfec_inner'>$template</div>";
			}
			else
			{
				$title = "<a href='".get_permalink($post->ID)."'  target='".$new_window."'>".rpfec_short($post->post_title,$post_length)."</a>";
				
				if(trim($post->post_excerpt)=='')
					$excerpt = rpfec_mindstien_excerpt($post->post_content,$excerpt_length,'');
				else
					$excerpt = rpfec_mindstien_excerpt($post->post_excerpt,$excerpt_length,'');
				
				$readmore = "<a id='rpfc_readmore' href='".get_permalink($post->ID)."' target='".$new_window."'>".__($read_more)."</a>";
			
				$thumb = '';
				if($thumbnail == 'yes')
				{
					$width = $rpfc->get_option('thumb_size');
					$height= $rpfc->get_option('thumb_size');
					$thumb = rpfec_mindstien_thumb($post->ID,$width,$height);
				}
				//print_r($post);die();
				//$author = get_the_author();
				
				$template = str_replace('{title}',$title,$template);
				$template = str_replace('{thumbnail}',$thumb,$template);
				$template = str_replace('{excerpt}',$excerpt,$template);
				$template = str_replace('{readmore}',$readmore,$template);
				$template = str_replace('{author}',$author,$template);
				$template = str_replace('{author_time}',$author_time,$template);
				
				
				$str .= "<div class='rpfec_inner'>$template</div>";
			}
			$counter ++;
			
		}
		$str .= "</div>";
	}
	
	
	$str .="<div class='rpfec_clear'></div>";
	return '<div id="rpfec_container">'.$str.'</div>';
	//return "<pre>".print_r($categories,true)."</pre>";
}

add_filter('the_content','rpfec_auto_insert');

function rpfec_auto_insert($content)
{
	global $post;
	rpfec_obj_start();
	global $rpfc;
	if(!is_home($post->ID) AND is_front_page($post->ID) AND $rpfc->get_option('insert_home')=='on')
	{
		$atts = array(
			'cat_length'	=>	$rpfc->get_option('cat_length'),
			'post_length'	=>	$rpfc->get_option('post_length'),
			'excerpt_length'=>	$rpfc->get_option('excerpt_length'),
			'title_only'	=>	($rpfc->get_option('title_only')=='on')? 'yes':'no',
			'thumbnail'		=>	($rpfc->get_option('thumbnail')=='on')? 'yes':'no',
			'read_more'		=>	$rpfc->get_option('read_more'),
			'new_window'	=>	($rpfc->get_option('new_window')=='on')? 'yes':'no',
			'posts'			=>	$rpfc->get_option('posts'),
			'order_by'		=>	$rpfc->get_option('order_by'),
			'order_by_type'	=>	$rpfc->get_option('order_by_type'),
			'exclude_cat'	=>	$rpfc->get_option('exclude_cat'),
			'include_cat'	=>	$rpfc->get_option('include_cat'),
			'child_cats'	=>	($rpfc->get_option('child_cats')=='on')? 'yes':'no',
			'columns'		=>	$rpfc->get_option('columns'),
			'limit'			=>	$rpfc->get_option('limit')
		);
		return $content.rpfec_catlist($atts);
	}
	return $content;
}

function  rpfec_mindstien_excerpt($data,$size=20,$read_more = '...')
{
	$data = strip_tags(strip_shortcodes($data));
	$temp = explode(' ',$data);
	$str = array();
	for($i=0;$i<$size;$i++)
		$str[] = $temp[$i];
	if(count($temp)<$size)
		return implode(' ',$str);
	else
		return implode(' ',$str).' '.__($read_more);
}

function rpfec_mindstien_thumb($id,$width='50px',$height='50px'){
	rpfec_obj_start();
	global $rpfc;
				
	$align = $rpfc->get_option('thumb_align');
	
	$find=false;
	if(function_exists('has_post_thumbnail'))
		if(has_post_thumbnail($id)){
			$thumb_id = get_post_thumbnail_id($id);
			$thumb_url = wp_get_attachment_image_src($thumb_id,array($width,$height),false);
			$src = $thumb_url[0];
			
			$full_url = wp_get_attachment_image_src($thumb_id,'full',false);
			$src = $full_url[0];
			$imgtype=array("jpg","jpeg","gif","png");
			foreach($imgtype as $type){
				preg_match_all('~(\w*)-([0-9]*)x([0-9]*).('.$type.')~', $src, $matches);
				if(!empty($matches[1][0]))
					$src = substr($src,0,strrpos($src,'/')).'/'.$matches[1][0].'.'.$matches[4][0];
				$src = str_replace(".".$type,"-".str_replace('px','',$width)."x".str_replace('px','',$height).".".$type,$src);
			}
			if($src!==$thumb_url[0])
			{
				// required regeneration of image
				$rest = str_replace(WP_CONTENT_URL,'',$src);
				//die($rest);
				if(!file_exists(realpath(".").'/wp-content'.$rest))
				{
					$src = $thumb_url[0];
				}
			}
			
			
			
			$attachment = get_post( $thumb_id );
			$title =  $attachment->post_title;
			$alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true );
			if($alt=='')
				$alt = $title;
			
			$plus='<img width="'.$width.'" height="'.$height.'" src="'.$src.'" class="rpfec'.$align.'" align="'.$align.'" alt="'.$alt.'" title="'.$title.'" />';
			$find=true;
		}
	if(!$find){
		$post_thumbnail = rpfec_mindstien_get_thumb_image($id,$width,$height);
		if(!empty($post_thumbnail))
			if($withlink=="yes")
				$plus='<a href="'.get_permalink().'">'.$post_thumbnail.'</a>';
			else
				$plus=$post_thumbnail;
	}
	return $plus;
}

function rpfec_mindstien_get_thumb_image($id,$width,$height) {
	$content_post = get_post($id);
	$content = $content_post->post_content;
	rpfec_obj_start();
	global $rpfc;
				
	$align = $rpfc->get_option('thumb_align');
	$alt = '';
	$title = $content_post->post_title;
	
	$first_img = '';
	//extract image
	preg_match_all('~<img [^\>]*>~', $content, $matches);
	$first_image = $matches[0][0];
	//extract alt
	preg_match_all('~alt=[\'"]([^\'"]+)[\'"]~', $first_image, $matches);
	$alt = $matches[1][0];
	//extract title
	preg_match_all('~title=[\'"]([^\'"]+)[\'"]~', $first_image, $matches);
	$title = $matches[1][0];
	//extract src
	preg_match_all('~src=[\'"]([^\'"]+)[\'"]~', $first_image, $matches);
	$src=$matches[1][0];
	$srcorig=$matches[1][0];
	//last try, for images with src without quotes
	if(empty($src)){
		preg_match_all('~src=([^\'"]+) ~', $first_image, $matches);
		$src=$matches[1][0];
		$srcorig=$matches[1][0];
	}
	//find base image for jpg
	$imgtype=array("jpg","jpeg","gif","png");
	foreach($imgtype as $type){
		preg_match_all('~(\w*)-([0-9]*)x([0-9]*).('.$type.')~', $src, $matches);
		if(!empty($matches[1][0]))
			$src = substr($src,0,strrpos($src,'/')).'/'.$matches[1][0].'.'.$matches[4][0];
		if(empty($orgsrc))
			$orgsrc=$src;
		$src = str_replace(".".$type,"-".str_replace('px','',$width)."x".str_replace('px','',$height).".".$type,$src);
		
	}
	
	$noimg=false;
	if(empty($src)){ //use the default image
		$noimg=true;
		
	}
	if($noimg==true){
		//not to show default? ok! nothing to show!
	}
	else {
		
		if(stripos($src,WP_CONTENT_URL)!==false){
			//the image is hosted on the blog
			$rest = str_replace(WP_CONTENT_URL,'',$src);
			if(!file_exists(realpath(".").'/wp-content'.$rest))
			{
				$thumb_id = rpfc_get_attachment_id_from_url($srcorig);
				//$thumb_id = get_post_thumbnail_id($id);
				$src = wp_get_attachment_image_src($thumb_id,array($width,$height),false);
				$src = $src[0];
			}
		}
		else
			//the image is hosted outside the blog!
			$src=$srcorig;
		if($src==$srcorig)
			return '<img  align="'.$align.'" width="'.$width.'" height="'.$height.'" src="'.$src.'" class="rpfec'.$align.'" alt="'.$alt.'" title="'.$title.'" />';
		else
			return '<img  align="'.$align.'" width="'.$width.'" height="'.$height.'" src="'.$src.'" class="rpfec'.$align.'" alt="'.$alt.'" title="'.$title.'" />';
	}
}

add_action('wp_head','rpfec_insert_style');
add_action('wp_footer','rpfec_insert_footer');

function rpfec_insert_footer()
{
	rpfec_obj_start();
	global $rpfc;
	// print custom footer code here...
	echo html_entity_decode($rpfc->get_option('footer_code'),ENT_QUOTES);
}

function rpfec_insert_style()
{
	rpfec_obj_start();
	global $rpfc;
	// print custom header code here...
	echo html_entity_decode($rpfc->get_option('header_code'),ENT_QUOTES);
	
	$box_border		= $rpfc->get_option('box_border');
	
	$rpfc_style ="";
	if($box_border=='on')
		$rpfc_style .=".rpfec_box {border: 1px solid gray !important;}";
	
	
	
	?>
	<style>
	<?php echo $rpfc_style; ?>
	#rpfec_meta
	{
		font-size:10px;
	}
	.rpfec_box h2
	{
		text-align: center !important;
		margin:auto !important;
	}
	.rpfec_box h1,.rpfec_box h3,.rpfec_box h4,.rpfec_box h5,.rpfec_box h6
	{
		margin:auto !important;
	}
	.rpfecleft
	{
		margin-bottom: 5px !important;
		margin-right: 10px !important;
	}
	.rpfeccenter
	{
		display:block;
		margin:auto !important;
	}
	.rpfecright
	{
		margin-bottom: 5px !important;
		margin-left: 10px !important;
	}
	.rpfec_box
	{
		float:left;
		margin:5px;
		padding:5px 5px 0;
	}
	.rpfec_clear
	{
		clear:both;
	}
	
	#rpfec_container
	{
		width:100%;
		margin:0 auto;
	}
	.cat_title
	{
		margin:0px !important;
	}
	</style>
	<?php
}

function rpfec_mindstien_load_scripts() {
	if ( !is_admin() ) {
		//wp_enqueue_script('jquery');
		wp_enqueue_script('masonry',plugins_url( '../js/jquery.masonry.min.js' , __FILE__ ),array( 'jquery' ),'',true);
		wp_enqueue_script('mindstien-script',plugins_url( '../js/script.js' , __FILE__ ),array( 'jquery' ),'',true);
	}
}
add_action( 'wp_enqueue_scripts', 'rpfec_mindstien_load_scripts' );


//Instant support request email...
add_action('wp_ajax_instant_support', 'rpfec_instant_support_callback');

function rpfec_instant_support_callback() {
	
	echo '<div><p style="font-size:1.5em;color:green;">Instant Support is available on <a href="http://mindstien.com/pro-plugins/recent-posts-from-each-category-pro.php" target="_blank"><strong><u>pro version</u></strong></a> only. </p></div>';
	die(); // this is required to return a proper result
	
}


function rpfc_get_attachment_id_from_url( $attachment_url = '' ) {
	global $wpdb;
	$prefix = $wpdb->prefix;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM " . $prefix . "posts" . " WHERE guid='%s';", $attachment_url )); 
	return $attachment[0];

}
?>