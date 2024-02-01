<?php
/**
 * @author MiSCapu
 * @since  1.0
 * @version 1.0
 */
?>

<div class="wrap">
    <h1>Configurações do Link</h1>
    <form action="" method="post">
        <?php
        if ( isset( $_POST[ 'link_text' ] ) )
        {
            update_option( 'link_text', sanitize_text_field( $_POST[ 'link_text' ] ) );
            echo '<div class="notice notice-success"><p>Texto do footer atualizado com sucesso!</p></div>';
        }
        ?>
        <label for="link_text">
            Text for link
        </label>
        <input type="text" id="link_text" name="link_text" value="<?= esc_attr( get_option( 'link_text' ) );?>">
        <br><br>
        <?php submit_button();?>
    </form>
</div>
