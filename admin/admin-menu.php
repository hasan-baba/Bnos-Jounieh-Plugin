<?php

function jounieh_menu()
{
    add_menu_page('Bnos Jounieh System', 'Bnos Jounieh', 'bnos_jounieh_role', 'bnosjounieh_functioality', 'bnosjounieh_welcome', 'dashicons-smartphone', 63);
    add_submenu_page('bnosjounieh_functioality', 'Scan Visit', 'Scan Visit', 'bnos_jounieh_role', 'scan_visit', 'scan_visit', null);
}
add_action('admin_menu', 'jounieh_menu');