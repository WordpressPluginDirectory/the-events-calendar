<?php
/**
 * Install_Event_Tickets notice.
 * Install and/or activate Event Tickets when it is not active.
 */

namespace Tribe\Events\Admin\Notice;

use TEC\Common\StellarWP\Installer\Installer;
use Tribe__Main;
use Tribe__Template;
use Tribe__Events__Main as Events_Main;
use Tribe__Events__Organizer as Events_Organizer;
use Tribe__Events__Venue as Events_Venue;
/**

 */
class Install_Event_Tickets {

	/**
	 * Stores the plugin slug.
	 *
	 * @since 6.0.9
	 *
	 * @var string
	 */
	protected static $plugin_slug = 'event-tickets';

	/**
	 * Stores the assets group ID for the notice.
	 *
	 * @since 6.0.9
	 *
	 * @var string
	 */
	protected static $assets_group = 'tribe-events-admin-notice-install-event-tickets';

	/**
	 * Stores the instance of the notice template.
	 *
	 * @since 6.0.9
	 *
	 * @var Tribe__Template
	 */
	protected $template;

	/**
	 * Register update notices.
	 *
	 * @since 6.0.9
	 */
	public function hook() {
		if ( ! is_admin() || ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$this->assets();

		tribe_notice(
			'event-tickets-install',
			[ $this, 'notice_install' ],
			[
				'dismiss' => true,
				'type'    => 'warning',
			],
			[ $this, 'should_display_notice_install' ]
		);

		tribe_notice(
			'event-tickets-activate',
			[ $this, 'notice_activate' ],
			[
				'dismiss' => true,
				'type'    => 'warning',
			],
			[ $this, 'should_display_notice_activate' ]
		);
	}

	/**
	 * Register `Install` notice assets.
	 *
	 * @since 6.0.9
	 *
	 * @return void
	 */
	public function assets() {
		$plugin = tribe( 'tec.main' );

		tec_asset(
			$plugin,
			'tribe-events-admin-notice-install-event-tickets-js',
			'admin/notice-install-event-tickets.js',
			[
				'jquery',
				'tribe-common',
			],
			[ 'admin_enqueue_scripts' ],
			[
				'groups'       => [
					self::$assets_group,
				],
				'conditionals' => [ $this, 'should_enqueue_assets' ],
			]
		);

		tec_asset(
			$plugin,
			'tribe-events-admin-notice-install-event-tickets-css',
			'admin/notice-install-event-tickets.css',
			[
				'wp-components',
				'tec-variables-full',
			],
			[
				'admin_enqueue_scripts',
				'wp_enqueue_scripts',
			],
			[
				'groups'       => [ self::$assets_group ],
				'conditionals' => [ $this, 'should_enqueue_assets' ],
			]
		);
	}

	/**
	 * Checks if `Event Tickets` is installed.
	 *
	 * @since 6.0.9
	 *
	 * @return boolean True if active
	 */
	public function is_installed(): bool {
		return Installer::get()->is_installed( static::$plugin_slug );
	}

	/**
	 * Checks if `Event Tickets` is active.
	 *
	 * @since 6.0.9
	 *
	 * @return boolean True if active.
	 */
	public function is_active(): bool {
		return Installer::get()->is_active( static::$plugin_slug );
	}

	/**
	 * Check if we're on the classic "Install Plugin" page.
	 *
	 * @since 6.0.9
	 *
	 * @return boolean
	 */
	public function is_install_plugin_page(): bool {
		return 'install-plugin' === tribe_get_request_var( 'action' );
	}

	/**
	 * Should the `Install` notice be displayed?
	 *
	 * @since 6.0.9
	 *
	 * @return bool True if the install notice should be displayed.
	 */
	public function should_display_notice_install(): bool {
		// Checks whether upsell should be rendered.
		if ( tec_should_hide_upsell( 'event-tickets-install-notice' ) ) {
			return false;
		}

		return ! $this->is_installed()
			&& empty( tribe_get_request_var( 'welcome-message-the-events-calendar' ) )
			&& $this->is_tec_related_page()
			&& ! $this->is_install_plugin_page();
	}

	/**
	 * Should the `Activate` notice be displayed?
	 *
	 * @since 6.0.9
	 *
	 * @return bool True if the activate notice should be displayed.
	 */
	public function should_display_notice_activate(): bool {
		// Checks whether upsell should be rendered.
		if ( tec_should_hide_upsell( 'event-tickets-activate-notice' ) ) {
			return false;
		}

		$plugin_status_check    = $this->is_installed() && ! $this->is_active();
		$is_admin_relevant_page = $this->is_tec_related_page();

		/**
		 * Filters whether the `Event Tickets` admin notice should display.
		 *
		 * @since 6.9.0
		 *
		 * @param bool $should_display True if the notice should display.
		 */
		return apply_filters( 'tec_events_admin_notice_event_tickets_should_display', $plugin_status_check && $is_admin_relevant_page );
	}

	/**
	 * Checks if the current admin page is TEC related.
	 *
	 * @since 6.10.3
	 *
	 * @return bool True if the current admin page is TEC related.
	 */
	public function is_tec_related_page(): bool {
		// Not in the admin we don't even care.
		if ( ! is_admin() ) {
			return false;
		}

		global $current_screen;

		// No screen, bail.
		if ( empty( $current_screen ) ) {
			return false;
		}

		// Match any TEC post type screens (events, organizers, venues).
		$tec_post_types = [
			Events_Main::POSTTYPE      => true,
			Events_Organizer::POSTTYPE => true,
			Events_Venue::POSTTYPE     => true,
		];

		if ( isset( $tec_post_types[ $current_screen->post_type ] ) ) {
			return true;
		}

		// Match any screen ID containing 'tribe_events'.
		if ( false !== strpos( $current_screen->id, Events_Main::POSTTYPE ) ) {
			return true;
		}

		// Match any screen ID starting with 'tec-'.
		if ( str_starts_with( $current_screen->id, 'tec-' ) ) {
			return true;
		}

		// Match TEC settings pages.
		if ( false !== strpos( $current_screen->id, 'tribe-common' ) ) {
			return true;
		}

		// If Admin Helpers class is available, use it for more comprehensive check.
		if ( class_exists( \Tribe__Admin__Helpers::class, false ) ) {
			$admin_helpers = tribe( 'admin.helpers' );
			if ( method_exists( $admin_helpers, 'is_screen' ) && $admin_helpers->is_screen() ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Install notice for `Event Tickets`.
	 *
	 * @since 6.0.9
	 *
	 * @return string $html The HTML for the notice.
	 */
	public function notice_install(): string {
		$html = $this->get_template()->template(
			'notices/install-event-tickets',
			$this->get_template_data(),
			false
		);

		return $html;
	}

	/**
	 * Should enqueue assets required for the notice.
	 *
	 * @since 6.0.9
	 *
	 * @return bool True if the assets should be enqueued.
	 */
	public function should_enqueue_assets(): bool {
		return $this->should_display_notice_activate() || $this->should_display_notice_install();
	}

	/**
	 * Activate notice for `Event Tickets`.
	 *
	 * @since 6.0.9
	 *
	 * @return string $html The HTML for the notice.
	 */
	public function notice_activate(): string {
		$args = [
			'description'  => __( 'You\'re almost there! Activate Event Tickets for free and you\'ll be able to sell tickets, collect RSVPs, and manage attendees all from your Dashboard.', 'the-events-calendar' ),
			'button_label' => __( 'Activate Event Tickets', 'the-events-calendar' ),
			'action'       => 'activate',
		];

		$html = $this->get_template()->template(
			'notices/install-event-tickets',
			$this->get_template_data( $args ),
			false
		);

		return $html;
	}

	/**
	 * Data for the notice template.
	 *
	 * @since 6.0.9
	 *
	 * @param array $args Array with arguments to override the defaults.
	 *
	 * @return array The template args.
	 */
	private function get_template_data( $args = [] ): array {
		$admin_url    = is_network_admin() ? network_admin_url( 'settings.php' ) : admin_url( 'admin.php' );
		$redirect_url = add_query_arg( [ 'page' => 'tec-tickets-settings' ], $admin_url );

		$defaults = [
			'action'           => 'install',
			'title'            => __( 'Start selling tickets to your Events', 'the-events-calendar' ),
			'description'      => __( 'Sell tickets, collect RSVPs, and manage attendees for free with Event Tickets.', 'the-events-calendar' ),
			'button_label'     => __( 'Install Event Tickets', 'the-events-calendar' ),
			'tickets_logo'     => Tribe__Main::instance()->plugin_url . 'src/resources/images/logo/event-tickets.svg',
			'redirect_url'     => $redirect_url,
		];

		return wp_parse_args( $args, $defaults );
	}

	/**
	 * Get template object.
	 *
	 * @since 6.0.9
	 *
	 * @return \Tribe__Template
	 */
	public function get_template() {
		if ( empty( $this->template ) ) {
			$this->template = new Tribe__Template();
			$this->template->set_template_origin( tribe( 'tec.main' ) );
			$this->template->set_template_folder( 'src/admin-views' );
			$this->template->set_template_context_extract( true );
			$this->template->set_template_folder_lookup( false );
		}

		return $this->template;
	}
}
