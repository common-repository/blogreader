<?php
if($_POST) {	
	blogR_setLogotipo($_POST["thumb_blog"]);
	update_option('url_css_blogreader', $_POST['url_css']);	
	$str_post='';

	foreach($_POST as $k=>$v) {
		$str_post .= $k.'='.base64_encode($v).'&';
	}	
	
	$c = blogR_http_post($str_post, CONST_HOST, CONST_PATH . 'receptor.php?acao=atualizaSite');
	echo "<script type='text/javascript'>document.location = '".get_option('siteurl')."/wp-admin/plugins.php';</script>" ;
}

$x = blogR_http_post('url_blog='.get_option('siteurl'), CONST_HOST, CONST_PATH . 'receptor.php?acao=buscaSite');
$site = explode('&',$x[1]);
$idBlog = explode('=',$site[0]);
$c = blogR_http_post($site[0], CONST_HOST, CONST_PATH . 'receptor.php?acao=listarCategorias');
$categorias = explode('&',$c[1]);
?>
<div class="wrap">
	<div id="icon-plugins" class="icon32">
<br />
</div>
<h2>Configura&ccedil;&otilde;es do BlogReader</h2>
<form action="" method="post">
	<input type="hidden" name="id_blog" value="<?php echo $idBlog[1];?>" />
	<input type="hidden" name="url_blog" value="<?php echo get_option('siteurl');?>"/>
	<input type="hidden" name="nome" value="<?php echo get_option('blogname');?>"/>
	<input type="hidden" name="descricao" value="<?php echo get_option('blogdescription');?>"/>
	
	<dt>
		<b>Nome do Blog</b>
		<dd><?php echo get_option('blogname'); ?></dd>
	</dt>
	<dt>
		<b>Descri&ccedil;&atilde;o do Blog</b>
		<dd><?php echo get_option('blogdescription'); ?></dd>
	</dt>
		<dt><b>Endere&ccedil;o do Blog</b>
		<dd><?php echo get_option('siteurl'); ?></dd>
	</dt>
	<dt>
		<b>CSS personalizado</b>
		<dd><input type="text" name="url_css" style="width: 450px; float: left;" value="<?php echo get_option('url_css_blogreader'); ?>"/><br /></dd>
		<b>Logotipo</b>
		<dd>
			<input type="text" name="thumb_blog" style="width: 450px; float: left;" value="<?php echo get_option('logotipo'); ?>"/>
			<div style="padding:0;margin:0;float:left;width: 350px;height: 20px;font-size: 10px;line-height: 12px;">
				Insira o caminho para o seu logotipo de 90x90 pixels.<br/>
				O logotipo ser&aacute; usado na listagem de seus posts no iPad
			</div><br/><br/>
	        <img src="<?php echo get_option('logotipo'); ?>" style="clear: both;border: #666 dotted 1px;float: left;"/>
	        <div style="clear: both;"></div>
        </dd>
     </dt>
     <dt>
     <b>Escolha a categoria do seu blog:</b>
     <dd>
		<?php			
			$myC = $categorias[count($categorias)-1];
			$myC = explode('=',$myC); 
			$myC = $myC[1];
		
			for($i=0;$i<count($categorias);$i++) {	
				$c = explode('|',$categorias[$i]);
				if(trim($c[1]) != '') {
					if($c[0] == $myC)
						$check = 'checked';
					else
						$check = '';
					echo '<input type="radio" name="id_categoria" '.$check.' value="'.$c[0].'" />' . $c[1] . '&nbsp;<br/>';
				}
			}
		 ?>
	  </dd>
	  </dt>
	  <input type="submit" name="Submit" class="button-primary" value="Salvar altera&ccedil;&otilde;es" />
	  </form>
  </div>
</div>