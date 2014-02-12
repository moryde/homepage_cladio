$(window).load(function () {
    $('.pictures').isotope({
        filter: '*',
        layoutMode: 'fitRows'
    });
    
    $('#logo').click(function (event) {
        $('.pictures').isotope('shuffle');
    });



    $(document).ready(function () {
    $('.imageView').hide();
	
	
    
    window.onhashchange = function(){
        var what_to_do = document.location.hash;    
        if (what_to_do=="#show_picture")
            show_picture();
    }
    
       
        $('.loadingScreen').hide();

        $('.mainmenu #data-filter').click(function (event) {
            console.log("subMenu Item Pressed");
            $('.imageView').hide();
            $('.pictures').show();
            $('.mainmenu .currentSub').removeClass('currentSub');
            $(this).addClass('currentSub');

            var selector = $(this).attr('data-filter');
            $('.pictures').isotope({
                filter: selector
            });
            return false;
        });

        $('.mainmenu #topLevelAjaxButton').click(function (event) {
            document.location.hash = $(this).attr('gid');
            
            console.log("topLevelAjaxButton is pressed");
            var $url;
            event.preventDefault();
			$('.imageView').hide();
            if ($(this).hasClass('current')) {
                            return;
            }
            //remove current from previous current and collapse submenu
            $('.mainmenu').find('.current').children('ul').slideToggle();
            $('.mainmenu .current').removeClass('current');
			
            //add the this menu as the current and expand submenu
            $(this).addClass('current');
            $(this).children('ul').slideToggle();
			
            //detect which type of button is pressed
            var type = $(this).attr('type');
            var getter = $(this).attr(type);
            //$('.pictures').isotope( 'remove', $('.isotope-item') );
            
            $('.pictures').fadeOut(function( ) {
            
                        $('.pictures').find('*').remove();
            
            
            });
            
			$('.loadingScreen').fadeIn(500);
            $('.pictures').isotope('destroy');
            $.ajax({
                url: 'http://ydefeldt.com/photo/wp-admin/admin-ajax.php',
                data: {
                    'action': 'get_picture_ids_thumb_url',
                    'type': type,
                    'getter': getter

                },
                success: function (data) {
                    // This outputs the result of the ajax request

                    var returnedData = JSON.parse(data);
                            $.each(returnedData, function (key, value) {
							$('.pictures').append(value);
                        });
                        
                        
                        $('.pictures').imagesLoaded( function(){
                        
                          			$('.loadingScreen').fadeOut();
                          			$('.pictures').fadeIn();
                          			                     			
                          $('.pictures').isotope({
								filter: '*',
								layoutMode: 'fitRows'                          
								});
                          
	clickImage();
                          });
                          


                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }

            });

        });
    });
    
var param1 = getUrlVars();
$( "[gid|="+param1['gid']+"]" ).trigger('click');
});

function getUrlVars() {
  var vars = [], hash;
  var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
  for(var i = 0; i < hashes.length; i++)
  {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
  }
  return vars;
}

function clickImage() {
    
$('.isotope-item a').click(function (event) {
  event.preventDefault();
	console.log($(this));
	
	$('.currentImage').removeClass();
	$(this).parent().addClass('currentImage');
	
	var url = $(this).attr('href');
	$('.pictures').fadeOut();
	//$('.content').append('<div class="pre"><--</div><div class="next">--></div><div class="imageView"></div>');
	$('.imageView img').remove();
	$('.imageView').show();
	$('.imageView').append('<img src="'+url+'">');
        });

$('.next').click(function () {

	var next = $('.currentImage').nextAll().not('.isotope-hidden').first();
	
	if (next.length == 0) {
	console.log("EOF (NEXT)");
		return;
	}
	
	$('.currentImage').removeClass('currentImage');
	next.addClass('currentImage');
	var url = next.find('a').attr("href");
	$('.imageView img').remove();
		$('.imageView').append('<img src="'+url+'">');
        });


$('.pre').click(function () {

	var next = $('.currentImage').prevAll().not('.isotope-hidden').first();
	
	if (next.length == 0) {
	console.log("EOF (PRE)");
		return;
	}
	
	console.log(next);
	
	$('.currentImage').removeClass('currentImage');
	next.addClass('currentImage');
	var url = next.find('a').attr("href");
	$('.imageView img').remove();
		$('.imageView').append('<img src="'+url+'">');
        });

$('.imageView img').click(function () {
	console.log("Image Pressed");
	$('.pictures').show();
	$('.imageView').hide();
  });
  
  
}


var getImage = function (getter, type) {
    $.ajax({
        url: 'http://ydefeldt.com/photo/wp-admin/admin-ajax.php',
        data: {
            'action': 'get_picture_ajax',
            'type': type,
            'getter': getter

        },
        success: function (data) {
            // This outputs the result of the ajax request
            //$('.pictures').isotope('appended', $( data ) );
            var $appendContent = $( data );
           $('.pictures').isotope( 'insert', $appendContent ); 
            

        },
        error: function (errorThrown) {
            console.log(errorThrown);
        }
    });

}