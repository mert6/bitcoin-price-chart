<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {

var dataPoints = [];

var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	exportEnabled: true,
	title: {
		text: ""
	},
	subtitles: [{
		text: "Market prices"
	}],
	axisX: {
		interval: 1,
		valueFormatString: "MMM"
	},
	axisY: {
		includeZero: false,
		prefix: "$",
		title: "Price"
	},
	toolTip: {
		content: "Date: {x}<br /><strong>Price:</strong><br />Open: {y[0]}, Close: {y[3]}<br />High: {y[1]}, Low: {y[2]}"
	},
	data: [{
		type: "candlestick",
		yValueFormatString: "$##0.00",
		dataPoints: dataPoints
	}]
});

$.get("Binance_BTCUSDT_d.csv", getDataPointsFromCSV);

function getDataPointsFromCSV(csv) {
	var csvLines = points = [];
	csvLines = csv.split(/[\r?\n|\r|\n]+/);
	for (var i = 0; i < csvLines.length; i++) {
		if (csvLines[i].length > 0) {
			points = csvLines[i].split(",");
			dataPoints.push({
				x: new Date(
					parseInt(points[0].split("-")[0]),
					parseInt(points[0].split("-")[1]-1),
					parseInt(points[0].split("-")[2])
				),
				y: [
					parseFloat(points[2]),
					parseFloat(points[3]),
					parseFloat(points[4]),
					parseFloat(points[5])
				]
			});
		}
	}
	chart.render();
}

}
</script>

<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}

.button2 {background-color: #008CBA;} /* Blue */
.button3 {background-color: #f44336;} /* Red */ 
.button4 {background-color: #ffffff; color: black; font-size: 30px} /* Gray */ 
.button5 {background-color: #555555;} /* Black */
</style>

</head>
<body>

<?php 

$jsondata = file_get_contents('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1&sparkline=false');
$jsonphp = json_decode($jsondata);
$current_price = $jsonphp[0]->current_price;
$high = $jsonphp[0]->high_24h;
$low = $jsonphp[0]->low_24h;
$total_vol = $jsonphp[0]->total_volume;
$market_cap = $jsonphp[0]->market_cap;
$price_change_perc_24h = $jsonphp[0]->price_change_percentage_24h;
$green = 'color="#00CC00"';
$red = 'color="#CC3300"';
$up_png = '<img src="icons/up.png" style="width: 25px; height:25px">';
$down_png = '<img src="icons/down.png" style="width: 25px; height:25px">';

?>
<img src="icons/bitcoin.png" style="width: 16px; height:16px">
<font face="Tahoma, Geneva, sans-serif" color="000000"><b>BTC / USDT</b></font>
<button style="width: 98%" class="button button4"><font face="Tahoma, Geneva, sans-serif" color="#000000">$ <?php echo $current_price; ?><?php if($price_change_perc_24h >0) echo $up_png; if($price_change_perc_24h < 0) echo $down_png; ?><sup><font size="0" face="Tahoma, Geneva, sans-serif" color="#000000">24h</font></sup></font></button>
<button style="width: 48%" class="button">High : $ <?php echo $high; ?></button>
<button style="width: 48%" class="button button3">Low : $ <?php echo $low; ?></button></br>
<button style="width: 48%" class="button button2">Market Cap : <?php echo $market_cap; ?></button>
<button style="width: 48%" class="button button5">Total Vol : <?php echo $total_vol; ?></button></br></br></br>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
</body>
</html>