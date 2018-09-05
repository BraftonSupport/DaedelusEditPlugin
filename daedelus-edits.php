<?php
/**
 * 
 * Plugin Name: Daedelus Edit Request
 * Description: Submit edit requests to the daedelus project manager
 * Author: Deryk
 * Version: 0.1
 */

//add the required scripts to the site only if user is logged in.
 function daedelus_enqueue_script(){
     if(is_user_logged_in()){
        wp_enqueue_script('daedelus-edit-js', plugins_url().'/daedelus-edits/daedelus_edits.js', false);
        $projectId = get_option('project_id');
        $script = '<script> window.onload = function(){window.DaedelusEditTool.init(\''.$projectId.'\');}</script>';
        wp_add_inline_script('daedelus-edit-js', $script);
     }
 }

 function daedelus_enqueue_style(){
     if(is_user_logged_in()){
        wp_enqueue_style('daedelus-edit--font-awesome-css', 'https://use.fontawesome.com/releases/v5.0.10/css/all.css', false);
         wp_enqueue_style('daedelus-edit-css', plugins_url().'/daedelus-edits/css/style.css', false);
     }
 }

 add_action('wp_enqueue_scripts', 'daedelus_enqueue_script');
 add_action('wp_enqueue_scripts', 'daedelus_enqueue_style');

 function render_daedelus_options(){?>
 <form method="post" action="options.php">
 <?php 
     settings_fields('daedelus_settings_options');
     do_settings_sections('daedelus_settings_options');
     ?>
     <h1>Daedelus Project Settings</h1>
     <table class="form-table">
       
        <tr valign="top">
        <th scope="row">Project ID</th>
        <td><input type="text" name="project_id" value="<?php echo esc_attr( get_option('project_id') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
     <?php
 }
 
 function add_daedelus_page(){
    add_options_page('Daedelus Site Build Project', 'Daedelus Project', 'edit_theme_options', 'daedelus', 'render_daedelus_options');
    add_action( 'admin_init', 'register_daedelus_settings' );
 }
 add_action('admin_menu', 'add_daedelus_page');

 function register_daedelus_settings() {
	//register our settings
    register_setting( 'daedelus_settings_options', 'project_id' );
}