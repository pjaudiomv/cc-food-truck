<?php

namespace FoodTruck;

class Settings
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'registerSettings']);
        add_action('admin_menu', [$this, 'createMenu']);
    }

    public function registerSettings(): void
    {
        register_setting('food-truck-group', 'food_truck_sheet_id', 'sanitize_text_field');
        register_setting('food-truck-group', 'food_truck_sheet_name', 'sanitize_text_field');
        register_setting('food-truck-group', 'food_truck_google_api_key', 'sanitize_text_field');
        register_setting('food-truck-group', 'food_truck_checkbox');
        register_setting('food-truck-group', 'food_truck_passed_events_checkbox');
    }

    public function createMenu(string $baseFile): void
    {
        add_options_page(
            esc_html__('Food Truck Settings'), // Page Title
            esc_html__('Food Truck'),          // Menu Title
            'manage_options',                  // Capability
            'food-truck',                      // Menu Slug
            [$this, 'drawSettings']            // Callback function to display the page content
        );
        add_filter('plugin_action_links_' . $baseFile, [$this, 'settingsLink']);
    }

    public function settingsLink($links)
    {
        $settings_url = admin_url('options-general.php?page=food-truck');
        $links[] = "<a href='{$settings_url}'>Settings</a>";
        return $links;
    }

    public function drawSettings(): void
    {
        ?>
        <div class="wrap">
            <h2>Food Truck Settings</h2>
            <form method="post" action="options.php">
                <?php settings_fields('food-truck-group'); ?>
                <?php do_settings_sections('food-truck-group'); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Google Sheet ID</th>
                        <td>
                            <input type="text" size="45" name="food_truck_sheet_id" value="<?php echo esc_attr(get_option('food_truck_sheet_id')); ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Google Sheet Name</th>
                        <td>
                            <input type="text" size="45" name="food_truck_sheet_name" value="<?php echo esc_attr(get_option('food_truck_sheet_name')); ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Google API KEY</th>
                        <td>
                            <p>Make sure to set referrer restrictions. Domain for client side or IP for server side loading .</p>
                            <input type="text" size="45" name="food_truck_google_api_key" value="<?php echo esc_attr(get_option('food_truck_google_api_key')); ?>" />
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Load Sheet Server Side</th>
                        <td>
                            <input type="checkbox" name="food_truck_checkbox" value="1" <?php checked(1, get_option('food_truck_checkbox'), true); ?> />
                            <label for="food_truck_checkbox">This will load the data server side and pass to the client. (Defaults to Client Side for faster loading)</label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Show past events</th>
                        <td>
                            <input type="checkbox" name="food_truck_passed_events_checkbox" value="1" <?php checked(1, get_option('food_truck_passed_events_checkbox'), true); ?> />
                            <label for="food_truck_passed_events_checkbox">This will show past events. (Defaults to not displaying them.)</label>
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
