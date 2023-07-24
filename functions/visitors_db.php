<?php
/*
 * Visits table
 */
/*
 * Visits table
 */
function visits_db_table()
{
    $visits_db_version = '5.2.0';
    if ($visits_db_version != get_option('visits_db_version')) {
        global $wpdb;
        $users_table = $wpdb->prefix . 'users';
        $visits_form_table = $wpdb->prefix . 'visits';

        $sql = "CREATE TABLE $visits_form_table (
            `id` INT(10) NOT NULL AUTO_INCREMENT,
            `user_id` INT(10) NOT NULL,
            `date_of_visit` DATE,
            `nb_children` INT(10),
            `nb_adults` INT(10),
            `amount` VARCHAR(255),
            `pay` INT(10),
            `city` VARCHAR(255),
            `creation_date` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        )";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);

        $foreign_key_sql = "ALTER TABLE $visits_form_table ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES $users_table (`id`)";
        dbDelta($foreign_key_sql);

        update_option('visits_db_version', $visits_db_version);
    }
}

add_action('after_setup_theme', 'visits_db_table');

