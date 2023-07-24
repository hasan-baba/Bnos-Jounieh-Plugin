<?php
// insert new visit
function insert_visits_form_data(){
    $date_of_visit = $_POST['date_of_visit'];
    $number_of_children = $_POST['number_of_children'];
    $number_of_adults = $_POST['number_of_adults'];
    $city = $_POST['city'];
    $amount = $_POST['amount'];
    $pay = $_POST['pay'];


    global $wpdb;
    $visits_table = $wpdb->prefix.'visits';
    $current_user = wp_get_current_user();
    $user_id = $current_user->ID;

    $insert_record = $wpdb->insert($visits_table,array(
        'date_of_visit' => $date_of_visit,
        'user_id' => $user_id,
        'nb_children' => $number_of_children,
        'nb_adults' => $number_of_adults,
        'amount' => $amount,
        'pay' => $pay,
        'city' => $city,
        'creation_date' => date('Y-m-d H:i:s')
    ));
//    wp_send_json($wpdb->last_query);
    if($insert_record) {
        wp_send_json
        ([
            'date_of_visit' => $date_of_visit,
            'message'=>'success',
            'user_id' => $user_id,
            'visit_id' => $wpdb->insert_id,
            'nb_children' => $number_of_children,
            'nb_adults' => $number_of_adults,
            'amount' => $amount,
            'pay' => $pay,
            'city' => $city,
        ]);
    }
    exit();
}
add_action('wp_ajax_nopriv_insert_visit_form_data','insert_visits_form_data');
add_action("wp_ajax_insert_visits_form_data", "insert_visits_form_data");



function update_visit_form_data() {
    $visit_id = intval($_POST['visit_id']);
    $number_of_children = intval($_POST['number_of_children']);
    $number_of_adults = intval($_POST['number_of_adults']);
    $city = sanitize_text_field($_POST['city']);
    $amount = sanitize_text_field($_POST['amount']);
    $pay = sanitize_text_field($_POST['pay']);

    global $wpdb;
    $visits_table = $wpdb->prefix . 'visits';
    $visit_status_table = $wpdb->prefix . 'visit_status';

    $update_record = $wpdb->query($wpdb->prepare(
        "UPDATE $visits_table SET nb_children = %d, nb_adults = %d, city = %s, amount = %s, pay = %s
        WHERE id = %d", $number_of_children, $number_of_adults, $city, $amount, $pay, $visit_id
    ));

    if ($update_record !== false) {
        $insert_to_status_table = $wpdb->insert($visit_status_table, array(
            'visit_id' => $visit_id,
            'status' => 1
        ));
        wp_send_json([
            'message' => 'success',
            'id' => visit_id,
            'nb_children' => $number_of_children,
            'nb_adults' =>$number_of_adults,
            'city' =>$city,
            'amount'=> $amount,
            'pay'=>$pay
        ]);
    }
    wp_send_json([
        'message' => 'error',
    ]);
    exit();
}
add_action("wp_ajax_update_visit_form_data", "update_visit_form_data");

// check visit status
function check_visit_status(){
    global $wpdb;
    $visit_status_table = $wpdb->prefix . 'visit_status';
    $visit_id = $_POST['visit_id'];

    // Check if the visit_id already exists in the visit_status table
    $result = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $visit_status_table WHERE visit_id = %s", $visit_id
    ));

    if ($result > 0) {
        $status = $_POST['status'];
        $wpdb->query($wpdb->prepare(
            "UPDATE $visit_status_table
        SET status = %s
        WHERE visit_id = %s", $status, $visit_id
        ));
    }
}
add_action("wp_ajax_update_visit_status_data", "check_visit_status");

// check user authority
function user_authority($user_id) {
    $date = date("Y-m-d");
    global $wpdb;
    $visits_table = $wpdb->prefix . 'visits';
    $visit_status_table = $wpdb->prefix . 'visit_status';

    $query = $wpdb->prepare(
        "SELECT COUNT(*) FROM $visits_table AS v
        INNER JOIN $visit_status_table AS vs ON v.id = vs.visit_id
        WHERE v.user_id = %d
        AND DATE(v.date_of_visit) = DATE(%s)
        AND v.pay = 1
        AND vs.status = 1",
        $user_id,
        $date
    );
    $count = $wpdb->get_var($query);

    if ($count > 0) {
        return true;
    } else {
        // User does not meet the criteria
       return false;
    }
}

// claim_reward
function claim_reward(){
    $user_id = get_current_user_id();
    $auth = user_authority($user_id);
//    if($auth){
//        $points = $_POST['points'];
//        global $wpdb;
//        $rewards_table = $wpdb->prefix . 'wc_points_rewards_user_points';
//
//        $current_points = $wpdb->get_var($wpdb->prepare("SELECT points_balance FROM $rewards_table WHERE user_id = %d",$user_id));
//        $new_points = $current_points + $points;
//        $update_table = $wpdb->update($rewards_table, array('points_balance' => $new_points),array('user_id' => $user_id));
//        if($update_table){
//            wp_send_json([
//                'message' => 'Authorized',
//                'status' => 1,
//            ]);
//        }
//    }else{
//        wp_send_json([
//            'message' => 'Not authorized',
//            'status' => 0,
//        ]);
//    }

    $points = $_POST['points'];
    global $wpdb;
    $rewards_table = $wpdb->prefix . 'wc_points_rewards_user_points';

    $current_points = $wpdb->get_var($wpdb->prepare("SELECT points_balance FROM $rewards_table WHERE user_id = %d",$user_id));
    $new_points = $current_points + $points;
    $update_table = $wpdb->update($rewards_table, array('points_balance' => $new_points),array('user_id' => $user_id));
    if($update_table){
        wp_send_json([
            'message' => 'Authorized',
            'status' => 1,
        ]);
    }



}
add_action("wp_ajax_claim_reward", "claim_reward");