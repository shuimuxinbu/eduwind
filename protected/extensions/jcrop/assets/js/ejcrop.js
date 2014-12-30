/**
 * Javascript for EJcrop extension.
 *
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 * @author Jacques Basseck
 * 
 */

function ejcrop_showThumb(coords, id) {
	var rx = 100 / coords.w;
	var ry = 100 / coords.h;
	
	var height = $('#'+id).prop('height');
	var width = $('#'+id).prop('width');
	
	$('#thumbEvent_'+id).css({ 
		width: Math.round(rx * width) + 'px',
		height: Math.round(ry * height) + 'px',
		marginLeft: '-' + Math.round(rx * coords.x) + 'px',
		marginTop: '-' + Math.round(ry * coords.y) + 'px'
	});
	if ($('#mirror_'+id).css('display') == 'none') {
		$('#mirror_'+id).css('display', '');
		$('#thumb_'+id).css('display', 'none');
	}
}

function ejcrop_getCoords(coords, id) {
	$('#'+ id +'_x').val(coords.x);
	$('#'+ id +'_y').val(coords.y);
	$('#'+ id +'_x2').val(coords.x2);
	$('#'+ id +'_y2').val(coords.y2);
	$('#'+ id +'_w').val(coords.w);
	$('#'+ id +'_h').val(coords.h);
}
	
function ejcrop_reinitThumb(id) {
	$('#mirror_' + id).hide();
	$('#thumb_' + id).show();
}
	
function ejcrop_cancelCrop(jcrop) {
	var buttons = jcrop.ui.holder.next(".jcrop-buttons");
	jcrop.disable();
	buttons.find(".jcrop-start").show();
	buttons.find(".jcrop-crop, .jcrop-cancel").hide();
	ejcrop_reinitThumb(jcrop.ui.holder.prev("img").attr("id"));
}

function ejcrop_initWithButtons(id, options) {
	var jcrop = {};
	
	function ajaxRequest(id) {
		// ajax request to send
		var ajaxData = {};
		ajaxData[id+'_x'] = $('#'+ id +'_x').val();
		ajaxData[id+'_x2'] = $('#'+ id +'_x2').val();
		ajaxData[id+'_y'] = $('#'+ id +'_y').val();
		ajaxData[id+'_y2'] = $('#'+ id +'_y2').val();
		ajaxData[id+'_h'] = $('#'+ id +'_h').val();
		ajaxData[id+'_w'] = $('#'+ id +'_w').val();
	//	ajaxData[id+'_th'] = $('#'+ id).height();
	//	ajaxData[id+'_tw'] = $('#'+ id).width();
		
		for (var v in options.ajaxParams) {
			ajaxData[v] = options.ajaxParams[v];
		}
		$.ajax({
			type: "post",
			url: options.ajaxUrl,
			data: ajaxData,
			success: function(msg) {
				if (msg != 'error') {
					// change the image source
					$('#thumb_' + id + '> img').attr('src', msg);
					ejcrop_reinitThumb(id);
				}
			}
		});
	}

	$('body').delegate('#start_'+id,'click', function(e){
		$('#crop_'+id+', #cancel_'+id).show();
		$('#start_'+id).hide();
		if (!jcrop.id){
			jcrop.id = $.Jcrop('#'+id, options);
		}
		jcrop.id.enable();
		var dim = jcrop.id.getBounds();
		jcrop.id.animateTo([dim[0]/4, dim[1]/4,dim[0]/2,dim[1]/2]);
	});
			
	$('body').delegate('#crop_'+id,'click', function(e){
		$('#start_'+id).show();
		$('#crop_'+id+', #cancel_'+id).hide();
		ajaxRequest(id);
		jcrop.id.release();
		jcrop.id.disable();
	});
	
	$('body').delegate('#cancel_'+id,'click', function(e){
		jcrop.id.release();
	});
}
