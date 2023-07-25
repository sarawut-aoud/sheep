// Morris Donut
Morris.Donut({
	element: 'donutOrders',
	data: [
		{value: 15, label: 'New'},
		{value: 10, label: 'Delivered'},
		{value: 7, label: 'Pending'},
	],
	backgroundColor: '#ffffff',
	labelColor: '#13202b',
	lineWidth: '10px',
	colors:['#1273eb', '#2b86f5', '#7facfa'],
	resize: true,
	hideHover: "auto",
	formatter: function (x) { return x}
});