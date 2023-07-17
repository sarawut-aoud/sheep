const swalbtn = Swal.mixin({
	customClass: {
		confirmButton: 'btn btn-success rounded-pill mx-3',
		cancelButton: 'btn btn-danger rounded-pill mx-3',
		denyButton: 'btn btn-warning rounded-pill mx-3'
	},
	buttonsStyling: false
})
function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function (n, prec) {
			var k = Math.pow(10, prec);
			return '' + Math.round(n * k) / k;
		};
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
}
function setdateAll() {
	const monthNames = [
		"Jan",
		"Feb",
		"Mar",
		"Apr",
		"May",
		"Jun",
		"Jul",
		"Aug",
		"Sep",
		"Oct",
		"Nov",
		"Dec",
	];
	var today = new Date();

	var data =
		today.getDate() +
		"-" +
		monthNames[today.getMonth()] +
		"-" +
		today.getFullYear();
	return data;
}
const application_id = document.getElementById('application_decrypt_id').value;
const sale_type_id = document.getElementById('sale_type_id').value;
const support_type_id = document.getElementById('support_type_id').value;
const sale_price = document.getElementById('sale_price').value
const support_price = document.getElementById('support_price').value
const encrypt_application_id = $('#application_id').val();
const priceInputAll = document.querySelector('[name=priceall]');
const quantityInputAll = document.getElementById('quantitysale');
const quantityInputsup = document.getElementById('quantitysupport');
const ctotalAll = document.querySelector('.ctotalAll');
const ctotalsup = document.querySelector('.ctotalsup');
const totalAll = document.querySelector('.totalAll');
const tax7All = document.querySelector('.tax7All');
const tax3All = document.querySelector('.tax3All');
const totalpriceAll = document.querySelector('.totalpriceAll');
const quantitySale = document.querySelector('.quantity-sale');
const quantitysupport = document.querySelector('.quantity-support');

