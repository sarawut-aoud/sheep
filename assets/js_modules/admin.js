const admin = {
	data: {
		table: "",
		password: true,
		pd_id: "",
	},
	components: {
		text(data) {
			let text = data ? data : "-";
			return `<div class="text-ellipsis-scroll"><span>${text}</span></div>`;
		},
		action(data) {
			let item = "";
			if (data.status_level == 2) {
				item += `<button title="จัดการให้สิทธิ์" class="btn btn-warning" id="update_level" data-pd-id="${data.pd_id}"><i class="fas fa-user-cog"></i></button>`;
				item += `<button title="แก้ไขข้อมูล" data-bs-toggle="offcanvas" data-bs-target="#getdata" aria-controls="getdata" class="btn btn-warning getdata" id="" data-pd-id="${data.pd_id}"><i class="fas fa-edit"></i></button>`;
				item += `<button title="ลบผู้ใช้ง่าน" class="btn btn-danger deldata" id="" data-pd-id="${data.pd_id}"><i class="fas fa-trash-alt"></i></button>`;
			}
			item += `<button title="ดูข้อมูลส่วนตัว" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-info" id="showdata" data-pd-id="${data.pd_id}"><i class="fas fa-search"></i></button>`;
			return `<div class="d-flex gap-2 ">${item}</div>`;
		},
		copylink(data) {
			return `
                <div class="d-flex flex-column gap-2 justify-content-center">
                    <div>คัดลอกลิงค์สำเร็จ</div>
                    <div class="content-copylink">
                        <div class="text-value">${data}</div>
                    </div>
                </div>
                   `;
		},
	},
	methods: {
		async renderTable(data) {
			admin.data.table.clear().draw();
			if (!data) return;
			data.forEach((ev, i) => {
				admin.data.table.row
					.add([
						admin.components.text(i + 1),
						admin.components.text(ev.fullname),
						admin.components.text(ev.phone),
						admin.components.text(ev.email),
						admin.components.action(ev),
					])
					.draw();
			});
		},
		addrequest: (tag) => {
			let off = $(".offcanvas.show");
			off.find(tag).addClass("request");
			off.find(tag).focus();
		},
		removeRequest: (tag) => {
			$(tag).val().length > 0
				? $(tag).removeClass("request")
				: $(tag).addClass("request");
		},
		checkinput: () => {
			let check = true;
			let off = $(".offcanvas.show");
			if (!off.find("#firstname").val()) {
				Swal.fire({
					icon: "error",
					title: `กรอกชื่อ`,
					showConfirmButton: false,
					timer: 1500,
				}).then(() => {
					admin.methods.addrequest("#firstname");
				});

				check = false;
			}
			return check;
		},
		checkpassword: () => {
			let pass = $("#password").val();
			let chkpass = $("#checkpassword");
			chkpass.removeClass("request active");

			let passw = /(?=.*[A-Za-z])\w{6,20}$/;
			if (pass) {
				if (!$("#password").val().match(passw) || pass.length < 6) {
					$("#password").removeClass("active").addClass("request");
					admin.data.password = true;
				} else {
					$("#password").removeClass("request").addClass("active");
					admin.data.password = false;
				}
			} else {
				$("#password").removeClass("active").addClass("request");
				admin.data.password = true;
			}
			if (chkpass.val()) {
				if (pass == chkpass.val() && chkpass.val() != "") {
					chkpass.removeClass("request").addClass("active");
					admin.data.password = false;
				} else {
					chkpass.addClass("request");
					admin.data.password = true;
				}
			} else {
				chkpass.addClass("request");
				admin.data.password = true;
			}
		},
		checkforminput: () => {
			let status = false;
			$(".input-form input").each((i, ev) => {
				if ($(ev).hasClass("request") == true) {
					status = true;
				}
			});
			$("#saveuser").prop("disabled", status);
		},
	},
	ajax: {
		async get_person() {
			await $.ajax({
				type: "GET",
				dataType: "json",
				url: site_url("admin/Setting/get_person"),
				success: async (results) => {
					if (results.data) {
						await admin.methods.renderTable(results.data.data);
						$("#countperson").text(results.data.count);
					}
				},
			});
		},
		async updatelevel(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				data: {
					pdid: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				url: site_url("admin/Setting/updatelevel"),
				success: async (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "บันทึกสำเร็จ",
							showConfirmButton: false,
							timer: 1500,
						}).then(async () => {
							await admin.ajax.get_person();
						});
					} else {
						Swal.fire({
							icon: "error",
							title: "เกิดข้อผิดพลาดในการบันทึก",
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			});
		},
		register: async () => {
			let chk = admin.methods.checkinput();
			loading_on($("#saveuser"));
			let off = $("#AddUser");
			if (chk) {
				await $.ajax({
					type: "POST",
					dataType: "json",
					url: site_url("process/register"),
					data: {
						title: off.find("#title").val(),
						firstname: off.find("#firstname").val(),
						lastname: off.find("#lastname").val(),
						email: off.find("#email").val(),
						username: off.find("#username").val(),
						password: off.find("#password").val(),
						csrf_token_ci_gen: $.cookie(csrf_cookie_name),
					},
					success: (results) => {
						if (results.status) {
							Swal.fire({
								icon: "success",
								title: `เพิ่มผู้ใช้งานสำเร็จ`,
								showConfirmButton: false,
								timer: 2500,
							}).then(async () => {
								$("#AddUser").offcanvas("hide");
								await admin.ajax.get_person();
							});
						}
					},
				});
				loading_on_remove($("#saveuser"));
			}
			loading_on_remove($("#saveuser"));
		},
		usernamecheck: async () => {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("process/usernamecheck"),
				data: {
					username: $("#AddUser").find("#username").val(),
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (!results.status) {
						$("#AddUser")
							.find("#username")
							.removeClass("active")
							.addClass("request");
						$("#AddUser").find(".checkusername").text(results.data);
					} else {
						$("#AddUser")
							.find("#username")
							.removeClass("request")
							.addClass("active");
						$("#AddUser").find(".checkusername").text("");
					}
				},
			});
		},
		emailcheck: async () => {
			let off = $(".offcanvas.show");
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("process/emailcheck"),
				data: {
					email: $("#email").val(),
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (!results.status) {
						off.find("#email").removeClass("active").addClass("request");
						off.find(".checkemail").text(results.data);
					} else {
						off.find("#email").removeClass("request").addClass("active");
						off.find(".checkemail").text("");
					}
				},
			});
		},
		async showperson(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("admin/setting/showdata"),
				data: {
					pdid: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					let item = "";
					if (results.data) {
						let data = results.data;
						item = `<div class="thumb-lg member-thumb mx-auto" style="width: 150px;">
							<img src="${base_url(
								data.picture
							)}" class="rounded-circle img-thumbnail" alt="profile-image">
						</div>
						<div class="mt-2">
							<h4>${data.fullname}</h4>
						</div>
						<div class="d-flex flex-column gap-2 align-items-start">
							<a href="${data.website}" target="_blank"class="text-pink">${
							data.website ? data.website : "-"
						}</a></span>
							<span>Email : <a href="mailto: ${data.email}"  class="text-pink"> ${
							data.email ? data.email : "-"
						}</a></span>
							<span>Line ID : <span  class="text-pink">${
								data.line ? data.line : "-"
							}</span></span>
							<span>Phone :<span  class="text-pink"> ${
								data.phone ? data.phone : "-"
							}</span></span>
						</div>`;
					}
					$("#showmember").html(item);
				},
			});
		},
		async delete(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("admin/setting/delete"),
				data: {
					pdid: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: `ลบข้อมูลสำเร็จ`,
							showConfirmButton: false,
							timer: 2500,
						}).then(async () => {
							await admin.ajax.get_person();
						});
					}
				},
			});
		},
		async getdata(id) {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("admin/setting/getdata"),
				data: {
					pdid: id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.status) {
						let data = results.data;
						let off = $("#getdata");
						off.find("#title").val(data.title).trigger("change");
						off.find("#firstname").val(data.firstname);
						off.find("#lastname").val(data.lastname);
						off.find("#username").val(data.username);
						off.find("#email").val(data.email);
					}
				},
			});
		},
		async update(id) {
			let chk = admin.methods.checkinput();
			loading_on($("#update"));
			let off = $("#getdata");
			if (chk) {
				await $.ajax({
					type: "POST",
					dataType: "json",
					url: site_url("admin/setting/update"),
					data: {
						pdid: id,
						title: off.find("#title").val(),
						firstname: off.find("#firstname").val(),
						lastname: off.find("#lastname").val(),
						email: off.find("#email").val(),
						username: off.find("#username").val(),
						password: off.find("#password").val(),
						csrf_token_ci_gen: $.cookie(csrf_cookie_name),
					},
					success: (results) => {
						if (results.status) {
							Swal.fire({
								icon: "success",
								title: `แก้ไขข้อมูลสำเร็จ`,
								showConfirmButton: false,
								timer: 2500,
							}).then(async () => {
								$("#getdata").offcanvas("hide");
								await admin.ajax.get_person();
							});
						}
					},
				});
				loading_on_remove($("#update"));
			}
			loading_on_remove($("#update"));
		},
	},
	async init() {
		this.data.table = $("#tbperson").DataTable({
			initComplete: function (settings) {
				initializeDataTables(settings);
			},
		});
		await this.ajax.get_person();
		$(document).on("click", "#copy-link", async (e) => {
			let btn = $(e.target).closest("#copy-link");
			let link = btn.data("link");
			Swal.fire({
				icon: "success",
				html: this.components.copylink(link),
				showConfirmButton: false,
			});
			navigator.clipboard.writeText(link);
		});
		$(document).on("click", ".content-copylink", async (e) => {
			$(e.target).closest(".content-copylink").addClass("active");
		});
		$(document).on("click", "#update_level", async (e) => {
			let btn = $(e.target).closest("#update_level");
			let pd_id = btn.data("pd-id");
			Swal.fire({
				title: "ยืนยันการให้สิทธิ์ Admin",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "ยืนยัน",
				cancelButtonText: "ยกเลิก",
			}).then((result) => {
				if (result.isConfirmed) {
					this.ajax.updatelevel(pd_id);
				}
			});
		});

		$("#saveuser").prop("disabled", true);
		$(document).on("click", "#saveuser", async (e) => {
			await this.ajax.register();
		});
		$(document).on("keyup focus", ".input-form input", async (e) => {
			this.methods.removeRequest($(e.target));
		});
		$(document).on("blur", "#AddUser #username", async (e) => {
			this.ajax.usernamecheck();
		});
		$(document).on("blur", "#email", async (e) => {
			this.ajax.emailcheck();
		});
		$(document).on("blur ", "AddUser #password", async (e) => {
			let passw = /(?=.*[A-Za-z])\w{6,20}$/;
			if (!e.target.value.match(passw)) {
				$("#password").addClass("request");
				this.data.password = true;
			} else {
				$("#password").removeClass("request").addClass("active");
				this.data.password = false;
			}
			if (e.target.value == "") {
				$("#password").removeClass(" active");
				this.data.password = false;
			}
		});
		$(document).on("keyup ", "#password,#checkpassword", async (e) => {
			this.methods.checkpassword();
		});
		setInterval(() => {
			if ($("#password").val() != "" && $("#checkpassword").val() != "") {
				$("#saveuser").prop("disabled", this.data.password);
			}
		}, 200);

		$(document).on("hide.bs.offcanvas", "#AddUser", async (e) => {
			$(".input-form input").each((i, ev) => {
				$(ev).val("");
				$(ev).removeClass("request");
				$(ev).removeClass("active");
			});
		});
		$(document).on("show.bs.modal", "#exampleModal", async (e) => {
			let btn = $(e.relatedTarget);
			let id = btn.data("pd-id");
			await this.ajax.showperson(id);
		});
		$(document).on("click", ".deldata", async (e) => {
			let btn = $(e.target).closest(".deldata");
			let pd_id = btn.data("pd-id");
			let name = $(btn.closest("tr").find("td")[1]).text();
			Swal.fire({
				title: `ต้องการลบผู้ใช้งาน ชื่อ ${name}?`,
				text: `เมื่อลบข้อมูลแล้วจะไม่แสดงข้อมูลของ ${name} ในระบบ`,
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "ยืนยัน",
				cancelButtonText: "ยกเลิก",
			}).then(async (result) => {
				if (result.isConfirmed) {
					await this.ajax.delete(pd_id);
				}
			});
		});
		$(document).on("show.bs.offcanvas", "#getdata", async (e) => {
			let btn = $(e.relatedTarget);
			let pd = btn.data("pd-id");
			this.data.pd_id = pd;
			await this.ajax.getdata(pd);
		});
		$(document).on("click", "#update", async (e) => {
			Swal.fire({
				title: `ยืนยันการแก้ไขข้อมูลเบื้องต้น`,
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "ยืนยัน",
				cancelButtonText: "ยกเลิก",
			}).then(async (result) => {
				if (result.isConfirmed) {
					await this.ajax.update(this.data.pd_id);
				}
			});
		});
	},
};
admin.init();
