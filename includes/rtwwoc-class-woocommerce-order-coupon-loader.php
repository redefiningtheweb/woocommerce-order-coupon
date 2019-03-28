<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://redefiningtheweb.com
 * @since      1.0.0
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Rtwwoc_WooCommerce_Order_Coupon
 * @subpackage Rtwwoc_WooCommerce_Order_Coupon/includes
 * @author     RedefiningTheWeb <developer@redefiningtheweb.com>
 */
class Rtwwoc_WooCommerce_Order_Coupon_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $rtwwoc_actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $rtwwoc_filters;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->rtwwoc_actions = array();
		$this->rtwwoc_filters = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress action that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the action is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function rtwwoc_add_action( $rtwwoc_hook, $rtwwoc_component, $rtwwoc_callback, $rtwwoc_priority = 10, $rtwwoc_accepted_args = 1 ) {
		$this->rtwwoc_actions = $this->rtwwoc_add( $this->rtwwoc_actions, $rtwwoc_hook, $rtwwoc_component, $rtwwoc_callback, $rtwwoc_priority, $rtwwoc_accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    1.0.0
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
	 * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function rtwwoc_add_filter( $rtwwoc_hook, $rtwwoc_component, $rtwwoc_callback, $rtwwoc_priority = 10, $rtwwoc_accepted_args = 1 ) {
		$this->rtwwoc_filters = $this->rtwwoc_add( $this->rtwwoc_filters, $rtwwoc_hook, $rtwwoc_component, $rtwwoc_callback, $rtwwoc_priority, $rtwwoc_accepted_args );
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string               $hook             The name of the WordPress filter that is being registered.
	 * @param    object               $component        A reference to the instance of the object on which the filter is defined.
	 * @param    string               $callback         The name of the function definition on the $component.
	 * @param    int                  $priority         The priority at which the function should be fired.
	 * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
	 * @return   array                                  The collection of actions and filters registered with WordPress.
	 */
	private function rtwwoc_add( $rtwwoc_hooks, $rtwwoc_hook, $rtwwoc_component, $rtwwoc_callback, $rtwwoc_priority, $rtwwoc_accepted_args ) {

		$rtwwoc_hooks[] = array(
			'hook'          => $rtwwoc_hook,
			'component'     => $rtwwoc_component,
			'callback'      => $rtwwoc_callback,
			'priority'      => $rtwwoc_priority,
			'accepted_args' => $rtwwoc_accepted_args
		);

		return $rtwwoc_hooks;

	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function rtwwoc_run() {

		foreach ( $this->rtwwoc_filters as $rtwwoc_hook ) {
			add_filter( $rtwwoc_hook['hook'], array( $rtwwoc_hook['component'], $rtwwoc_hook['callback'] ), $rtwwoc_hook['priority'], $rtwwoc_hook['accepted_args'] );
		}

		foreach ( $this->rtwwoc_actions as $rtwwoc_hook ) {
			add_action( $rtwwoc_hook['hook'], array( $rtwwoc_hook['component'], $rtwwoc_hook['callback'] ), $rtwwoc_hook['priority'], $rtwwoc_hook['accepted_args'] );
		}

	}

}
