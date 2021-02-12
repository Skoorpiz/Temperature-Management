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


    <?php if ($id == 1) {
    ?>
      var value;
      var open;
      var close;
      <?php } else if ($id == 2) {
      for ($n = 0; $n < count($a_ville); $n++) { ?>
        var value<?php echo $n ?>;

    <?php }
    } ?>
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
          ?>


            data.push({

              date: date,
              <?php  
              for ($n = 0; $n < count($a_ville); $n++) {  
                ?>
              value<?php echo $n ?>: value<?php echo $n ?>,


            
      <?php
          }?> });
          <?php
        }
        $compteur++;
      }

      ?>

      chart.data = data;

      // Create axes
      var dateAxis = chart.xAxes.push(new am4charts.DateAxis());

      var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());



      <?php
      if ($id == 1) {
      ?>
        var series1 = chart.series.push(new am4charts.LineSeries());
        series1.dataFields.valueY = "value";
        series1.dataFields.dateX = "date";
        series1.yAxis = valueAxis;
        series1.name = "Moyenne";
        series1.tooltipText = "{name} : {value}";

        var series2 = chart.series.push(new am4charts.ColumnSeries());
        series2.dataFields.openValueY = "open";
        series2.dataFields.valueY = "close";
        series2.tooltipText = "Max: {openValueY.value} Min: {valueY.value}";
        series2.dataFields.dateX = "date";
        series2.yAxis = valueAxis;
        series2.name = "Maximum et Minimum";
        series2.tooltip.pointerOrientation = "horizontal";
        series2.sequencedInterpolation = true;
        series2.fillOpacity = 0;
        series2.strokeOpacity = 1;
        series2.columns.template.width = 0.01;

        var openBullet = series2.bullets.create(am4charts.CircleBullet);
        openBullet.locationY = 1;

        var closeBullet = series2.bullets.create(am4charts.CircleBullet);

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
          series<?php echo $n ?>.tooltipText = "{name} : {valueY}";
      <?php }
      } ?>


      console.log(chart.data);
      chart.legend = new am4charts.Legend();
      chart.legend.position = "top";

      chart.cursor = new am4charts.XYCursor();

      chart.scrollbarY = new am4core.Scrollbar();
      chart.scrollbarX = new am4core.Scrollbar();

  }); // end am4core.ready()
</script>