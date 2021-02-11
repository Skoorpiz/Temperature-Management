<script>
  $(function() {
    $('.selectpicker').selectpicker();
  });
  am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv3", am4charts.XYChart);

    var value;
    var open;
    var close;
    var date;
    var data = [];
    
    <?php
    $compteur = 0;

    for ($i = 1; $i <= 12; $i++) {
      if ($id == 1) {
    ?>
        value = <?php echo $a_temp[$i][0] ?>;
        open = <?php echo $a_max[$i][0] ?>;
        close = <?php echo $a_min[$i][0];
              } else if ($id == 2) {
                for ($n = 0; $n < count($a_ville); $n++) {
                ?>;
        value<?php echo $n ?> = <?php echo $a_temp[$n][$i][0];
                              }
                            } ?>;
        date = new Date();
        date.setFullYear(0, <?php echo $compteur ?>);
        <?php if ($id == 1) { ?>
          data.push({

            date: date,
            value: value,
            open: open,
            close: close,

          });

          <?php
        } else if ($id == 2) {
          for ($n = 0; $n < count($a_ville); $n++) { ?>


            data.push({

              date: date,
              value<?php echo $n ?>: value<?php echo $n ?>,

            });
      <?php
          }
        }
        $compteur++;
      }

      ?>

      chart.data = data;

      // Create axes
      var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
      //dateAxis.renderer.grid.template.location = 0;
      //dateAxis.renderer.minGridDistance = 30;

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());



      // var series2 = chart.series.push(new am4charts.LineSeries());
      // series2.dataFields.openValueY = "open";
      // series2.dataFields.valueY = "close";
      // series2.tooltipText = "Min: {valueY.value}";
      // series2.dataFields.dateX = "date";
      // series2.yAxis = valueAxis;
      // series2.name = "Minimum";

      // var series3 = chart.series.push(new am4charts.LineSeries());
      // series2.dataFields.openValueY = "open";
      // series3.dataFields.valueY = "open";
      // series3.tooltipText = "Max: {valueY.value}";
      // series3.dataFields.dateX = "date";
      // series3.yAxis = valueAxis;
      // series3.name = "Maximum";


      <?php
      if ($id == 1) {
      ?>
        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "value";
        series1.dataFields.dateX = "date";
        series1.yAxis = valueAxis;
        series1.name = "Moyenne";
        series1.tooltipText = "Moyenne: {value}"
        var series4 = chart.series.push(new am4charts.ColumnSeries());
        series4.dataFields.openValueY = "open";
        series4.dataFields.valueY = "close";
        series4.tooltipText = "open: {openValueY.value} close: {valueY.value}";
        series4.dataFields.dateX = "date";
        series4.yAxis = valueAxis;
        series4.name = "Maximum et Minimum";
        series4.tooltip.pointerOrientation = "horizontal";
        series4.sequencedInterpolation = true;
        series4.fillOpacity = 0;
        series4.strokeOpacity = 1;
        series4.columns.template.width = 0.01;

        var openBullet = series4.bullets.create(am4charts.CircleBullet);
        openBullet.locationY = 1;

        var closeBullet = series4.bullets.create(am4charts.CircleBullet);

        closeBullet.fill = chart.colors.getIndex(4);
        closeBullet.stroke = closeBullet.fill;

        <?php } else if ($id == 2) {
        for ($n = 0; $n < count($a_ville); $n++) {
        ?>
          var series<?php echo $n ?> = chart.series.push(new am4charts.LineSeries());
          series<?php echo $n ?>.dataFields.valueY = "value<?php echo $n ?>";
          series<?php echo $n ?>.dataFields.dateX = "date";
          series<?php echo $n ?>.yAxis = valueAxis;
          series<?php echo $n ?>.name = "<?php echo $nomVille[$n][0] ?>";
          series<?php echo $n ?>.stroke = am4core.color("<?php echo $color[$n] ?>");
          series<?php echo $n ?>.tooltipText = "{name}: {valueY}"
        <?php } ?>
        // series0.tooltipText = "Moy: {value0}"
        // series1.tooltipText = "Moy: {value1}"
        // series2.tooltipText = "Moyd: {value2}"
      <?php
      } ?>

      chart.legend = new am4charts.Legend();
      chart.legend.position = "top";

      chart.cursor = new am4charts.XYCursor();
      // chart.cursor.snapToSeries = series1;
      chart.cursor.xAxis = dateAxis;


      chart.scrollbarY = new am4core.Scrollbar();
      chart.scrollbarX = new am4core.Scrollbar();

  }); // end am4core.ready()
</script>