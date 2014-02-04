<?php

//wordpress hooks
add_action('wp_ajax_nopriv_get_picture_ajax', 'get_picture_ajax');
add_action('wp_ajax_get_picture_ajax', 'get_picture_ajax');

add_action('wp_ajax_nopriv_get_picture_ids_ajax', 'get_picture_ids_ajax');
add_action('wp_ajax_get_picture_ids_ajax', 'get_picture_ids_ajax');

add_action('wp_ajax_nopriv_get_picture_ids_thumb_url', 'get_picture_ids_thumb_url');
add_action('wp_ajax_get_picture_ids_thumb_url', 'get_picture_ids_thumb_url');

add_theme_support('menus');
register_nav_menus(array(
    'photographers' => 'photographers',
    'mainMenu' => 'mainMenu' // i like to set up a coupple at first in case i need them later
    
));


function get_picture_ids_ajax() {
	if (isset($_REQUEST)) {
	    global $nggdb;
		switch ($_REQUEST['type']) {
			case "gid":
			     $getter = $_REQUEST['getter'];
        		 $image_ids = $nggdb->get_ids_from_gallery($_REQUEST['getter']);
        		 $image_ids[0] = $_REQUEST['type']; // <-- DELETE THE FIRST IMAGE
        		 echo json_encode($image_ids);
				 break;
			case "tag":
				 $getter = $_REQUEST['getter'];
    			 $images = nggTags::find_images_for_tags($_REQUEST['getter']);
        		 $image_ids[] = $_REQUEST['type'];
    			 foreach ($images as $image) {
    			 	$image_ids[] = $image->pid;
    			 }
    			 echo json_encode($image_ids);
				 break;
			default:
				 echo("Ivalid request type");
				 break;
		}
	}
	die();
	
}

function get_picture_ids_thumb_url() {
	if (isset($_REQUEST)) {
	    global $nggdb;
		switch ($_REQUEST['type']) {
			case "gid":
			     $getter = $_REQUEST['getter'];
        		 //$image_ids = $nggdb->get_ids_from_gallery($_REQUEST['getter']);
        		 $gallery = $nggdb->get_gallery($_REQUEST['getter']);
    			 $tags = "";
    			 
    			 foreach ($gallery as $image) {
	    			 foreach ($image->tags as $tag) {
	    			    $tags .= $tag->slug . " ";
	    			 }
	    			 $data_filter = substr_replace($tags, "", -1);
	    			 $image_ids[] = "<div class=\"$data_filter\"><a href=\"$image->imageURL\"><img src=\"$image->thumbURL\"></a></div>";
	    			 $tags = "";
					
    			 	//$image_ids[] = $image->get_href_thumb_link();
    			 	//$image_ids[] = $image->thumbURL;
    			 }
    			 
   				 break;
			case "tag":
				 $getter = $_REQUEST['getter'];
    			 $images = nggTags::find_images_for_tags($_REQUEST['getter']);
    			 foreach ($images as $image) {
    			 	//$image_ids[] = $image->get_href_thumb_link();
    			 	$data_filter = $image->galleryid;
    			 	$image_ids[] = "<div class=\"$data_filter\"><a href=\"$image->imageURL\"><img src=\"$image->thumbURL\"></a></div>";
    			 }
				 break;
			default:
				 echo("Ivalid request type");
				 break;
		}
		echo json_encode($image_ids);
		
	}
	die();
	
}

//ajax callback
function get_picture_ajax()
{
    
    if (isset($_REQUEST)) {
    	switch ($_REQUEST['type']) {
    		case "gid":
    		     $getter = $_REQUEST['getter'];
    			 get_picture_with_gid($getter); 			 
    			 break;
    		case "tag":
    			 $getter = $_REQUEST['getter'];
    			 get_picture_with_tag($getter);
    			 break;
    		default:
    			 echo("Ivalid request type");
    			 break;
    	}
    }
    die();
}

function portfolio_menu()
{
    global $nggdb;
    
    $galleries = $nggdb->find_all_galleries();
    
    foreach ($galleries as $gallery) {
        $image_ids = $nggdb->get_ids_from_gallery($gallery->gid);
        $tags      = array();
        foreach ($image_ids as $image) {
            $foo = $nggdb->find_image($image);
            foreach ($foo->tags as $tag) {
                $tags[] = $tag->slug;
            }
            
        }
    }
    
    $tags = array_unique($tags);
    echo '<ul>';
    foreach ($tags as $tag) {

        echo "<li id=\"topLevelAjaxButton\" type=\"tag\" tag='" . $tag . "'><a href='#'>$tag</a>";
		echo "<ul class=\"subMenu>\">";
		get_photographer_Submenu($tag);
		echo "</ul>";
		echo "</li>";
    }
	echo '</ul>';
	
}

