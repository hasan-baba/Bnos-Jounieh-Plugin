jQuery( document ).ready(function() {

    // print-invoice
    jQuery('#print_invoice').click(function() {
        // Clone the modal content element
        var modalContent = jQuery('.modal-body').clone();

        // Remove background styles from the cloned element
        modalContent.find('*').css('background', 'none');

        // Create a new window and write the cloned content
        var printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title></head><body>');
        printWindow.document.write(modalContent.html());
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        // Call the print function on the new window
        printWindow.print();
    });

    // calculate amount
    function calculate_ammount(nb_chld, nb_adult){
        const ppc = 100000;
        const ppa = 100000;
        var ammount = (nb_chld*ppc)+(nb_adult*ppa);
        return ammount;
    }

    // Get the input elements
    var adultsInput = document.getElementById('number_of_adults');
    var childrenInput = document.getElementById('number_of_children');

    if (adultsInput != null && childrenInput != null){
        adultsInput.addEventListener('input', updateTotal);
        childrenInput.addEventListener('input', updateTotal);
    }
    // Add event listeners to detect input changes
    function updateTotal() {
        var adults = parseInt(adultsInput.value) || 0;
        var children = parseInt(childrenInput.value) || 0;

        // Calculate the amount using the provided function
        var amount = calculate_ammount(children, adults);

        // Update the "total" input with the calculated amount
        var totalInput = document.getElementById('amount');
        totalInput.value = amount.toLocaleString() + ' LBP';
    }

    // Add an event listener to the close button
    var closeButton = document.querySelector('.modal .close');
    if(closeButton != null){
        closeButton.addEventListener('click', function() {
            // Reload the page
            location.reload();
        });
    }
    jQuery(document).on("click", function(event) {
        if (jQuery('#invoice-modal').is(':visible')) {
            location.reload();
        }
    });

    // create new visit
    jQuery("#new_visit").click((e) => {
        e.preventDefault();

        var date_of_visit = jQuery('#date_of_visit').val();
        var number_of_children = jQuery('#number_of_children').val();
        var number_of_adults = jQuery('#number_of_adults').val();
        var city = jQuery('#city').val();
        var amount = jQuery('#amount').val();
        var pay = 1;

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
                    jQuery('#qrcode').empty();
                    var qrcode = new QRCode("qrcode");
                    function makeCode () {
                        qrcode.makeCode("https://bnosjounieh.morfiyos.com/wp-admin/admin.php?page=scan_visit&id="+data.visit_id);
                    }
                    makeCode();

                    jQuery('#response-date').text(data.date_of_visit);
                    jQuery('#response-child').text(data.nb_children);
                    jQuery('#response-adult').text(data.nb_adults);
                    jQuery('#response-city').text(data.city);

                    if(data.pay == 0){
                        jQuery('#response-amount').text(data.amount + " (Not Paid)");
                    }else{
                        jQuery('#response-amount').text(data.amount + " (Paid)");
                    }
                    jQuery('#invoice-modal').modal('show');
                }
            });
        }else{
            alert("All fields are required!");
        }

    });

    // Update visit
    jQuery("#update_visit").click((e) => {
        e.preventDefault();

        var date_visit = jQuery('#date_visit').text();
        var visit_id = jQuery('#visit_id').val();
        var number_of_children = jQuery('#number_of_children').val();
        var number_of_adults = jQuery('#number_of_adults').val();
        var city = jQuery('#city').val();
        var amount = jQuery('#amount').val();
        var pay = 1;

        if(number_of_children != null && number_of_adults != null && city != null && amount != null){

            var form_data = new FormData();
            form_data.append('action', 'update_visit_form_data');
            form_data.append('visit_id', visit_id);
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
                    jQuery('#qrcode').empty();
                    var qrcode = new QRCode("qrcode");
                    function makeCode () {
                        qrcode.makeCode("https://bnosjounieh.morfiyos.com/wp-admin/admin.php?page=scan_visit&id="+data.visit_id);
                    }
                    makeCode();
                    jQuery('#response-date').text(date_visit);
                    jQuery('#response-child').text(data.nb_children);
                    jQuery('#response-adult').text(data.nb_adults);
                    jQuery('#response-city').text(data.city);

                    if(data.pay == 0){
                        jQuery('#response-amount').text(data.amount + " (Not Paid)");
                    }else{
                        jQuery('#response-amount').text(data.amount + " (Paid)");
                    }
                    jQuery('#update_invoice_modal').modal('show');
                }
            });
        }else{
            alert("All fields are required!");
        }

    });

    // exit_visit
    jQuery("#exit_visit").click((e)=> {
        e.preventDefault();
        var visit_id = jQuery("#visit_id").val();
        var form_data = new FormData();
        form_data.append('action', 'update_visit_status_data');
        form_data.append('visit_id', visit_id);
        form_data.append('status', 0);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data){
                location.reload();
            }
        });
    });

    // enter_visit
    jQuery("#enter_visit").click((e)=> {
        e.preventDefault();
        var visit_id = jQuery("#visit_id").val();
        var form_data = new FormData();
        form_data.append('action', 'update_visit_status_data');
        form_data.append('visit_id', visit_id);
        form_data.append('status', 1);
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            enctype: 'multipart/form-data',
            contentType: false,
            processData: false,
            data: form_data,
            success: function(data){
                location.reload();
            }
        });
    });
});