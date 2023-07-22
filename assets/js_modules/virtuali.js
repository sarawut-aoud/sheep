const dashboard = {
	data: {
		months: (option = { count: 12 }) => {
			const month = [
				{ id: 1, name: "January" },
				{ id: 2, name: "February" },
				{ id: 3, name: "March" },
				{ id: 4, name: "April" },
				{ id: 5, name: "May" },
				{ id: 6, name: "June" },
				{ id: 7, name: "July" },
				{ id: 8, name: "August" },
				{ id: 9, name: "September" },
				{ id: 10, name: "October" },
				{ id: 11, name: "November" },
				{ id: 12, name: "December" },
			];
			let data = [];
			month.forEach((ev, idx) => {
				if (ev.id <= option.count) {
					data.push(ev.name);
				}
			});
			return data;
		},
		chart2: () => {
			let data = {
				labels: ["Red", "Blue", "Yellow"],
				datasets: [
					{
						label: "My First Dataset",
						data: [300, 50, 100],
						backgroundColor: [
							"rgb(255, 99, 132)",
							"rgb(54, 162, 235)",
							"rgb(255, 205, 86)",
						],
						hoverOffset: 4,
					},
				],
			};
			return data;
		},
		chart3: () => {
			let data = {
				labels: dashboard.data.months({ count: 7 }),
				datasets: [
					{
						label: "My First Dataset",
						data: [65, 59, 80, 81, 56, 55, 40],
						fill: false,
						borderColor: "rgb(75, 192, 192)",
						tension: 0.1,
					},
				],
			};
			return data;
		},
	},
	async init() {
		new Chart($("#myChart")[0], {
			type: "doughnut",
			data: {
				labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
				datasets: [
					{
						label: "# of Votes",
						data: [12, 19, 3, 5, 2, 3],
						borderWidth: 1,
					},
				],
			},
			options: {
				scales: {
					y: {
						beginAtZero: true,
					},
				},
			},
		});
		new Chart($("#myChart2")[0], {
			type: "pie",
			data: dashboard.data.chart2(),
			options: {
				scales: {
					y: {
						beginAtZero: true,
					},
				},
			},
		});
		new Chart($("#myChart3")[0], {
			type: "line",
			data: dashboard.data.chart3(),
			options: {
				scales: {
					y: {
						beginAtZero: true,
					},
				},
			},
		});
	},
};
dashboard.init();
