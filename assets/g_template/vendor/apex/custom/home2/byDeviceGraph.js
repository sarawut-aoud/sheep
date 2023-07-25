var options = {
  chart: {
    height: 290,
    type: 'donut',
  },
  labels: ['Desktop', 'Tablet', 'Mobile'],
  series: [60000, 45000, 15000],
  legend: {
    position: 'bottom',
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: 0,
  },
  colors: ['#ffd5c0', '#ff7951', '#ffb893'],
  tooltip: {
    y: {
      formatter: function(val) {
        return  "$" + val
      }
    }
  },
}
var chart = new ApexCharts(
  document.querySelector("#byDevice"),
  options
);
chart.render();