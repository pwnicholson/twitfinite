function doHideSwap(elem1,elem2) {
	elem1 = $(elem1);
	elem2 = $(elem2);
	if(elem1.style.display=="") {
		elem1.style.display = "none";
		elem2.style.display = "";
	} else {
		elem2.style.display = "none";
		elem1.style.display = "";
	}
}

function showDiv(elem,div,page) {
	elem = $(elem);
	div = $(div);

	if(elem.style.display=="") {
		div.innerHTML = 'Loading . . .';
		new Ajax.Updater(div,page);
		div.style.display = "";
	} else {
		div.style.display = "none";
	}
}

function doDeleteConfirm(elem) {
	if(elem.checked) {
		if(confirm("Are you sure?")) {
			elem.checked = true;
			return true;
		} else {
			elem.checked = false;
			return false;
		}
	}
}

function doShowIfChecked(div,checked) {
	div = $(div);
	if(checked==true) {
		div.style.display = 'block';
	} else {
		div.style.display = 'none';
	}
}