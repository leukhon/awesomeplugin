<?php
/**
* Plugin Name: Wolfcode
* Plugin URI: https://hispawolf.com/descargas/repositorio
* Description: Este plugin permite añadir varias funcionalidades para mejorar la instalación de tu web en Wordpress
* Version: 1.1
* Author: Volk
* Author URI: https://hispawolf.com
* License: GPL2
*/

/***COPYRIGHT DINÁMICO***/
if( !is_admin()){
   wp_deregister_script('jquery'); 
   wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"), false, '1.3.2'); 
   wp_enqueue_script('jquery');
}

function iw_copyright(){
	global $wpdb;
	$copyright_dates = $wpdb->get_results("SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts	WHERE post_status = 'publish'");
	$output = '';
	if($copyright_dates){
		$copyright = "&copy; " . $copyright_dates[0]->firstdate;
		if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate){
			$copyright .= '-' . $copyright_dates[0]->lastdate;
		}
		$output = $copyright;
	}
	return $output;
}
/*OCULTACIÓN DE PÁGINAS DE WORDPRESS*/

/*Se ocultan las páginas Categoría, Etiqueta y Autor*/
add_action('template_redirect', 'aw_remove_wp_archives'); 

/*Esconde los archivos */
function aw_remove_wp_archives(){  

//Si estamos en el archivo de la categoría o etiqueta o fecha o autor  
if( is_category() || is_tag() || is_author() ) {    global $wp_query;
$wp_query->set_404(); 
//definimos una página de 404 no encontrado  
}}

/*ACTIVACIÓN DE TODOS LOS BOTONES DEL EDITOR VISUAL DE WP*/

function todos_los_botones($buttons) {
	$buttons[] = 'fontselect';  //Selector de tipo de fuente
	$buttons[] = 'fontsizeselect'; //Selector de tamaño de fuente
	$buttons[] = 'styleselect';  //Selector de estilos de párrafo mucho más amplio
	$buttons[] = 'backcolor';  //Color de fondo de párrafo
	$buttons[] = 'newdocument';  //Nuevo documento inline
	$buttons[] = 'cut';  //Cortar texto
	$buttons[] = 'copy';  //Copiar texto
	$buttons[] = 'charmap';  //Mapa de caracteres
	$buttons[] = 'hr'; //Línea horizontal
	$buttons[] = 'visualaid'; //Ayudas visuales del editor
return $buttons;}

add_filter("mce_buttons_3", "todos_los_botones");*

/*SALUDO PERSONALIZADO EN ESCRITORIO*/
function saludo_personal( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Hola,', 'Bienvenido,', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'saludo_personal',25 );

/***OCULTAR ERROR LOGIN***/
/*Muy util para ocultar en que nos estamos equivocando cuando hacemos login*/
add_filter('login_errors',create_function('$a', "return null;"));

/**CABECERAS SEGURIDAD**/
/*WP no viene con estas cabeceras por defecto.
Estas cabeceras solucionan varios problemas de seguridad en WP*/

add_action( 'send_headers', 'add_header_seguridad' );
function add_header_seguridad() {
header( 'X-Content-Type-Options: nosniff' );
header( 'X-Frame-Options: SAMEORIGIN' );
header( 'X-XSS-Protection: 1;mode=block' );
}

?>