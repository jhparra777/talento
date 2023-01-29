<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleShortUrl extends Model
{
    // Constructor
 function __construct($key, $apiURL = 'https://www.googleapis.com/urlshortener/v1/url'){
  $this->apiURL = $apiURL.'?key='.$key;
 }
  
 // Acortar la URL
 function shorten($url) {
  $response = $this->send($url);
  return isset($response['id']) ? $response['id'] : false;
 }
  
 // Expandir la URL
 function expand($url) {
  $response = $this->send($url, false);
  return isset($response['longUrl']) ? $response['longUrl'] : false;
 }
  
 // Enviar información a Google
 function send($url, $shorten = true){
 
  // Inicializamos curl y definimos el objeto
  $curlObj = curl_init();
  if ($shorten){
   curl_setopt($curlObj, CURLOPT_URL, $this->apiURL);
   curl_setopt($curlObj, CURLOPT_POST, 1);
   curl_setopt($curlObj, CURLOPT_POSTFIELDS, json_encode(array("longUrl"=>$url)));
   curl_setopt($curlObj, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
  } else {
   curl_setopt($curlObj, CURLOPT_URL, $this->apiURL.'&shortUrl='.$url);
  }
  curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($curlObj, CURLOPT_HEADER, 0);
   
  // Ejecutamos el post
  $response = curl_exec($curlObj);
 
  // Cerramos la conexión
  curl_close($curlObj);
   
  // Devolvemos la respuesta
  return json_decode($response, true);
 }  
}
