const regis = {
	data: {
		password: true,
	},
	methods: {
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
					regis.methods.addrequest("#firstname");
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
				if (!$("#password").val().match(passw)) {
					$("#password").addClass("request");
					regis.data.password = true;
				} else {
					$("#password").removeClass("request").addClass("active");
					regis.data.password = false;
				}
			} else {
				$("#password").removeClass("active").addClass("request");
				regis.data.password = true;
			}
			if (chkpass.val()) {
				if (pass == chkpass.val() && chkpass.val() != "") {
					chkpass.removeClass("request").addClass("active");
					regis.data.password = false;
				} else {
					chkpass.addClass("request");
					regis.data.password = true;
				}
			} else {
				chkpass.addClass("request");
				regis.data.password = true;
			}
		},
		checkforminput: () => {
			let status = false;
			$(".input-form input").each((i, ev) => {
				if ($(ev).hasClass("request") == true) {
					status = true;
				}
			});
			$("#btnregister").prop("disabled", status);
		},
	},
	ajax: {
		register: async () => {
			let chk = regis.methods.checkinput();
			loading_on($("#btnregister"));
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
								title: results.data,
								showConfirmButton: false,
								timer: 1500,
							}).then(() => {
								window.location.href = base_url("home");
							});
						}
					},
				});
				loading_on_remove($("#btnregister"));
			}
			loading_on_remove($("#btnregister"));
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
		$("#btnregister").prop("disabled", true);
		$(document).on("click", "#btnregister", async (e) => {
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
				$("#btnregister").prop("disabled", this.data.password);
			}
		}, 200);
	},
};
regis.init();
