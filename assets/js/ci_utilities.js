let cleaveThousandOpt = {
	numeral: true,
	numeralThousandsGroupStyle: "thousand",
};

let holidayDate = {};
let serverTime;

$.fn.serializeObject = function () {
	var o = {};
	var a = this.serializeArray();
	$.each(a, function () {
		if (o[this.name]) {
			if (!o[this.name].push) {
				o[this.name] = [o[this.name]];
			}
			o[this.name].push(this.value || "");
		} else {
			o[this.name] = this.value || "";
		}
	});
	return o;
};

function site_url(url) {
	if (!url) {
		url = "";
	}
	return siteURL + url;
}

function base_url(param) {
	if (!param) {
		param = "";
	}
	return baseURL + param;
}

var ci_notify;

function notify(strTitle, strMessage, strType, pPosition, pFrom) {
	if (!strType) {
		strType = "info";
	}
	if (!pPosition) {
		pPosition = "right";
	}
	if (!pFrom) {
		pFrom = "top";
	}
	ci_notify = $.notify(
		{
			title: "<b>" + strTitle + " : </b><br/>",
			message: strMessage,
		},
		{
			type: strType,
			placement: {
				from: pFrom,
				align: pPosition,
			},
		}
	);
}

function loading_after(obj) {
	$(obj).after(
		'<span id="loading_after">&nbsp;&nbsp;<i class="fa fa-refresh fa-spin"></i> Loading..</span>'
	);
}

function loading_after_remove() {
	$("#loading_after").remove();
}

function loading_on(obj) {
	var attr = obj.attr("prev_html");
	if (typeof attr !== typeof undefined && attr !== false) {
		return false;
	} else {
		$(obj).addClass("disabled");
		obj.attr("prev_html", $(obj).html());
		obj.html('<i class="fa fa-refresh fa-spin"></i> Loading..');
		return true;
	}
}

function loading_on_remove(obj) {
	obj.removeClass("disabled");
	var prev_html = obj.attr("prev_html");
	obj.html(prev_html);
	obj.removeAttr("prev_html");
}

function setDropdownList(elem, box_width) {
	if (!box_width) {
		box_width = "auto";
	}
	$(elem).select2({
		dropdownAutoWidth: true,
		width: box_width,
		dropdownParent: $(elem).parent(),
	});
	var default_value = $(elem).attr("value");
	$(elem).val("").val(default_value).trigger("change");
}

function jsUcfirst(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}

function formatNumber(number, dec, thousand, pnt, curr1, curr2, n1, n2) {
	if (isNaN(number)) {
		return 0;
	}
	if (number == "") {
		return 0;
	}
	num = number.toString().replace(/,/g, "");
	if (dec == undefined) dec = 2;
	if (thousand == undefined) thousand = ",";
	if (pnt == undefined) pnt = ".";
	if (curr1 == undefined) curr1 = "";
	if (curr2 == undefined) curr2 = "";
	if (n1 == undefined) n1 = "";
	if (n2 == undefined) n2 = "";

	var x = Math.round(num * Math.pow(10, dec));

	if (x >= 0) n1 = n2 = "";

	var y = ("" + Math.abs(x)).split("");
	var z = y.length - dec;

	if (z < 0) z--;
	for (var i = z; i < 0; i++) y.unshift("0");
	if (z < 0) z = 1;
	y.splice(z, 0, pnt);
	if (y[0] == pnt) y.unshift("0");

	while (z > 3) {
		z -= 3;
		y.splice(z, 0, thousand);
	}
	var r = curr1 + n1 + y.join("") + n2 + curr2;

	if (dec == 0) r = r.replace(/\.$/, "");
	if (number < 0) {
		return "-" + r;
	} else {
		return r;
	}
}

function removeComma(num) {
	return num.toString().replace(/,/g, "");
}

function stringToNumber(num) {
	if (isNaN(num)) {
		return 0;
	}
	num = num.toString().replace(/ /g, "");
	return parseFloat(removeComma(num));
}

function isNumber(evt) {
	evt = evt ? evt : window.event;
	var charCode = evt.which ? evt.which : evt.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
		return false;
	}
	return true;
}

function isValidDate(s) {
	var bits = s.split("/");
	var d = new Date(bits[2] + "/" + bits[1] + "/" + bits[0]);
	return !!(d && d.getMonth() + 1 == bits[1] && d.getDate() == Number(bits[0]));
}

