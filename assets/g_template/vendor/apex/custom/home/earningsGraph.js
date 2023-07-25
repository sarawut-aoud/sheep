var options = {
  chart: {
    height: 320,
    width: '80%',
    type: 'bar',
    toolbar: {
      show: false,
    },
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '60%',
      borderRadius: 7,
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  series: [{
    name: 'Revenue',
    data: [2000, 4000, 8000, 12000]
  }],
  legend: {
    show: false,
  },
  xaxis: {
    categories: ['Q1', 'Q2', 'Q3', 'Q4'],
  },
  yaxis: {
    show: false,
  },
  fill: {
    opacity: 1
  },
  tooltip: {
    y: {
      formatter: function(val) {
        return "$" + val
      }
    }
  },
  grid: {
    show: false,
    xaxis: {
      lines: {
        show: true
      }
    },   
    yaxis: {
      lines: {
        show: false,
      } 
    },
    padding: {
      top: 0,
      right: 0,
      bottom: -10,
      left: 0
    },
  },
  colors: ['#ffffff'],
}
var chart = new ApexCharts(
  document.querySelector("#earningsGraph"),
  options
);
chart.render();