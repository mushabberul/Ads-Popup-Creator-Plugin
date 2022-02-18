;(function($){
	var delayedPopups = [];
	$(document).ready(function(){

		PlainModal.closeByOverlay = false;
		PlainModal.closeByEscKey = false;

		var modalels = document.querySelectorAll('.modal-content');
		var modals = [];
		for(var i = 0; i<modalels.length; i++){
			var content = modalels[i];
			var modal = new PlainModal(content);
			modal.closeButton = content.querySelector('.close-button');
			var delay = modalels[i].getAttribute("data-delay");
				if(delay > 0){
					delayedPopups.push({modal:modal,delay:delay});
				}else{
					modal.open();
				}
		}

		for(i in delayedPopups){
			setTimeout(function(i){
				delayedPopups[i].modal.open();
			},delayedPopups[i].delay,i)
		}
	});

})(jQuery);