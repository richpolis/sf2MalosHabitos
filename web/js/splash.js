function iniciarSplash(){
	var $frase = $("#frase");
        var $footer = $("footer");
        $footer.hide("fast");
	$frase.fadeIn("slow",function(){
		setTimeout(splashShow,1500);
	});
}

function splashShow(){
	var $leyenda = $("#leyenda");
	var $frase = $("#frase");
	var $botones = $("#botones");
        /*var $footer = $("footer");*/
	$frase.fadeOut("slow",function(){
		$leyenda.fadeIn("slow");
		$botones.fadeIn("slow");
        /*$footer.fadeIn("slow");*/
	});

}

$(document).on("ready",iniciarSplash);
