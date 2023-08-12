const login = {
	data: {},
	methods: {},
	ajax: {
		async login() {
			let chk = true;
			if ($("#inputUser").val() == "") {
				Swal.fire({
					icon: "error",
					title: `กรอกชื่อเข้าใช้งาน`,
					showConfirmButton: false,
					timer: 1500,
				});
				chk = false;
			}
			if ($("#inputPassword").val() == "") {
				Swal.fire({
					icon: "error",
					title: `กรอกรหัสเข้าใช้งาน`,
					showConfirmButton: false,
					timer: 1500,
				});
				chk = false;
			}
			loading_on($("#btnlogin"));
			if (chk) {
				await $.ajax({
					type: "POST",
					dataType: "json",
					url: site_url("process/login"),
					data: {
						input_username: $("#inputUser").val(),
						input_password: $("#inputPassword").val(),
						csrf_token_ci_gen: $.cookie(csrf_cookie_name),
					},
					success: (results) => {
						if (results.status) {
							Swal.fire({
								icon: "success",
								title: results.message,
								showConfirmButton: false,
								timer: 1500,
							}).then(() => {
								window.location.href = base_url("dashboard");
							});
						} else {
							Swal.fire({
								icon: "error",
								title:'ไม่สามารถบันทึกข้อมูลได้',
								showConfirmButton: false,
								timer: 1500,
							});
						}
					},
				});
				loading_on_remove($("#btnlogin"));
			}
			loading_on_remove($("#btnlogin"));

		},
	},
	async init() {
		$(document).on("keypress", "#inputUser,#inputPassword", async (e) => {
			var key = e.which;
			if (key == 13) {
				$("#btnlogin").click();
				return false;
			}
		});
		$(document).on("click", "#btnlogin", async (e) => {
			this.ajax.login();
		});
	},
};
login.init();
