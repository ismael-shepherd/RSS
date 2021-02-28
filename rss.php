<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>RSS</title>
</head>
<body class="p-4">
<div class="content">

<form method="post" action="">
 <input type="text" name="feedurl" placeholder="Enter website feed URL">&nbsp;<input type="submit" value="Submit" name="submit">
</form>
<?php

$url = "https://news.google.com/rss/search?q=psg&hl=fr&gl=FR&ceid=FR%3Afr";
if(isset($_POST['submit'])){
  if($_POST['feedurl'] != ''){
    $url = $_POST['feedurl'];
  }
}

$invalidurl = false;
if(@simplexml_load_file($url)){
 $feeds = simplexml_load_file($url);
}else{
 $invalidurl = true;
 echo "<h2>Invalid RSS feed URL.</h2>";
}


$i=0;
if(!empty($feeds)){

 $site = $feeds->channel->title;
 $sitelink = $feeds->channel->link;

 echo "<h1>".$site."</h1>";
 foreach ($feeds->channel->item as $item) {

  $title = $item->title;
  $link = $item->link;
  $description = $item->description;
  $postDate = $item->pubDate;
  $pubDate = date('D, d M Y',strtotime($postDate));


  if($i>=10) break;
 ?>
  <div class="post">
    <div class="post-head">
      <h2><a class="feed_title" href="<?php echo $link; ?>"><?php echo $title; ?></a></h2>
      <span><?php echo $pubDate; ?></span>
    </div>
    <div class="post-content">
      <?php echo implode(' ', array_slice(explode(' ', $description), 0, 20)) . "..."; ?> <a href="<?php echo $link; ?>">Read more</a>
    </div>
  </div>

  <?php
   $i++;
  }
}else{
  if(!$invalidurl){
    echo "<h2>No item found</h2>";
  }
}
?>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>