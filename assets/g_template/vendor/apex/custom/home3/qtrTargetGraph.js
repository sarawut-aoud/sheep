var options = {
  chart: {
    height: 325,
    width: '85%',
    type: "line",
    stacked: false,
    toolbar: {
      show: false,
    }
  },
  dataLabels: {
    enabled: false
  },
  colors: ['#ffa77e', '#ffffff'],
  series: [
    {
      name: 'Target',
      type: 'column',
      data: [30, 50, 70, 90]
    },
    {
      name: "Achieived",
      type: 'line',
      data: [25, 35, 65, 55]
    },
  ],
  stroke: {
    width: [0, 7]
  },
  plotOptions: {
    bar: {
      columnWidth: "60%",
      borderRadius: 7,
    }
  },
  xaxis: {
    categories: ['Q1', 'Q2', 'Q3', 'Q4'],
  },
  yaxis: [
    {
      show: false,
    }
  ],
  tooltip: {
    shared: false,
    intersect: true,
    x: {
      show: false
    }
  },
  legend: {
    horizontalAlign: "center",
  },
  grid: {
	  borderColor: '#fea67f',
	  strokeDashArray: 0, 
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
      top: -30,
      right: 0,
      bottom: 0,
      left: 10
	  }, 
	},
};

var chart = new ApexCharts(document.querySelector("#qtrTargetGraph"), options);

chart.render();