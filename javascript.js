$(window).load(function () {
    $('.pictures').isotope({
        filter: '*',
        layoutMode: 'fitRows'
    });
    
    $('#logo').click(function (event) {
        //$('.pictures').isotope('shuffle');
        var $newItems = $('<div class="item">lol</div>');
		
		var img = document.createElement("img");
		var date1 = new Date().getTime();
		img.src = "http://ydefeldt.com/photo/wp-content/gallery/lasse-wind/vk_05_139357.jpg";

		
		
    });

    $(document).ready(function () {
    
    
$('img').click(function (event) {
            event.preventDefault();
			console.log(this);
	var url = $(this).attr('href');
	console.log(url);
	//$('.pictures').fadeOut();
	
        });

    window.onhashchange = function(){
        var what_to_do = document.location.hash;    
        if (what_to_do=="#show_picture")
            show_picture();
    }
    
       
        $('.loadingScreen').hide();

        $('.mainmenu #data-filter').click(function (event) {
            console.log("subMenu Item Pressed");
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
            
                        $('.pictures').find('img').remove();
            
            
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
                	console.log(data);
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