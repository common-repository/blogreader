<?php
function blogR_http_post($request, $host, $path, $port = 80, $ip=null) {
	$http_request  = "POST $path HTTP/1.0\r\n";
	$http_host = $host;
	if( false != ( $fs = @fsockopen($http_host, $port, $errno, $errstr, 10) ) ) {

function blogR_setLogotipo($url_img){
	if(strlen($url_img) == 0){
	elseif(strlen($url_img) > 0 && strtolower($extensao) != "jpg" && strtolower($extensao) != "png"){
function blogR_getFirstImage($post,$get_url=false,$size=array(90,90)){
	if(strlen($post) > 0  && is_array($size)){     
     if(!@$dom->loadHTML($post)){
     $items = $dom->getElementsByTagName("img");  
     if($items->length > 0){
         if($get_url)return $urlImg;            
         $w =  $atributos->getNamedItem('width')->nodeValue; 
         if($img[0] == '' || $img[1] == ''){
            if($img[0] > $size[0]){        
//Functions for thumb
   if(!is_dir($path_br_thumbs)){   
   $tipo = $tipo[count($tipo)-1];
   if(!@getimagesize($url)){
   if($width >= $height && $height > 0){
   // Load
   	   $thumb = imagecreatetruecolor(90, 90);
function blogR_getURLThumb($idPost, $post){
    return get_option('siteurl')."/wp-content/uploads/br_thumbs/$idPost.png";
    return '';
}
function blogR_getRootWP(){
?>