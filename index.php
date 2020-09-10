<html>
<head>
<script src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

function validate()
{

  var street=document.getElementById('street').value;
  var city=document.getElementById('city').value;
  var state=document.getElementById('state').value;

  if(street.length==0 || city.length==0 || state.length==0)
  {
    document.getElementById("display").innerHTML="<div class='errormessage'> Please check the input address </div>";
  } else {
  const xmlhttprequest = new XMLHttpRequest();
  xmlhttprequest.onreadystatechange = function() {
    if( xmlhttprequest.readyState==4 && xmlhttprequest.status==200 ){
       document.getElementById('display').innerHTML=xmlhttprequest.responseText;
    }
  };
  xmlhttprequest.open("POST", "" , false);
  xmlhttprequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttprequest.send("street="+street+"&city="+city+"&state="+state);
  }
}
function clear_data()
{
   document.getElementById('street').value='';
   document.getElementById('city').value='';
   document.getElementById('state').value='';
   document.getElementById('display').innerHTML='';
   document.getElementById("location").checked = false;
   document.getElementById("street").disabled = false;
   document.getElementById("city").disabled = false;
   document.getElementById("state").disabled = false;
}

function retrieveCurrentLocationForecast(current_latitude,current_longitude,city)
{
  const xmlhttprequest = new XMLHttpRequest();
  xmlhttprequest.onreadystatechange = function() {
    if( xmlhttprequest.readyState==4 && xmlhttprequest.status==200 ){
       document.getElementById('display').innerHTML=xmlhttprequest.responseText;
    }
  };
  xmlhttprequest.open("POST", "" , false);
  xmlhttprequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xmlhttprequest.send("latitude="+current_latitude+"&longitude="+current_longitude+"&city="+city);
}

function currentLocation()
{
  var checkBox = document.getElementById("location");
  if (checkBox.checked == true) {
  document.getElementById("street").disabled = true;
  document.getElementById("city").disabled = true;
  document.getElementById("state").disabled = true;

  const xmlhttprequest = new XMLHttpRequest();
  xmlhttprequest.onreadystatechange = function() {
    if( xmlhttprequest.readyState==4 && xmlhttprequest.status==200 ){
        var json_obj = JSON.parse(xmlhttprequest.responseText);
        var current_latitude=json_obj.lat;
        var current_longitude=json_obj.lon;
        var city=json_obj.city;
        retrieveCurrentLocationForecast(current_latitude,current_longitude,city);
    }
  };
  xmlhttprequest.open("GET", "http://ip-api.com/json" , false);
  xmlhttprequest.send();
  }
  else {
    document.getElementById("street").disabled = false;
    document.getElementById("city").disabled = false;
    document.getElementById("state").disabled = false;
  }
}

function daily_forecast_check(latitude, longitude, time, timezone, dark_sky_api_key)
{
  const xmlhttprequest = new XMLHttpRequest();
  xmlhttprequest.onreadystatechange = function() {
    if( xmlhttprequest.readyState==4 && xmlhttprequest.status==200 ){
        document.getElementById('display').innerHTML=xmlhttprequest.responseText;
    }
  };
  xmlhttprequest.open("POST","",false);
  xmlhttprequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded; charset=UTF-8");
  xmlhttprequest.send("latitude="+latitude+"&longitude="+longitude+"&time="+time+"&timezone="+timezone);
}

