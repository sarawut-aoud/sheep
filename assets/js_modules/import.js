const imp = {
	data: {
		table: null,
		gender: [
			{ id: 1, name: "เพศผู้" },
			{ id: 2, name: "เพศเมีย" },
		],
		rawfarm: [],
		rawsheeptype: [],
	},
	components: {},
	methods: {
		setData() {
			let obj = [["A001", "ชื่อแพะ", "เพศผู้", "", true, "10", "123", "40"]];
			return obj;
		},
	},
	ajax: {
		getsheeptype: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("farm/get_typesheep"),
				success: (results) => {
					if (results.data) {
						results.data.forEach((ev, i) => {
							imp.data.rawsheeptype.push({
								id: ev.id,
								name: ev.typename,
							});
						});
					}
				},
			});
		},
		get_farmlist: async () => {
			await $.ajax({
				type: "get",
				dataType: "json",
				url: site_url("farm/get_farmlist"),
				success: (results) => {
					if (results.data) {
						results.data.forEach((ev, i) => {
							imp.data.rawfarm.push({
								id: ev.id,
								name: ev.farmname,
							});
						});
					}
				},
			});
		},
		async save(data) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("farm/savesheep_import"),
				data: {
					data,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "บันทึกสำเร็จ",
							showConfirmButton: false,
							timer: 1500,
						}).then(async () => {
							location.reload();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "เกิดข้อผิดพลาด",
							showConfirmButton: false,
							timer: 1500,
						});
						location.reload();
					}
				},
			});
		},
	},
	async init() {
		await this.ajax.get_farmlist();
		await this.ajax.getsheeptype();
		this.data.table = jspreadsheet($("#spreadsheet")[0], {
			data: [[]],
			columns: [
				{
					type: "text",
					width: 120,
					title: "รหัสแพะ",
					name: "sheepcode",
				},
				{
					type: "text",
					width: 120,
					title: "ชื่อแพะ",
					name: "sheepname",
				},
				{
					type: "dropdown",
					title: "เพศ",
					width: 120,
					source: imp.data.gender,
					name: "gender",
				},
				{
					type: "dropdown",
					title: "ประเภทแพะ",
					width: 120,
					source: imp.data.rawsheeptype,
					name: "sheep_type",
				},
				{
					type: "dropdown",
					title: "ฟาร์มต้นทาง",
					width: 120,
					source: imp.data.rawfarm,
					name: "farm_id",
				},
				{
					type: "numeric",
					title: "อายุ (เดือน)",
					width: 120,
					name: "old",
				},
				{
					type: "numeric",
					title: "น้ำหนัก (กก.)",
					mask: "#.##,00",
					width: 120,
					decimal: ".",
					name: "weight",
				},
				{
					type: "numeric",
					title: "ส่วนสูง (ซม.)",
					mask: "#.##,00",
					width: 120,
					decimal: ".",
					name: "height",
				},
			],
		});

		$(document).on("click", ".addrows", async (e) => {
			this.data.table.insertRow();
		});
		$(document).on("click", ".delrows", async (e) => {
			this.data.table.deleteRow();
		});
		$(document).on("click", "#saveimport", async (e) => {
			let data = this.data.table.getJson();
			let msg = "";
			let status = true;
			let c = 0;
			data.forEach((ev, i) => {
				if (ev.sheepcode == "") {
					msg += `- รหัสแพะแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
				if (ev.sheepname == "") {
					msg += `- ชื่อแพะแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
				if (ev.gender == "") {
					msg += `- เพศแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
				if (ev.sheep_type == "") {
					msg += `- ประเภทแพะแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
				if (ev.farm_id == "") {
					msg += `- ฟาร์มต้นทางแพะแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
				if (ev.old == "") {
					msg += `- อายุแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
				if (ev.weight == "") {
					msg += `- น้ำหนักแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
				if (ev.height == "") {
					msg += `- ส่วนสูงแถวที่ ${i + 1} ห้ามเป็นค่าว่าง <br>`;
					c++;
				}
			});
			if (c > 0) {
				status = false;
			}
			if (!status) {
				Swal.fire({
					icon: "warning",
					title: "ไม่สามารถบันทึกข้อมูลได้",
					html: msg,
					showConfirmButton: false,
					timer: 3000,
				});
			} else {
				this.ajax.save(data);
			}
		});
	},
};
imp.init();
