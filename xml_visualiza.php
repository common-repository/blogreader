<?php
// XML
$id = $wpdb->escape($_GET['id']);
echo '<' . '?xml version="1.0" encoding="utf-8" ?' . '>'.chr(13);
$sql = "SELECT po.ID, po.post_title, po.post_content, po.post_date, po.post_author, usu.display_name
$conteudos = $wpdb->get_results($sql);
foreach($conteudos as $conteudo){
	echo '<titulo_blog>'.get_option('blogname').'</titulo_blog>'.chr(13);
echo '</conteudo>'.chr(13);