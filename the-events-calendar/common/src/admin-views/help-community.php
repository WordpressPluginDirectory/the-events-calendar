<?php
/**
 * View: Community Help Page.
 */

$faqs               = tribe( Tribe__Admin__Help_Page::class )->get_calendar_faqs();
$extensions         = tribe( Tribe__Admin__Help_Page::class )->get_community_extensions();
$community_products = tribe( Tribe__Admin__Help_Page::class )->get_community_products();

?>
<div id="tribe-community">
	<img class="tribe-events-admin-header__right-image" src="<?php echo esc_url( tribe_resource_url( 'images/help/help-community-header.png', false, null, $main ) ); ?>" />
	<p class="tribe-events-admin-products-description">
		<?php esc_html_e( 'Get help for these products and learn more about products you don\'t have.', 'tribe-common' ); ?>
	</p>

	<?php
	// list of products.
	?>
	<div class="tribe-events-admin-products tribe-events-admin-2col-grid">
		<?php
		// requires valid links for all the products.
		foreach ( $community_products as $slug ) :
			?>
			<div class="tribe-events-admin-products-card">
				<img class="tribe-events-admin-products-card__icon" src="<?php echo esc_url( tribe_resource_url( $products[ $slug ]['logo'], false, null, $main ) ); ?>" alt="<?php esc_attr_e( 'logo icon', 'tribe-common' ); ?>" />
				<div class="tribe-events-admin-products-card__group">
					<h4 class="tribe-events-admin-products-card__group-title">
						<?php echo esc_html( $products[ $slug ]['title'] ); ?>
					</h4>
					<div class="tribe-events-admin-products-card__group-description">
						<?php echo esc_html( $products[ $slug ]['description-help'] ); ?>
					</div>
				</div>
				<?php
				$plugin_path_url = WP_PLUGIN_DIR . '/' . $products[ $slug ]['plugin-dir'] . '/' . $products[ $slug ]['main-file'];
				$plugin_exists   = file_exists( $plugin_path_url );

				// checks if plugin is installed and activated.
				if ( $products[ $slug ]['is_installed'] ) {
					?>
					<button class="tribe-events-admin-products-card__button tribe-events-admin-products-card__button--active">
						<?php esc_html_e( 'Active', 'tribe-common' ); ?>
					</button>
					<?php
					// checks if plugin is installed but not activated.
				} elseif ( ! $products[ $slug ]['is_installed'] && $plugin_exists ) {
					?>
					<a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>" class="tribe-events-admin-products-card__button">
						<?php esc_html_e( 'Activate', 'tribe-common' ); ?>
					</a>
					<?php
					// adds a learn more link if plugin is neither activated nor installed.
				} else {
					?>
					<a href="<?php echo esc_url( $products[ $slug ]['link'] ); ?>" target="_blank" rel="noopener noreferrer" class="tribe-events-admin-products-card__button">
						<?php esc_html_e( 'Learn More', 'tribe-common' ); ?>
					</a>
					<?php
				}
				?>
			</div>
		<?php endforeach; ?>
	</div>

	<div class="tribe-events-admin-section-header">
		<h3>
			<?php esc_html_e( 'Start Here', 'tribe-common' ); ?>
		</h3>

		<a href="https://evnt.is/1aq9" target="_blank" rel="noopener noreferrer">
			<?php esc_html_e( 'Visit Knowledgebase', 'tribe-common' ); ?>
		</a>
	</div>

	<div class="tribe-events-admin-kb tribe-events-admin-3col-grid">
		<div class="tribe-events-admin-kb-card">
			<img class="tribe-events-admin-kb-card__image" src="<?php echo esc_url( tribe_resource_url( 'images/help/help-start-guide-tickets.png', false, null, $main ) ); ?>" alt="<?php esc_attr_e( 'book with The Events community logo', 'tribe-common' ); ?>" />
			<h4 class="tribe-events-admin-kb-card__title">
				<?php esc_html_e( 'Getting Started Guides', 'tribe-common' ); ?>
			</h4>
			<ul class="tribe-events-admin-kb-card__links">
				<li>
					<a href="https://evnt.is/1apy" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Community', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1apz" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Community Tickets', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1ary" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Community Shortcodes', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1arz" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Locating Links to Your Community Pages', 'tribe-common' ); ?>
					</a>
				</li>
			</ul>
		</div>

		<div class="tribe-events-admin-kb-card">
			<img class="tribe-events-admin-kb-card__image" src="<?php echo esc_url( tribe_resource_url( 'images/help/customizing.png', false, null, $main ) ); ?>" alt="<?php esc_attr_e( 'book with Event Tickets logo', 'tribe-common' ); ?>" />
			<h4 class="tribe-events-admin-kb-card__title">
				<?php esc_html_e( 'Managing Submissions', 'tribe-common' ); ?>
			</h4>
			<ul class="tribe-events-admin-kb-card__links">
				<li>
					<a href="https://evnt.is/1aq1" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Managing Submissions Overview', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1aq2" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Setting Notifications', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1ar-" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Auto-Publish Events Submitted By Logged-In Users', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1aq4" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Preventing Spam Submissions', 'tribe-common' ); ?>
					</a>
				</li>
			</ul>
		</div>

		<div class="tribe-events-admin-kb-card">
			<img class="tribe-events-admin-kb-card__image" src="<?php echo esc_url( tribe_resource_url( 'images/help/common-issues.png', false, null, $main ) ); ?>" alt="<?php esc_attr_e( 'book with The Events community logo', 'tribe-common' ); ?>" />
			<h4 class="tribe-events-admin-kb-card__title">
				<?php esc_html_e( 'Plugin Maintenance', 'tribe-common' ); ?>
			</h4>
			<ul class="tribe-events-admin-kb-card__links">
				<li>
					<a href="https://evnt.is/1aq5" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Testing for Conflicts', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1aq6" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Release notes', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1aq7" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Integrations', 'tribe-common' ); ?>
					</a>
				</li>
				<li>
					<a href="https://evnt.is/1aq8" target="_blank" rel="noopener noreferrer">
						<?php esc_html_e( 'Automatic Updates', 'tribe-common' ); ?>
					</a>
				</li>
			</ul>
		</div>
	</div>

	<?php
	// faq section.
	?>
	<div class="tribe-events-admin-section-header">
		<h3>
			<?php esc_html_e( 'FAQs', 'tribe-common' ); ?>
		</h3>

		<a href="https://evnt.is/1av4#faqs" target="_blank" rel="noopener noreferrer">
			<?php esc_html_e( 'All FAQs', 'tribe-common' ); ?>
		</a>
	</div>

	<div class="tribe-events-admin-faq tribe-events-admin-4col-grid">
		<?php foreach ( $faqs as $faq ) : ?>
			<div class="tribe-events-admin-faq-card">
				<div class="tribe-events-admin-faq-card__icon">
					<img src="<?php echo esc_url( tribe_resource_url( 'images/icons/faq.png', false, null, $main ) ); ?>" alt="<?php esc_attr_e( 'lightbulb icon', 'tribe-common' ); ?>" />
				</div>
				<div class="tribe-events-admin-faq-card__content">
					<div class="tribe-events-admin-faq__question">
						<a href="<?php echo esc_url( $faq['link'] ); ?>" target="_blank" rel="noopener noreferrer">
							<?php echo esc_html( $faq['question'] ); ?>
						</a>
					</div>
					<div class="tribe-events-admin-faq__answer">
						<?php echo esc_html( $faq['answer'] ); ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<?php
	// extensions section.
	?>
	<div class="tribe-events-admin-section-header">
		<h3>
			<?php esc_html_e( 'Free extensions', 'tribe-common' ); ?>
		</h3>

		<a href="https://evnt.is/1aqa" target="_blank" rel="noopener noreferrer">
			<?php esc_html_e( 'All Extensions', 'tribe-common' ); ?>
		</a>
	</div>

	<p class="tribe-events-admin-extensions-title">
		<?php esc_html_e( 'Small, lightweight WordPress plugins that add new capabilities to our core plugins. Support is not offered for extensions; however they provide enhanced functionality and bonus features.', 'tribe-common' ); ?>
	</p>

	<div class="tribe-events-admin-extensions tribe-events-admin-4col-grid">
		<?php foreach ( $extensions as $extension ) : ?>
			<div class="tribe-events-admin-extensions-card">
				<h4 class="tribe-events-admin-extensions-card__title">
					<a href="<?php echo esc_url( $extension['link'] ); ?>" target="_blank" rel="noopener noreferrer">
						<?php echo esc_html( $extension['title'] ); ?>
					</a>
				</h4>
				<div class="tribe-events-admin-extensions-card__description">
					<?php echo esc_html( $extension['description'] ); ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
