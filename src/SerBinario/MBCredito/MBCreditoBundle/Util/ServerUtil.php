<?php
namespace SerBinario\MBCredito\MBCreditoBundle\Util;

/**
 * Description of ServerUtil
 *
 * @author andrey
 */
class ServerUtil
{
   
    /**
     * 
     * @param type $url
     * @return type
     */
    public static function open($url, $cookie = "cookie.txt")
    {
        $ch        = curl_init();       
        $cookie    = realpath($cookie);
        
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'Accept-Language: en-US,en;q=0.5';                

        curl_setopt($ch, CURLOPT_URL,$url);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0 FirePHP/0.7.4');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt ($ch, CURLOPT_REFERER, $url);
        $result = curl_exec($ch);  
  
        curl_close($ch);

        return $result;
    }
    
    /**
     * 
     * @param type $url
     * @param type $postdata
     * @param type $cookie
     * @return type
     */
    public static function submit($url, $postdata, $cookie = "cookie.txt")
    {
        $ch        = curl_init();      
        $cookie    = realpath($cookie);
        
        $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        $headers[] = 'x-insight: activate';
        $headers[] = 'Accept-Language: en-US,en;q=0.5';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        $headers[] = 'Connection: keep-alive';
        $headers[] = 'Accept-Encoding: deflate';

        curl_setopt ($ch, CURLOPT_URL, $url); 
        curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0 FirePHP/0.7.4"); 
        curl_setopt ($ch, CURLOPT_TIMEOUT, 60); 
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
        curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);  // <-- add this line
        curl_setopt ($ch, CURLOPT_REFERER, $url); 

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
        curl_setopt ($ch, CURLOPT_POST, true);
        
        $result = curl_exec ($ch); 
        
        return $result;
    }
}