function setDatePicker(obj, options) {
	//datepicker
	$(obj).each(function (i) {
		var defaultDate = $(this).val().split("/");
		var defaultYear = defaultDate[2];
		var dateBefore = defaultDate[0] + "-" + defaultDate[1] + "-" + defaultYear;

		$(this).datepicker({
			dateFormat: "dd-mm-yy",
			dayNamesMin: ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส"],
			monthNamesShort: [
				"มกราคม",
				"กุมภาพันธ์",
				"มีนาคม",
				"เมษายน",
				"พฤษภาคม",
				"มิถุนายน",
				"กรกฎาคม",
				"สิงหาคม",
				"กันยายน",
				"ตุลาคม",
				"พฤศจิกายน",
				"ธันวาคม",
			],
			changeMonth: true,
			changeYear: true,
			yearRange: "-70:+0",
			beforeShow: function () {
				$(this).keydown(function (e) {
					// if(helper.zGetKey(e) !=
					// "9")$(this).datepicker(
					// "hide" );
				}); // ไม่ให้พิมพ์เอง
				if ($(this).val() != "" && $(this).val().length > 6) {
					var arrayDate = $(this).val().split("/");
					arrayDate[2] = parseInt(arrayDate[2]);
					$(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
				}
				setTimeout(function () {
					$.each($(".ui-datepicker-year option"), function (j, k) {
						var textYear = parseInt(
							$(".ui-datepicker-year option").eq(j).val()
						);
						$(".ui-datepicker-year option").eq(j).text(textYear);
					});
				}, 50);
			},
			onChangeMonthYear: function (year, month) {
				var day, thisMonth;

				var date = new Date();
				thisMonth = date.getMonth();

				if ($(this).val() != "") {
					var arrayDate = $(this).val().split("-");
					day = arrayDate[0];
				} else {
					day = date.getDate();
				}
				$(this).val(day + "-" + month + "-" + year);
				dateBefore = $(this).val();

				setTimeout(function () {
					//Not this month
					if (month - 1 != thisMonth) {
						var tdDay =
							'div#ui-datepicker-div td[data-month="' +
							(month - 1) +
							'"][data-year="' +
							year +
							'"] a.ui-state-default:contains(' +
							day +
							")";
						$(tdDay)
							.filter(function () {
								return $(this).text() == day;
							})
							.addClass("ui-state-active");
					}

					$.each($(".ui-datepicker-year option"), function (j, k) {
						var textYear = parseInt(
							$(".ui-datepicker-year option").eq(j).val()
						);
						$(".ui-datepicker-year option").eq(j).text(textYear);
					});
				}, 50);
			},
			onClose: function () {
				if ($(this).val() != "" && $(this).val() == dateBefore) {
					var arrayDate = dateBefore.split("-");
					if (
						isValidDate(
							arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]
						) == false
					) {
						dateBefore = new Date(arrayDate[2], arrayDate[1] + 1, 0);
						alert(dateBefore);
					}
					arrayDate[2] = parseInt(arrayDate[2]);
					$(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
				}
				if (options != undefined) {
					if (options.onClose) options.onClose();
				}
			},
			onSelect: function (dateText, inst) {
				dateBefore = $(this).val();
				var arrayDate = dateText.split("-");
				if (
					isValidDate(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]) ==
					false
				) {
					dateBefore = new Date(arrayDate[2], arrayDate[1] + 1, 0);
					alert(dateBefore);
				}
				arrayDate[2] = parseInt(arrayDate[2]);
				$(this).val(arrayDate[0] + "/" + arrayDate[1] + "/" + arrayDate[2]);
				if (options != undefined) {
					if (options.onSelect) options.onSelect();
				}
			},
		});
	});

	$(obj).on("keydown", function (e) {
		var keycode = getKeyCode(e);
		if (keycode != "9") {
			$(obj).focus();
			return false;
		}
	}); //ไม่ให้พิมพ์เอง
}

function getKeyCode(ev) {
	return ev.keyCode ? ev.keyCode : ev.which;
}

function isEnter(e) {
	if (getKeyCode(e) == 13) {
		return true;
	} else {
		return false;
	}
}

