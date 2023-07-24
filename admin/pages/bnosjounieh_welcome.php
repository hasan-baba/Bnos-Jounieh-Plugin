<?php

function bnosjounieh_welcome(){ ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>
        <div>
            <h1>Add New Visit</h1>
        </div>
        <div class="visit_form">
            <?php
            $shortcode_output = do_shortcode('[new_vist]');
            echo $shortcode_output;
            ?>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="invoice-modal" tabindex="-1" data-backdrop="false" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLongTitle">Successfully Reserved</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <img src="/wp-content/plugins/bnos-jounieh/assets/img/jounieh.png"/>
                        </div>
                        <h5 >Reservation Details</h5>
                        <p>Date of reservation: <span id="response-date"></span></p>
                        <p>Number of Children: <span id="response-child"></span></p>
                        <p>Number of Adults: <span id="response-adult"></span></p>
                        <p>City of Residence: <span id="response-city"></span></p>
                        <p>Total amount: <span id="response-amount"></span></p>
                        <div id="qrcode" class="text-center mt-3"></div>
                    </div>
                    <div class="text-right">
<!--                        <button class="btn btn-primary mr-4 mb-4" id="print_invoice">Print</button>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }