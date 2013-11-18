//=== Utilidades de javascript para el proyecto
/*
* div: Objeto jQuery
* template: 
*/
function uxShowMessage(div, template, _type, _title, _message) {
	div.html(Mustache.to_html(template, {type: _type, title: _title, message: _message}));
}

// Función correcta completa
function uxShowMsg(divId, templateId, _type, _title, _message) {
	$('#' + divId).html(Mustache.to_html($('#' + templateId).html(), 
		{type: _type, title: _title, message: _message}));
}

// Mensaje genérico
function uxGenericMsg(div, template, params) {
	div.html(Mustache.to_html(template, params));
	div.slideDown(1500).fadeOut(2500);
}

// Mensaje básico
function uxMessage(_type, _title, _message) {
	var template = '<div class=\"alert alert-{{type}} alert dismissable\">'
	template += '<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>';
	template += '<strong>{{title}}: </strong>{{message}}</div>';

	// Call generic message
	uxGenericMsg($('#mensajes'), template, {type: _type, title: _title, message: _message});
}

// Mensaje de error
function uxErrorAlert(message) {
	uxMessage('danger', 'Error', message);
}

// Mensaje de éxito
function uxSuccessAlert(message) {
	uxMessage('success', 'Mensaje', message);
}