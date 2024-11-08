<!DOCTYPE html>
<html>
<head>
    <title>Bookings Line Chart</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            drawChart('weekly');
            drawChart('monthly');
            drawChart('yearly');
        }

        function drawChart(period) {
            var data = google.visualization.arrayToDataTable(getData(period));
            var options = {
                title: 'Bookings - ' + period.charAt(0).toUpperCase() + period.slice(1),
                chartArea: {width: '70%'},
                hAxis: {
                    title: period.charAt(0).toUpperCase() + period.slice(1)
                },
                vAxis: {
                    title: 'Count',
                    minValue: 0
                },
                curveType: 'function', // This makes the lines smooth
                legend: { position: 'bottom' }
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_' + period));
            chart.draw(data, options);
        }

        function getData(period) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'fetch_data.php', false); 
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('period=' + period);
            var response = JSON.parse(xhr.responseText);

            var data = [['Category', 'Count']];
            response.forEach(function(row) {
                data.push([row.category, row.count]);
            });

            return data;
        }
    </script>
</head>
<body>
    <h1>Bookings Line Charts</h1>
    <div id="chart_weekly" style="width: 900px; height: 500px;"></div>
    <div id="chart_monthly" style="width: 900px; height: 500px;"></div>
    <div id="chart_yearly" style="width: 900px; height: 500px;"></div>
</body>
</html>
