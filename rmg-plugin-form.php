<?php
/**
 * Plugin Name: RMG Plugin Form
 * Author: Richard Marcelo
 * Description: Formulario personalizado usando el shortcode [rmg-plugin-form]
 */

 // Define el shortcode que muestra el formulario
 add_shortcode( 'rmg_plugin_form', 'RMG_Plugin_form' );

 function RMG_Plugin_form() {

    ob_start();
    ?>
 
        <form action="<?php get_the_permalink(); ?>" method="post" class="cuestionario">
        
            <div class="form-input">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-input">
                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" required>
            </div>
            <div class="form-input">
                <label for="nivel_html">¿Cual es tu nivel de HTML?</label>
                <input type="radio" name="nivel_html" value="1" required> Nada<br>
                <input type="radio" name="nivel_html" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_html" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_html" value="4" required> Lo domino al dedillo
            </div>
            <div class="form-input">
                <label for="nivel_css">¿Cual es tu nivel de CSS?</label>
                <input type="radio" name="nivel_css" value="1" required> Nada<br>
                <input type="radio" name="nivel_css" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_css" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_css" value="4" required> Lo domino al dedillo
            </div>
            <div class="form-input">
                <label for="nivel_js">¿Cual es tu nivel de JavaScript?</label>
                <input type="radio" name="nivel_js" value="1" required> Nada<br>
                <input type="radio" name="nivel_js" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_js" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_js" value="4" required> Lo domino al dedillo
            </div>
            <div class="form-input">
                <label for="aceptacion">La informacion se manejara de manera confidencial</label>
                <input type="checkbox" id="aceptacion" name="aceptacion" value="1" required> Entiendo y acepto las condiciones
            </div>
            <div class="form-input">
                <input type="submit" value="Enviar">
            </div>
        
        </form>

    <?php
    return ob_get_clean();
 }