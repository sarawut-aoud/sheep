var options = {
	chart: {
		height: 90,
		width: '45%',
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
		name: "Customers",
		data: [50, 120, 200, 170, 250, 150, 320, 430]
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
			opacityFrom: 0,
			opacityTo: 0,
			stops: [15, 100]
	  	}
	},
	colors: ['#FFFFFF'],
	markers: {
		size: 0,
		opacity: 0.2,
		colors: ["#FFFFFF"],
		strokeColor: "#FFFFFF",
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
	document.querySelector("#customersGraph"),
	options
);
chart.render();
















var options2 = {
	chart: {
		height: 90,
		width: '45%',
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
		name: "Products",
		data: [20, 90, 140, 190, 150, 350, 180, 270]
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
			opacityFrom: 0,
			opacityTo: 0,
			stops: [15, 100]
	  	}
	},
	colors: ['#FFFFFF'],
	markers: {
		size: 0,
		opacity: 0.2,
		colors: ["#FFFFFF"],
		strokeColor: "#FFFFFF",
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
	document.querySelector("#customersGraph2"),
	options2
);
chart.render();














var options3 = {
	chart: {
		height: 90,
		width: '45%',
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
		data: [80, 10, 100, 80, 150, 210, 170, 230]
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
			opacityFrom: 0,
			opacityTo: 0,
			stops: [15, 100]
	  	}
	},
	colors: ['#FFFFFF'],
	markers: {
		size: 0,
		opacity: 0.2,
		colors: ["#FFFFFF"],
		strokeColor: "#FFFFFF",
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
	document.querySelector("#customersGraph3"),
	options3
);
chart.render();















var options4 = {
	chart: {
		height: 90,
		width: '45%',
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
		name: "Signups",
		data: [50, 70, 90, 30, 120, 80, 120, 330]
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
			opacityFrom: 0,
			opacityTo: 0,
			stops: [15, 100]
	  	}
	},
	colors: ['#FFFFFF'],
	markers: {
		size: 0,
		opacity: 0.2,
		colors: ["#FFFFFF"],
		strokeColor: "#FFFFFF",
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
	document.querySelector("#customersGraph4"),
	options4
);
chart.render();