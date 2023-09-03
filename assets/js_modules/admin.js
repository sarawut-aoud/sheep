const admin = {
	data: {
		table: "",
		password: true,
	},
	components: {
		text(data) {
			let text = data ? data : "-";
			return `<div class="text-ellipsis-scroll"><span>${text}</span></div>`;
		},
		action(data) {
			return `<button class="btn btn-warning" id="update_level" data-pd-id="${data.pd_id}"><i class="fas fa-user-cog"></i></button>`;
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
			$(tag).addClass("request");
			$(tag).focus();
		},
		removeRequest: (tag) => {
			$(tag).val().length > 0
				? $(tag).removeClass("request")
				: $(tag).addClass("request");
		},
		checkinput: () => {
			let check = true;
			if (!$("#firstname").val()) {
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
			if (chk) {
				await $.ajax({
					type: "POST",
					dataType: "json",
					url: site_url("process/register"),
					data: {
						title: $("#title").val(),
						firstname: $("#firstname").val(),
						lastname: $("#lastname").val(),
						email: $("#email").val(),
						username: $("#username").val(),
						password: $("#password").val(),
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
					username: $("#username").val(),
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (!results.status) {
						$("#username").removeClass("active").addClass("request");
						$(".checkusername").text(results.data);
					} else {
						$("#username").removeClass("request").addClass("active");
						$(".checkusername").text("");
					}
				},
			});
		},
		emailcheck: async () => {
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
						$("#email").removeClass("active").addClass("request");
						$(".checkemail").text(results.data);
					} else {
						$("#email").removeClass("request").addClass("active");
						$(".checkemail").text("");
					}
				},
			});
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
		$(document).on("blur", "#username", async (e) => {
			this.ajax.usernamecheck();
		});
		$(document).on("blur", "#email", async (e) => {
			this.ajax.emailcheck();
		});
		$(document).on("blur ", "#password", async (e) => {
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
	},
};
admin.init();
