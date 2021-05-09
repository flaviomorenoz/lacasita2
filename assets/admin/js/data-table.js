var dtable;
function get_tableData(tbl_id, url,conditions, disablesorting,default_order,type='') 
{
	try
	{
			$('#'+tbl_id).dataTable().fnDestroy();

	}
	catch(e)
	{
		
	}
	
	var parts = new Array();
	if(typeof(disablesorting) != 'undefined')
	{
		parts = disablesorting.split(',').map(function(item) {
			return parseInt(item);
		});
	}
	//console.log(parts); 
	dtable=$('#'+tbl_id).DataTable({
			"aoColumnDefs": [
			  { 'bSortable': false, 'aTargets': parts }
			],
			"order": default_order,
			"processing": false,
			"serverSide": true,
			"bDestroy": true,
			"ajax": {
				"url": url,
				"type": "POST",
				"async":true,
				"data": function(d){ d.conditions = conditions;d.type=type },
				"error": function(data, statusText, xhr){ if(xhr.status==303) location.reload(); console.log(xhr.status);}
			},			
			"language": {
	            "decimal": "",
	            "emptyTable": "No hay información",
	            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
	            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
	            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
	            "infoPostFix": "",
	            "thousands": ",",
	            "lengthMenu": "Mostrar _MENU_ Entradas",
	            "loadingRecords": "Cargando...",
	            "processing": "Procesando...",
	            "search": "Buscar:",
	            "zeroRecords": "Sin resultados encontrados",
	            "paginate": {
	                "first": "Primero",
	                "last": "Ultimo",
	                "next": "Siguiente",
	                "previous": "Anterior"
	            }
	        },
	    	responsive: true,
	    	bDestroy: true,
	    // lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	    // order: [[ 0, "desc" ]],
			
	});
	// console.log(" URL : "+url);
	// console.log(" TABLEID : "+tbl_id);
	// console.log(" Conditions : "+conditions);
	$('#'+tbl_id).dataTable();
	return false;
}

function in_array(needle, haystack, argStrict) {
  var key = '',
    strict = !! argStrict;
  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}