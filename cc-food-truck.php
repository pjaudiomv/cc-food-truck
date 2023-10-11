<?php

/**
 * Plugin Name: Carnes Food Truck
 * Description: A plugin that displays Food Truck Schedule For Carnes Crossroads.
 * Version: 1.0
 * Author: pjaudiomv
 * Author URI: https://github.com/pjaudiomv/carnesresidents/
 */

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Sorry, but you cannot access this page directly.');
}

spl_autoload_register(function (string $class) {
    if (strpos($class, 'FoodTruck\\') === 0) {
        $class = str_replace('FoodTruck\\', '', $class);
        require __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    }
});

use FoodTruck\Settings;
use FoodTruck\Events;

// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
class FoodTruckPlugin
{
    // phpcs:enable PSR1.Classes.ClassDeclaration.MissingNamespace
    public function __construct()
    {
        add_action('admin_menu', [$this, 'optionsMenu']);
        add_action('wp_enqueue_scripts', [$this, 'assets']);
        add_shortcode('cc_food_truck', [$this, 'events']);
    }

    public function optionsMenu()
    {
        $dashboard = new Settings();
        $dashboard->createMenu();
    }

    public function events($atts)
    {
        $event = new Events();
        return $event->renderEvents($atts);
    }

    public function assets()
    {
        $event = new Events();
        wp_enqueue_style("food-truck-css", plugin_dir_url(__FILE__) . "assets/css/food-truck.css", false, filemtime(plugin_dir_path(__FILE__) . "assets/css/food-truck.css"), false);
        wp_enqueue_script('food-truck-js', plugin_dir_url(__FILE__) . "assets/js/food-truck.js", ['jquery'], '1.0', true);
        wp_localize_script('food-truck-js', 'foodTruckParams', [
            'SHEET_ID' => esc_js(get_option('food_truck_sheet_id')),
            'SHEET_NAME' => esc_js(get_option('food_truck_sheet_name')),
            'API_KEY' => esc_js(get_option('food_truck_google_api_key')),
            'EVENTS' => $event->optionalGetEvents()
        ]);
    }
}

$foodTruckPlugin = new FoodTruckPlugin();
