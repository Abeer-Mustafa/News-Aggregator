	
$(document).ready(function () {
	// Filter form control to default size
	// ? setTimeout used for multilingual table initialization
	setTimeout(() => {
		$('.dataTables_filter .form-control').removeClass('form-control-sm');
		$('.dataTables_length .form-select').removeClass('form-select-sm');
	}, 300);


});
function load_datatable(params) {
	var dt_product_table = $('#records_table');
	var url =  params.url;
	var columns =  params.columns;
	var extra_buttons = params.hasOwnProperty('buttons') ? params.buttons : [];
	var columns_no_exported = params.hasOwnProperty('columns_no_exported') ? params.columns_no_exported : ':not(:last-child, :first-child)';
	var file_name = params.hasOwnProperty('file_name') ? params.file_name : "";
	var file_title = params.hasOwnProperty('file_title') ? params.file_title : true;
	var checkboxe = params.hasOwnProperty('checkboxe') ? params.checkboxe : "";
	var createdRow = params.hasOwnProperty('createdRow') ? params.createdRow : "";
	var columnDefsTargets = params.hasOwnProperty('columnDefs') ? params.columnDefs : [];
	var serverSide = params.hasOwnProperty('serverSide') ? params.serverSide : true;
	var dom = params.hasOwnProperty('dom') ? params.dom : 'default';
	var paging = params.hasOwnProperty('paging') ? params.paging : true;
	var info = params.hasOwnProperty('info') ? params.info : true;
	var searching = params.hasOwnProperty('searching') ? params.searching : true;
	var initComplete = params.hasOwnProperty('initComplete') ? params.initComplete : null;
	
	// buttons
	var buttons = [];
	if(extra_buttons.hasOwnProperty('export')){
		// print
		var print_button = {
			extend: 'print',
			text: '<i class="ti ti-printer me-2" ></i>Print',
			className: 'dropdown-item',
			filename: file_name,
			exportOptions: {
				columns: ':visible',
				columns: columns_no_exported,
				modifier: {
					page: 'all',
					search: 'applied',
				},
				format: {
					body: function (data, row, column, node) {
						var exportSelect = $(node).find('.export-select');
						if(exportSelect.length){
							return exportSelect.find('option:selected').text();
						}

						var exportData = $(node).find('.export-datatable');
						if(exportData.length){
							return exportData.text();
						}
						
						else{
							return $(node).text();
						}
					}
				},
				customizeData: function(dataForExport) {
					if(extra_buttons.hasOwnProperty('export_extra_rows')){
						extra_buttons.export_extra_rows.forEach( row_element => {
							let values = [];
							row_element.forEach( cell_element => {
								if(cell_element.type == 'text'){
									values.push(cell_element.value);
								}
								else if(cell_element.type != 'text' && cell_element.value == ''){
									values.push(cell_element.value);
								}
								else if(cell_element.type == 'id'){
									values.push($(`#${cell_element.value}`).text());
								}
							});
							dataForExport.body.push(values);
						});
					}
				}
			},
			customize: function (win) {
				$(win.document.body).css('direction', 'rtl');
				$(win.document.body).find('table').css('direction', 'rtl');
			}
		};

		// excel
		var excelHtml5_button = {
			extend: 'excel',
			text: '<i class="ti ti-file me-2" ></i>Excel',
			className: 'dropdown-item',
			filename: file_name,
			exportOptions: {
				columns: ':visible',
				columns: columns_no_exported,
				modifier: {
					page: 'all',
					search: 'applied',
				},
				format: {
					body: function (data, row, column, node) {
						var exportSelect = $(node).find('.export-select');
						if(exportSelect.length){
							return exportSelect.find('option:selected').text();
						}

						var exportData = $(node).find('.export-datatable');
						if(exportData.length){
							return exportData.text();
						}
						
						else{
							return $(node).text();
						}
					}
				},
				customizeData: function(dataForExport) {
					if(extra_buttons.hasOwnProperty('export_extra_rows')){
						extra_buttons.export_extra_rows.forEach( row_element => {
							let values = [];
							row_element.forEach( cell_element => {
								if(cell_element.type == 'text'){
									values.push(cell_element.value);
								}
								else if(cell_element.type != 'text' && cell_element.value == ''){
									values.push(cell_element.value);
								}
								else if(cell_element.type == 'id'){
									values.push($(`#${cell_element.value}`).text());
								}
							});
							dataForExport.body.push(values);
						});
					}
				}
			},
			
		}

		// colvis
		var colvis_button = {
			extend:'colvis',
			text: '<i class="ti ti-eye me-2"></i>columns visible',
			columns: ':not(:first-child)'
		}

		// copy
		var copy_button = {
			// copy
			extend: 'copy',
			text: '<i class="ti ti-copy me-2"></i>Copy',
			className: 'dropdown-item',
			exportOptions: {
				columns: ':visible',
				columns: columns_no_exported,
				modifier: {
					page: 'all',
					search: 'applied',
				},
				format: {
					body: function (data, row, column, node) {
						var exportSelect = $(node).find('.export-select');
						if(exportSelect.length){
							return exportSelect.find('option:selected').text();
						}

						var exportData = $(node).find('.export-datatable');
						if(exportData.length){
							return exportData.text();
						}
						
						else{
							return $(node).text();
						}
					}
				},
				customizeData: function(dataForExport) {
					if(extra_buttons.hasOwnProperty('export_extra_rows')){
						extra_buttons.export_extra_rows.forEach( row_element => {
							let values = [];
							row_element.forEach( cell_element => {
								if(cell_element.type == 'text'){
									values.push(cell_element.value);
								}
								else if(cell_element.type != 'text' && cell_element.value == ''){
									values.push(cell_element.value);
								}
								else if(cell_element.type == 'id'){
									values.push($(`#${cell_element.value}`).text());
								}
							});
							dataForExport.body.push(values);
						});
					}
				}
			},
		};

		// pdf
		var pdf_button = {
			// pdf
			extend: 'pdf',
			text: '<i class="ti ti-file-text me-2"></i>Pdf',
			className: 'dropdown-item',
			filename: file_name,
			exportOptions: {
				columns: ':visible',
				columns: columns_no_exported,
				modifier: {
					body: function (data, row, column, node) {
						// Extract the attrdata for export
						// var exportData = $(node).find('.export-datatable').text();
						// return exportData || data;
						return data;
					},
					page: 'all',
					search: 'applied',
				}
			},
			customize: function (doc) {        
				// doc.defaultStyle.font = 'Arial';
			},
		};

		if(file_title == true){
			print_button.title = file_name;
			excelHtml5_button.title = file_name;
			pdf_button.title = file_name;
		}
		else{
			print_button.title = "";
			excelHtml5_button.title = "";
			pdf_button.title = "";
		}

		buttons.push(
			{
				extend: 'collection',
				className: 'm010 btn btn-label-dark btn-sm dropdown-toggle me-3 waves-effect waves-light',
				text: '<i class="ti ti-download me-1 ti-xs"></i>Export',
				buttons: [
					print_button,
					excelHtml5_button,
					colvis_button,
					copy_button
				]
			}
		)
	}

	// columnDefs
	var columnDefs = [
		{
			// For Responsive
			className: 'control',
			searchable: false,
			orderable: false,
			responsivePriority: 2,
			targets: 0,
			render: function (data, type, full, meta) {
				return '';
			}
		}
	];
	if(checkboxe){
		columnDefs.push(
		{
			// For Checkboxes
			targets: checkboxe,
			orderable: false,
			searchable: false,
			checkboxes: {
				selectAllRender: '<input type="checkbox" class="form-check-input">'
			},
			render: function () {
				return '<input type="checkbox" class="dt-checkboxes form-check-input" >';
			},
		},
		)
	}
	if(columnDefsTargets){
		columnDefsTargets.forEach(element => {
			columnDefs.push(element);
		});
	}

	// dom
	var datatable_dom = dom == 'default' ? 
			'<"card-header d-flex border-top rounded-0 flex-wrap py-2"' +
			'<"me-5 ms-n2 pe-5"f>' +
			'<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex flex-column align-items-start align-items-md-center justify-content-sm-center mb-3 mb-md-0 pt-0 gap-4 gap-sm-0 flex-sm-row"lB>>' +
			'>t' +
			'<"row mx-2"' +
			'<"col-sm-12 col-md-6"i>' +
			'<"col-sm-12 col-md-6"p>' +
			'>' : dom;

	dt_records = dt_product_table.DataTable({
		serverSide: serverSide,
		ajax: ajax_load_datatable('records_table', url, columns.length),
		columns: columns,
		columnDefs: columnDefs,
		createdRow: createdRow,
		dom: datatable_dom,
		paging: paging,
		info: info,
		searching: searching,
		order: [0],
		lengthMenu: [
			[10, 25, 50, 75, 100, -1],
			[10, 25, 50, 75, 100]
		],
		buttons: buttons,
		responsive: responsive_datatable(),
		initComplete: initComplete
	});
	$('.dataTables_length').addClass('mt-2 mt-sm-0 mt-md-3 me-2');
	$('.dt-buttons').addClass('d-flex flex-wrap');
}

