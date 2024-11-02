<?phpinclude('../../../wp-load.php' );
// XMLheader("Content-Type: application/xml; charset=UTF-8");header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");header("Last-Modified: ". gmdate("D, d M Y H:i:s") ." GMT");header("Cache-Control: no-store, no-cache, must-revalidate");header("Cache-Control: post-check=0, pre-check=0", false);header("Pragma: no-cache");
$id = $wpdb->escape($_GET['id']);
echo '<' . '?xml version="1.0" encoding="utf-8" ?' . '>'.chr(13);echo '<conteudo>'.chr(13);
$sql = "SELECT po.ID, po.post_title, po.post_content, po.post_date, po.post_author, usu.display_name		FROM $wpdb->posts AS po		INNER JOIN $wpdb->users AS usu ON po.post_author = usu.ID		WHERE po.post_type = 'post' 		AND po.post_status = 'publish' 		AND po.ID='" . $id . "'";
$conteudos = $wpdb->get_results($sql);
foreach($conteudos as $conteudo){
	echo '<titulo_blog>'.get_option('blogname').'</titulo_blog>'.chr(13);	echo '<url_blog>'.get_option('siteurl').'</url_blog>'.chr(13);	echo '<id_post>'.$conteudo->ID.'</id_post>'.chr(13);	echo '<titulo><![CDATA['.$conteudo->post_title.']]></titulo>'.chr(13);	echo '<texto><![CDATA['.$conteudo->post_content.']]></texto>'.chr(13);	echo '<autor><![CDATA['.$conteudo->display_name.']]></autor>'.chr(13);	echo '<link><![CDATA['.get_option('siteurl'). '/?p='.$conteudo->ID.']]></link>'.chr(13); 	echo '<data_publicacao>'.$conteudo->post_date.'</data_publicacao>'.chr(13);}
echo '</conteudo>'.chr(13);?>