<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

if ( ! have_comments() && ! comments_open() ) {
	return;
}

// Comment Reply Script.
if ( comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

// Adiciona um campo personalizado ao formulário de comentários
add_filter('comment_form_fields', 'meu_campo_personalizado');

function meu_campo_personalizado($fields) {
    $meu_campo = '<p class="meu-campo-comentario">' .
                 '<label for="habilidade">Sua habilidade ou cargo:</label>' .
                 '<input type="text" name="habilidade" id="habilidade" class="input-habilidade" />' .
                 '</p>';

    // Insere o novo campo antes do campo de comentário
    $fields['comment'] = $meu_campo . $fields['comment'];
    return $fields;
}

function salvar_habilidade_comentario( $comment_id ) {
    if ( isset( $_POST['habilidade'] ) ) {
        $habilidade = sanitize_text_field( $_POST['habilidade'] );
        add_comment_meta( $comment_id, 'habilidade', $habilidade );
    }
}
add_action( 'comment_post', 'salvar_habilidade_comentario' );

function meu_formato_comentario( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    $habilidade = get_comment_meta( get_comment_ID(), 'habilidade', true );

    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div id="comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
                <?php printf( __( '<cite class="fn">%s</cite>', 'text-domain' ), get_comment_author_link() ); ?>
                <div class="comment-habilidade"><?php echo esc_html( $habilidade ); ?></div>
            </div>
            <div class="comment-meta commentmetadata">
                <?php /* Demais marcações do comentário */ ?>
            </div>
            <?php comment_text(); ?>
        </div>
    </li>
    <?php
}

?>
<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="title-comments">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				printf( esc_html_x( 'One Response', 'comments title', 'hello-elementor' ) );
			} else {
				printf(
					esc_html( /* translators: 1: number of comments */
						_nx(
							'%1$s Response',
							'%1$s Responses',
							$comments_number,
							'comments title',
							'hello-elementor'
						)
					),
					esc_html( number_format_i18n( $comments_number ) )
				);
			}
			?>
		</h3>

		<?php the_comments_navigation(); ?>

	<ol class="comment-list">
		<?php
		wp_list_comments( array( 'callback' => 'meu_formato_comentario', 'style' => 'ol', 'short_ping' => true, 'avatar_size' => 42 ) );
		?>
	</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

<?php endif; // Check for have_comments(). ?>

<?php
comment_form(
	[
		'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'  => '</h2>',
	]
);
?>

</section><!-- .comments-area -->