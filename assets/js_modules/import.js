const imp = {
	data: {
		table: null,
	},
	components: {},
	methods: {},
	ajax: {},
	async init() {
		var data = [["A001", "ชื่อแพะ", "เพศผู้", "", true, "10", "123", "40"]];
		this.data.table = jspreadsheet($("#spreadsheet")[0], {
			data: data,
			columns: [
				{
					type: "text",
					width: 120,
					title: "รหัสแพะ",
				},
				{
					type: "text",
					width: 120,
					title: "ชื่อแพะ",
				},
				{
					type: "dropdown",
					title: "เพศ",
					width: 120,
					source: ["เพศผู้", "เพศเมีย"],
				},
				{
					type: "dropdown",
					title: "ประเภทแพะ",
					width: 120,
					source: ["เพศผู้", "เพศเมีย"],
				},
				{
					type: "dropdown",
					title: "ฟาร์ฒต้นทาง",
					width: 120,
					source: ["เพศผู้", "เพศเมีย"],
				},
				{
					type: "numeric",
					title: "อายุ (เดือน)",
					mask: "#.##,00",
					width: 120,
					decimal: ",",
				},
				{
					type: "numeric",
					title: "น้ำหนัก (กก.)",
					mask: "#.##,00",
					width: 120,
					decimal: ",",
				},
				{
					type: "numeric",
					title: "ส่วนสูง (ซม.)",
					mask: "#.##,00",
					width: 120,
					decimal: ",",
				},
			],
		});

		$(document).on("click", ".addrows", async (e) => {
			this.data.table.insertRow();
		});
		$(document).on("click", ".delrows", async (e) => {
			this.data.table.deleteRow();
		});
	},
};
imp.init();
