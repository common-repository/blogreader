<?phpdefine('CONST_HOST','digeratidigital.com.br');define('CONST_PATH','/agregador/');
function blogR_http_post($request, $host, $path, $port = 80, $ip=null) {	global $wp_version;
	$http_request  = "POST $path HTTP/1.0\r\n";	$http_request .= "Host: $host\r\n";	$http_request .= "Content-Type: application/x-www-form-urlencoded; charset=iso-8859-1\r\n";	$http_request .= "Content-Length: " . strlen($request) . "\r\n";	$http_request .= "User-Agent: WordPress/$wp_version\r\n";	$http_request .= "\r\n";	$http_request .= $request;
	$http_host = $host;	$response = '';
	if( false != ( $fs = @fsockopen($http_host, $port, $errno, $errstr, 10) ) ) {		fwrite($fs, $http_request);		while ( !feof($fs) )			$response .= fgets($fs, 1160); // One TCP-IP packet		fclose($fs);		$response = explode("\r\n\r\n", $response, 2);	}	return $response;}

function blogR_setLogotipo($url_img){	$a = explode(".",$url_img);	$extensao = $a[count($a)-1];
	if(strlen($url_img) == 0){		update_option('logotipo', '' );        echo "<script type='text/javascript'>document.location = '".get_option('siteurl')."/wp-admin/plugins.php';</script>" ; 	}
	elseif(strlen($url_img) > 0 && strtolower($extensao) != "jpg" && strtolower($extensao) != "png"){		echo utf8_encode(	   '<script type="text/javascript">			alert("A extensão da imagem é inválida\n utilize imagens .jpg ou .png");		</script>'); 	}	else{		update_option('logotipo', $url_img );	}}
function blogR_getFirstImage($post,$get_url=false,$size=array(90,90)){
	if(strlen($post) > 0  && is_array($size)){     	$dom = new DOMDocument();
     if(!@$dom->loadHTML($post)){         return "";     }       
     $items = $dom->getElementsByTagName("img");       $atributos = $items->item(0)->attributes ; 
     if($items->length > 0){         $urlImg = $atributos->getNamedItem('src')->nodeValue;   
         if($get_url)return $urlImg;            
         $w =  $atributos->getNamedItem('width')->nodeValue;          $h  = $atributos->getNamedItem('height')->nodeValue;         $img = array($w,$h);  
         if($img[0] == '' || $img[1] == ''){            return '';         }         if($img[0] > 0){            //regra proporcional    	        $img[0] = ceil(($img[0]*$size[0])/$img[1]);            $img[1] = $size[0];
            if($img[0] > $size[0]){                       $img[1] = ceil(($img[1]*$size[1])/$img[0]);               $img[0] = $size[1];                    }             }               return '<img width="'.$img[0].'" height="'.$img[1].'" src="'.$urlImg.'"  />';     }  }  } 
//Functions for thumbfunction blogR_makeThumb($post, $idPost){   $url = blogR_getFirstImage($post, true);   $path_br_thumbs = blogR_getRootWP()."wp-content/uploads/br_thumbs/";
   if(!is_dir($path_br_thumbs)){          @mkdir($path_br_thumbs, 0777);       @chmod($path_br_thumbs, 0777);   }   $nomeTotal = explode("/",$url);    $nomeTotal = $nomeTotal[count($nomeTotal)-1];    $tipo = explode(".",$nomeTotal);   $nome = $tipo[0]; 
   $tipo = $tipo[count($tipo)-1];
   if(!@getimagesize($url)){        $url = explode("wp-content",$url);        $url = blogR_getRootWP()."wp-content".$url[1];             }   elseif(!@getimagesize($url)) return '';   // Get new sizes   list($width, $height) = @getimagesize($url);
   if($width >= $height && $height > 0){        //calc resize        $newheight = 90;           $newwidth = round( ($width * $newheight) / $height);     }   elseif($height >= $width && $width > 0){  		//calc resize        $newwidth = 90;            $newheight = round( ($height * $newwidth) / $width);      }   //margem direita   if($newwidth > 90)   $margin_rigth = ceil($newwidth / 2);   //echo "Largura: ".$newwidth.'<br/>';   //echo "Altura: ".$newheight.'<br/>'; 
   // Load   if($tipo == "jpg"){
   	   $thumb = imagecreatetruecolor(90, 90);       $source = imagecreatefromjpeg($url);       $red = imagecolorallocate($thumb, 255, 255, 255);       imagefill($thumb, 0, 0, $red);    }    elseif($tipo == "png"){   	   $thumb = imagecreatetruecolor(90, 90);       $source = imagecreatefrompng($url);        $red = imagecolorallocate($thumb, 255, 255, 255);       imagefill($thumb, 0, 0, $red);    }       // Resize    if(!@imagecopyresized($thumb, $source, 0, 0, $margin_rigth, 0, $newwidth, $newheight, $width, $height) ) return '';    // Output    @imagepng($thumb,$path_br_thumbs."$idPost.png", 9);  }
function blogR_getURLThumb($idPost, $post){	if(file_exists(blogR_getRootWP()."/wp-content/uploads/br_thumbs/$idPost.png"))
    return get_option('siteurl')."/wp-content/uploads/br_thumbs/$idPost.png";
    return '';
}
function blogR_getRootWP(){	$arr = explode('wp-content',__FILE__);     $root = $arr[0];     $r = explode('/',$root);    if(count($r) == 1){        $root = str_replace("\\","/",$root);    }    return $root;}
?>