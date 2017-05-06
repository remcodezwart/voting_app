var elements = document.getElementsByTagName("button");

for (index in elements) {
	if (elements[index] instanceof Element) {
        elements[index].addEventListener('click', button_confirm);
    }
}

function button_confirm() {
	if (confirm("Weet u het Zeker?") == true) {
		document.submit.submit();
	}
}    