// Morris Donut
Morris.Donut({
	element: 'donutColors',
	data: [
		{value: 30, label: 'foo'},
		{value: 15, label: 'bar'},
		{value: 10, label: 'baz'},
		{value: 5, label: 'A really really long label'}
	],
	backgroundColor: '#cc385e',
	labelColor: '#ffffff',
	colors:['#ffa7be', '#fd8caa', '#fb7a9b', '#ffbbcd'],
	resize: true,
	hideHover: "auto",
	gridLineColor: "#000000",
	formatter: function (x) { return x + "%"}
});