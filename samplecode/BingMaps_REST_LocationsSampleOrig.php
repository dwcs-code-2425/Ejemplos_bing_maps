<html>  
  <head>  
    <title>Using PHP and Bing Maps REST Services APIs</title>  
  </head>  
  <body>  
    <form action="BingMaps_REST_LocationsSampleOrig.php" method="post">  
      Bing Maps Key: <input type="text" name="key" value="<?php echo (isset($_POST['key'])?$_POST['key']:'') ?>"><br>  
        Street Address: <input type="text" name="address" value="<?php echo (isset($_POST['address'])?$_POST['address']:'') ?>"><br>  
          City: <input type="text" name="city" value="<?php echo (isset($_POST['city'])?$_POST['city']:'') ?>"><br>  
            State: <input type="text" name="state" value="<?php echo (isset($_POST['state'])?$_POST['state']:'') ?>"><br>  
              Zip Code: <input type="text" name="zipcode" value="<?php echo (isset($_POST['zipcode'])?$_POST['zipcode']:'') ?>"><br>  
                Query: <input type="text" name="query" value="<?php echo (isset($_POST['query'])?$_POST['query']:'') ?>"><br>  
                  <input type="submit" value="Submit">  
  </form>  
<?php  
  
if(isset($_POST['key']) &&   
     ( isset($_POST['address']) || isset($_POST['city']) || isset($_POST['state']) || isset($_POST['zipcode']) || isset($_POST['query']) ))  
  {  
  // URL of Bing Maps REST Locations API;   
    $baseURL = "http://dev.virtualearth.net/REST/v1/Locations";  
  
  // Set key based on user input  
  $key = $_POST['key'];  
  
  if ($_POST['query']!= "")//if query value is provided, find location using query  
  {  
   // Create URL to find a location by query  
    $query = str_ireplace(" ","%20",$_POST['query']);  
    $findURL = $baseURL."/".$query."?output=xml&key=".$key;  
  }  
  else //if query value is not provided, find location using specified US address values  
    // Create a URL to find a location by address  
  {  
    $country = "US";  
    $addressLine = str_ireplace(" ","%20",$_POST['address']);  
    $adminDistrict = str_ireplace(" ","%20",$_POST['state']);  
    $locality = str_ireplace(" ","%20",$_POST['city']);  
    $postalCode = str_ireplace(" ","%20",$_POST['zipcode']);    
    // Construct final URL for call to Locations API  
    $findURL = $baseURL."/".$country."/".$adminDistrict."/".$postalCode."/".$locality."/".$addressLine."?output=xml&key=".$key;  
  }  
  
   // Get output from URL and convert to XML element using php_xml  

  $output = file_get_contents($findURL);  
   $response = new SimpleXMLElement($output);  
  
  // Extract and pring latitude and longitude coordinates from results  
  $latitude = $response->ResourceSets->ResourceSet->Resources->Location->Point->Latitude;  
  $longitude = $response->ResourceSets->ResourceSet->Resources->Location->Point->Longitude;  
  
  echo "Latitude: ".$latitude."<br>";  
  echo "Longitude: ".$longitude."<br>";  
  
  // Display the location on a map using the Imagery API  
  $imageryBaseURL = "http://dev.virtualearth.net/REST/v1/Imagery/Map";  
  
  $imagerySet = "Road";  
  $centerPoint = $latitude.",".$longitude;  
  $pushpin = $centerPoint.";4;ID";  
  $zoomLevel = "15";  
  
  echo "<img src='".$imageryURL = $imageryBaseURL."/".$imagerySet."/".$centerPoint."/".$zoomLevel."?pushpin=".$pushpin."&key=".$key."'>";  
  
}  
else  
{  
  echo "<p>Please enter your Bing Maps key and complete all address fields for a US address or the Query field, then click submit.</p>";  
}  
?>  
</body>  
</html>