function get_line_chart(json_content)
{
   var col = document.getElementById('collapsearrow');
   col.classList.toggle("active");
   var content = document.getElementById('line_chart')
   if (content.style.display === "block") {
     content.style.display = "none";
   } else {
     content.style.display = "block";

  json_string=json_content;
  google.charts.load('current', {packages: ['corechart', 'line']});
  google.charts.setOnLoadCallback(drawScales)

  function drawScales() {

   var data = new google.visualization.DataTable();
    data.addColumn('number', 'X');
    data.addColumn('number', 'T');

   console.log(json_string.length);

   var hour_array = new Array(json_string.length);

   for (var i = 0; i < hour_array.length; i++) {
         hour_array[i]=new Array(json_string[i]);
         data.addRow(hour_array[i][0]);
         console.log(hour_array[i][0]);
    }

    var options = {
        hAxis: {
          title: 'Time',
          logScale: false,
          ticks: [0, 5, 10, 15, 20],
          minValue: 0,
          maxValue: 23
        },
        vAxis: {
          title: 'Temperature',
          logScale: false,
          textPosition: 'none'
        },
        curveType: 'function',
        colors: ['#98EEF7'],
        height: 200,
        width: 700
      };

  var view = new google.visualization.DataView(data);
  view.setRows(data.getSortedRows({column: 0, desc: true}));
  var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
  chart.draw(view, options);
   }
 }
}

function comparator(a, b) {
  if (a[0] < b[0]) return -1;
  if (a[0] > b[0]) return 1;
  return 0;
}

</script>

<style>

.coloredmainbox{
    background-color: green ;
    padding: 10px ;
    display: inline-block;
    border-radius: 15px 15px;
    height: 180px;
    width: 700px;
    align: center;
    color:white;
    margin-left: 400px;
}

.colored_current_box{
    background-color: #01C3FE;
    display: inline-block;
    border-radius: 10px 10px;
    height: 260px;
    padding:0px 10px;
    width: 350px;
    align: center;
    color:white;
    margin-left: 580px;
    margin-top: 50px;
    line-height:1px;
}
.colored_daily_box{
    background-color: #93CBDF;
    display: inline-block;
    border-radius: 10px 10px;
    height: 400px;
    padding:0px 10px;
    width: 500px;
    align: center;
    color:white;
    margin-left: 500px;
    margin-top:0;
    line-height:1px;
}

.inputbox{
  width: 150px;
  margin-left: 10px;
  height: 20px;
  font-size: 12px;
}

.selectboxstyle select{
  width: 225px;
  margin-left: 5px;
  height: 17px;
  line-height:normal;
  font-size: 12px;
  border: 0;
}

select:focus
{
  outline:none;
}

.selectboxelement{
  line-height:normal;
  font-size: 12px;
  border: 0;
}

.formfix {
  margin-left:30px;
  font-weight: bold;
  font-size:15px;
}
.col1 {
    position: relative;
    width: 50%;
    float: left;
    z-index: 1;
}
.col2 {
    position: relative;
    width: 10%;
    float: left;
    z-index: 1;
}
.coldaily1 {
    position: relative;
    width: 50%;
    float: left;
    z-index: 1;
}
.coldaily1 {
    position: relative;
    width: 50%;
    float: left;
    z-index: 1;
}
.vl {
  margin-top: 10px;
  border-left: 3px solid white;
  height: 100px;
}
.displaytitle {
  text-align: center;
  font-size: 30px;
  margin-top:0px;
  color:white;
  font-style: italic;
}
.dailytableimageresizer{
  height:30px;
  width:30px;
}
.imageresizer{
  height:20px;
  width:20px;
}
.dailytable{
  text-align: center;
  padding: 5px;
  margin-top: 50px;
  margin-left: 400px;
  color:white;
  font-weight: bold;
  font-size:18px;
  border-color:#4096F9;
  border-style: solid;
  border-width:medium;
  text-align:center;
  background-color: #88BEFD;
  border-collapse: collapse;
}
.hidebutton
{
  border: none;
  background: none;
  font-size:17px;
  font-weight: bold;
  color:white;
  cursor: pointer;
}
.currenttable {
  padding: 7px;
  text-align: center;
  color:white;
  font-weight: bold;
  font-size:20px;
}
.dailyweathertable {
  padding: 7px;
  text-align: right;
}

.cityp
{
font-size:30px;
font-weight:bold;
}

