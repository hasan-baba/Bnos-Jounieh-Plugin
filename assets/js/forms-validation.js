jQuery( document ).ready(function() {

    // Add an event listener to the close button
    var closeButton = document.querySelector('.modal .close');
    if(closeButton != null){
        closeButton.addEventListener('click', function() {
            // Reload the page
            location.reload();
        });
    }
    jQuery(document).on("click", function(event) {
    	if (jQuery('#reserve-modal').is(':visible')) {
      		location.reload();
    	}
  	});

    // add new visit
    jQuery("#new_visit").click((e) => {
        e.preventDefault();

        var date_of_visit = jQuery('#date').val();
        var number_of_children = jQuery('#children').val();
        var number_of_adults = jQuery('#adults').val();
        var city = jQuery('#city').val();
        var amount = jQuery('#total').val();
        var pay = 0;

        if(date_of_visit != 0 && number_of_children != null && number_of_adults != null && city != 0 && amount != null){

            var form_data = new FormData();
            form_data.append('action', 'insert_visits_form_data');
            form_data.append('date_of_visit', date_of_visit);
            form_data.append('number_of_children', number_of_children);
            form_data.append('number_of_adults', number_of_adults);
            form_data.append('city', city);
            form_data.append('amount', amount);
            form_data.append('pay', pay);

            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                dataType: 'json',
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                data: form_data,
                success: function(data){
                    if(jQuery('#qrcode') != null){
                        jQuery('#qrcode').empty();
                        var qrcode = new QRCode("qrcode");
                        function makeCode () {
                            qrcode.makeCode("https://bnosjounieh.morfiyos.com/wp-admin/admin.php?page=scan_visit&id="+data.visit_id);
                        }
                        makeCode();
                    }

                    jQuery('#response-date').text(data.date_of_visit);
                    jQuery('#response-child').text(data.nb_children);
                    jQuery('#response-adult').text(data.nb_adults);
                    jQuery('#response-city').text(data.city);

                    if(data.pay == 0){
                        jQuery('#response-amount').text(data.amount + " (Not Paid)");
                    }else{
                        jQuery('#response-amount').text(data.amount + " (Paid)");
                    }
                    jQuery('#reserve-modal').modal('show');
                }
            });
        }else{
            alert("All fields are required!");
        }

    });

    // get points value from url
    function getPointsFromURL(url) {
        var queryString = url.split('?')[1];
        var params = queryString.split('&');
        var points = null;

        for (var i = 0; i < params.length; i++) {
            var param = params[i].split('=');
            if (param[0] === 'points') {
                points = parseInt(param[1]);
                break;
            }
        }
        return points;
    }

    // Check if the current URL matches the specific URL
    if (window.location.hostname === 'bnosjounieh.morfiyos.com' && window.location.pathname === '/claim-reward-winner-user/') {
        // Encoded URL and secret key
        var encodedURL = window.location.href;
        var secretKey = 'Ngodeinweb';

        // Extracting the encoded points value from the URL
        var searchParams = new URLSearchParams(new URL(encodedURL).search);
        var hasPointsParameter = searchParams.has('points');

        var points;

        if (hasPointsParameter) {
            var encryptedPoints = searchParams.get('points');
            var modifiedPoints = encryptedPoints.replace(/ /g, '+');
            jQuery("#points_value").text(modifiedPoints);
            // Decrypting the points value
            var decrypted = CryptoJS.AES.decrypt(modifiedPoints, secretKey).toString(CryptoJS.enc.Utf8);
            points = decrypted;
            jQuery("#points_value").text(points);
        } else {
            points = 0;
            window.location.href = "/my-account/augmented-game-user/";
        }
    }

    // check authority & claim rewards
    jQuery("#claim_ammount").click((e) => {
        e.preventDefault();

        // Encoded URL and secret key
        var encodedURL = window.location.href;
        var secretKey = 'Ngodeinweb';

        // Extracting the encoded points value from the URL
            var searchParams = new URLSearchParams(new URL(encodedURL).search);
            var hasPointsParameter = searchParams.has('points');

        var points;

        if (hasPointsParameter) {
            var encryptedPoints = searchParams.get('points');
            var modifiedPoints = encryptedPoints.replace(/ /g, '+');
            // Decrypting the points value
            var decrypted = CryptoJS.AES.decrypt(modifiedPoints, secretKey).toString(CryptoJS.enc.Utf8);
            points = decrypted;
        } else {
            points = 0;
            window.location.href = "/my-account/augmented-game-user/";
        }

        var form_data = new FormData();
        form_data.append('action', 'claim_reward');
        form_data.append('points', points);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data){
                console.log(data);
                if(data.status == 1){
                    jQuery("#claim_ammount").prop("disabled", true);
                    jQuery("#claim_ammount").html("You claimed your points!");
                    // window.location.href = '/my-account/augmented-game-user/';

                }else {
                    jQuery("#claim_ammount").prop("disabled", true);
                    jQuery("#claim_ammount").html("Sorry! You're not Authorized!");
                    // window.location.href = '/my-account/augmented-game-user/';
                }
            }
        });
    });

    jQuery("#menu_img").click((e)=>{
        jQuery('#menu_modal').modal('show');
        if(closeButton != null){
            closeButton.addEventListener('click', function() {
                e.preventDefault();
            });
        }
    });

    var closeButtonMap = document.querySelector('.modal .close.close_map');
    if(closeButtonMap != null){
        closeButtonMap.addEventListener('click', function(e) {
            jQuery('#ar_menu_modal').modal('hide');
        });
    }

    jQuery("#ar_btn").click((e) => {
        jQuery('#ar_menu_modal').modal('show');
        jQuery("#easy1").click(() => {
            jQuery('.elementor-element-18ad761').css('background-image', 'url(/wp-content/uploads/2023/06/easy-3.jpg)');
            jQuery('#ar_btn img').attr('src', '/wp-content/uploads/2023/06/Camera-1.png');
            jQuery('#game_btn > div > div > a').attr('href', 'https://bnosjounieh.morfiyos.com/projects/easy1/index.html');
            jQuery('#game_btn > div > div > a').attr('target', '_blank');
            jQuery('#ar_menu_modal').modal('hide');
            jQuery('#game_btn').css('display','block');
        });

        jQuery("#easy2").click(() => {
            jQuery('.elementor-element-18ad761').css('background-image', 'url(/wp-content/uploads/2023/06/easy-4.jpg)');
            jQuery('#ar_btn img').attr('src', '/wp-content/uploads/2023/06/Camera-1.png');
            jQuery('#game_btn > div > div > a').attr('href', 'https://bnosjounieh.morfiyos.com/projects/easy2/index.html');
            jQuery('#game_btn > div > div > a').attr('target', '_blank');
            jQuery('#ar_menu_modal').modal('hide');
            jQuery('#game_btn').css('display','block');
        });

        jQuery("#easy3").click(() => {
            jQuery('.elementor-element-18ad761').css('background-image', 'url(/wp-content/uploads/2023/06/easy_1.jpg)');
            jQuery('#ar_btn img').attr('src', '/wp-content/uploads/2023/06/Camera-1.png');
            jQuery('#game_btn > div > div > a').attr('href', 'https://bnosjounieh.morfiyos.com/projects/easy3/index.html');
            jQuery('#game_btn > div > div > a').attr('target', '_blank');
            jQuery('#ar_menu_modal').modal('hide');
            jQuery('#game_btn').css('display','block');
        });

        jQuery("#easy4").click(() => {
            jQuery('.elementor-element-18ad761').css('background-image', 'url(/wp-content/uploads/2023/06/easy_2.jpg)');
            jQuery('#ar_btn img').attr('src', '/wp-content/uploads/2023/06/Camera-1.png');
            jQuery('#game_btn > div > div > a').attr('href', 'https://bnosjounieh.morfiyos.com/projects/easy4/index.html');
            jQuery('#game_btn > div > div > a').attr('target', '_blank');
            jQuery('#ar_menu_modal').modal('hide');
            jQuery('#game_btn').css('display','block');
        });

        jQuery("#med").click(() => {
            jQuery('.elementor-element-18ad761').css('background-image', 'url(/wp-content/uploads/2023/06/Medium.jpg)');
            jQuery('#ar_btn img').attr('src', '/wp-content/uploads/2023/06/Camera-medium.png');
            jQuery('#game_btn > div > div > a').attr('href', 'https://bnosjounieh.morfiyos.com/projects/meduim/index.html');
            jQuery('#game_btn > div > div > a').attr('target', '_blank');
            jQuery('#ar_menu_modal').modal('hide');
            jQuery('#game_btn').css('display','block');
        });

        jQuery("#hard").click(() => {
            jQuery('.elementor-element-18ad761').css('background-image', 'url(/wp-content/uploads/2023/06/Hard.jpg)');
            jQuery('#ar_btn img').attr('src', '/wp-content/uploads/2023/06/Hard.png');
            jQuery('#game_btn > div > div > a').attr('href', 'https://bnosjounieh.morfiyos.com/projects/hard/index.html');
            jQuery('#game_btn > div > div > a').attr('target', '_blank');
            jQuery('#ar_menu_modal').modal('hide');
            jQuery('#game_btn').css('display','block');
        });
    });

    jQuery("#hint_btn").click(() => {
        jQuery('#hint_menu_modal').modal('show');
    });

    var closeButtonhint = document.querySelector('.modal .close.close_hint');
    if(closeButtonMap != null){
        closeButtonMap.addEventListener('click', function(e) {
            jQuery('#hint_menu_modal').modal('show');
        });
    }

});