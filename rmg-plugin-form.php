<?php
/**
 * Plugin Name: RMG Plugin Form
 * Description: Formulario personalizado usando el shortcode [rmg_plugin_form]
 * version: 0.1.1
 * Author: Richard Marcelo
 * Author URI: https://www.rmarcelo.com/
 * PHP Version: 5.6
 * 
 * @category Form
 * @package RMG
 * @author Richard Marcelo <https://www.rmarcelo.com>
 * @license GPLv2 http://www.gnu.org/licenses/gpl--2.0.txt
 * @link https://www.rmarcelo.com
 */

//Cuando el plugin se activa se crea la tabla del mismo si no existe 
register_activation_hook( __FILE__, 'Rmg_Aspirante_init' );

/**
 * Realiza las acciones necesarias para configurar el plugin cuando se activa
 * 
 * @return void
 */
function Rmg_Aspirante_init() {

    global $wpdb;
    $tabla_aspirante = $wpdb->prefix . 'aspirante';
    $charset_collate = $wpdb->get_charset_collate();
    // Prepara la consulta que vamos a lanzar para crear la tabla
    $query = "CREATE TABLE IF NOT EXISTS $tabla_aspirante (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        nombre varchar(40) NOT NULL,
        correo varchar(100) NOT NULL,
        nivel_html smallint(4) NOT NULL,
        nivel_css smallint(4) NOT NULL,
        nivel_js smallint(4) NOT NULL,
        nivel_php smallint(4) NOT NULL,
        nivel_wp smallint(4) NOT NULL,
        motivacion text,
        aceptacion smallint(4) NOT NULL,
        ip varchar(300),
        created_at datetime NOT NULL,
        UNIQUE (id)
    ) $charset_collate";

    include_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query);
}

 // Define el shortcode que muestra el formulario
 add_shortcode( 'rmg_plugin_form', 'RMG_Plugin_form' );

 /**
  * Crea y procesa el formulario que rellenan los aspirantes
  *
  * @return string
  */
 function RMG_Plugin_form() {

    global $wpdb;

    if ( !empty($_POST)
            && $_POST['nombre'] != '' 
            && is_email($_POST['correo'])
            && $_POST['nivel_html'] != ''
            && $_POST['nivel_css'] != ''
            && $_POST['nivel_js'] != ''
            && $_POST['nivel_php'] != ''
            && $_POST['nivel_wp'] != ''
            && $_POST['aceptacion'] == '1'
    ) {
        $tabla_aspirante = $wpdb->prefix . 'aspirante';
        $nombre = sanitize_text_field($_POST['nombre']);
        $correo = sanitize_email($_POST['correo']);
        $nivel_html = (int)$_POST['nivel_html'];
        $nivel_css = (int)$_POST['nivel_css'];
        $nivel_js = (int)$_POST['nivel_js'];
        $nivel_php = (int)$_POST['nivel_php'];
        $nivel_wp = (int)$_POST['nivel_wp'];
        $motivacion = sanitize_text_field($_POST['motivacion']);
        $aceptacion = (int)$_POST['aceptacion'];
        $ip = RMG_Obtener_IP_usuario();
        $created_at = date('Y-m-d H:i:s');

        $wpdb->insert(
            $tabla_aspirante, 
            array(
                'nombre' => $nombre,
                'correo' => $correo,
                'nivel_html' => $nivel_html,
                'nivel_css' => $nivel_css,
                'nivel_js' => $nivel_js,
                'nivel_php' => $nivel_php,
                'nivel_wp' => $nivel_wp,
                'motivacion' => $motivacion,
                'aceptacion' => $aceptacion,
                'ip' => $ip,
                'created_at' => $created_at,
            )
        );
        echo "<p class='exito'><b>Tus datos han sido registrados</b>. Gracias por tu interes. En breve contactare contigo.</p>";
    }
    // Carga hoja de estilo para el formulario
    wp_enqueue_style('css_aspirante', plugins_url('style.css', __FILE__));
    ob_start();
    ?>
 
        <form action="<?php get_the_permalink(); ?>" method="post" id="form_aspirane" class="cuestionario">
        
            <?php wp_nonce_field('graba_aspirante', 'aspirante_nonce'); ?>
            <div class="form-input">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="form-input">
                <label for="correo">Correo</label>
                <input type="email" name="correo" id="correo" required>
            </div>
            <div class="form-input">
                <label for="nivel_html">¿Cual es tu nivel de HTML?</label><br>
                <input type="radio" name="nivel_html" value="1" required> Nada<br>
                <input type="radio" name="nivel_html" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_html" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_html" value="4" required> Lo domino al dedillo<br>
            </div>
            <div class="form-input">
                <label for="nivel_css">¿Cual es tu nivel de CSS?</label><br>
                <input type="radio" name="nivel_css" value="1" required> Nada<br>
                <input type="radio" name="nivel_css" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_css" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_css" value="4" required> Lo domino al dedillo<br>
            </div>
            <div class="form-input">
                <label for="nivel_js">¿Cual es tu nivel de JavaScript?</label><br>
                <input type="radio" name="nivel_js" value="1" required> Nada<br>
                <input type="radio" name="nivel_js" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_js" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_js" value="4" required> Lo domino al dedillo<br>
            </div>
            <div class="form-input">
                <label for="nivel_php">¿Cual es tu nivel de PHP?</label><br>
                <input type="radio" name="nivel_php" value="1" required> Nada<br>
                <input type="radio" name="nivel_php" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_php" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_php" value="4" required> Lo domino al dedillo<br>
            </div>
            <div class="form-input">
                <label for="nivel_wp">¿Cual es tu nivel de WordPress?</label><br>  
                <input type="radio" name="nivel_wp" value="1" required> Nada<br>
                <input type="radio" name="nivel_wp" value="2" required> Estoy aprendiendo<br>
                <input type="radio" name="nivel_wp" value="3" required> Tengo experiencia<br>
                <input type="radio" name="nivel_wp" value="4" required> Lo domino al dedillo<br>
            </div>
            <div class="form-input">
                <label for="motivacion">Motivacion</label>
                <input type="text" name="motivacion" id="motivacion">
            </div>
            <div class="form-input">
                <label for="aceptacion">La informacion se manejara de manera confidencial</label><br>
                <input type="checkbox" id="aceptacion" name="aceptacion" value="1" required> Entiendo y acepto las condiciones<br>
            </div>
            <div class="form-input">
                <input type="submit" value="Enviar">
            </div>
        
        </form>

    <?php
    return ob_get_clean();
 }

 add_action("admin_menu", "RMG_Plugin_menu");

 /**
  * Agrega el menu del plugin al formulario de wordpress
  *
  *@return void
*/
function RMG_Plugin_menu() {
    add_menu_page("Formulario Aspirante", "Aspirantes", "manage_options", "rmg_plugin_menu", "RMG_Plugin_admin", "dashicons-feedback", 75);
}

