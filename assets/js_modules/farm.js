const farm = {
	data: {
		rawsheeptype: null,
	},
	components: {
		content: () => {
			return `
			<div class="d-flex justify-content-end">
				<button type="button" class="btn btn-warning font-m" data-action="update" data-bs-toggle="offcanvas" data-bs-target="#updatefarm" aria-controls="updatefarm">แก้ไขข้อมูลฟาร์ม</button>
			</div>
			<div class="contents-farm-view-item mb-3">
				<div class="">
					<div class="v-label h-100  w-icon">
						<div class="icon">
							<i class="fas fa-warehouse"></i>
						</div>
						<div class="contents">
							<div class="label">ชื่อฟาร์ม</div>
							<div class="text-value">ฟาร์มทดสอบ</div>
						</div>
					</div>
				</div>
				<div class="">
					<div class="v-label h-100  w-icon">
						<div class="icon">
							<i class="fas fa-tag"></i>
						</div>
						<div class="contents">
							<div class="label">เจ้าของฟาร์ม</div>
							<div class="text-value">ผู้ใช้งานทดสอบ</div>
						</div>
					</div>
				</div>
				<div class="">
					<div class="v-label h-100  w-icon">
						<div class="icon">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<div class="contents">
							<div class="label">ที่ตั้งฟาร์ม</div>
							<div class="text-value">17/6 ตำบลบางแสน อำเภอเมืองชลบุรี จังหวัดชลบุรี <i class="fas fa-map-marker text-danger"></i></div>
						</div>
					</div>
				</div>

			<div class="">
				<div class="v-label h-100  w-icon">
					<div class="icon">
						<i class="icon-sheep-icon"></i>
					</div>
					<div class="contents">
						<div class="label">แพะพ่อพันธ์ุ</div>
						<div class="text-value">10 ตัว</div>
					</div>
				</div>
			</div>
			<div class="">
				<div class="v-label h-100  w-icon">
					<div class="icon">
						<i class="icon-sheep-icon"></i>
					</div>
					<div class="contents">
						<div class="label">แพะแม่พันธ์ุ</div>
						<div class="text-value">10 ตัว</div>
					</div>
				</div>
			</div>
			<div class="">
				<div class="v-label h-100  w-icon">
					<div class="icon">
						<i class="icon-sheep-icon"></i>
					</div>
					<div class="contents">
						<div class="label">แพะขุน</div>
						<div class="text-value">5 ตัว</div>
					</div>
				</div>
			</div>
			<div class="">
				<div class="v-label h-100  w-icon">
					<div class="icon">
						<i class="icon-sheep-icon"></i>
					</div>
					<div class="contents">
						<div class="label">แพะปลด</div>
						<div class="text-value">3 ตัว</div>
					</div>
				</div>
			</div>
		</div>
			`;
		},
	},
	Jquery: {
		main: () => {
			$(document).on("show.bs.offcanvas", "#updatefarm", async (e) => {
				let btn = $(e.relatedTarget);
				let action = btn.data("action");

				let text = action == "create" ? "เพิ่มข้อมูลฟาร์ม" : "แก้ไขข้อมูลฟาร์ม";
				$("#offcanvas-headerupdatefarm").text(text);

				$("#updatefarm")
					.after(` <div class="offcanvas-backdrop fade "></div>`)
					.fadeIn(300, () => {
						$(".offcanvas-backdrop").addClass("show");
					});
				await farm.Jquery.get_location();
			});
			$(document).on("hide.bs.offcanvas", "#updatefarm", async (e) => {
				$(`.offcanvas-backdrop`).fadeOut(10, () => {
					$(".offcanvas-backdrop").remove();
				});
			});
		},
		get_location: async () => {
			let amphoe = await get_location();
			let district = await get_location();
			let province = await get_location();

			let data_province = "";
			let data_district = "";
			let data_amphoe = "";
			province.result.province.forEach((ev, i) => {
				data_province += `<option value="${ev.province_id}">${ev.nameTh}</option>`;
			});
			$("#province").html(data_province);
		},
	},
	methods: {
		renderinputsheeptype: async (data) => {
			if (!data) return;
			let item = "";
			data.forEach((ev, i) => {
				item += `
				<div class="mb-3 ">
					<label for="sheep_type${ev.id}" class="form-label">จำนวน${ev.typename} <small>(ตัว)</small></label>
					<input type="number" class="form-control" name="" id="sheep_type${ev.id}" min="0" max="100" data-type-id="${ev.id}"  placeholder="0">
				</div>
				`;
			});
			$("#show-sheeptype").html(item);
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
						farm.data.rawsheeptype = results.data;
					}
				},
			});
		},
	},
	async inti() {
		$(".select2").select2();
		await this.ajax.getsheeptype();
		await this.methods.renderinputsheeptype(this.data.rawsheeptype);
		this.Jquery.main();
		$("#show-content-detail-farm").html(this.components.content());
	},
};
farm.inti();