// DATATABLE | ajax request
function ajax_load_datatable(table_name, url, colspan, data = null) {
	return function(data, callback){
		$.ajax({
			url: url,
			'data': data,
			dataType: 'json',
			beforeSend: function(){
			// Here, manually add the loading message.
			$(`#${table_name} > tbody`).html(
				`<tr class="odd dataTables_processing">
					<td valign="top" colspan="${colspan}" class="dataTables_empty">Loading...</td>
				</tr>`
			);
			},
			success: function(res){
				if(res.extra_data){
					for (var key in res.extra_data) {
						$(`#${key}`).html(res.extra_data[key])
					};
				}
				callback(res);
			}
		});
	}
}

// DATATABLE | For responsive popup
function responsive_datatable(param = 'name') {
	return {
		details: {
			display: $.fn.dataTable.Responsive.display.modal({
			header: function (row) {
				var data = row.data();
				
				return 'Details ' + (data[param] ? data[param] : data['id'])  ;
			}
			}),
			type: 'column',
			renderer: function (api, rowIdx, columns) {
			var data = $.map(columns, function (col, i) {
				return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
					? '<tr data-dt-row="' +
						col.rowIndex +
						'" data-dt-column="' +
						col.columnIndex +
						'">' +
						'<td>' +
						col.title +
						':' +
						'</td> ' +
						'<td>' +
						col.data +
						'</td>' +
						'</tr>'
					: '';
			}).join('');

			return data ? $('<table class="table"/><tbody />').append(data) : false;
			}
		}
	}
}

function import_salla_data(url, page) {
	return new Promise((resolve) => {
		$.ajax({
			url: `${url}/${page}`,
			method: 'POST',
			timeout: 500000,
			success: function(response) {
				if (response.data.next && response.data.next > 0) {
					Swal.update({
						text: `جاري تحديث بيانات الصفحة ${response.data.next}...`,
					});
					Swal.showLoading();
					import_salla_data(url, response.data.next).then(resolve);
				} 
				else {
					Swal.fire({
						title: 'تم الاستيراد!',
						text: 'تم تحديث كامل البيانات بنجاح.',
						icon: 'success',
						confirmButtonText: 'موافق',
						buttonsStyling: false
					});
					$('#records_table').DataTable().ajax.reload();
					resolve();
				}
			},
			error: function(xhr, status, error) {
				Swal.fire({
						title: 'خطأ!',
						text: `حدث خطأ أثناء محاولة استيراد بيانات الصفحة ${page}.`,
						icon: 'error',
						confirmButtonText: 'موافق',
						buttonsStyling: false
				});
				resolve();
			}
		});
	});
}