function RMG_Plugin_admin() {

    global $wpdb;
    $tabla_aspirante = $wpdb->prefix . 'aspirante';
    $aspirantes = $wpdb->get_results("SELECT * FROM $tabla_aspirante");

    echo '<div class="wrap"><h1>Lista de aspirantes</h1>';
    echo '<table class="wp-list-table widefat fixed stripped">';
    echo '<thead><tr><th width="30%">Nombre</th><th width="20%">Correo</th><th>IP</th>';
    echo '<th>HTML</th><th>CSS</th><th>JS</th><th>PHP</th><th>WP</th><th>Total</th>';
    echo '</tr></thead>';
    echo '<tbody id="the-list">';

    foreach ($aspirantes as $aspirante){
        $nombre = esc_textarea( $aspirante->nombre );
        $correo = esc_textarea( $aspirante->correo );
        $ip = $aspirante->ip;
        $motivacion = esc_textarea($aspirante->motivacion);
        $nivel_html = (int)$aspirante->nivel_html;
        $nivel_css = (int)$aspirante->nivel_css;
        $nivel_js = (int)$aspirante->nivel_js;
        $nivel_php = (int)$aspirante->nivel_php;
        $nivel_wp = (int)$aspirante->nivel_wp;
        $total = $nivel_html + $nivel_css + $nivel_js + $nivel_php + $nivel_wp;
        
        echo "<tr><td><a href='#' title='$motivacion'>$nombre</a></td><td>$correo</td><td>$ip</td>";
        echo "<td>$nivel_html</td><td>$nivel_css</td><td>$nivel_js</td><td>$nivel_php</td><td>$nivel_wp</td><td>$total</td></tr>";
    }

    echo '</tbody></table></div>';

}

/**
 * Devuelve la IP del usuario que esta visitando la pagina
 * Codigo fuente: https://stackoverflow.com/questions/6717926/function-to-get-user-ip-address
 * 
 * @return string
 */
function RMG_Obtener_IP_usuario(){

    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key)
    {
        if (array_key_exists($key, $_SERVER) === true)
        {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip)
            {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false)
                {
                    return $ip;
                }
            }
        }
    }
}