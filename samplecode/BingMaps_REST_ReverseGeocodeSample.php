<html>  
  <head>  
    <title>Using PHP and Bing Maps REST Services Locations API</title>  
  </head>  
  <body>  
    <form action="BingMaps_REST_ReverseGeocodeSample.php" method="post">  
      Bing Maps Key: <input type="text" name="key" value=""<?php echo (isset($_POST['key'])?$_POST['key']:'') ?>"><br>  
        Latitude: <input type="text" name="latitude" value=""<?php echo (isset($_POST['latitude'])?$_POST['latitude']:'') ?>"><br>  
          Longitude: <input type="text" name="longitude" value=""<?php echo (isset($_POST['longitude'])?$_POST['longitude']:'') ?>"><br>  
            <input type="submit" value="Submit">  
  </form>  
<?php  
// Reverse geocode a location by point  
if(isset($_POST['key']) && isset($_POST['latitude']) && isset($_POST['longitude']))  
{  
  
  // Set key based on user input  
  $key = $_POST['key'];   
  $latitude = $_POST['latitude'];  
  $longitude = $_POST['longitude'];  
  
  // URL of Bing Maps REST Locations API;   
  $baseURL = "http://dev.virtualearth.net/REST/v1/Locations";  
  $revGeocodeURL = $baseURL."/".$latitude.",".$longitude."?output=xml&key=".$key;  
  
   $rgOutput = file_get_contents($revGeocodeURL);  
  $rgResponse = new SimpleXMLElement($rgOutput);  
  
  $address= $rgResponse->ResourceSets->ResourceSet->Resources->Location->Address->FormattedAddress;  
  echo $address;  
  }  
else  
{  
  echo "<p>Please enter your Bing Maps key and a latitude and longitude pair, then click Submit.</p>";  
}  
  
?>  
</body>  
</html>