$(function() {
	var main = $('#main');
	var showTable = $('#showTable');
	var table = $('#table');
	var productTable = $('#productTable');
	var panel = $('.panel.panel-default');
	var submit = $('button[type="submit"]');
	var reset = $('button[type="reset"]');


	$('form').submit(function() {
		$(this).find(':submit').prop('disabled', 'true');
		$(this).find(':submit').find('i').removeClass().addClass('fa fa-circle-o-notch fa-lg fa-spin');
	});

	$('.transportDate').datepicker({
		autoclose: true,
		orientation: "auto"
	});

	$('#myModal').on('show.bs.modal', function(e) {		
		productTable.html('');
		productTable.html('<div class="row"><div class="col-xs-2 col-xs-offset-5"><i class="fa fa-circle-o-notch fa-spin fa-5x"></i></div></div>');
		$.post(url.Product, {
			table: true
		}, function(data, textStatus, xhr) {
			/*optional stuff to do after success */
			productTable.html('');
			productTable.append(data);
		}).fail(function() {

		}).done(function() {
			$('body').css('overflow', 'hidden');
			afterLoadTable();
		});
	});
	$('#myModal').on('hidden.bs.modal', function(e) {
		productTable.html('');
		$('body').css('overflow', 'auto');
	});

	showTable.on('click', function(event) {
		main.toggle('fast', function() {
			if (!main.is(':visible')) {
				showTable.text('บันทึกรายการสั่งซื้อ');
			} else {
				showTable.text('แสดงรายการสั่งซื้อ');
			}
			panel.toggle('fast', function() {
				if (table.is(':visible')) {
					table.html('');
					table.parent().find('.panel-body').show();
					$.post(url.Order, {
						table: true
					}, function(data, textStatus, xhr) {
						/*optional stuff to do after success */
						table.append(data);
					}).fail(function() {

					}).done(function() {
						table.parent().find('.panel-body').hide();
					});
				}
			});
		});
	});
});

function afterLoadTable() {
	$('.outEdit').off('click').on('click', function() {
		var objectId = $(this).find('.objectId').find('input').val();
		var imageURL = $(this).find('.pic').find('a').prop('href');
		var name = $(this).find('.pic').find('a').prop('title');
		$('.productPreview > h3 > a').prop({
			href: imageURL,
			title: name
		});
		$('.productPreview > h3 > a > img').prop('src', imageURL);
		$('.productPreview > input[name="productId"]').val(objectId);		
		$('.productPreview > input[name="productName"]').val(name);		
		$('.productPreview > h3 > span').text(name);
		$('#myModal').modal('hide');
		$('.productPreview > h3 > i').hide();
		$('.productPreview').find('a').show();
	});	
}
$('#fileToUpload').fileinput({
	showUpload: false,
	showCaption: true,
	showRemove: true,
	browseClass: 'btn btn-primary',
	removeClass: 'btn btn-danger',
	fileType: 'image',
	previewFileIcon: '<i class="glyphicon glyphicon-king"></i>',
	maxFileSize: 50000,
	maxFileCount: 1,
	slugCallback: function(filename) {
		return filename.replace('(', '-').replace(']', '-');
	}
});