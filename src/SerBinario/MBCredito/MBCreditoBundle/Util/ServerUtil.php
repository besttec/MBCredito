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
        $ch = curl_init();        
        $cookie = realpath($cookie);
   
        curl_setopt($ch, CURLOPT_URL,$url);  
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0 FirePHP/0.7.4');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIE, 1);
        curl_setopt($ch, CURLOPT_COOKIESESSION, FALSE);
        curl_setopt($ch, CURLOPT_COOKIEJAR,$cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
        curl_setopt($ch, CURLOPT_REFERER, $url);
        
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
        $ch = curl_init();      
        $cookie = realpath($cookie);
        
        curl_setopt ($ch, CURLOPT_URL, $url); 
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
        curl_setopt ($ch, CURLOPT_TIMEOUT, 5); 
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_COOKIESESSION, FALSE);
        curl_setopt ($ch, CURLOPT_COOKIEJAR, $cookie); 
        curl_setopt ($ch, CURLOPT_COOKIEFILE, $cookie);       
        curl_setopt ($ch, CURLOPT_REFERER, $url); 

        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata); 
        curl_setopt ($ch, CURLOPT_POST, true); 
        
        $result = curl_exec($ch); 
        
        return $result;
    }
}
