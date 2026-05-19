   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['학년', '재학생', '휴학생', '퇴교생'],
          ['1학년',  10,      17, 2],
          ['2학년',  11,      15, 0],
          ['3학년',  17,       13, 5],
          ['4학년',  12,      10, 4]
        ]);

        var options = {
          title: '학년별 휴학자 분포',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);

        chart = new google.visualization.LineChart(document.getElementById('cnu1'));

        chart.draw(data, options);
      }
    </script>

    <div id="curve_chart" style="width: 300px; height: 200px"></div>

    <div id="cnu1" style="width: 900px; height: 500px"></div>

