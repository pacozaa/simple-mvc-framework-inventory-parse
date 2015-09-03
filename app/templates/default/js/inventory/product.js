$(function() {
	var main = $('#main');
	var showTable = $('#showTable');
	var table = $('#table');
	var panel = $('.panel.panel-default');
	var submit = $('button[type="submit"]');
	var reset = $('button[type="reset"]');


	$('form').submit(function() {
		$(this).find(':submit').prop('disabled', 'true');
		$(this).find(':submit').find('i').removeClass().addClass('fa fa-circle-o-notch fa-lg fa-spin');
	});
	showTable.on('click', function(event) {		
		main.toggle('fast', function() {
			if(!main.is(':visible')){
				showTable.text('บันทึกสินค้า');
			}
			else{
				showTable.text('แสดงสินค้า');
			}
			panel.toggle('fast', function() {
				if (table.is(':visible')) {
					table.html('');
					table.parent().find('.panel-body').show();
					$.post(url.search, {
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