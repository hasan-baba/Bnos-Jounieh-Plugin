<?php
/*
 * Visits Status table
 */
function visits_status_db_table()
{
    // change the version to update db structure
    $visits_status_db_version = "3.2.0";
    if ($visits_status_db_version != get_option("visits_status_db_version")) {
        global $wpdb;

        $visits_form_table = $wpdb->prefix . 'visits';
        $visits_status_table = $wpdb->prefix . 'visit_status';

        $sql = "CREATE TABLE $visits_status_table (
			`id` INTEGER (10) NOT NULL AUTO_INCREMENT,
			`visit_id` INTEGER (10) NOT NULL,
			`status` INTEGER (10),
			PRIMARY KEY (`id`)
			)";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $foreign_key_sql = "ALTER TABLE $visits_form_table ADD CONSTRAINT `FK_visit_status` FOREIGN KEY (`visit_id`) REFERENCES $visits_form_table (`id`)";
        dbDelta($foreign_key_sql);

        update_option('visits_status_db_version', $visits_status_db_version);


    }
}
add_action('after_setup_theme', 'visits_status_db_table');