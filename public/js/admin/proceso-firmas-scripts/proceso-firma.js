localStorage.setItem('reloadTab', true)

let nextStep = localStorage.getItem('nextStep')

window.addEventListener('beforeunload', function (e) {
	if (localStorage.getItem('reloadTab') == "true") {
		if (nextStep != "true") {
			e.preventDefault();
    		e.returnValue = '';
		}else {
			localStorage.removeItem('nextStep')
		}
	}
});