function setSelectBox(element_obj, opt_value) {
	$(element_obj + ' option[value="' + opt_value + '"]').attr("selected", true);
	var slect_box_value = $(element_obj + " option[selected]").val();
	$(element_obj).val(slect_box_value).trigger("change");
}

function jumpto(h) {
	var url = location.href; //Save down the URL without hash.
	location.href = "#" + h; //Go to the target element.
	history.replaceState(null, null, url); //Don't like hashes. Changing it back.
}

/**
 * Display images before upload
 */
function previewPicture(input, elem_display, h, w) {
	if (input.files && input.files[0]) {
		if (!h) {
			h = 300;
		}
		if (!w) {
			w = 400;
		}
		var reader = new FileReader();
		reader.onload = function (e) {
			$(elem_display).attr("src", e.target.result);
		};
		var rFilter =
			/^(image\/bmp|image\/cis-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x-cmu-raster|image\/x-cmx|image\/x-icon|image\/x-portable-anymap|image\/x-portable-bitmap|image\/x-portable-graymap|image\/x-portable-pixmap|image\/x-rgb|image\/x-xbitmap|image\/x-xpixmap|image\/x-xwindowdump)$/i;
		var file = input.files[0];
		if (!rFilter.test(file.type)) {
			$(elem_display).attr({ src: "", height: 0 });

			var extall = "pdf,sql,txt,mp4,mp3,mov";
			var file_value = input.value;
			var ext = file_value.split(".").pop().toLowerCase();
			if (parseInt(extall.indexOf(ext)) >= 0) {
				if (!$(elem_display + "_iframe").attr("id")) {
					var iframe_preview =
						'<video id="' +
						elem_display.replace("#", "") +
						'_iframe" frameborder="0" scrolling="no" width="400" height="600" style="max-width: 90%; max-height: 120px; border-radius: 10px;" controls></video>';
					$(elem_display).after(iframe_preview);
				}
				if (ext == "mp3" || ext == "mp4") {
					// h = 50;
					// w = 100
				}
				previewUpload(input, elem_display + "_iframe", h, w);
			} else {
				$(elem_display + "_iframe").remove();
			}
			return;
		} else {
			$(elem_display + "_iframe").remove();
			$(elem_display).attr({ height: h });
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function previewUpload(input, elem_display, h, w) {
	if (!h) {
		h = 350;
	}
	if (!w) {
		w = 50;
	}
	pdffile = input.files[0];
	pdffile_url = URL.createObjectURL(pdffile);
	if (pdffile_url) {
		$(elem_display).attr({ src: pdffile_url, height: h, width: w });
	}
}

$(document).ready(function () {
	$(document).on("keypress", ".isNumberOnly", function () {
		return isNumber(event);
	});
});

function autoTab(obj) {
	var pattern = new String("__:__:_"); // กำหนดรูปแบบในนี้
	var pattern_ex = new String(":"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้

	var returnText = new String("");
	var obj_l = obj.value.length;
	var obj_l2 = obj_l - 1;
	for (i = 0; i < pattern.length; i++) {
		if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
			returnText += obj.value + pattern_ex;
			obj.value = returnText;
		}
	}
	if (obj_l >= pattern.length) {
		obj.value = obj.value.substr(0, pattern.length);
	}
}

function ajaxErrorMessage(jqXHR, exception, elem) {
	var message;
	var statusErrorMap = {
		400: "Server understood the request, but request content was invalid.",
		401: "Unauthorized access.",
		403: "Forbidden resource can't be accessed.",
		500: "Internal server error.",
		503: "Service unavailable.",
	};
	if (jqXHR.status) {
		message = statusErrorMap[jqXHR.status];
		if (!message) {
			message = "Unknown Error. \n";
		}
	} else if (jqXHR.status === 0) {
		message = "Requested JSON parse failed.";
	} else if (exception === "parsererror") {
		message = "Requested JSON parse failed.";
	} else if (exception === "timeout") {
		message = "Time out error.";
	} else if (exception === "abort") {
		message = "Ajax request aborted.";
	} else {
		message = "Uncaught Error. \n"; // + jqXHR.responseText;
	}
	var responseTitle = $(jqXHR.responseText).filter("title").get(0);
	var detail = $(responseTitle).text();

	var other_detail = "";
	var obj = $(jqXHR.responseText).filter("div").get(0);
	other_detail = $(obj).find("p").eq(1).text();
	if (other_detail == "") {
		other_detail = "> " + $(obj).find("p").text();
	}

	detail += " - " + other_detail;

	alert(message + "\n\n" + detail);
	if (elem) {
		elem.html(
			message + "(" + jqXHR.status + ")" + "\n\n" + jqXHR.responseText + "\n\n"
		);
	}
}

function initializeDataTables(settings) {
	$("#" + settings.nTable.id + "_filter")
		.parent()
		.removeClass("col-sm-12")
		.addClass("col-sm-6 d-flex align-items-center ms-auto w-auto");
	$("#" + settings.nTable.id + "_length")
		.parent()
		.removeClass("col-sm-12")
		.addClass("col-sm-6 d-flex align-items-center w-auto")
		.css("margin-bottom", "0px");
	$("#" + settings.nTable.id + "_filter").addClass("ms-auto");
	$("#" + settings.nTable.id + "_length select")
		.addClass("radius-15")
		.css("margin", "7px 3px");
	$("#" + settings.nTable.id + "_filter input")
		.css("width", "100px")
		.addClass("radius-15");
	$("#" + settings.nTable.id + "_filter .form-control").addClass(
		"icon-search-input"
	);
	$(".dataTables_length").css("margin-bottom", "0px");

	//ใช้สำหรับไม่ให้ช่อง search ใน datatable auto ข้อความช่องค้นหา
	$("#" + settings.nTable.id + "_filter")
		.find("input")
		.parent()
		.wrap("<form>")
		.parent()
		.attr("autocomplete", "off");
}

/**
 * เช็คว่าเจอไฟล์ไหม
 * return boolean (true, false)
 */
function UrlExists(url) {
	var http = new XMLHttpRequest();
	http.open("HEAD", url, false);
	http.send();
	return http.status != 404;
}

function isEmpty(str) {
	return !str.trim().length;
}

function setTimepickerList(elem) {
	$(elem)
		.daterangepicker({
			singleDatePicker: true,
			datePicker: false,
			autoUpdateInput: false,
			timePicker: true,
			timePicker24Hour: true,
			timePickerIncrement: 5,
			forceMinuteStep: true,
			alwaysShowCalendars: true,
			locale: {
				format: "HH:mm",
			},
			parentEl: $(elem).parent(),
		})
		.on("show.daterangepicker", function (ev, picker) {
			picker.container.find(".calendar-table").hide();
		})
		.on("apply.daterangepicker", (ev, picker) => {
			$(ev.target).val(picker.startDate.format("HH:mm"));
		});
}

function jsUcfirst(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}

function cb(start, end) {
	$(`#${daterange.element} span`).html(
		start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
	);
}

const daterange = {
	element: null,
};

function initDateRange(ele) {
	daterange.element = ele;

	var currentYear = moment().year();

	var currentYearStart = moment({
		years: currentYear,
		months: "0",
		date: "1",
	});

	var currentYearEnd = moment({
		years: currentYear,
		months: "11",
		date: "31",
	});
	var dateRange = {};
	dateRange["Today"] = [moment(), moment()];
	dateRange["Yesterday"] = [
		moment().subtract(1, "days"),
		moment().subtract(1, "days"),
	];
	dateRange["Last 7 Days"] = [moment().subtract(6, "days"), moment()];
	dateRange["Last 30 Days"] = [moment().subtract(29, "days"), moment()];
	dateRange["This Month"] = [
		moment().startOf("month"),
		moment().endOf("month"),
	];
	dateRange["Last Month"] = [
		moment().subtract(1, "month").startOf("month"),
		moment().subtract(1, "month").endOf("month"),
	];
	dateRange["Quarter 1"] = [
		moment().month(0).startOf("month"),
		moment().month(2).endOf("month"),
	];
	dateRange["Quarter 2"] = [
		moment().month(3).startOf("month"),
		moment().month(5).endOf("month"),
	];
	dateRange["Quarter 3"] = [
		moment().month(6).startOf("month"),
		moment().month(8).endOf("month"),
	];
	dateRange["Quarter 4"] = [
		moment().month(9).startOf("month"),
		moment().month(11).endOf("month"),
	];
	dateRange[`Year ${currentYear}`] = [
		moment(currentYearStart.subtract(0, "year")),
		moment(currentYearEnd.subtract(0, "year")),
	];
	dateRange[`Year ${currentYear - 1}`] = [
		moment(currentYearStart.subtract(1, "year")),
		moment(currentYearEnd.subtract(1, "year")),
	];
	dateRange[`Year ${currentYear - 2}`] = [
		moment(currentYearStart.subtract(1, "year")),
		moment(currentYearEnd.subtract(1, "year")),
	];

	var start = moment();
	var end = moment();

	$(`#${ele}`).daterangepicker(
		{
			startDate: start,
			endDate: end,
			ranges: dateRange,
		},
		cb
	);

	cb(start, end);
}

// TODO : add Comma จำนวนเงิน
function formatCurrency(number) {
	number = parseFloat(number);
	return number.toFixed(2).replace(/./g, function (c, i, a) {
		return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
	});
}

function removeCommaCurrency(number) {
	return parseFloat(number.replace(/,/g, ""));
}

function pdf_viewer({
	url = "",
	pdfDoc = null,
	num = 1,
	canvas = document.getElementById("qo_document"),
	pageRendering = false,
	pageNumPending = null,
	scale = 2,
	height = "auto",
	width = "100%",
}) {
	var pdfjsLib = window["pdfjs-dist/build/pdf"];

	pdfjsLib.GlobalWorkerOptions.workerSrc =
		document.location.origin + "/assets/lib/pdfjs/pdf.worker.js";

	if ($('style[role="pdf-style"]').length === 0) {
		$("body").append(`
            <style role="pdf-style">
                .pdf-viewer .btn-action {
                    background-color: #98C452;
                    padding: .5rem 1rem;
                    color: white;
                    border-radius: 8px;
                    border: none;
                    transition: all .25s;
                    text-decoration: none;
                }
                
                .pdf-viewer .btn-action.disabled {
                    opacity: .7;
                    cursor: not-allowed;
                }
                
                .pdf-viewer .btn-action:hover {
                    transform: translateY(-3px);
                }
                
                .pdf-viewer {
                    border: 2px solid black;
                    margin-bottom: 1rem;
                    overflow-y: auto;
                    max-height: 75vh;
                }
                
                .pdf-viewer--grid {
                    display: grid;
                    grid-template-columns: 15% 60% 15%;
                    gap: 1rem;
                    position: sticky;
                    top: 0;
                    z-index: 999;
                }
                
                .pdf-viewer-icon,
                a.pdf-viewer-icon {
                    cursor: pointer;
                    color: #b2b2b2;
                    background: transparent;
                    transition: all .25s;
                    border: none;
                }
                
                .pdf-viewer-icon:hover,
                a.pdf-viewer-icon:hover {
                    color: #FFFFFF !important;
                    transform: translateY(-2px);
                }
                
                .pdf-viewer-action {
                    cursor: pointer;
                    color: #b2b2b2;
                    transition: all .25s;
                    background: transparent;
                    border: 1px solid #757575;
                    border-radius: 8px;
                }
                
                .pdf-viewer-action:hover {
                    transform: translateY(-2px);
                    border: 1px solid #FFFFFF;
                    color: #FFFFFF;
                }
                
                .pdf-action {
                    background-color: #3c3c3c;
                    padding: 0.3rem 1.5rem;
                    border-radius: 0;
                    color: white;
                }
            </style>
        `);
	}
	function renderPage(num) {
		var ctx = canvas.getContext("2d");
		pageRendering = true;
		// Using promise to fetch the page
		pdfDoc.getPage(num).then(function (page) {
			var viewport = page.getViewport({ scale: scale });

			canvas.height = viewport.height;
			canvas.width = viewport.width;
			canvas.style.display = "block";
			canvas.style.height = height;
			canvas.style.width = width;

			// Render PDF page into canvas context
			var renderContext = {
				canvasContext: ctx,
				viewport: viewport,
			};
			var renderTask = page.render(renderContext);

			// Wait for rendering to finish
			renderTask.promise.then(function () {
				pageRendering = false;
				if (pageNumPending !== null) {
					// New page rendering is pending
					renderPage(pageNumPending);
					pageNumPending = null;
				}
			});
		});

		// Update page counters
		// document.getElementById('page_num').textContent = num;
	}

	// canvas.outerHTML = "<div></div>"

	const prev = document.createElement("button"),
		next = document.createElement("button"),
		dl = document.createElement("a"),
		zin = document.createElement("button"),
		zout = document.createElement("button"),
		_page = document.createElement("span");

	zin.addEventListener("click", onZoomIn);
	zin.innerHTML = '<i class="fas fa-search-plus"></i>';
	zin.classList = "pdf-viewer-icon";
	zout.addEventListener("click", onZoomOut);
	zout.innerHTML = '<i class="fas fa-search-minus"></i>';
	zout.classList = "pdf-viewer-icon";
	prev.addEventListener("click", onPrevPage);
	prev.innerHTML = '<i class="fas fa-chevron-left"></i>';
	prev.classList = "pdf-viewer-action";
	next.addEventListener("click", onNextPage);
	next.innerHTML = '<i class="fas fa-chevron-right"></i>';
	next.classList = "pdf-viewer-action";
	dl.addEventListener("click", onDownload);
	dl.innerHTML = '<i class="fas fa-file-download"></i>';
	dl.classList = "pdf-viewer-icon";
	dl.setAttribute("download", "g-pdf-viewer");

	const mainDiv = document.createElement("div");
	mainDiv.classList =
		"pdf-viewer--grid justify-content-between align-items-center w-100 pdf-action";

	const leftDiv = document.createElement("div");
	leftDiv.classList = "d-flex justify-content-start";
	// leftDiv.append(zin);
	// leftDiv.append(zout)

	const pageDiv = document.createElement("div");
	pageDiv.classList =
		"d-flex justify-content-between align-items-center w-100 ";

	const actionDiv = document.createElement("div");
	actionDiv.classList = "d-flex justify-content-end";
	actionDiv.append(dl);

	// canvas.parentElement.prepend(div);

	pageDiv.append(prev);
	pageDiv.append(_page);
	pageDiv.append(next);

	mainDiv.append(leftDiv);
	mainDiv.append(pageDiv);
	mainDiv.append(actionDiv);

	const loading = document.createElement("div");
	loading.classList = "loading-pdf-previewer w-100";
	loading.innerHTML = `
		<div class="d-flex justify-content-center w-100 align-items-center" style="background: #6c757d;height: 50vh;">
			<div class="spinner-border text-light" role="status" style="width: 6rem; height: 6rem;" >
				<span class="visually-hidden">Loading...</span>
			</div>
		</div>
	`;
	// const loading = $(`<div class="loading-pdf-previewer">dasdasd</div>`).html();
	canvas.parentElement.prepend(loading);
	canvas.parentElement.prepend(mainDiv);

	// Loading

	pdfjsLib
		.getDocument(url)
		.promise.then(function (pdfDoc_) {
			// Success
			$(".loading-pdf-previewer").remove();

			if (canvas.parentElement.childElementCount > 2) {
				canvas.parentElement.children[1].remove();
			}
			// document.getElementById('page_count').textContent = pdfDoc.numPages;
			pdfDoc = pdfDoc_;
			_page.textContent = `${num} / ${pdfDoc.numPages}`;
			// Initial/first page rendering
			renderPage(num);
		})
		.catch((err) => {});

	function onPrevPage() {
		if (num <= 1) {
			return;
		}
		num--;
		queueRenderPage(num);
	}
	function onNextPage() {
		if (num >= pdfDoc.numPages) {
			return;
		}
		num++;
		queueRenderPage(num);
	}

	function onDownload(e) {
		e.target.closest("a").href = pdfDoc._transport._params.url;
	}

	function onZoomIn() {
		scale *= 4 / 3;
		canvas.style.scale = scale;
	}

	function onZoomOut() {
		scale *= 2 / 3;
		canvas.style.scale = scale;
	}

	function queueRenderPage(num) {
		if (pageRendering) {
			pageNumPending = num;
		} else {
			renderPage(num);
			_page.textContent = `${num} / ${pdfDoc.numPages}`;
		}
	}
}

function Check_National(card_id) {
	//* Check id_card
	// card_id.replaceAll('-', '')
	let i;
	let sum;
	if (card_id.length != 13) return false;
	for (i = 0, sum = 0; i < 12; i++) sum += parseInt(card_id[i]) * (13 - i);
	if ((11 - (sum % 11)) % 10 == parseInt(card_id[12])) return true;
	return false;
}

function diffTimeToMinutes(time_start, time_end) {
	var diff = Math.abs(new Date(time_end) - new Date(time_start));
	return Math.floor(diff / 1000 / 60); // convert to minute
}

function messageAlert(icon, title, message) {
	Swal.fire({
		icon: icon,
		title: title,
		html: message,
	});
}

String.prototype.toHHMMSS = function () {
	var sec_num = parseInt(this, 10); // don't forget the second param
	var hours = Math.floor(sec_num / 3600);
	var minutes = Math.floor((sec_num - hours * 3600) / 60);
	var seconds = sec_num - hours * 3600 - minutes * 60;

	if (hours < 10) {
		hours = "0" + hours;
	}
	if (minutes < 10) {
		minutes = "0" + minutes;
	}
	if (seconds < 10) {
		seconds = "0" + seconds;
	}
	return hours + ":" + minutes;
};

function setDatePickerHoliday(el) {
	loadCompanyHoliday();
	$(el).datepicker({
		dateFormat: "dd-M-yy",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: function (date) {
			console.log(holidayDate[date]);
			var Highlight = holidayDate[date];
			if (Highlight) {
				return [true, "Holiday-highlighted", Highlight.toString()];
			} else {
				return [true, "", ""];
			}
		},
	});
}

/**
 * @param {*} pd_id 
 * @param {*} com_id 
 * @returns  num of work like 10 month, 26 day
 * @example
    calNumOfWork(163, 165).then((res) => {
        numofwork = res;
    });
 */

function dataURLtoFile(dataurl, filename) {
	var arr = dataurl.split(","),
		mime = arr[0].match(/:(.*?);/)[1],
		bstr = atob(arr[1]),
		n = bstr.length,
		u8arr = new Uint8Array(n);

	while (n--) {
		u8arr[n] = bstr.charCodeAt(n);
	}

	return new File([u8arr], filename, { type: mime });
}

function base64toFile(base64String, filename) {
	const byteString = atob(base64String.split(",")[1]);
	const mimeString = base64String.split(",")[0].split(":")[1].split(";")[0];
	const ab = new ArrayBuffer(byteString.length);
	const ia = new Uint8Array(ab);
	for (let i = 0; i < byteString.length; i++) {
		ia[i] = byteString.charCodeAt(i);
	}
	const blob = new Blob([ab], { type: mimeString });
	return new File([blob], filename, { type: mimeString });
}
$('input[type="number"]').keypress(function (event) {
	var keycode = event.which;
	if (
		!(
			event.shiftKey == false &&
			(keycode == 46 ||
				keycode == 8 ||
				keycode == 37 ||
				keycode == 39 ||
				(keycode >= 48 && keycode <= 57))
		)
	) {
		event.preventDefault();
	}
});
$(".onlyNumber").keypress(function (event) {
	var keycode = event.which;
	if (
		!(
			event.shiftKey == false &&
			(keycode == 46 ||
				keycode == 8 ||
				keycode == 37 ||
				keycode == 39 ||
				keycode == 47 ||
				(keycode >= 48 && keycode <= 57))
		)
	) {
		event.preventDefault();
	}
});

$(".onlyCharEng").keypress(function (event) {
	var keycode = event.which;
	if (keycode == 32) return true;
	if (48 <= keycode && keycode <= 57) return true;
	if (65 <= keycode && keycode <= 90) return true;
	if (97 <= keycode && keycode <= 122) return true;
	if (keycode == 45) return true;
	return false;
});

function get_average_rgb(img) {
	var context = document.createElement("canvas").getContext("2d");
	if (typeof img == "string") {
		var src = img;
		img = new Image();
		img.setAttribute("crossOrigin", "");
		img.src = src;
	}
	context.imageSmoothingEnabled = true;
	context.drawImage(img, 0, 0, 1, 1);
	return context.getImageData(0, 0, 1, 1).data.slice(0, 3);
}

function reverseTextColor(rgb) {
	var threshold = 140;
	var luminance = 0.299 * rgb[0] + 0.587 * rgb[1] + 0.114 * rgb[2];
	return luminance > threshold ? "black" : "white";
}
console.log(navigator.userAgent);