.errormessage
{
  width: 350px;
  margin-top: 20px;
  background-color: #e9e5e5;
  height: 20px;
  border: 2px solid #808080;
  margin-left: 600px;
  text-align: center;
}

.timezonep
{
  font-weight:bold;
  font-size:15px;
}

.temperaturep{
  font-weight:bold;
  font-size:50px;

}
.summaryp
{
  font-weight:bold;
  font-size:25px;
}
.arrow-down {
  width: 50px;
  height: 50px;
  position:relative;
  margin-left: 750px;

}

.arrow-down.active
{
  background: white;
}

.arrow-down:before, .arrow-down:after {
  content: "";
  display: block;
  width: 20px;
  height: 5px;
  background: black;
  position: absolute;
  top: 20px;
  transition: .5s;
}

.arrow-down:before {
  right: 21px;
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
  transform: rotate(45deg);
}

.arrow-down:after {
  right: 10px;
  transform: rotate(-45deg);
}

.arrow-down.active:before {
  transform: rotate(-45deg);
}

.arrow-down.active:after {
  transform: rotate(45deg);
}

.daily_details {

  font-size: 22px;
  font-weight:bold;
  margin-left: 180px;
  line-height: 15px;
  margin-top: 40px;
  color:white;

}
.dailyiconimageresizer{
  height: 150px;
  width: 150px;
  margin-top: 20px;
  margin-left: 50px;
}

</style>
</head>
<body>

<?php if(!($_SERVER['REQUEST_METHOD'] == 'POST')): ?>

<div class="coloredmainbox">
  <div class="displaytitle"> Weather Search </div>
  <div class="col1">
  <form class="formfix">
  Street  <input type="text" name="street" id="street" class="inputbox"> <br> <br>
  City   <input type="text" name="city" id="city" style='margin-left:20px' class="inputbox"> <br> <br>
  State
  <div class="selectboxstyle" style="display:inline">
  <select name="state" id="state">
    <option class='selectboxelement' value="state"> State </option>
    <option class='selectboxelement' > --------------------------------------------------- </option>
  	<option class='selectboxelement' value="AL">Alabama</option>
  	<option class='selectboxelement' value="AK">Alaska</option>
  	<option class='selectboxelement' value="AZ">Arizona</option>
  	<option class='selectboxelement' value="AR">Arkansas</option>
  	<option class='selectboxelement' value="CA">California</option>
  	<option class='selectboxelement' value="CO">Colorado</option>
  	<option class='selectboxelement' value="CT">Connecticut</option>
  	<option class='selectboxelement' value="DE">Delaware</option>
  	<option class='selectboxelement' value="DC">District Of Columbia</option>
  	<option class='selectboxelement' value="FL">Florida</option>
  	<option class='selectboxelement' value="GA">Georgia</option>
  	<option class='selectboxelement' value="HI">Hawaii</option>
  	<option class='selectboxelement' value="ID">Idaho</option>
  	<option class='selectboxelement' value="IL">Illinois</option>
  	<option class='selectboxelement' value="IN">Indiana</option>
  	<option class='selectboxelement' value="IA">Iowa</option>
  	<option class='selectboxelement' value="KS">Kansas</option>
  	<option class='selectboxelement' value="KY">Kentucky</option>
  	<option class='selectboxelement' value="LA">Louisiana</option>
  	<option class='selectboxelement' value="ME">Maine</option>
  	<option class='selectboxelement' value="MD">Maryland</option>
  	<option class='selectboxelement' value="MA">Massachusetts</option>
  	<option class='selectboxelement' value="MI">Michigan</option>
  	<option class='selectboxelement' value="MN">Minnesota</option>
  	<option class='selectboxelement' value="MS">Mississippi</option>
  	<option class='selectboxelement' value="MO">Missouri</option>
  	<option class='selectboxelement' value="MT">Montana</option>
  	<option class='selectboxelement' value="NE">Nebraska</option>
  	<option class='selectboxelement' value="NV">Nevada</option>
  	<option class='selectboxelement' value="NH">New Hampshire</option>
  	<option class='selectboxelement' value="NJ">New Jersey</option>
  	<option class='selectboxelement' value="NM">New Mexico</option>
  	<option class='selectboxelement' value="NY">New York</option>
  	<option class='selectboxelement' value="NC">North Carolina</option>
  	<option class='selectboxelement' value="ND">North Dakota</option>
  	<option class='selectboxelement' value="OH">Ohio</option>
  	<option class='selectboxelement' value="OK">Oklahoma</option>
  	<option class='selectboxelement' value="OR">Oregon</option>
  	<option class='selectboxelement' value="PA">Pennsylvania</option>
  	<option class='selectboxelement' value="RI">Rhode Island</option>
  	<option class='selectboxelement' value="SC">South Carolina</option>
  	<option class='selectboxelement' value="SD">South Dakota</option>
  	<option class='selectboxelement' value="TN">Tennessee</option>
  	<option class='selectboxelement' value="TX">Texas</option>
  	<option class='selectboxelement' value="UT">Utah</option>
  	<option class='selectboxelement' value="VT">Vermont</option>
  	<option class='selectboxelement' value="VA">Virginia</option>
  	<option class='selectboxelement' value="WA">Washington</option>
  	<option class='selectboxelement' value="WV">West Virginia</option>
  	<option class='selectboxelement' value="WI">Wisconsin</option>
  	<option class='selectboxelement' value="WY">Wyoming</option>
  </select>
  </div>
  <br> <br>
  <div style="margin-left: 200px">
  <button type="button" style="border-radius: 5px" onclick="validate()" name="submit"> search </button>
  <button type="button" style="border-radius: 5px" value="clear" onclick="clear_data()"> clear </button>
  </div>
  </form>
  </div>
  <div class="col2">
     <div class="vl"> </div>
  </div>
  <div class="col3">
      <form action="" method="post">
        Current Location
        <input type="checkbox" id="location" name="currentlocation" onclick="currentLocation()"> </input>
      </form>
  </div>
