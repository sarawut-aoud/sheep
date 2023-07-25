var options = {
  chart: {
    height: 200,
    width: '85%',
    type: 'area',
    zoom: {
      enabled: false
    },
    toolbar: {
      show: false
    },
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    curve: 'smooth',
    width: 7,
  },
  series: [{
    name: "Orders",
    data: [120, 300, 260, 400, 510, 230, 350, 400, 350, 410, 560, 590, 620, 570, 680, 730, 820, 910]
  }],
  grid: {
    borderColor: '#bede68',
    strokeDashArray: 0,
    show: false,
    xaxis: {
      lines: {
        show: false,
      }
    },   
    yaxis: {
      lines: {
        show: false,
      } 
    },
    padding: {
      top: -20,
      right: 10,
      bottom: 0,
      left: 10
    }, 
  },
  xaxis: {
    labels: {
      show: false,
    },
  },
  yaxis: {
    show: false,
  },
  fill: {
    type:"gradient",
    gradient: {
      type: "vertical",
      shadeIntensity: 1,
      inverseColors: !1,
      opacityFrom: .4,
      opacityTo: 0,
      stops: [15, 100]
    }
  },
  colors: ['#ffffff'],
  markers: {
    size: 0,
    opacity: 0.2,
    colors: ["#ffffff"],
    strokeColor: "#49914E",
    strokeWidth: 2,
    hover: {
      size: 10,
    }
  },
  tooltip: {
    y: {
      formatter: function(val) {
        return val
      }
    }
  },
}

var chart = new ApexCharts(
  document.querySelector("#ordersGraph"),
  options
);

chart.render();