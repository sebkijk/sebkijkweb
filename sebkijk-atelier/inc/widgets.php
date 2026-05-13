<?php
/**
 * "Currently watching" – a tiny custom widget for the colophon sidebar
 * that displays the most recent film along with a personal one-liner.
 *
 * @package SebKijk_Atelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class SebKijk_Currently_Watching_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'sebkijk_currently_watching',
			__( 'Currently watching', 'sebkijk-atelier' ),
			array( 'description' => __( 'A small block displaying the latest film entry.', 'sebkijk-atelier' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Currently watching', 'sebkijk-atelier' );

		$film = get_posts( array( 'post_type' => 'film', 'posts_per_page' => 1 ) );
		if ( ! $film ) {
			return;
		}
		$film = $film[0];

		echo $args['before_widget'];
		echo $args['before_title'] . esc_html( $title ) . $args['after_title'];

		$y = sebkijk_field( 'film_year', $film->ID );
		$d = get_the_term_list( $film->ID, 'director', '', ', ', '' );
		?>
		<p class="cw__title"><a href="<?php echo esc_url( get_permalink( $film ) ); ?>"><?php echo esc_html( get_the_title( $film ) ); ?></a></p>
		<p class="cw__meta"><?php
			if ( $d ) echo $d;
			if ( $d && $y ) echo ' <span aria-hidden="true">·</span> ';
			if ( $y ) echo esc_html( $y );
		?></p>
		<?php if ( ! empty( $instance['note'] ) ) : ?>
			<p class="cw__note"><?php echo esc_html( $instance['note'] ); ?></p>
		<?php endif; ?>
		<?php
		echo $args['after_widget'];
	}

	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? $instance['title'] : '';
		$note  = isset( $instance['note'] )  ? $instance['note']  : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'sebkijk-atelier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'note' ) ); ?>"><?php esc_html_e( 'Personal note:', 'sebkijk-atelier' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'note' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'note' ) ); ?>" type="text" value="<?php echo esc_attr( $note ); ?>" />
		</p>
		<?php
	}

	public function update( $new, $old ) {
		return array(
			'title' => sanitize_text_field( $new['title'] ?? '' ),
			'note'  => sanitize_text_field( $new['note']  ?? '' ),
		);
	}
}

add_action( 'widgets_init', function () {
	register_widget( 'SebKijk_Currently_Watching_Widget' );
} );
