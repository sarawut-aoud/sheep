var options = {
	chart: {
	  height: 150,
	  width: '100%',
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
	  data: [50, 300, 270, 70, 150, 290, 320, 430]
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
		right: 0,
		bottom: 0,
		left: 0
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
	  type: "gradient",
	  gradient: {
		type: "vertical",
		shadeIntensity: 1,
		inverseColors: !1,
		opacityFrom: .6,
		opacityTo: 0,
		stops: [15, 100]
	  }
	},
	colors: ['#FFFFFF'],
	markers: {
	  size: 0,
	  opacity: 0.2,
	  colors: ["#FFFFFF"],
	  strokeColor: "#f98faa",
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
	document.querySelector("#earningsGraph"),
	options
  );
  
  chart.render();
