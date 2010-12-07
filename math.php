<?php

    class Math {

         public function __construct() {}

         public function __destruct() {}

         public function cmmdc($a,$b) {

                while($b) {
                   $r = $a%$b;
                   $a = $b;
                   $b = $r;   
                } 

            return $a;
         }

         public function submult($n) {
                $out = "";           
                $vec = array();
                for($i=0;$i<$n;$i++) {
                    $vec[$i] = 0; 
                }      
                do {
                   $vec[$n-1]++;
                   for($j=$n-1;$j>=1;$j--) {

                       if($vec[$j] > 1) {
                          $vec[$j] -= 2;
                          $vec[$j-1] += 1;                            
                       } 
                   }   
                   $s = 0;
                   for($i=0;$i<$n;$i++) {
                     if($vec[$i]){ 
                        $s++;
                     }
                   }
                   for($k=$n-1;$k>=0;$k--) {
                       if($vec[$k]) {
                          $out .= ($k+1) . ' ';
                       }  
                   } 
                     $out .= "\n"; 
                }while($s<$n);

            return nl2br($out);
         }

         public function eratosthenes($n) {
                $stack = array();
                $arr = array();
                for($i=2;$i<=$n;$i++) {
                    $stack[$i] = 1;
                } 

                for($j=2;($j*$j)<=$n;$j++) {
                    if($stack[$j]) {
                       $k = 2;
                       while(($j*$k)<=$n) {
                          $stack[$j*$k] = 0;
                          $k++;
                       }//endwhile
                    }//endif                
                }//endfor

                for($i=2;$i<$n;$i++) {
                    if($stack[$i]) {
                       array_push($arr,$i);  
                    }
                }
            return $arr;
         }

         public function toBin($n) {
             $out = ''; 
             for($i=15;$i>=0;$i--) {
                 $out .= (($n>>$i)&1) . '';
             } 
           return $out;
         }


         public function bubblesort($arr) {
                if(func_num_args() > 1) {$arr =  func_get_args();}
                $n = sizeof($arr);
                do {
                    $sorted = false;
                    for($i=$n;$i>=0;$i--) {
                        for($j=0;$j<$i-1;$j++) {
                            if($arr[$j]>$arr[$j+1]) {
                                $aux = $arr[$j];
                                $arr[$j] = $arr[$j+1];
                                $arr[$j+1] = $aux;
                                $sorted = true;  
                            }  
                        }
                    }
                }while($sort);
            return $arr; 
         }

         public function deliciousbadge($username='thinkphp',$amount=10,$tag='') {  
            if(empty($tag)) { 
               $url = 'http://feeds.delicious.com/v2/json/'. $username . '?count=' . $amount;
            } else {
               $url = 'http://feeds.delicious.com/v2/json/'. $username . '/'.$tag.'?count=' . $amount;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($output);
            $ul = '<ul>';
            foreach($data as $del) {
                $ul .= '<li><a href="'. $del->u . '">' . $del->d. '</a></li>';
            }
            $ul .= '</ul>';
            return($ul);
         } 

         public function produit_cartesien($cards) {
            if(func_num_args() > 1) {$cards =  func_get_args();}
            $n = sizeof($cards);
            $v = array();
            for($i=0;$i<$n;$i++) {
                $v[$i] = 1;  
            } 
            $out = '';
            do {              
               for($k=0;$k<$n;$k++) {
                  $out .= $v[$k].' ';
               }      
               $out .= " \n ";
               $i = $n-1;
               while($i>=0) { 
                   if($v[$i]==$cards[$i]) {
                     $v[$i] = 1;
                     $i--; 
                   } else {
                     $v[$i]++;
                     $i = -2; 
                   }  
              }

            }while($i!=-1); 
           return nl2br($out);
         }

         public function getTweets($username,$amount=5,$linkify=false) {
            $api = 'http://twitter.com/statuses/user_timeline/' . $username . '.json?count=' . $amount;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $tweets = json_decode($output);
            $out = '<ul>';             
            foreach($tweets as $tweet) {
                if($linkify) { 
                   $tweet = preg_replace("/(https?:\/\/[\w\-:;?&=+.%#\/]+)/i", '<a href="$1">$1</a>',$tweet->text);
                   $tweet = preg_replace("/(^|\W)@(\w+)/i", '$1@<a href="http://twitter.com/$2">$2</a>',$tweet);
                   $tweet = preg_replace("/(^|\W)#(\w+)/i", '$1#<a href="http://search.twitter.com/search?q=%23$2">$2</a>',$tweet);
                   $out .= '<li>'.$tweet.'</li>';
                } else {
                   $out .= '<li>'.$tweet->text.'</li>';
                }
            }  
            $out .= '</ul>'; 
           return($out);
         }
    }
   
?>