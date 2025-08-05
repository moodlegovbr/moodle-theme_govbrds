<?php
namespace theme_govbrds\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\user_preference_provider;

class provider implements 
    \core_privacy\local\metadata\provider,
    user_preference_provider {

    public static function get_metadata(collection $items): collection {
        $items->add_user_preference(
            'govbrds_user_setting',
            'privacy:metadata:govbrds_user_setting'
        );
        return $items;
    }

    public static function export_user_preferences(int $userid) {
        $value = get_user_preferences('yourtheme_user_setting', null, $userid);
        if ($value !== null) {
            \core_privacy\local\request\writer::export_user_preference(
                'theme_govbrds',
                'govbrds_user_setting',
                $value,
                get_string('privacy:metadata:govbrds_user_setting', 'theme_govbrds')
            );
        }
    }
}