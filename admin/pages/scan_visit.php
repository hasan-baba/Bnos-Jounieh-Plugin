<?php

function scan_visit(){
    $visit_id = $_GET['id'];
    global $wpdb;
    $visits_table = $wpdb->prefix.'visits';

    $sql = $wpdb->get_row($wpdb->prepare("SELECT * FROM $visits_table WHERE id=%s", $visit_id));
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>
        <div class="visit_scan">
            <div class="d-flex flex-column mt-5"
            <label>Date of Visit: <span id="date_visit"><?php echo $sql->date_of_visit; ?></span></label>
            <?php
            if($sql->pay == 0){ ?>

                <label for="">Number of Children</label>
                <input type="number" name="number_of_children" value="<?php echo $sql->nb_children; ?>" id="number_of_children" min="0" required>

                <label for="">Number of Adults</label>
                <input type="number" name="number_of_adults" value="<?php echo $sql->nb_adults; ?>" id="number_of_adults" min="0" required>

                <label for="">City</label>
                <?php
                $selectedCity = $sql->city;

                $options = array(
                    "beirut" => "Beirut",
                    "jounieh" => "Jounieh",
                    "tripoli" => "Tripoli",
                    "sidon" => "Sidon",
                    "baalbek" => "Baalbek",
                    "nabatieh" => "Nabatieh",
                    "tyre" => "Tyre",
                    "zahle" => "Zahle",
                    "zgharta_ehden" => "Zgharta-Ehden",
                    "byblos" => "Byblos",
                    "batroun" => "Batroun"
                );

                ?>

                <select name="city" id="city" required>
                    <?php foreach ($options as $value => $label): ?>
                        <option value="<?php echo $value; ?>" <?php if ($selectedCity == $value) echo "selected"; ?>><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </select>


                <label for="">Amount (Not Paid)</label>
                <input type="text" id="amount" value="<?php echo $sql->amount; ?>" class="form-control" readonly>
                <input type="hidden" id="visit_id" value="<?php echo $visit_id; ?>" class="form-control" readonly>
                <button id="update_visit" class="button back-btn mt-5">Update Reserve & Pay</button >

            <?php
            }else{
                ?>
                <label for="">Number of Children: <?php echo $sql->nb_children; ?></label>
                <label for="">Number of Adults: <?php echo $sql->nb_adults; ?></label>
                <label for="">City of Residence: <?php echo $sql->city; ?></label>
                <label for="">Amount: <?php echo $sql->amount; ?> (Paid)</label>
                <input type="hidden" value="<?php echo $visit_id; ?>" id="visit_id">
            <?php
                $visit_status_table = $wpdb->prefix.'visit_status';
                $sql_status = $wpdb->get_row($wpdb->prepare("SELECT * FROM $visit_status_table WHERE visit_id=%s", $visit_id));
                if($sql_status->status == 0){ ?>
                    <button id="enter_visit" class="button back-btn bg-success mt-5 w-25" style="color: #ffffff">Enter</button >
                <?php }else{ ?>
                    <button id="exit_visit" class="button back-btn bg-danger mt-5 w-25" style="color: #ffffff">Exit</button >
               <?php }
            ?>

        </div>
            <?php
            }
                ?>
        </div>
    </div>
    <div class="modal fade" id="update_invoice_modal" tabindex="-1" role="dialog" data-backdrop="false" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
<!--                    <button class="btn btn-primary mr-4 mb-4" id="print_invoice">Print</button>-->
                </div>
            </div>
        </div>
    </div>

<?php }