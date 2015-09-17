$(document).ready(function() {
	try {
		$(document).bind("contextmenu", function(e) {
			e.preventDefault();
			$("#custom-menu").css({ top: e.pageY + "px", left: e.pageX + "px" }).show(100);
		});
		$(document).mouseup(function(e) {
			var container = $("#custom-menu");
			if (container.has(e.target).length == 0) {
				container.hide();
			}
		});
	}
	catch (err) {
		alert(err);
	}
});