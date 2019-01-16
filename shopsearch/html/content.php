
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"> 
  
    <meta charset="UTF-8"> 
    
    <script type="text/javascript"> 
  function goBack(){ 
      window.history.back(); 
  } 
</script> 
    
        <div class="container" > 
<div class="row" style="padding:20px;"> 
<button type="submit" class="btn btn-default" value="다시검색" onclick="goBack();" >다시검색</button> 
<p> 


<?php 
@header("Cache-Control:no-cache, must-revalidate"); 
@header("Content-Type: text/html; charset=utf-8"); 
class NaverProxy { 
 public function queryNaver($query, $target) { 
 $client_id = "UIMqSTRMASTzP5SgXW8s"; 
 $client_secret = "Rj1D1ge4gk"; 
 $query=urlencode($_POST['aa']); 
 $target="shop"; 
 $url = "https://openapi.naver.com/v1/search/shop.xml"; 
 $url = sprintf("%s?query=%s&display=50&start=1&sort=sim&target=shop", $url, $query); 
 $is_post = true; 
 $ch = curl_init(); 
 curl_setopt($ch, CURLOPT_URL, $url); 
// curl_setopt($ch, CURLOPT_GET, $is_post); 
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
 $headers = array(); 
 $headers[] = "X-Naver-Client-Id: ".$client_id; 
 $headers[] = "X-Naver-Client-Secret: ".$client_secret; 
 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); 
 $data = curl_exec ($ch); 
 curl_close ($ch); 
 return $data; 
  } 
} 
$naverproxy = new NaverProxy(); 
// XML파일에서 원하는 항목만 추출하기 http://search.naver.comNaver Search ResultThu, 25 Jan 2018 13:05:39 +09001764410110 
//echo $naverproxy -> queryNaver($_POST['query'], $_POST['target']); 
$xmlstring = $naverproxy -> queryNaver($_POST['query'], $_POST['target']); 
$xml = simplexml_load_string($xmlstring) or die("에러: 객체를 생성할 수 없습니다"); 
$items = $xml->channel->item; 
if(!empty($items)){ 
foreach($items as $item){  
    echo ' 
    <div class="panel panel-default"> 
  <div class="panel-heading"><h3><b><a href="' . $item->link . '" target="_blank">'. $item->title . ' </a></b></h3></div> 
  <br> 
  <div class="row"> 
  <div class="col-md-4" style="text-align: center;"> <a href="' . $item->link . '" target="_blank"><img src='. $item->image . ' width="100px" height="100px" /></a></div> 
  <div class="col-md-8"> <h4>쇼핑몰: <a href="' . $item->link . '">'.$item->mallName. '</a></h4> 
      <!--<h4>아이디: '. $item->productId . '</h4>--> 
      <h4>가격: '. $item->lprice. '원</h4> 
      </div> 
</div> 
              <br> 
              </div> 
              '      
      ; 
} 
} 
                      
?> 

  </div> 
</div>

