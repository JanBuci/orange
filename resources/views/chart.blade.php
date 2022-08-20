<!doctype html>
<html lang="en">
  <head>
    <title>GRAF NÁKUP/PREDAJ</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>
  <body>

    <div class="container p-5" style="margin: 0">
        <h5>GRAF NÁKUP/PREDAJ - refresh interval (10 sekund)</h5>

        <div id="google-line-chart"></div>

    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    setInterval(getFreshData, 10000);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
            ['Cas', 'Predaj', 'Nakup'],

            @php
                $lastAsk = $lastBid = 0;
                foreach($data as $d) {

                    if ($d['priznak'] == 'bids'){
                           $lastBid  = $d['cena'];
                    }
                    if ($d['priznak'] == 'asks'){
                          $lastAsk = $d['cena'];
                    }
                    echo "['".$d['casova_peciatka']."', ".$lastBid.", ".$lastAsk."],";
                }
            @endphp
        ]);

        var options = {
            title: 'GRAF NAKUP/PREDAJ',
            curveType: 'function',
            legend: {position: 'bottom'},
            width: jQuery(window).width(),
            height: jQuery(window).height()*0.75,
            vAxis: {
                viewWindowMode: 'explicit',
                viewWindow: {
                    max: 1.05,
                    min: 0.95
                }
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));

        chart.draw(data, options);
    }

    function getFreshData() {
        jQuery.ajax({
            url: "/getData",
            type:'POST',
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (jsonData) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Cas');
                data.addColumn('number', 'Predaj');
                data.addColumn('number', 'Nakup');

                let lastAsks, lastBids;
                for (var i = 0; i < jsonData.length; i++) {
                    if (jsonData[i].priznak === 'bids'){
                        lastBids = jsonData[i].cena;
                    }
                    if (jsonData[i].priznak === 'asks'){
                        lastAsks = jsonData[i].cena;
                    }
                    data.addRow([jsonData[i].casova_peciatka, lastBids, lastAsks]);
                }

                var options = {
                    title: 'GRAF NAKUP/PREDAJ',
                    curveType: 'function',
                    legend: {position: 'bottom'},
                    width: jQuery(window).width(),
                    height: jQuery(window).height()*0.75,
                    vAxis: {
                        viewWindowMode: 'explicit',
                        viewWindow: {
                            max: 1.05,
                            min: 0.95
                        }
                    }
                };
                var chart = new google.visualization.LineChart(document.getElementById('google-line-chart'));
                chart.draw(data, options);
            },
            error: function (request, error) {
                console.log(error);
            }
        });
    }
</script>
</body>
</html>
