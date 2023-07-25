var options = {
  chart: {
    height: 225,
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
    data: [120, 320, 260, 490, 580, 310]
  }],
  grid: {
    borderColor: '#69c3f7',
    strokeDashArray: 5,
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
      right: 20,
      bottom: -10,
      left: 20
    }, 
  },
  xaxis: {
    categories: ['Pizzas', 'Donuts', 'Biscuits', 'Ice Creams', 'Cakes', 'Coffee'],
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
      opacityTo: .2,
      stops: [15, 100]
    }
  },
  colors: ['#9ddcff'],
  markers: {
    size: 0,
    opacity: 0.2,
    colors: ["#9ddcff"],
    strokeColor: "#ffffff",
    strokeWidth: 2,
    hover: {
      size: 7,
    }
  },
  tooltip: {
    y: {
      formatter: function(val) {
        return  val
      }
    }
  },
}

var chart = new ApexCharts(
  document.querySelector("#revenueGraph"),
  options
);

chart.render();