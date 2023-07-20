const profile = {
	data: {
		pd_id: "",
		croppie: null,
		rawdata: [],
	},
	components: {},
	methods: {
		setdata: async (data) => {
			profile.data.pd_id = data.pd_id;
			let img = data.picture
				? base_url(data.picture)
				: base_url("/assets/images/blank_person.jpg");
			$("#image-main").attr("src", img);
			$("#pd_id").val(data.pd_id);
			$("#email-main").text(data.email);
			$("#fullname").text(`${data.firstname} ${data.lastname}`);
			$("#username").val(data.username);
			$("#firstname").val(data.firstname);
			$("#lastname").val(data.lastname);
			$("#email").val(data.email);
			$("#phone").val(data.phone);
			$("#LineID").val(data.line);
			$("#Website").val(data.website);
			$("#PrivateProfile").prop("checked", data.private_profile==1?true:false);
			$("#Notifications").prop("checked",  data.notify==1?true:false);
			$("#tokenNotifications").val(data.token_line);
			$("#Receivemessages").prop("checked",  data.receive==1?true:false);
		},
	},
	ajax: {
		get_data: async () => {
			await $.ajax({
				type: "GET",
				dataType: "json",
				url: site_url("profile/getdata"),
				success: (results) => {
					profile.data.rawdata = results.data;
				},
			});
		},
		savepicture: async (croppie) => {
			croppie
				.croppie("result", {
					type: "canvas",
					size: "viewport",
				})
				.then(async function (img) {
					await $.ajax({
						type: "POST",
						dataType: "json",
						url: site_url("profile/updatepic"),
						data: {
							pictrue: encodeURIComponent(img),
							pd_id: profile.data.pd_id,
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
									window.location.reload();
								});
							} else {
								Swal.fire({
									icon: "Error",
									title: results.data,
									showConfirmButton: false,
									timer: 1500,
								});
							}
						},
					});
				});
		},
		saveprofile: async () => {
			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url("profile/updateprofile"),
				data: {
					pd_id: profile.data.pd_id,
					firstname: $("#firstname").val(),
					lastname: $("#lastname").val(),
					email: $("#email").val(),
					phone: $("#phone").val(),
					lineid: $("#LineID").val(),
					website: $("#Website").val(),
					privateprofile: $("#PrivateProfile").is(":checked") ? 1 : 0,
					notifications: $("#Notifications").is(":checked") ? 1 : 0,
					token: $("#tokenNotifications").val(),
					receivemessages: $("#Receivemessages").is(":checked") ? 1 : 0,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name),
				},
				success: (results) => {
					if (results.status) {
						Swal.fire({
							icon: "success",
							title: "บันทึกข้อมูลสำเร็จ",
							showConfirmButton: false,
							timer: 1500,
						}).then(async () => {
							await profile.ajax.get_data();
							await profile.methods.setdata(profile.data.rawdata);
						});
					} else {
						Swal.fire({
							icon: "Error",
							title: "เกิดข้อผิดพลาด",
							showConfirmButton: false,
							timer: 1500,
						});
					}
				},
			});
		},
	},
	async init() {
		await this.ajax.get_data();
		await this.methods.setdata(this.data.rawdata);
		$(document).on("click", ".box-camera-image", async (e) => {
			if (!mobile) {
				$("#upload-picture").modal("show");
			} else {
				$("#upload-picture").offcanvas("toggle");
			}
		});

		croppie = $("#upload-demo").croppie({
			enableExif: true,
			viewport: {
				width: 200,
				height: 200,
				type: "circle",
			},
			boundary: {
				width: 300,
				height: 300,
			},
		});
		$("#upload").on("change", function () {
			var reader = new FileReader();
			reader.onload = function (e) {
				croppie
					.croppie("bind", {
						url: e.target.result,
					})
					.then(function () {
						console.log("jQuery bind complete");
					});
			};
			reader.readAsDataURL(this.files[0]);
		});
		$(document).on("click", "#savepicture", async (e) => {
			this.ajax.savepicture(croppie);
		});
		$(document).on("click", "#saveprofile", async (e) => {
			this.ajax.saveprofile();
		});
	},
};
profile.init();
