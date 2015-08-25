// SHARED FUNCTIONS
function addListener(li, ev, fn) {
    var ev = ev.split(' ');
    
    for (var i = 0, j = ev.length; i < j; i++) {
        if (li && window.addEventListener) {
            li.addEventListener(ev[i], fn, false);
        } else if (li && window.attachEvent) {
            li.attachEvent('on' + ev[i], fn);
        }
    }
}

function hasClass(el, cls) {
	return (' ' + el.className + ' ').indexOf(' ' + cls + ' ') > -1;
}

function viewportOffset() {
    return (window.pageYOffset !== undefined) ? window.pageYOffset : body.scrollTop;
}

// SEARCH
(function() {
	
	var overlay = document.getElementById('search');
		toggle = document.getElementById('searchToggle');
	
	if (overlay) {
	
		var a = overlay.getElementsByTagName('a')[0];
		
		function toggleSearch(action) {
			if (hasClass(overlay, 'open') || action == 'close') {
				overlay.className = overlay.className.replace(/\b ?open\b/g, '');
			} else {
				overlay.className += ' open';
				overlay.getElementsByTagName('input')[0].focus();
			}
		}
		
		addListener(toggle, 'click', toggleSearch);
		addListener(a, 'click', toggleSearch);
		
		addListener(window, 'keyup', function(e) {
			if (e.keyCode == 27) {
				toggleSearch('close');
			}
		});
	
		addListener(toggle, 'touchend', function() {
			toggle.click();
		});
	
	}

})();

function search(data) {
	document.location.href = 'search?q=' + data.getElementsByTagName('input')[0].value;
}

// FORM VALIDATION
(function() {

	// float labels are great
	function floatLabel() {
		if (this.value.length > 0) {
			if (!hasClass(this, 'blurred')) {
				this.className += ' blurred';
			}
		} else {
			this.className = this.className.replace(/\b ?blurred\b/g, '');
		}
	}

	var fields = document.getElementsByClassName('float-label');
	
	for (var i = 0, j = fields.length; i < j; i++) {
		addListener(fields[i].getElementsByTagName('input')[0], 'blur keyup', floatLabel);
	}
	
	// textarea auto height
	function textareaAdjust() {
	    this.style.height = '';
	    this.style.height = (25 + this.scrollHeight) + 'px';
		console.log((this.scrollHeight) + 'px');
	}
	
	var textareas = document.getElementsByTagName('textarea');
	
	for (var i = 0, j = textareas.length; i < j; i++) {
		addListener(textareas[i], 'blur keyup', floatLabel);
		addListener(textareas[i], 'keyup', textareaAdjust);
	}
	
	// select boxes label fix
	var selectboxes = document.getElementsByTagName('select');
	
	for (var i = 0, j = selectboxes.length; i < j; i++) {
		addListener(selectboxes[i], 'change', floatLabel);
	}

})();

function validate(data) {

	// button loader
	var button = document.getElementsByTagName('form')[0].getElementsByTagName('button')[0];
	button.className = 'loading';
	
	addListener(button, 'touchend', function() {
		button.click();
	});

	// set initial status
	var status = true;
	
	// render message for validated field
	function error(field) {
	
		// hard error
		if (field === undefined) {
			window.location.href = '?state=error';
		// soft error
		} else {
			field.setAttribute('data-state', 'error');
		}
		
		// set status
		status = false;
	
	}
	
	// variables
	var fields = data.getElementsByClassName('required');
	
	// actual validation
	for (var i = 0, l = fields.length; i < l; i++) {
		
		// variables
		var field = fields[i],
			inputLength = field.value.length,
			type = field.type;
		
		field.setAttribute('data-state', 'success');
		
		// validate fields and print message if required
		if (hasClass(field, 'antibot') && field.value != 'antibot') {
			error();
		} else if (type == 'email') {
			if (!/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/.test(field.value)) {
				error(field);
			}
		} else if (field.value == '') {
			error(field);
		}
		
	}

	// final check and submitting
	if (status) {
		data.action = 'system/scripts/send.php';
		data.submit();
	}
	
	// reset loading button
	setTimeout(function() {
		button.className = '';
	}, 500);
	
}