function get_photographer_Submenu($tag)
{
    global $nggdb;
	$photographers = array();
	
	$picturelist = nggTags::find_images_for_tags($tag , 'ASC');
	
	
	foreach ($picturelist as $image) {
	$photographers[] = $image->galleryid;
	}

	$photographers = array_unique($photographers);
	echo ('<a href="#" id="data-filter" data-filter="*" class="currentSub"><li>All</li></a>');
	foreach ($photographers as $ID) {
		$gallery = $nggdb->find_gallery($ID);
		echo "<a  href='#" . $gallery->slug . "' id='data-filter' data-filter=" . "." . $gallery->gid . "><li id='" . $gallery->slug . "'>$gallery->title</li></a>";
		
	}

}


function photographers_menu()
{
    global $nggdb, $wpdb;
    $q           = "select * from $wpdb->nggallery";
    $gallerylist = $wpdb->get_results($q);
    echo '<ul>';
    foreach ($gallerylist as $gallery) {
        
        echo "<li id=\"topLevelAjaxButton\" type=\"gid\" gid='" . $gallery->gid . "'><a href='#'>$gallery->title</a>";
        echo "<ul class=\"subMenu>\">";
        get_tag_Submenu($gallery->gid);
        echo "</ul>";
        echo "</li>";
        
    }
    echo '</ul>';
}

function get_tag_Submenu($ID)
{
    global $nggdb;
    
    $gallery = $nggdb->get_gallery($ID, 'sortorder', 'ASC', true, 0, 0);
    
    $tags = array();
    foreach ($gallery as $image) {
        
        foreach ($image->tags as $tag) {
            $tags[] = $tag->slug;
        }
        
    }
    echo "<a href=\"#\" id='data-filter' data-filter=\"*\" class=\"currentSub\"><li id=\"all\">All</li></a>";
    $tags = array_unique($tags);
    foreach ($tags as $tag) {
        echo "<a  href=\"#\" id='data-filter' data-filter=" . "." . $tag . "><li id='" . $tag . "' >$tag</li></a>";
    }
}


function get_picture_with_gid($ID)
{
    global $nggdb;
    $image = $nggdb->find_image( $ID );
        foreach ($image->tags as $tag) {
           $tags .= $tag->slug . " ";
            
        }
        $data_filter = substr_replace($tags, "", -1);
        echo "<div class=\"$data_filter\">";
        echo "<a href=\"$image->imageURL\">";
        echo "<img src=\"$image->thumbURL\">";
        echo "</a>";
        echo "</div>";
        $tags = "";
}

function get_picture_with_tag($ID)
{
    global $nggdb;
    
    $image = $nggdb->find_image( $ID );
            
        $data_filter = $image->galleryid;
        echo "<div class=\"$data_filter\">";
        echo "<a href=\"$image->imageURL\">";
        echo "<img src=\"$image->thumbURL\">";
        echo "</a>";
        echo "</div>";
}

function get_picture_with_tag_json($ID)
{
    global $nggdb;
    
    $image = $nggdb->find_image( $ID );
            
        $data_filter = $image->galleryid;
        echo "<div class=\"$data_filter\"><a href=\"$image->imageURL\"><img src=\"$image->thumbURL\"></a></div>";
}


function get_picture_with_gid_json($ID)
{
    global $nggdb;
    $image = $nggdb->find_image( $ID );
        foreach ($image->tags as $tag) {
           $tags .= $tag->slug . " ";
        }
        $data_filter = substr_replace($tags, "", -1);
        echo "<div class=\"$data_filter\"><a href=\"$image->imageURL\"><img src=\"$image->thumbURL\"></a></div>";
        $tags = "";
}


function get_random_pictures()
{
    global $nggdb;
    
    $gallery = $nggdb->get_random_images(20);
    $tags = "";
    foreach ($gallery as $image) {
        foreach ($image->tags as $tag) {
            $tags .= $tag->slug . " ";
            
        }
        $new = substr_replace($tags, "", -1);
        echo "<div class=\"$new\">";
        echo "<a href=\"$image->imageURL\">";
        echo "<img src=\"$image->thumbURL\">";
        echo "</a>";
        echo "</div>";
        $tags = "";
    }
}


?>
