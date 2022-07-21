<?php
namespace Creative_Addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

defined( 'ABSPATH' ) || exit();

/**
 * Features List widget for Elementor
 */
class Features_List extends Creative_Widget_Base {


	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Features List', 'creative-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-advanced-heading-icon';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'features', 'list' ];
	}

	protected function get_config_defaults() {
		return [];
	}

	protected function get_config_rtl_defaults() {
		return [];
	}

	// get_config_defaults until preset defaults are the same as config defaults
	protected function get_presets_defaults() {
		return $this->get_config_defaults();
	}
	
	// get_config_defaults until preset defaults are the same as config defaults
	protected function get_presets_rtl_defaults() {
		return $this->get_config_rtl_defaults();
	}

	/**
	 * Return presets for this widget
	 */
	public function get_presets_options() {
		$options = array();
		
		$options['default'] = array(
			'title' => 'Design 1',
			'preview_url'   => $this->presets_preview_url( 'features-list-design-1.png' ),
			'options' => array()
		);

		return $options;
	}

	/**
	 * CONTENT tab for this widget
	 */
	protected function register_content_controls() {

		// CONTENT =================================[ TAB ]====================================/

		// HEADER ------------------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_features_list__header__section_content',
			[
				'label' => __( 'Header', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'crel_features_list__title',
				[
					'label'         => __( 'Title', 'creative-addons-for-elementor' ),
					'type'          => Controls_Manager::TEXT,
					'placeholder'   => __( 'Features List Title', 'creative-addons-for-elementor' ),
				]
			);

			$this->add_control(
				'crel_features_list__subtitle',
				[
					'label'         => __( 'Subtitle', 'creative-addons-for-elementor' ),
					'type'          => Controls_Manager::TEXT,
					'placeholder'   => __( 'features subtitle', 'creative-addons-for-elementor' ),
				]
			);

		$this->add_control(
			'crel_features_list__titleHTML_tag',
			[
				'label' => __( 'Title HTML Tag', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'h1'  => [
						'title' => 'H1',
						'icon' => 'eicon-editor-h1'
					],
					'h2'  => [
						'title' => 'H2',
						'icon' => 'eicon-editor-h2'
					],
					'h3'  => [
						'title' => 'H3',
						'icon' => 'eicon-editor-h3'
					],
					'h4'  => [
						'title' => 'H4',
						'icon' => 'eicon-editor-h4'
					],
					'h5'  => [
						'title' => 'H5',
						'icon' => 'eicon-editor-h5'
					],
					'h6'  => [
						'title' => 'H6',
						'icon' => 'eicon-editor-h6'
					]
				],
				'default' => 'h3',
				'toggle' => false,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * STYLE tab for this widget
	 */
	protected function register_style_controls() {

		// STYLE ===================================[ TAB ]====================================/

	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

        $title_text         = $settings['crel_features_list__title'];
		$title_html_tag     = $settings['crel_features_list__titleHTML_tag'];
        $sub_header_text    = $settings['crel_features_list__subtitle'];

        $body_top_dec       = 'XML format allows you to export all content information from your Knowledge Base and easily import all articles or just a selected few into another website.';
        $body_bottom_dec    = 'XML format allows you to export all content information from your Knowledge Base and easily import all articles or just a selected few into another website.';


		?>
		<!-- Features -->
		<div class="crel-features-list-container">

            <!----- HEADER -------------->
            <div class="crel-features-list-header">
                <div class="crel-features-list-header__title">
                    <<?php echo esc_attr( $title_html_tag ); ?>>
                        <?php echo esc_html( $title_text ); ?>
                    </<?php echo esc_attr( $title_html_tag ); ?>>
                </div>
                <div class="crel-features-list-sub-header__text"><?php echo esc_html( $sub_header_text ); ?></div>
            </div>

            <!----- BODY ---------------->
            <div class="crel-features-list-body">

                <!----- Top Desc ---------------->
                <div class="crel-features-list-body__top-desc"><p><?php echo esc_html( $body_top_dec ); ?></p></div>

                <!----- Features ---------------->
                <div class="crel-features-list-items-container">

                    <?php
                    $header_text        = 'Use KB Editor for Basic Styling';
                    $learn_more_url     = 'https://www.microsoft.com';
                    $learn_more_text    = 'Learn More';
                    $header_icon        = 'crelfa-check-circle';
                    $item_desc          = 'It is important to understand what your users are searching for so that you know how to improve your KB content. By knowing specific search keywords, you can better understand what help content your users are looking for.';

                    $footer_btn_url     = 'https://www.microsoft.com';
                    $footer_btn_text    = 'Buy Now';
                    ?>
                    <div class="crel-list-item">

                        <!----- Item Header ---------------->
                        <div class="crel-list-item__header">
                            <div class="crel-list-item__header__icon crelfa <?php echo esc_html( $header_icon ); ?>"></div>
                            <div class="crel-list-item__header__text"><?php echo esc_html( $header_text ); ?></div>
                            <?php if (  empty( $item_desc ) && !empty( $learn_more_text ) ) { ?>
                                <div class="crel-list-item__learn-more-link"><a href="<?php echo esc_url( $learn_more_url ); ?>"><?php echo esc_html( $learn_more_text ); ?></a></div>
                            <?php } ?>
		                    <?php if (  !empty( $item_desc ) ) { ?>
                                <div class="crel-list-item__header__info crelfa crelfa-info-circle"></div>
		                    <?php } ?>
                        </div>

                        <!----- Item Body ------------------>
	                    <?php if ( !empty( $item_desc ) ) { ?>
                            <div class="crel-list-item__body">
                                <div class="crel-list-item__desc">
                                    <?php echo wp_kses_post( $item_desc ); ?>
                                </div>
                                <?php if ( !empty( $learn_more_text ) ) { ?>
                                    <div class="crel-list-item__learn-more-link"><a href="<?php echo esc_url( $learn_more_url ); ?>"><?php echo esc_html( $learn_more_text ); ?></a></div>
                                <?php } ?>
                            </div>
	                    <?php } ?>

                    </div>

                </div>

                <!----- Bottom Desc ------------->
                <div class="crel-features-list-body__bottom-desc"><p><?php echo esc_html( $body_bottom_dec ); ?></p></div>

            </div>

            <!----- FOOTER ---------------->
            <div class="crel-features-list-footer">
                <div class="crel-features-list-footer_btn-link"><a href="<?php echo esc_url( $footer_btn_url ); ?>"><?php echo esc_html( $footer_btn_text ); ?></a></div>
            </div>

		</div>
		<?php



	}
	
	/**
	 * Dynamically render Features List
	 */
	protected function content_template() { }
}
