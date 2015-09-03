/*
Salah time application ..::.. Displaying salah time based on location
Created by: Lelly Hidayah Anggraini
Email: lelly@morebit.co
Web:http://mimiubay.blogspot.com
*/
<!DOCTYPE html>
<html>
<title>Shalat ..::.. Tampilkan Waktu Shalatmu</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta name="copyright" content="Morebit Information Technology">
<meta name="author" content="http://morebit.co">
<meta name="keywords" content="waktu shalat,informasi waktu shalat,jam shalat,jadwal shalat">
<meta name="description" content="menampilkan informasi shalat berdasar tanggal dan lokasi tertentu">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<style>
body{
	background:#000;
}
.main{
	
	text-align:center;
	margin-top:200px;
	
}
.main button{
	font-size:28px;
	
}
.tampil{
	font-weight:bold;
	padding:10px;
	margin-top:5px;
//	width:50%;
	text-align:center;
	color:#FF8533;
	font-size:20px;
}

.waktu{
	padding:10px;
	//border:2px solid
	
}
.waktu p{
	color:#FFFFCC;
	font-size:16px;
}
.colorgraph {
  height: 5px;
  border-top: 0;
  background: #c4e17f;
  border-radius: 5px;
  background-image: -webkit-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -moz-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: -o-linear-gradient(left, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
  background-image: linear-gradient(to right, #c4e17f, #c4e17f 12.5%, #f7fdca 12.5%, #f7fdca 25%, #fecf71 25%, #fecf71 37.5%, #f0776c 37.5%, #f0776c 50%, #db9dbe 50%, #db9dbe 62.5%, #c49cde 62.5%, #c49cde 75%, #669ae1 75%, #669ae1 87.5%, #62c2e4 87.5%, #62c2e4);
}
</style>
<body>

<div class="main" ng-app="salahApp" ng-controller="salahtimeController"> 
<div class="alert alert-danger" ng-if="error">
  <strong>Perhatian!</strong> {{error}}
</div>
<button class="btn btn-info" ng-click="waktu()">
<span class="glyphicon glyphicon-calendar"></span> Tampilkan Waktu Shalat
</button>
<hr class="colorgraph">
<div class="tampil" ng-if="alamat">{{alamat}}</div>
<div class="waktu" ng-if="tampil">
	<p>Waktu Shalat Tanggal <?php echo date('d F Y',time());?></p>
	<p>Subuh {{subuh}}</p>
	<p>Dhuhur {{dhuhur}}</p>
	<p>Asar {{asar}}</p>
	<p>Maghrib {{maghrib}}</p>
	<p>Isya {{isha}}</p>
</div>
<hr class="colorgraph">
<div class="footer">Powered by <a href="http://mimiubay.blogspot.com">mimiubay</a> - <a href="http://morebit.co">morebit</a></div>
<script>
var app = angular.module('salahApp', []);
app.controller('salahtimeController', function($scope, $http) {
	$scope.waktu=function(){
		if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition($scope.showPosition);
		} else { 
			$scope.error="Lokasi tidak ditemukan. Cek koneksi Internet anda";
		    
		}
		
		
	}
	
	$scope.showPosition=function(position){
		lat=position.coords.latitude;
		long=position.coords.longitude;
		var d = new Date();
		var n = Math.floor((new Date).getTime()/1000);
		 $http.get("http://api.aladhan.com/timings/"+n+"?latitude="+lat+"&longitude="+long+"&timezonestring=Asia/Jakarta&method=3")
		  .success(function (response) {
		  	
		  	var latlon = lat + "," + long;
		  	if(response.code == 200){
		  		$scope.tampil =true;
		  		$scope.subuh=response.data.timings.Fajr;
		  		$scope.dhuhur=response.data.timings.Dhuhr;
		  		$scope.asar=response.data.timings.Asr;
		  		$scope.maghrib=response.data.timings.Maghrib;
		  		$scope.isha=response.data.timings.Isha;
		  		
		  	
		  	}
		  	
		  	$http.get("http://maps.googleapis.com/maps/api/geocode/json?latlng="+latlon+"&sensor=true")
		  	.success(function (address){
		  		$scope.alamat='Lokasi Anda: '+address.results[0].formatted_address;
		  			  	})
		  	
		  	
		  
		  });
		
	}
 
});
</script>

</body>
</html>
