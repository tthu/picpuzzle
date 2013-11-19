

 <?php

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
$boxPX = $_POST['boxsize'];
$winX = $_POST['width'];
$winY = $_POST['height'];

if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 2000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
    }
  }
else
  {
    echo "invalid";
}

//Set save details
$original_image = $_FILES['file']['tmp_name'];
$size=GetImageSize( $original_image );
$new_Name = str_replace(" ", "", $_FILES["file"]["name"]);
$new_image = "images/" . $new_Name;

//resize larger image down to fit on screen and save
exec("convert $original_image -thumbnail x$winY $new_image");

$newURL = "http://picpuzzle.dkteacherswiki.com/images/" . $new_Name;

//get new size
list($width, $height) = getimagesize($new_image);

//set box configuration
switch ($boxPX)
{
  case "9":
    $xBox = "3";
    $yBox = "3";
  case "12":
    if ($width > $height)
    {
      $xBox = "4";
      $yBox = "3";
      break;
    }
    else
    {
      $xBox = "3";
      $yBox = "4";
      break;
    }
  case "16":
    $xBox = "4";
    $yBox = "4";
    break;
  case "20":
    if ($width > $height)
    {
      $xBox = "5";
      $yBox = "4";
      break;
    }
    else
    {
      $xBox = "4";
      $yBox = "5";
      break;
    }
 
  case "25":
    $xBox = "5";
    $yBox = "5";
    break;

  case "30":
    if ($width > $height)
    {
      $xBox = "6";
      $yBox = "5";
      break;
    }
    else
    {
      $xBox = "5";
      $yBox = "6";
      break;
    }
   case "36":
    $xBox = "6";
    $yBox = "6";
    break;

  case "42":
    if ($width > $height)
    {
      $xBox = "7";
      $yBox = "6";
      break;
    }
    else
    {
      $xBox = "6";
      $yBox = "7";
      break;
    }
  case "49":
    $xBox = "7";
    $yBox = "7";
    break;

 case "56":
    if ($width > $height)
    {
      $xBox = "8";
      $yBox = "7";
      break;
    }
    else
    {
      $xBox = "7";
      $yBox = "8";
      break;
    }
  case "64":
    $xBox = "8";
    $yBox = "8";
    break;

 case "72":
    if ($width > $height)
    {
      $xBox = "9";
      $yBox = "8";
      break;
    }
    else
    {
      $xBox = "8";
      $yBox = "9";
      break;
    }
  case "81":
    $xBox = "9";
    $yBox = "9";
    break;

 case "90":
    if ($width > $height)
    {
      $xBox = "10";
      $yBox = "9";
      break;
    }
    else
    {
      $xBox = "9";
      $yBox = "10";
      break;
    }
  case "100":
    $xBox = "10";
    $yBox = "10";
    break;

  default:
      $xBox = "7";
      $yBox = "7";

}

$boxH = round($height / $yBox)+3;
$boxW = round($width / $xBox)+3;

$pageStart = "<!doctype html>
<html>
<head>
<style type=\"text/css\">
body {
background: no-repeat url('{$newURL}');
}
.wrapper {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background: none;
    overflow: hidden;
}
.box,
.box div {    
    background: none;
    float:left;
    clear:none;
}
.box div {
    background: #ccf;
    border-style:solid;
    text-align:center;
    line-height: {$boxH}px;  
    vertical-align:middle;
    font-size: 2em;
}    


#footer
{
    clear: both;
    border: 1px groove #aaaaaa;
    background: #6cf;
    color: White;
    padding: 0;
    text-align: center;
    vertical-align: middle;
    line-height: normal;
    margin: 0;
    position: absolute;
    bottom: 0px;
    width: 100%;
    height: 40px;
}

</style>
<title>Hidden Puzzle</title>
<script src=\"http://code.jquery.com/jquery-latest.min.js\"></script>
<script type=\"text/javascript\">
$(function() {

    $('#showall').click(function() {
      $('.box').fadeOut('fast');
    });

    var box_height = {$boxH},
        box_width = {$boxW},
        wrapper = $('.wrapper'),
        x = Math.ceil( {$width}/box_width ),
        y = Math.ceil( {$height}/box_height ),
        html = '';
    
    for(var i = $('.box', wrapper ).length; i < x*y; i++)
        html += '<div class=\"box\"><div>'+i+'</div></div>';
        
    
    wrapper.html('<div class=\"inner\">'+html+'</div>');
    
    $('.inner', wrapper ).css({
        'width' : x*box_width ,
        'height' : y*box_height ,
        'overflow': 'visible'
    });
    
    $('.box,.box>div', wrapper ).css({
        'width': box_width,
        'height': box_height
    });
    
    $('.box', wrapper ).click(function(){ 
        $(this).children().fadeOut('slow'); });
    });



</script>


</head>
<body>
<div class=\"wrapper\"></div>


<div class=\"footer\" id=\"footer\">
<button id=\"showall\" name=\"showall\" style=\"height:30px; width:150px\">Clear All Tiles</button>
<button onclick=\"window.location='http://picpuzzle.dkteacherswiki.com'\" style=\"height:30px; width:190px\">Create New Puzzle</button>

</div>
</body>

</html>";


print $pageStart;
exit;

?>