var package_price = "";
var package_vat = "";
var package_tax = "";
let sale_val = "";
let sup_val = "";
function readURL(input) {
	if (input.files[0]) {
		let reader = new FileReader();
		document.querySelector('#no-img').classList.replace("d-block", "d-none");
		document.querySelector('#imgControl').classList.replace("d-none", "d-block");
		reader.onload = function (e) {
			let element = document.querySelector('#imgUpload');
			element.setAttribute("src", e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
	}
}

function update_check_all($quantity, $table, check, type) {

	var sum = 0;
	let rows = ''
	if (type == 'sale') {
		rows = 4
	} else {
		rows = 5
	}
	for (i = 0; i < $table.length; i++) {

		var div = $($table[i][rows]);
		var num = $(div).find('input').is(':checked');
		if (num == true) {
			sum = sum + 1;
		}
	}

	if (check == 'check') {
		if (sum > 1) {
			for (i = 0; i < $table.length; i++) {
				var div = $($table[i][rows]);
				$(div).find('input').val(0);
				$(div).find('input').attr('checked', false);
				var row = $(div).find('input').attr('data-row');
				$('.tbposition').dataTable().fnUpdate(div[0].outerHTML, row, rows, false);
			}
			for_check($quantity, $table, rows)

		} else {
			for_check($quantity, $table, rows)
		}

	} else {
		for (i = 0; i < $quantity; i++) {
			var div = $($table[i][rows]);
			$(div).find('input').val(0);
			$(div).find('input').attr('checked', false);
			var row = $(div).find('input').attr('data-row');
			$('.tbposition').dataTable().fnUpdate(div[0].outerHTML, row, rows, false);
		}
		count_used($table, $quantity, row)
		$('input[target*="check_all"]').prop('disabled', false);
		$('#tb_position').on('draw.dt', function () {
			$('input[target="check_all"]').prop('disabled', false);
		});
	}

}

function for_check($quantity, $table, rows) {

	for (i = 0; i < $quantity; i++) {
		var div = $($table[i][rows]);
		$(div).find('input').val(1);
		$(div).find('input').attr('checked', true);
		var row = $(div).find('input').attr('data-row');
		$('.tbposition').dataTable().fnUpdate(div[0].outerHTML, row, rows, false);

	}

	count_used($table, $quantity, row, rows)
	if (rows == 4) {
		$('.check_allsale').not(':checked').prop('disabled', true);
		$('#tb_position').on('draw.dt', function () {
			$('.check_allsale').not(':checked').prop('disabled', true);
		});
	} else {
		$('.check_allsupport').not(':checked').prop('disabled', true);
		$('#tb_position').on('draw.dt', function () {
			$('.check_allsupport').not(':checked').prop('disabled', true);
		});
	}



}

function count_used($table, $quantity, row, rows) {

	var count = 0;
	var $table = $('.tbposition').dataTable().fnGetData();
	for (i = 0; i < $table.length; i++) {

		var div = $($table[i][rows]);
		var num = $(div).find('input').val();
		if (num == 1) {
			count += 1;
		}
	}
	if (rows == 4) {
		$('.check_topageSale  .permission_use').html(count);
	} else {
		$('.check_topageSup .permission_use').html(count);
	}

}

function check_length($table, element) {
	var sum = 1;

	for (i = 0; i < $table.length; i++) {
		var div = $($table[i][3]);
		var num = $(div).find('input').val();
		if (num == 1) {
			sum += 1;
		}
	}

	return sum;
}

function calculatePieCostALL() {

	const formatToCurrency = amount => {
		return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
	};
	const price_sale = sale_val * sale_price
	const price_sup = sup_val * support_price
	const cost = price_sale + price_sup;
	totalAll.innerText = formatToCurrency(cost);
	tax7All.innerText = formatToCurrency(cost * 0.07);
	tax3All.innerText = formatToCurrency(cost * 0.03);
	const deducttax3 = (cost * 0.03);
	var deducttax3calu = 0;
	if ($("#taxdeductionAll").is(':checked')) {
		deducttax3calu = deducttax3;
	}

	totalpriceAll.innerText = formatToCurrency((cost + (cost * 0.07)) - deducttax3calu);
	priceInputAll.value = formatToCurrency((cost + (cost * 0.07)) - deducttax3calu)
	// // $("#pro_package_id").val(puformatToCurrency((cost + (cost * 0.07)) - deducttax3calu)r_pack.data.dataTarget);
	$("#pro_order_price").val((cost + (cost * 0.07)) - deducttax3calu);
	$("#pro_sum_tax").val((cost * 0.07));
	$("#pro_sum_amount").val(cost);
	$("#pro_wht").val(deducttax3calu);
	// }
}

function updatequantitySale() {
	const quantity = quantityInputAll.value;
	if (quantity < 2000) {
		quantitySale.innerText = quantity + " Employee";
	} else {
		quantitySale.innerText = 2000 + "+ Employee";
	}
}


function calculate_sale(method) {
	if (method == 0) {
		$('.ctotalAll_sale').text(0)
		sale_val = 0

	} else {
		const formatToCurrency = amount => {
			return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
		};
		$('.ctotalAll_sale').text(formatToCurrency($('#quantitysale').val() * sale_price))
		$(document).on('input', '#quantitysale', (e) => {
			let value = $(e.target).val();
			let resul = '';
			const cost = sale_price * value
			sale_val = value
			calculatePieCostALL()
			$('.ctotalAll_sale').text(formatToCurrency(cost))

			if (value < 2000) {
				result = value + " Employee";
			} else {
				result = 2000 + "+ Employee";
			}
			$('.quantity-sale').text(result)
		})

	}

}

function calculate_sup(method) {
	if (method == 0) {
		$('.ctotalAll_support').text(0)

		sup_val = 0
	} else {
		const formatToCurrency = amount => {
			return amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, "$&,");
		};
		$('.ctotalAll_support').text(formatToCurrency($('#quantitysupport').val() * support_price))
		$(document).on('input', '#quantitysupport', (e) => {
			let value = $(e.target).val();
			let resul = '';
			const cost = support_price * value
			sup_val = value

			calculatePieCostALL()
			$('.ctotalAll_support').text(formatToCurrency(cost))

			if (value < 2000) {
				result = value + " Employee";
			} else {
				result = 2000 + "+ Employee";
			}
			$('.quantity-support').text(result)
		})

	}

}
for (let e of document.querySelectorAll('input[type="range"].g-progress')) {
	e.style.setProperty('--value', e.value);
	e.style.setProperty('--min', e.min == '' ? '0' : e.min);
	e.style.setProperty('--max', e.max == '' ? '2000' : e.max);
	e.addEventListener('input', () => e.style.setProperty('--value', e.value))
};



const pur_pack = {
	data: {
		freePacketid: [],
		proPacketidsale: [],
		proPacketidsup: [],
		dataTarget: "",
		target: "",
		typename: "",
		freesubpackage: [],
		freesalepackage: [],
		package_pro: [],
		order_id: "",
		form: {
			order_id: "",
			sum_tax: "",
			sum_amount: "",
			order_price: "",
			wht: "",
			wht_vat: "",
			quantity: "",
			package_id: "",
			productname: "",
			invoice_no: "",
		}
	},

	methods: {
		switch_pack: (data) => {
			// check Type Programmer
			if ($.inArray(data, [8, 9, 10]) >= 0) {
				return 'GHRM';
			}
			if ($.inArray(data, [14, 15, 16, 17]) >= 0) {
				return 'GCRM';
			}

		},
		check_typedata: (data = null) => {
			// check Type Package 
			if (data == null) return false;

			if (data == 14 || data == 15) {
				return sale_type_id;
			}
			if (data == 16 || data == 17) {
				return support_type_id
			}

		}
	},
	ajax: {
		get_dataPackage: async (package_id) => {

			await $.ajax({
				type: "POST",
				dataType: "json",
				url: site_url('package_purchase/get_dataPackage'),
				data: {
					encrypt_application_id: encrypt_application_id,
					package_id: package_id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name)
				},
				success: (results) => {
					var result = results.data;
					package_price = result.package_price;
					package_tax = result.package_tax;
					package_vat = result.package_vat;

				}
			})
		},
		saveFreepackage: async (target, dataTarget) => {
			$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

			const fdata = new FormData();
			// const fdata = new FormData($("#savepacakgeghrm")[0]);
			fdata.append('package_id', dataTarget);
			fdata.append('target', target);
			fdata.append('application_id', application_id)

			fdata.append('csrf_token_ci_gen', $.cookie(csrf_cookie_name));

			await $.ajax({
				method: "POST",
				url: site_url("package_purchase/Purchase_free/savepackage_free"),
				dataType: "json",
				data: fdata,
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				success: function (result) {
					if (result.data.is_successful) {
						if (result.data.check == true) {
							swalbtn.fire({
								title: 'ท่านเคยสมัคร Package นี้แล้ว',
								icon: 'info',
								showCancelButton: false,
								showConfirmButton: false,
								timer: 1500,
							})
						} else {
							$("fieldset").eq(1).css('display', 'none');
							$("fieldset").eq(2).css('display', 'block');
							swalbtn.fire({
								icon: "success",
								html: result.data.message,
								showConfirmButton: false,
								timer: 1500
							}).then(() => {
								window.location.reload()
							});
						}

					} else {
						swalbtn.fire({
							icon: "error",
							html: result.data.message,
							showConfirmButton: false,
							timer: 1500
						}).then(() => {
							window.location.reload()
						});
					}
				},
				error: function (jqXHR, exception) {
					ajaxErrorMessage(jqXHR, exception);
				},
			});
		},
		Check_person: async (package_id) => {
			var modal = $('#modal-position-check');
			// let amount = $('input[name="quantityall"]').val();
			let quantity = $('input[name="quantityall"]')
			let amount = [];
			quantity.each((index, elem) => {
				if ($(elem).parents('.form-check').find('.checkboxpurchase').is(':checked')) {
					amount.push(
						$(elem).val()
					)
				}

			})

			await $.ajax({
				type: 'POST',
				dataType: 'json',
				url: site_url('package_purchase/Package_purchase/get_peson_check'),
				data: {
					application_id: encrypt_application_id,
					package_id,
					amount,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name)
				},
				success: (results) => {

					if (results.status) {
						modal.modal({
							backdrop: 'static',
							keyboard: false
						});
						modal.modal('show');
						pur_pack.ajax.load_select.get_position()
						pur_pack.ajax.load_select.get_branchs()
					} else {
						pur_pack.ajax.save_order_pack();
					}


				}

			})
		},
		save_order_pack: (data_position = '', data_arr = '') => {
			var btn = $('.savepackagepro_crm');
			const fdata = new FormData($("#savepacakgeghrm")[0]);
			fdata.append('package_id', pur_pack.data.package_pro);
			fdata.append('encrypt_application_id', encrypt_application_id);
			let quantity = $('input[name="quantityall"]');
			quantity.each((index, elem) => {
				if ($(elem).parents('.form-check').find('.checkboxpurchase').is(':checked')) {
					fdata.append('quantityall[]', $(elem).val());
				}
			})


			if (data_position && data_arr) {

				fdata.append('type_id', pur_pack.data.typename)
				for (i in data_position) {
					fdata.append(`arr_position[${i}]`, data_position[i].position)
				}
				for (i in data_arr) {
					fdata.append(`arr_sale[${i}]`, data_arr[i].status_sale)
					fdata.append(`arr_support[${i}]`, data_arr[i].status_support)
				}
			}

			loading_on(btn)

			Swal.fire({
				title: 'ต้องการจ่ายเงิน?',
				icon: 'warning',
				showCancelButton: true,
				showDenyButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				denyButtonColor: '#f2bb13',
				confirmButtonText: 'ชำระเงิน',
				denyButtonText: 'ข้ามการชำระเงิน',
				showCancelButton: false,
			}).then((result) => {
				if (result.isConfirmed) {

					pur_pack.ajax.ksher(fdata)

					loading_on_remove(btn)
				} else if (result.isDenied) {
					current_fs = $(this).parent();
					next_fs = $(this).parent().next();
					//Add Class Active
					$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
					$("fieldset").eq(1).css('display', 'none');

					pur_pack.ajax.not_ksher(fdata)

					loading_on_remove(btn)
				}

			})
			loading_on_remove(btn)

		},
		ksher: async (formdata) => {
			await $.ajax({
				method: "POST",
				url: site_url("package_purchase/Purchase_pro/SavePackagePro"),
				dataType: "json",
				data: formdata,
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				success: function (result) {
					if (result.is_successful) {
						if (result.invoice_no) {
							//create payment
							var mch_order_no = result.invoice_no;
							var fdata = 'product_name=' + pur_pack.data.dataTarget;
							fdata += '&local_total_fee=' + 1; // result.order_price;
							fdata += '&action=gateway_pay';
							fdata += '&mch_order_no=' + mch_order_no;
							fdata += '&fee_type=THB';
							fdata += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name),
								$.ajax({
									method: "POST",
									url: site_url("pay/payment_pay"),
									dataType: "json",
									data: fdata,
									success: function (result) {
										if (result.message == 'SUCCESS') {
											window.location.href = result.data.pay_content;
										} else {
											swalbtn.fire({
												icon: "error",
												title: result.message,
												showConfirmButton: false,
												timer: 1500
											});
										}
									},
									error: function (jqXHR, exception) {
										ajaxErrorMessage(jqXHR, exception);
									},
								});
						}
					} else {
						Swal.fire({
							icon: "error",
							title: result.message,
							showConfirmButton: false,
							timer: 1500
						});
					}
				},
				error: function (jqXHR, exception) {
					ajaxErrorMessage(jqXHR, exception);
				},
			});
		},
		not_ksher: async (formdata) => {
			await $.ajax({
				method: "POST",
				url: site_url("package_purchase/Purchase_pro/SavePackagePro"),
				dataType: "json",
				data: formdata,
				enctype: 'multipart/form-data',
				processData: false,
				contentType: false,
				success: function (result) {
					if (result.is_successful) {
						if (result.invoice_no) {
							$("fieldset").eq(1).css('display', 'none');
							$("fieldset").eq(2).css('display', 'block');
						}
					} else {
						swalbtn.fire({
							icon: "error",
							title: result.message,
							showConfirmButton: false,
							timer: 1500
						});
					}
				},
				error: function (jqXHR, exception) {
					ajaxErrorMessage(jqXHR, exception);
				},
			});
		},
		get_qo: async (fdata) => {
			await $.ajax({
				method: "POST",
				url: site_url("package_purchase/get_orders"),
				dataType: "json",
				data: fdata,
				success: function (result) {
					if (result.length > 0) {
						$(".orderprice_preview").text(number_format(result[0].sum_amount, 2));
						$(".tax7_preview").text(number_format(result[0].sum_tax, 2));
						if (result[0].wht > 0) {
							$(".tax3_preview").text(number_format(result[0].wht, 2));
						} else {
							$(".tax3_preview").text(0.00);
						}
						$(".totalprice_preview").text(number_format(result[0].order_price, 2));
						$('#upload-slip-payment').attr('data-order-id', (result[0].order_id))
						pur_pack.data.order_id = result[0].order_id
					}

				},
				error: function (jqXHR, exception) {
					ajaxErrorMessage(jqXHR, exception);
				},
			});
		},
		get_bank: async () => {
			let frmdata = site_url('package_payment/get_bank_payment');
			$.ajax({
				type: "get",
				dataType: 'json',
				url: frmdata,
				success: (results) => {
					let html = `<option value="">--- ธนาคาร ---</option>`;
					for (i in results) {
						html += `<option value="${results[i].id}">${results[i].bank_name}</option>`;
					}
					$("#bank_payment").html(html);
				}
			})
		},
		upload_payment: async (order_id) => {
			let frmdata = site_url('package_payment/upload_payment');
			var fdata = new FormData($("#form-data-payment")[0]);
			fdata.append('order_id', order_id);
			// console.table(Object.fromEntries(fdata))
			var obj = $("#upload-img-payment");
			loading_on(obj);

			await $.ajax({
				type: "POST",
				url: frmdata,
				dataType: "json",
				data: fdata,
				cache: false,
				contentType: false,
				processData: false,
				success: function (result) {
					loading_on_remove(obj)
					if (result.is_successful) {
						let timerInterval
						Swal.fire({
							icon: "success",
							title: 'สถานะ',
							html: 'กำลังตรวจสอบหลักฐานการชำละเงิน',
							timer: 5000,
							timerProgressBar: true,
						}).then(() => {
							location.href = base_url('users/dashboard')
						})

					} else {
						Swal.fire({
							icon: "error",
							title: result.message,
						});
						loading_on_remove(obj);
					}
				},
				error: function (jqXHR, exception) {
					Swal.fire({
						icon: "error",
						title: "เกิดข้อผิดพลาดในการอัพโหลดหลักฐานการชำระเงิน",
					});
					loading_on_remove(obj);
				},
			});

		},
		Sendmail: async () => {
			let frmdata = site_url('package_payment/sendtoemail_contact');
			let fdata = $('#contactForm').serialize();
			fdata += "&" + csrf_token_name + "=" + $.cookie(csrf_cookie_name);
			var obj = $("#send-contact");
			if (loading_on(obj) == true) {
				$.ajax({
					type: "POST",
					url: frmdata,
					dataType: "json",
					data: fdata,
					success: function (result) {
						if (result.is_successful) {
							Swal.fire({
								icon: "success",
								html: result.message,
								showConfirmButton: true,
								timer: 2000,
							});

							setTimeout(function () {
								location.reload();
							}, 1000);
						} else {
							Swal.fire({
								icon: "error",
								html: result.message,
							});
							loading_on_remove(obj);
						}
					},

				});

			}
		},
		load_select: {
			get_branchs: async () => {
				let frmdata = site_url("users/position/get_branchs");

				await $.ajax({
					type: "GET",
					dataType: "JSON",
					url: frmdata,
					success: (results) => {
						let html = `<option value="">- เลือกสาขา -</option>`;
						for (i in results) {
							html += `<option value="${results[i].branch_id}">${results[i].branch_name}</option>`;
						}
						$('.branch').html(html);
					}
				});
			},
			get_Employee: async () => {
				let frmdata = site_url("users/position/get_Employee");

				let html = `<option value="">- เลือกพนักงาน -</option>`;
				$('.emp_id').html(html);
				var b_id = $('.branch').val();
				var p_id = $('.position').val();
				if (b_id && p_id) {
					await $.ajax({
						type: "GET",
						dataType: "JSON",
						url: frmdata,
						data: {
							branch_id: $('.branch').val(),
							position_id: $('.position').val(),
						},
						beforeSend: () => { },
						success: (results) => {

							for (i in results) {

								html += `<option value="${results[i].pd_id}">${results[i].title + results[i].fullname}</option>`;
							}
							$('.emp_id').html(html);
						}
					});
				}

			},
			get_position: async () => {
				let frmdata = site_url("users/position/get_position");

				let html = `<option value="">- เลือกตำแหน่งงาน -</option>`;

				$('.position').html(html);
				var data_id = $('.branch').val();

				await $.ajax({
					type: "GET",
					dataType: "JSON",
					url: frmdata,
					data: {
						branch_id: $('.branch').val()
					},
					beforeSend: () => { },
					success: (results) => {
						for (i in results) {
							html += `<option value="${results[i].position_name}">${results[i].position_name}</option>`;
						}
						$('.position').html(html);
					}
				});


			},
		},
		load_table: {
			data_tb: async (branch, pos_id) => {
				let arr = pur_pack.data.proPacketidsale.concat(pur_pack.data.proPacketidsup);
				let type = await (pur_pack.ajax.getTypepackage(arr))
				var btn = $('.btn_search');
				var loaddata = `  <div id='loader_table'>
                                    <div class="row justify-content-center " style="padding: 5rem;">
                                        <div class="loader-three-quarters-loader">Loading...</div>
                                    </div>
                                </div>`;
				loading_on(btn)
				$('.class_datatable').html(loaddata);
				await $.ajax({
					type: 'POST',
					dataType: 'json',
					url: site_url("users/position/search"),
					data: {
						branch_id: branch,
						position_id: pos_id,
						type: 'payment',
						csrf_token_ci_gen: $.cookie(csrf_cookie_name)
					},
					success: (results) => {
						let html = `
                        <div class="table-responsive">
                            <table class="table  table-striped tbposition" id="tb_position" width="100%">
                                <thead align="center" bgcolor="#8a8a8a" class="text-white">
                                    <th style="width: 331px;">ตำแหน่ง</th>
                                    <th style="width: 285px;">พนักงานประจำตำแหน่ง</th>
									<th style="width: 100px;">SALE</th>
									<th style="width: 100px;">SUPPORT</th>
                                    <th class="check_topage check_topageSale" style="font-size:14px;width: 280px;">ตำแหน่งที่ต่ออายุการใช้งาน Sale
                                    	<span>( <i class="permission_use"></i> Use)</span>
                                    </th>
                                    <th class="check_topage check_topageSup" style="font-size:14px;width: 280px;">ตำแหน่งที่ต่ออายุการใช้งาน Support
                                    	<span>( <i class="permission_use"></i> Use)</span>
                                    </th>
									<th hidden></th>
                                    </thead>
                                <tbody>`;
						var chk;
						var value;


						results.forEach((elem, index) => {
							html += `<tr>
										<td>${elem.position_name}</td>
										<td>${elem.employee}</td>
										<td>${pur_pack.ajax.load_table.set_table(elem.package, 2)}</td>
										<td>${pur_pack.ajax.load_table.set_table(elem.package, 3)}</td>
										<td class="text-center">
											${pur_pack.ajax.load_table.set_checkbox(elem, 'sale', index)}	
										</td>
										<td class="text-center">
											${pur_pack.ajax.load_table.set_checkbox(elem, 'support', index)}	
										</td>
										<td class="d-none">
											${elem.position_id}	
										</td>
								</tr> `
						});
						html += `</tbody></table></div> `;

						$('.class_datatable').html(html)
						$('.tbposition').DataTable();
						$(`.check_allsale`).prop('disabled', true);
						$(`.check_allsupport`).prop('disabled', true);
						$('.is_enable').prop('disabled', true)
						$('#tb_position').on('draw.dt', function () {
							$(`.crm_switchSale`).prop('disabled', true);
							$(`.crm_switchSupport`).prop('disabled', true);


						});
						
						if(type.data.length > 0){
							type.data.forEach((ev, idx) => {
								if (ev == '2') {
									$(`.check_allsale`).prop('disabled', false);
								} else {
									$(`.check_allsupport`).prop('disabled', false);
								}
							})
						}
						

						if ($('.check_allsale').is(':disabled') === false) {
							$('table#tb_position').on('click', '.check_topageSale', function () {
								var $table = $('.tbposition').dataTable().fnGetData()
								var $quantity = $("#quantitysale").val();
								console.log($table);
								Swal.fire({
									title: 'คุณต้องการต่ออายุการใช้งานทุกตำแหน่งหรือไม่',
									icon: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'เปิด',
									cancelButtonText: 'ยกเลิก'
								}).then((result) => {
									if (result.isConfirmed) {
										update_check_all($quantity, $table, 'check', 'sale');
									} else {
										update_check_all($quantity, $table, 'uncheck', 'sale');
									}
								})

							});
						}
						if ($('.check_allsupport').is(':disabled') === false) {

							$('table#tb_position').on('click', '.check_topageSup', function () {
								var $table = $('.tbposition').dataTable().fnGetData()
								var $quantity = $("#quantitysupport").val();
								console.log($table);
								Swal.fire({
									title: 'คุณต้องการต่ออายุการใช้งานทุกตำแหน่งหรือไม่',
									icon: 'warning',
									showCancelButton: true,
									confirmButtonColor: '#3085d6',
									cancelButtonColor: '#d33',
									confirmButtonText: 'เปิด',
									cancelButtonText: 'ยกเลิก'
								}).then((result) => {
									if (result.isConfirmed) {
										update_check_all($quantity, $table, 'check', 'sup');
									} else {
										update_check_all($quantity, $table, 'uncheck', 'sup');
									}
								})

							});
						}
						loading_on_remove(btn)
					},
					error: function (jqXHR, exception) {
						ajaxErrorMessage(jqXHR, exception);
						loading_on_remove(btn);
					}
				})
				loading_on_remove(btn)
			},
			set_table: (data, type) => {
				var html = '';
				data.forEach((ev, idx) => {
					if (ev.type_id != 1) {
						if (type == ev.type_id) {
							html += ev.html
						}

					}
				})
				return html;
			},
			set_checkbox: (elem, type, index) => {
				let item = '';
				item += `<div class="form-check" >
								<div class="form-check form-switch form-switch-lg  d-flex justify-content-center">
									<input class="form-check-input for_check  check-package check_all${type}" data-position="${elem.position_id}" data-row="${index}" type="checkbox" target="check_all${type}" value="">
								</div>
							</div>
					 `
				return item;

			}
		},

		save_pos_app_log: async () => {
			var modal = $('#modal-position-check');
			var datatb = $('.tbposition').dataTable().fnGetData();
			var data_arr = [];
			var data_position = [];
			for (i = 0; i < datatb.length; i++) {
				data_arr.push(
					{
						'status_sale': $(datatb[i][4]).find('input').val(),
						'status_support': $(datatb[i][5]).find('input').val()

					}
				)
			}
			for (i = 0; i < datatb.length; i++) {
				data_position.push({
					'position': $(datatb[i][5]).find('input').attr('data-position')
				})
			}


			try {
				Swal.fire({
					title: 'ยืนยันการเลือกตำแหน่ง',
					icon: 'info',
					showCancelButton: true,
					showDenyButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					denyButtonColor: '#f2bb13',
					confirmButtonText: 'ตกลง',
					denyButtonText: 'เลือกใหม่',
					showCancelButton: false,
				}).then((btn) => {
					if (btn.isConfirmed) {
						modal.modal('hide');
						setTimeout(() => {
							pur_pack.ajax.save_order_pack(data_position, data_arr);
						}, 1000);

					} else {

					}
				})

			} catch (error) {
				console.error(error);
			}

		},
		getTypepackage: async (pack_id) => {

			return await $.ajax({
				type: 'POST',
				dataType: 'json',
				url: site_url('package_purchase/Package_purchase/getTypepackage'),
				data: {
					pack_id,
					csrf_token_ci_gen: $.cookie(csrf_cookie_name)
				},
				success: (results) => {

				}
			})
		},

		get_package: async () => {
			if (pur_pack.data.order_id != '') {

				await $.ajax({
					type: 'POST',
					dataType: 'json',
					url: site_url('package_purchase/getPackage'),
					data: {
						order_id: pur_pack.data.order_id,
						application_id: application_id,
						csrf_token_ci_gen: $.cookie(csrf_cookie_name),
					},
					success: (results) => {
						if (results.status) {
							let data = results.data
							pur_pack.data.form.order_id = data.order_id
							pur_pack.data.form.sum_tax = data.sum_tax
							pur_pack.data.form.sum_amount = data.sum_amount
							pur_pack.data.form.order_price = data.order_price
							pur_pack.data.form.wht = data.wht
							pur_pack.data.form.wht_vat = data.wht_vat
							pur_pack.data.form.quantity = data.quantity
							pur_pack.data.form.package_id = data.package_id
							pur_pack.data.form.productname = data.productname
							pur_pack.data.form.invoice_no = data.invoice_no
						}
					}
				})
			}
		},
		billpayment: async () => {
			let encrypt_user_id = $('input[name="encrypt_user_id"]').val()
			swalbtn.fire({
				title: "ต้องการจ่ายเงิน?",
				icon: "warning",
				showCancelButton: true,
				showDenyButton: true,
				confirmButtonText: "ชำระเงิน",
				denyButtonText: "ยกเลิก",
				showCancelButton: false,
			}).then((result) => {
				if (result.isConfirmed) {
					var mch_order_no = pur_pack.data.form.invoice_no ;
					var fdata = "product_name=" + pur_pack.data.form.productname;
					fdata += "&local_total_fee=" + 1; // result.order_price;
					fdata += "&action=gateway_pay";
					fdata += "&mch_order_no=" + mch_order_no;
					fdata += "&fee_type=THB";
					fdata += "&" + csrf_token_name + "=" + $.cookie(csrf_cookie_name),
						$.ajax({
							method: "POST",
							url: site_url("pay/payment_pay"),
							dataType: "json",
							data: fdata,
							success: function (result) {
								if (result.message == "SUCCESS") {
									window.location.href = result.data.pay_content;
								} else {
									Swal.fire({
										icon: "error",
										title: result.message,
										showConfirmButton: false,
										timer: 1500,
									});
								}
							},
							error: function (jqXHR, exception) {
								ajaxErrorMessage(jqXHR, exception);
							},
						});
				}

			})
		}
	},


}
$(document).ready(function () {
	$('.saleprice').text(sale_price)
	$('.supportprice').text(support_price)
	if ($('#selectqo option:selected').val() != '') {
		setTimeout(() => {
			$('#selectqo').val($('#selectqo option:selected').val()).trigger('change')

		}, 200);
	}
	$('.modal').on('hidden.bs.modal', (e) => {
		let btn = ['#upload-img-payment'];
		btn.forEach(element => {
			loading_on_remove($(element))
		});
	})

	/** //! Package Free */

	$(document).on("click", ".hfree", function () {
		if ($("div#accordiong.accordion.d-none").length > 0) {
			$("#accordiong").removeClass("d-none");
			$(".hfree").find("img").css("transform", "rotate(0deg)");
		} else {
			$("#accordiong").addClass("d-none");
			$(".hfree").find("img").css("transform", "rotate(269deg)");
		}
	});
	$(document).on("click", ".hpro", function () {
		if ($("div#accordiong-pro.accordion.d-none").length > 0) {
			$("#accordiong-pro").removeClass("d-none");
			$(".hpro").find("img").css("transform", "rotate(0deg)");
		} else {
			$("#accordiong-pro").addClass("d-none");
			$(".hpro").find("img").css("transform", "rotate(269deg)");
		}
	});
	// $(document).on('change', '#typepackage_id', (e) => {
	// 	pur_pack.data.freePacketid = $(e.target).val()
	// 	$('.savepackagefree_crm').attr('data-target', pur_pack.data.freePacketid)
	// })
	$(document).on('change', '#freesale', (e) => {
		let obj = $(e.target)
		let chk = obj.is(':checked')

		let input = obj.find('.showpackage_type').find('input')
		if (chk) {
			$('.savepackagefree_crm').attr('data-target', pur_pack.data.freePacketid)
			obj.parents('.form-check').find('.showpackage_type').slideDown()
		} else {
			obj.parents('.form-check').find('.showpackage_type').slideUp()
			$('.checkbox_forfree_sale').prop('checked', false)

		}

	})
	$(document).on('change', '#freesupport', (e) => {
		let obj = $(e.target)
		let chk = obj.is(':checked')
		let input = obj.find('.showpackage_type').find('input')
		if (chk) {

			obj.parents('.form-check').find('.showpackage_type').slideDown()
		} else {
			obj.parents('.form-check').find('.showpackage_type').slideUp()
			$('.checkbox_forfree_support').prop('checked', false)
		}

	})
	$(document).on('change', '.checkbox_forfree_support', (e) => {
		if ($(e.target).is(':checked')) {
			pur_pack.data.freesubpackage.pop()
			pur_pack.data.freesubpackage.push($(e.target).val())
			$('.checkbox_forfree_support').not(e.target).prop('checked', false)
		} else {
			pur_pack.data.freesubpackage.pop()
		}

	})
	$(document).on('click', '.checkbox_forfree_sale', (e) => {
		if ($(e.target).is(':checked')) {
			pur_pack.data.freesalepackage.pop()
			pur_pack.data.freesalepackage.push($(e.target).val())
			$('.checkbox_forfree_sale').not(e.target).prop('checked', false)
		} else {
			pur_pack.data.freesalepackage.pop()
		}

	})
	$(document).on('click', '.savepackagefree_crm', async (e) => {

		var target = 'GCRM'
		let arr = pur_pack.data.freesalepackage.concat(pur_pack.data.freesubpackage);

		let chk = false;
		let dataTarget = false;
		$('.checkboxfree').each((index, elem) => {
			if ($(elem).is(':checked')) {
				chk = true
				$(elem).parents('.form-check').find('.showpackage_type').find('input').each((i, ev) => {
					if ($(ev).is(':checked')) {
						dataTarget = true
					}
				});

			}
		})


		let packagetype = await (pur_pack.ajax.getTypepackage(arr))

		if (chk) {
			if (dataTarget) {
				Swal.fire({
					title: 'ยืนยันใช้งานฟรี ?',
					text: `สำหรับ ${packagetype.data} `,
					icon: 'warning',
					showCancelButton: true,
					cancelButtonColor: '#d33',
					denyButtonColor: '#f2bb13',
					confirmButtonText: 'ตกลง',
					showCancelButton: false,

				}).then((result) => {

					if (result.isConfirmed) {
						current_fs = $(this).parent();
						next_fs = $(this).parent().next();
						pur_pack.ajax.saveFreepackage(target, arr)
					}
				})
			} else {
				Swal.fire({
					title: 'ท่านยังไม่ได้เลือก Package',
					icon: 'info',
					showCancelButton: false,
					showConfirmButton: false,
					timer: 1500,
				})
			}
		} else {
			Swal.fire({
				title: 'ท่านยังไม่ได้เลือก Options สำหรับการใช้งาน Package',
				icon: 'info',
				showCancelButton: false,
				showConfirmButton: false,
				timer: 1500,
			})
		}

	});

	/** //! Package Pro */

	$(document).on('change', '#sale', (e) => {
		let obj = $(e.target)
		let chk = obj.is(':checked')

		let input = obj.find('.showrange').find('input')
		if (chk) {
			calculate_sale(sale_price);
			sale_val = 1
			pur_pack.data.proPacketidsale.pop()
			pur_pack.data.proPacketidsale.push($(e.target).val())
			// $('.savepackagepro_crm').attr('data-target', pur_pack.data.proPacketid)
			obj.parents('.form-check').find('.showrange').slideDown()
		} else {
			sale_val = 0
			calculate_sale(0);
			pur_pack.data.proPacketidsale.pop()
			obj.parents('.form-check').find('.showrange').slideUp()
		}
		calculatePieCostALL();

	})
	$(document).on('change', '#support', (e) => {
		let obj = $(e.target)
		let chk = obj.is(':checked')
		let input = obj.find('.showrange').find('input')
		if (chk) {
			calculate_sup(support_price)
			sup_val = 1
			pur_pack.data.proPacketidsup.pop()
			pur_pack.data.proPacketidsup.push($(e.target).val())
			// $('.savepackagepro_crm').attr('data-target', pur_pack.data.proPacketid)
			obj.parents('.form-check').find('.showrange').slideDown()
		} else {
			calculate_sup(0)
			sup_val = 0
			pur_pack.data.proPacketidsup.pop()
			obj.parents('.form-check').find('.showrange').slideUp()
		}
		calculatePieCostALL();


	})
	$(document).on('click', '.savepackagepro_crm', async (e) => {
		e.preventDefault();
		$('.class_datatable').html('')
		pur_pack.data.target = 'GCRM'
		let arr = pur_pack.data.proPacketidsale.concat(pur_pack.data.proPacketidsup);

		pur_pack.data.package_pro = arr

		let chk = false;
		$('.checkboxpurchase').each((index, elem) => {
			if ($(elem).is(':checked')) {
				chk = true

			}
		})


		let packagetype = await (pur_pack.ajax.getTypepackage(arr))

		if (chk) {
			pur_pack.ajax.Check_person(arr)
		} else {
			Swal.fire({
				title: 'ท่านยังไม่ได้เลือก Package',
				icon: 'info',
				showCancelButton: false,
				showConfirmButton: false,
				timer: 4000,
			})
		}

	})
	$(document).on('click', '#taxdeductionAll', function () {
		if ($(this).is(":checked")) {
			$(this).prop('checked', true);
			calculatePieCostALL();
		} else {
			$(this).prop('checked', false);
			calculatePieCostALL();
		}
	});
	$(document).on('change', "input[name='quantityall']", function (e) {
		e.preventDefault();
		$(`input[name = 'quantityall']`).each((index, elem) => {
			if ($($(`input[name = 'quantityall']`)[0]).val() < 2000 && $($(`input[name = 'quantityall']`)[1]).val() < 2000) {
				$('#show-h2').addClass('d-none').removeClass('d-flex');
				$('.show-h4').addClass('d-none').removeClass('d-flex');
				$('.show-h3').addClass('d-flex').removeClass('d-none');
				$('.show-h5').addClass('d-none');
				$('.show-h6').removeClass('d-none');
			} else {
				$('#show-h2').addClass('d-flex').removeClass('d-none');
				$('.show-h4').addClass('d-flex').removeClass('d-none');
				$('.show-h3').addClass('d-none').removeClass('d-flex');
				$('.show-h5').removeClass('d-none');
				$('.show-h6').addClass('d-none');
			}
		})

	})

	//!  ****************************************** Upload Payment ******************************************************
	$(document).on('click', "#upload-slip-payment", function (e) {
		e.preventDefault();
		pur_pack.ajax.get_bank();
		$('.show-money-forpayment').html($('.totalprice_preview').text() + ' ฿');
		$('#upload_Payment').modal('show');
		$("#upload_Payment #upload-img-payment").attr('data-order-id', $(this).attr('data-order-id'))
		$("#upload_Payment #date_payment").datepicker({
			dateFormat: "dd-M-yy",
			changeMonth: true,
			changeYear: true,

		});
	})
	$(document).on('click', "#upload_Payment .btn-close", function (e) {
		e.preventDefault();
		$('#upload_Payment').modal('hide');
	})

	$("#date_payment").val(setdateAll());
	$(document).on('focus', "#time_payment", function () {
		$(this)
			.daterangepicker({
				singleDatePicker: true,
				datePicker: false,
				timePicker: true,
				timePicker24Hour: true,
				timePickerIncrement: 01,
				forceMinuteStep: true,
				locale: {
					format: "HH:mm",
				},
			})
			.on("show.daterangepicker", function (ev, picker) {
				picker.container.find(".calendar-table").hide();
			});
	})
	//! ------------------------- Check Position --------------------------


	$(document).on('click', ".btn-modal-close", function (e) {
		e.preventDefault();
		$('#modal-position-check').modal('hide');
	})
	$(document).on('click', '.btn_search', function () {
		var branch = $('.branch').val();
		var pos_id = $('.position').val();
		pur_pack.ajax.load_table.data_tb(branch, pos_id);

	})
	$(document).on('click', '#save-position-app-log', function (e) {
		e.preventDefault();
		pur_pack.ajax.save_pos_app_log()
	})
	$(document).on('change', '.check_allsale', function (e) {
		e.preventDefault();
		var div = $(this).parent().parent();
		var row = $(this).attr('data-row');
		var check = $(this).is(':checked');
		var $quantity = $("input[name='quantityall']").val();
		var $table = $('.tbposition').dataTable().fnGetData();
		var check_legnth = check_length($table)

		if (check == true) {
			if (check_legnth >= $quantity) {
				$('.check_allsale').not(':checked').prop('disabled', true);
				$('#tb_position').on('draw.dt', function () {
					$('.check_allsale').not(':checked').prop('disabled', true);
				});

			}
			$(this).val(1);
			$(this).attr('checked', true);
			$('.tbposition').dataTable().fnUpdate(div[0].outerHTML, row, 4, false);
			count_used($table, $quantity, row, 4);
		} else {

			$(this).val(0);
			$(this).attr('checked', false);
			$('.tbposition').dataTable().fnUpdate(div[0].outerHTML, row, 4, false);
			count_used($table, $quantity, row, 4);
			$('.check_allsale').prop('disabled', false);
			$('#tb_position').on('draw.dt', function () {
				$('.check_allsale').prop('disabled', false);
			});
		}
	})

	$(document).on('change', '.check_allsupport', function (e) {
		e.preventDefault();
		var div = $(this).parent().parent();
		var row = $(this).attr('data-row');
		var check = $(this).is(':checked');
		var $quantity = $("input[name='quantityall']").val();
		var $table = $('.tbposition').dataTable().fnGetData();

		var check_legnth = check_length($table)

		if (check == true) {
			if (check_legnth >= $quantity) {
				$('.check_allsupport').not(':checked').prop('disabled', true);
				$('#tb_position').on('draw.dt', function () {
					$('.check_allsupport').not(':checked').prop('disabled', true);
				});

			}
			$(this).val(1);
			$(this).attr('checked', true);
			$('.tbposition').dataTable().fnUpdate(div[0].outerHTML, row, 5, false);
			count_used($table, $quantity, row, 5);
		} else {

			$(this).val(0);
			$(this).attr('checked', false);
			$('.tbposition').dataTable().fnUpdate(div[0].outerHTML, row, 5, false);
			count_used($table, $quantity, row, 5);
			$('.check_allsupport').prop('disabled', false);
			$('#tb_position').on('draw.dt', function () {
				$('.check_allsupport').prop('disabled', false);
			});
		}
	})


	// ? -------------------------------------------------------- Upload Image Data -------------------------------------------

	$(document).on('click', "#upload_Payment #upload-img-payment", function (e) {
		e.preventDefault();
		let order_id = $(this).attr('data-order-id');
		pur_pack.ajax.upload_payment(order_id);
	})

	$(document).on('click', '.btn-contact', function (e) {
		e.preventDefault();
		$("#modal-contact").modal('show')
	})
	$(document).on('click', '#send-contact', function (e) {
		e.preventDefault();
		pur_pack.ajax.Sendmail();
	})
	$(document).on('change', '#selectqo', function () {
		if ($(this).val() != '') {
			$(".bill_show").removeClass('d-none');
			//create payment
			var target = $(this).val();

			var fdata = 'order_id=' + target;
			fdata += '&encrypt_id=' + encrypt_application_id;
			fdata += '&' + csrf_token_name + '=' + $.cookie(csrf_cookie_name)
			pur_pack.ajax.get_qo(fdata)
		} else {
			$(".bill_show").addClass('d-none');
		}

	});
	//* check type 5 people
	$(document).on('change', '[target="checkforfree"]', (e) => {
		$('input[name="quantityall"]').prop('disabled', false);
		$('[target="checkforfree"]').not(e.target).prop('checked', false);
		// if ($(e.target).val() == '1') {
		// 	if ($(e.target).is(':checked') == true) {
		// 		$('.quantity-labelAll').text('5 Employee')
		// 		$('input[type="range"]').val(5)
		// 		for (let e of document.querySelectorAll('input[type="range"].g-progress')) {
		// 			e.style.setProperty('--value', 5);
		// 			e.style.setProperty('--min', e.min == '' ? '0' : e.min);
		// 			e.style.setProperty('--max', e.max == '' ? '2000' : e.max);
		// 			e.addEventListener('input', () => e.style.setProperty('--value', e.value))
		// 		};
		// 		$('input[name="quantityall"]').prop('disabled', true);
		// 	} else {
		// 		$('input[name="quantityall"]').prop('disabled', false);

		// 	}

		// } else {
		// 	if ($(e.target).is(':checked') == true) {
		// 		$('.quantity-labelAll').text('100 Employee')
		// 		$('input[type="range"]').val(100)
		// 		for (let e of document.querySelectorAll('input[type="range"].g-progress')) {
		// 			e.style.setProperty('--value', 100);
		// 			e.style.setProperty('--min', e.min == '' ? '0' : e.min);
		// 			e.style.setProperty('--max', e.max == '' ? '2000' : e.max);
		// 			e.addEventListener('input', () => e.style.setProperty('--value', e.value))
		// 		};
		// 		$('input[name="quantityall"]').prop('disabled', true);
		// 	} else {
		// 		$('input[name="quantityall"]').prop('disabled', false);
		// 		$('.quantity-labelAll').text('5 Employee')
		// 		$('input[type="range"]').val(5)
		// 		for (let e of document.querySelectorAll('input[type="range"].g-progress')) {
		// 			e.style.setProperty('--value', 5);
		// 			e.style.setProperty('--min', e.min == '' ? '0' : e.min);
		// 			e.style.setProperty('--max', e.max == '' ? '2000' : e.max);
		// 			e.addEventListener('input', () => e.style.setProperty('--value', e.value))
		// 		};
		// 	}
		// }
	})
	// ?ชำระค่าค้างบริการ
	$(document).on('click', '#upload-payment', async (e) => {
		let obj = $(e.target).closest('#upload-payment')
		if (obj.length > 0) {
			await pur_pack.ajax.get_package()
			await pur_pack.ajax.billpayment()
		}

	})

	window.fbAsyncInit = function () {
		FB.init({
			xfbml: true,
			version: 'v14.0'
		});
	};

	(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s);


		js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));


})