</div>

<?php else: ?>

<?php
    $Dark_Sky_API_Key = "";

    function displayTableContent($latitude,$longitude,$city){
      $Dark_Sky_API_Key = "";
      $forecast = $latitude.','.$longitude;
      $forecast_url="https://api.forecast.io/forecast/".$Dark_Sky_API_Key."/".$forecast."?exclude=minutely,hourly,alerts,flags";
      $json_content= file_get_contents($forecast_url);

      $json_array_forecast = json_decode($json_content);

      $timezone = 0;
      $temperature = 0;
      $summary = 0;
      $humidity = 0;
      $pressure=0;
      $wind_speed = 0;
      $visibility = 0;
      $cloud_cover = 0;
      $ozone = 0;

      if(!empty($json_array_forecast->timezone))
      $timezone =  $json_array_forecast->timezone;
      if(!empty($json_array_forecast->currently->temperature))
      $temperature = $json_array_forecast->currently->temperature;
      if(!empty($json_array_forecast->currently->summary))
      $summary = $json_array_forecast->currently->summary;
      if(!empty($json_array_forecast->currently->humidity))
      $humidity = $json_array_forecast->currently->humidity;
      if(!empty($json_array_forecast->currently->pressure))
      $pressure = $json_array_forecast->currently->pressure;
      if(!empty($json_array_forecast->currently->windSpeed))
      $wind_speed = $json_array_forecast->currently->windSpeed;
      if(!empty($json_array_forecast->currently->visibility))
      $visibility = $json_array_forecast->currently->visibility;
      if(!empty($json_array_forecast->currently->ozone))
      $ozone = $json_array_forecast->currently->ozone;
      //echo gettype($ozone);
      if(!empty($json_array_forecast->currently->cloudCover))
      $cloud_cover = $json_array_forecast->currently->cloudCover;
      //echo gettype($cloud_cover);



      echo "<div class='colored_current_box'>";
      echo "<p class='cityp'> $city </p>";
      echo "<p class='timezonep'> $timezone </p>";
      echo "<img style='margin-left:108px;height:10px;width:10px;' src='https://cdn3.iconfinder.com/data/icons/virtual-notebook/16/button_shape_oval-512.png' >";
      echo "<div class='temperaturep' style='margin-top:20px'> $temperature <p class='summaryp' style='display:inline'> F </p></div>";
      echo "<p class='summaryp' style='margin-top:40px'> $summary</p>";
      echo "<table class='currenttable' border='0'>";
      echo "<tr>";
      echo "<td class='currenttable'> <img class='imageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-16-512.png'  title='Humidity'> </td>";
      echo "<td class='currenttable'> <img class='imageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-25-512.png' title='Pressure'> </td>";
      echo "<td class='currenttable'> <img class='imageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png' title='WindSpeed'> </td>";
      echo "<td class='currenttable'> <img class='imageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-30-512.png' title='Visibility'> </td>";
      echo "<td class='currenttable'> <img class='imageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png' title='CloudCover'> </td>";
      echo "<td class='currenttable'> <img class='imageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-24-512.png' title='Ozone'> </td>";
      echo "</tr>";
      echo "<tr>";
      echo "<td class='currenttable'> $humidity </td>";
      echo "<td class='currenttable'> $pressure </td>";
      echo "<td class='currenttable'> $wind_speed </td>";
      echo "<td class='currenttable'> $visibility </td>";
      echo "<td class='currenttable'> $cloud_cover </td>";
      echo "<td class='currenttable'> $ozone </td>";
      echo "</tr>";
      echo "</table>";
      echo "</div>";


      if (count($json_array_forecast->daily)) {

          $table_content="<table class='dailytable' border='1'>
           <th class='dailytable'> Date </th>
           <th class='dailytable'> Status </th>
           <th class='dailytable'> Summary </th>
           <th class='dailytable'> TemperatureHigh </th>
           <th class='dailytable'> TemperatureLow </th>
           <th class='dailytable'> Wind Speed </th>";

          foreach ($json_array_forecast->daily->data as $idx => $data) {

              $table_content.="<tr>";
              $date = gmdate("Y-m-d", $data->time);
              $time = $data->time;
              $table_content.="<td class='dailytable'> $date </td>";
              $image_tag='';

              if($data->icon == "clear-day" || $data->icon=="clear-night")
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-12-512.png' > </td>";
              elseif( $data->icon == "rain")
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-04-512.png' > </td>";
              elseif( $data->icon == "snow")
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-19-512.png' > </td>";
              elseif( $data->icon == "sleet")
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-07-512.png' > </td>";
              elseif( $data->icon == "wind")
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png' > </td>";
              elseif( $data->icon == "fog")
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png' > </td>";
              elseif( $data->icon == "cloudy")
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-01-512.png' > </td>";
              elseif( $data->icon == "partly-cloudy-day" || $data->icon = "partly-cloudy-night" )
              $image_tag="<td class='dailytable'> <img class='dailytableimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-02-512.png' > </td>";

              $table_content.=$image_tag;
              $table_content.="<td class='dailytable' ><a class='hidebutton' onclick=daily_forecast_check(\"$latitude\",\"$longitude\",\"$time\",\"$timezone\",\"$Dark_Sky_API_Key\")> $data->summary </a></td>";
              $table_content.="<td class='dailytable'> $data->temperatureHigh </td>";
              $table_content.= "<td class='dailytable'> $data->temperatureLow </td>";
              $table_content.="<td class='dailytable'> $data->windSpeed </td>";
              $table_content.="</tr>";
          }
        }

          // Close the table
            $table_content.="</table>";
            echo $table_content;
    }

    if(isset($_POST['street']) && isset($_POST['city']) && isset($_POST['state']))
     {
        $street = $_POST["street"];
        $city = $_POST["city"];
        $state = $_POST["state"];
        $Google_API_Key = "";
        $Dark_Sky_API_Key = "";
        $add='['.$street.','.$city.','.$state.']';
        $url="https://maps.googleapis.com/maps/api/geocode/xml?address=".urlencode($add)."&key=".$Google_API_Key;
        $xmlcontent= file_get_contents($url);
        $xmlload= simplexml_load_string($xmlcontent);

        $latitude= $xmlload->result->geometry->location->lat;
        $longitude= $xmlload->result->geometry->location->lng;

        displayTableContent($latitude,$longitude,$city);

  }

  elseif(isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['time']) && isset($_POST['timezone']))
  {
       $latitude = $_POST["latitude"];
       $longitude = $_POST["longitude"];
       $time = $_POST["time"];
       $timezone= $_POST["timezone"];

       $forecast = $latitude.','.$longitude.','.$time;

       $forecast_url="https://api.darksky.net/forecast/".$Dark_Sky_API_Key."/".$forecast."?exclude=minutely";
       #echo $forecast_url;
       $json_content= file_get_contents($forecast_url);
       $json_array_forecast = json_decode($json_content);

       $summary = '';
       $precipProbability = 0;
       $wind_speed = 0;
       $humidity = 0;
       $visibility = 0;
       $cloud_cover = 0;
       $ozone = 0;
       $precipIntensity = 0;
       $data_arr = 0;
       $hourly_data_arr =  0;

       if(!empty($json_array_forecast->currently->summary))
       $summary = $json_array_forecast->currently->summary;
       if(!empty($json_array_forecast->currently->temperature))
       $temperature = $json_array_forecast->currently->temperature;
       if(!empty($json_array_forecast->currently->icon))
       $icon = $json_array_forecast->currently->icon;
       if(!empty($json_array_forecast->currently->precipIntensity))
       $precipIntensity = $json_array_forecast->currently->precipIntensity;
       if(!empty($json_array_forecast->currently->precipProbability))
       $precipProbability = $json_array_forecast->currently->precipProbability;
       if(!empty($json_array_forecast->currently->windSpeed))
       $wind_speed = $json_array_forecast->currently->windSpeed;
       if(!empty($json_array_forecast->currently->humidity))
       $humidity = $json_array_forecast->currently->humidity;
       if(!empty($json_array_forecast->currently->visibility))
       $visibility = $json_array_forecast->currently->visibility;
       if(!empty($json_array_forecast->currently->cloudCover))
       $cloud_cover = $json_array_forecast->currently->cloudCover;
       if(!empty($json_array_forecast->currently->ozone))
       $ozone = $json_array_forecast->currently->ozone;
       if(!empty($json_array_forecast->daily->data))
       $data_arr = $json_array_forecast->daily->data;
       if(!empty($json_array_forecast->hourly->data))
       $hourly_data_arr =  $json_array_forecast->hourly->data;

       foreach ($json_array_forecast->daily->data as $idx => $data) {
         if(!empty( $sunsetTime = $data->sunsetTime))
         $sunsetTime = $data->sunsetTime;
         if(!empty($data->sunriseTime))
         $sunriseTime = $data->sunriseTime;
       }


      $send_array=array();

       foreach ($json_array_forecast->hourly->data as $idx => $data) {

         $temp_array=array(intval(gmdate("H", $data->time)),$data->temperature) ;
         array_push($send_array,$temp_array);
       }

       $json_encoded= json_encode($send_array);

       $sunrise = new DateTime("@$sunriseTime");
       $sunrise->setTimezone(new DateTimeZone($timezone));
       $sunriseTimehour=$sunrise->format('h');

       $sunset = new DateTime("@$sunsetTime",new DateTimeZone($timezone));
       $sunset->setTimezone(new DateTimeZone($timezone));
       $sunsetTimehour=$sunset->format('h');

       if($precipIntensity<=0.001)
       $precdisplay="None";
       else if($precipIntensity>0.001 && $precipIntensity<=0.015)
       $precdisplay="Very Light";
       else if($precipIntensity>0.015 && $precipIntensity<=0.05)
       $precdisplay="Light";
       else if($precipIntensity>0.05 && $precipIntensity<=0.1)
       $precdisplay="Moderate";
       else if($precipIntensity>0.1)
       $precdisplay="Heavy";
       else
       $precdisplay="N/A";

       $precipProbability*=100;
       $humidity*=100;

       if($icon == "clear-day" || $icon=="clear-night")
       $image_tag=" <img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-12-512.png' >" ;
       elseif( $icon == "rain")
       $image_tag=" <img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-04-512.png' >" ;
       elseif( $icon == "snow")
       $image_tag=" <img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-19-512.png' > ";
       elseif( $icon == "sleet")
       $image_tag="<img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-07-512.png' > ";
       elseif( $icon == "wind")
       $image_tag=" <img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-27-512.png' >";
       elseif( $icon == "fog")
       $image_tag=" <img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-28-512.png' > ";
       elseif( $icon == "cloudy")
       $image_tag=" <img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-01-512.png' > ";
       elseif( $icon == "partly-cloudy-day" || $icon = "partly-cloudy-night" )
       $image_tag=" <img class='dailyiconimageresizer' src='https://cdn2.iconfinder.com/data/icons/weather-74/24/weather-02-512.png' > ";

       $temperature=round($temperature,0);
       $precipProbability=round($precipProbability,0);
       $humidity=round($humidity,0);

       echo "<h1 style='margin-left:630px'> Daily Weather Detail </h1>";
       echo "<div class='colored_daily_box'>";
       echo "<div class='coldaily1'>";
       echo "<p style='margin-left:10px;margin-top:70px;font-size:35px;font-weight:bold;'> $summary </p>";
       echo "<img style='margin-left:115px;height:10px;width:10px;' src='https://cdn3.iconfinder.com/data/icons/virtual-notebook/16/button_shape_oval-512.png' >";
       echo "<div style='margin-top:40px;margin-left:10px;font-size:100px;font-weight:bold;'> $temperature <p style='margin-left:5px;font-size:80px;display:inline;'> F </p>  </div>";
       echo "</div>";
       echo "<div class='coldaily2'>";
       echo $image_tag;
       echo "</div>";
       echo "<div>";
       echo "<table class='daily_details' border='0'>";
       echo "<tr><td class='dailyweathertable'> Precipitation: </td> <td> $precdisplay </td></tr>";
       echo "<tr><td class='dailyweathertable'> Chance of Rain: </td> <td> $precipProbability % </td></tr>";
       echo "<tr><td class='dailyweathertable'> Wind Speed:  </td> <td> $wind_speed mph</td></tr>";
       echo "<tr><td class='dailyweathertable'> Humidity:   </td> <td> $humidity % </td></tr>";
       echo "<tr><td class='dailyweathertable'> Visibility: </td> <td>  $visibility mi</td></tr>";
       echo "<tr><td class='dailyweathertable'> Sunrise / Sunset:  </td> <td> $sunriseTimehour AM/ $sunsetTimehour PM </td></tr>";
       echo "</table>";
       echo "</div>";
       echo "</div>";

       echo "<h1 style='margin-left:630px'> Day's Hourly Weather </h1>";

       echo "<div class='arrow-down' id='collapsearrow' onclick=get_line_chart(".$json_encoded.")></div>";

     }
   elseif(isset($_POST['latitude']) && isset($_POST['longitude'])&&isset($_POST['city']))
   {
     $latitude=$_POST['latitude'];
     $longitude=$_POST['longitude'];
     $city=$_POST['city'];
     displayTableContent($latitude,$longitude,$city);
   }
?>
<?php endif; ?>
<div id="display"> </div>
<div style="margin-left:400px" id="line_chart"></div>
</body>
</html>
