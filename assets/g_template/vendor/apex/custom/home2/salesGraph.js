var options = {
  chart: {
    height: 270,
    width: '90%',
    type: 'bar',
    stacked: true,
    toolbar: {
      show: false
    },
    zoom: {
      enabled: true
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      borderRadius: 7,
    },
  },
  dataLabels: {
    enabled: true
  },
  series: [{
    name: 'Sales',
    data: [15, 25, 35, 45, 55, 65]
  },{
    name: 'Revenue',
    data: [20, 30, 40, 50, 60, 70]
  }],
  xaxis: {
    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
  },
  legend: {
    show: false,
  },
  grid: {
    borderColor: '#43c3d0',
    strokeDashArray: 5,
    xaxis: {
      lines: {
        show: true,
      }
    },   
    yaxis: {
      lines: {
        show: false,
      } 
    },
    padding: {
      top: 20,
      right: 0,
      bottom: 0,
      left: 20
    }, 
  },
  yaxis: {
    show: false,
  },
  fill: {
    opacity: 1
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return "$" + val
      }
    }
  },
  colors: ['#50bfca', '#FFFFFF'],
}
var chart = new ApexCharts(
  document.querySelector("#salesGraph"),
  options
);
chart.render();


