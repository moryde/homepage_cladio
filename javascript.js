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
		img.onload = function() {
		    var date2 = new Date().getTime();
		    var delta = date2 - date1;
		    
		};
		
		
    });

    $(document).ready(function () {
       $('.pictures').isotope({
           filter: '*',
           layoutMode: 'fitRows'
       });
       
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
            console.log("topLevelAjaxButton is pressed");
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
            $('.pictures').isotope( 'remove', $('.isotope-item') );
            //$('.pictures').isotope('reLayout');
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
                    console.log(returnedData);
                    
                    switch (returnedData[0]) {
                    case 'tag':
                        returnedData.shift();
                        $.each(returnedData, function (key, value) {
                            getImage(value, 'tag');
                        });
                        break;

                    case 'gid':
                        returnedData.shift();
                        $.each(returnedData, function (key, value) {
                            getImage(value, 'gid');
                        });
                        break;
                    }

                },
                error: function (errorThrown) {
                    console.log(errorThrown);
                }

            });

        });
    });
});

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