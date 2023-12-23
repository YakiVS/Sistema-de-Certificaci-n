const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');

/* Inicializamos la imagen */
/* const image =new Image(); */
const imageqr =new Image();
const image =new Image();

$(document).ready(function(){
    var curd_id=getUrlParameter('curd_id');
    
    $.post("../../controller/usuario.php?op=mostrar_curso_detalle",{curd_id:curd_id},function(data){
        data=JSON.parse(data);
                
        /* Ruta de la Imagen */
        image.src = data.cur_img;
        /* image.src = '../../public/1.png'; */

        /* Dimensionamos y seleccionamos la imagen */
        ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
        /* Definimos tamaño de la fuente */
        ctx.font = '20px Dosis ExtraBold';
        ctx.textAlign = "center";
        ctx.textBaseline = 'middle';
        var x = canvas.width / 3;
        ctx.fillText(data.usu_nom+' '+ data.usu_apep+' '+data.usu_apem, x, 240);

        ctx.font = '22px Dosis ExtraBold';
        ctx.fillText(data.cur_nom, x, 292);

        ctx.font = 'Bold 12px Times New Roman';
        ctx.fillText(data.curd_nota, 387, 267);

        ctx.font = 'Bold 12px Calibri';
        ctx.fillText(data.curd_id, 772, 408);

        /* ctx.font = 'Bold 14px Calibri';
        ctx.fillText(data.cur_fechini, 188, 335);

        ctx.font = 'Bold 14px Calibri';
        ctx.fillText(data.cur_fechfin, 272, 335); */

        // Convertir la fecha inicial a formato español
        var fechaInicial = new Date(data.cur_fechini);
        var fechaInicialFormateada = fechaInicial.toLocaleDateString('es-ES');

        // Convertir la fecha final a formato español
        var fechaFinal = new Date(data.cur_fechfin);
        var fechaFinalFormateada = fechaFinal.toLocaleDateString('es-ES');

        // Luego, puedes utilizar las variables fechaInicialFormateada y fechaFinalFormateada para renderizar en tu lienzo:
        ctx.font = 'Bold 14px Calibri';
        ctx.fillText(fechaInicialFormateada, 188, 335);

        ctx.font = 'Bold 14px Calibri';
        ctx.fillText(fechaFinalFormateada, 272, 335);

        // Suponiendo que data.curd_fechemi es una cadena de fecha válida
        var fecha = new Date(data.curd_fechemi);

        // Array con nombres de meses
        var meses = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];

        // Obtener día, mes y año
        var dia = fecha.getDate();
        var mes = meses[fecha.getMonth()];
        var año = fecha.getFullYear();

        // Construir la cadena formateada
        var fechaFormateada = dia + " de " + mes + " del " + año;

        // Luego puedes usar fechaFormateada en tu código
        ctx.font = 'Bold 14px Calibri';
        ctx.fillText(fechaFormateada, 445, 400);
 

        /* Ruta de la Imagen */
        imageqr.src = "../../public/qr/"+curd_id+".png";
        /* Dimensionamos y seleccionamos imagen */
        ctx.drawImage(imageqr, 400, 500, 100, 100);
        
        

        $('#cur_descrip').html(data.cur_descrip);
    });

});

/* Recarga por defecto solo 1 vez */
window.onload = function() {
    if(!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
    }
}

$(document).on("click","#btnpng", function(){
    let lblpng = document.createElement('a');
    lblpng.download = "Certificado.png";
    lblpng.href = canvas.toDataURL();
    lblpng.click();
});

$(document).on("click","#btnpdf", function(){
    var imgData = canvas.toDataURL('image/png');
    var doc = new jsPDF('l', 'mm');
    doc.addImage(imgData, 'PNG', 30, 15);
    doc.save('Certificado.pdf');
});

var getUrlParameter = function getUrlParameter(sParam){
    var sPageURL=decodeURIComponent(window.location.search.substring(1)),
    sURLVariables = sPageURL.split('&'),
    sParameterName,
    i;

    for (i=0; i< sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if(sParameterName[0] === sParam){
            return sParameterName[1]===undefined ? true: sParameterName[1];
        }        
    }
};