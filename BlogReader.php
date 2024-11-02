<?php
/*
Plugin Name: BlogReader
Plugin URI: http://www.blogreader.com.br/
Description: Envie o conte&uacute;do do seu blog para o iPad.
Version: 1.9.9.8
Author: Digisa
*/

include('funcoes.php');

function blogR_inicializar() {

	global $wpdb;
	$str = '';
	$str.= 'nome='.get_option('blogname')
		   .'&descricao='.get_option('blogdescription')
		   .'&email_admin='.get_option('admin_email')
		   .'&url_blog='.get_option('siteurl')
		   .'&url_css=';

	add_option('logotipo','');
	add_option('url_css_blogreader','');
	blogR_http_post($str, CONST_HOST, CONST_PATH . 'receptor.php?acao=instalar');
}

function blogR_desinstalar() {

	$str ='';
	$str.= 'nome='.get_option('blogname')
		   .'&descricao='.get_option('blogdescription')
           .'&email_admin='.get_option('admin_email')
		   .'&url_blog='.get_option('siteurl');

	$c = blogR_http_post($str, CONST_HOST, CONST_PATH . 'receptor.php?acao=desinstalar');
}

function blogR_menu() {
	add_menu_page('Blog Reader','Blog Reader',10,'blogreader/configuracoes.php');
}

function blogR_send_post( $id ) {

	$x= blogR_http_post('url_blog='.get_option('siteurl'), CONST_HOST, CONST_PATH . 'receptor.php?acao=buscaSite');
	$site = explode('=',$x[1]);

	if($_POST) {

		$post = get_post($id);
        blogR_makeThumb($post->post_content, $post->ID);
		$str_post = '';
		$str_post.= 'id_post='.$post->ID;		
		$str_post.= '&thumb_blog='.get_option('logotipo');
		$str_post.= '&thumb_post='.blogR_getURLThumb($post->ID, $post->post_content);		
		$str_post.= '&titulo='.$post->post_title;
		$str_post.= '&id_blog='.$site[1];                                           
		$str_post.= '&link='.get_option('siteurl').'/?p='.$post->ID;
		$str_post.= '&data_publicacao='.$post->post_date;
		
		$c = blogR_http_post($str_post, CONST_HOST, CONST_PATH . 'receptor.php?acao=adicionar');
	}
}

// Actions and Filters
register_activation_hook(__FILE__,'blogR_inicializar');
register_deactivation_hook(__FILE__,'blogR_desinstalar');
add_action('admin_menu','blogR_menu');
add_action('publish_post','blogR_send_post');
?>