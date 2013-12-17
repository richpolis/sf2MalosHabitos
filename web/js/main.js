jQuery.browser = {};
jQuery.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
jQuery.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
jQuery.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());

function showImagenesNoticia(idNoticia){
    $.get('/app.php/imagenes/noticias/'+idNoticia,{},function(data){
       $.prettyPhoto.open(data.imagenes,data.titulos,data.descripciones);
    });
}

function paginaNoticias(pagina){
    $(".loader-richpolis").show("fast",function(){
        $.get('/app.php/noticias',{'pageNoticias':pagina},function(data){
            $(".contenido-news").fadeOut("fast",function(){
                $(".contenido-news").html(data).fadeIn("slow",function(){
                    $(".loader-richpolis").hide("fast");
                });
            });
        });
    });
    
}

function paginaArtistas(){
    $(".loader-richpolis").show("fast",function(){
        $.get('/app.php/artistas',{},function(data){
            $(".lista-artistas").fadeOut("fast",function(){
                $(".lista-artistas").html(data).fadeIn("slow",function(){
                    $(".loader-richpolis").hide("fast");
                });
                iniciarPaginaArtistas();
            });
        });
    });
}

function paginaProductos(tipo,pagina){
    $(".loader-richpolis").show("fast",function(){
        $.get('/app.php/productos/'+tipo,{},function(data){
            $(".contenido-shop").fadeOut("fast",function(){
                $(".contenido-shop").html(data).fadeIn("slow",function(){
                    $(".loader-richpolis").hide("fast");
                });
                $(".categoria-shop").removeClass("active");
                $(".categoria-shop-"+tipo).addClass("active");
                iniciarPaginaShop();
            });
        });
    });
    
}

function mensajeFormulario(){
    $(".mensaje-formulario").fadeOut("slow",function(){
        $(".input-formulario").find("ul").delay(1000).fadeOut();
        $(".input-form-producto").find("ul").delay(1000).fadeOut();
    });
}


function inicializarContacto() {
    $('button.form-submit').on('click',function() {
        var datos = $("form.form-contacto").serialize();
        $(".loader-richpolis").show("fast",function(){
            $.post("/contacto", datos,
                function(data) {
                    $(".formulario").fadeOut("fast",function(){
                        $(".formulario").html(data).fadeIn("slow",function(){
                            $(".loader-richpolis").hide("fast");
                        });
                    });
            });
        });
    });
}

function iniciarPaginaShop(){
    $(".item-shop").on("click", function(){
       var $item= $(this); 
       $(".loader-richpolis").show("fast",function(){ 
          $().dialogModalRS("/app.php/producto/"+$item.data("shop"),cargarProducto($item.data("shop")));
       });
    });
}

function iniciarPaginaArtistas(){
    $(".item-artista").click(function() {
       var $item= $(this);
       var $contenidoAjax=$(".contenido-ajax");
       var source = $item.data("url");
       var $loader=$(".loader-richpolis").html();
       $contenidoAjax.html('<div style="margin: auto; width: 100%; height: 100px;">'+$loader+'</div>');
       $('html,body').animate({scrollTop: $("#artistas").offset().top}, 'slow');
       $.get(source, function(data) {
            $contenidoAjax.html(data).slideDown(500);
        });
       
    });
}

function cargarProducto(id){
    setTimeout(function(){
        $(".loader-richpolis").hide("fast");
    },2000);
}

$(function(){
    $.fn.scrollToTop=function(){
        $(this).hide().removeAttr("href");
        if($(window).scrollTop()>="100"){
            $(this).fadeIn("slow")
        }
        var scrollDiv=$(this);
        $(window).scroll(
            function(){
                if($(window).scrollTop()<="1200"){
                    $(scrollDiv).fadeOut("slow")
                }else{
                    $(scrollDiv).fadeIn("slow")}
                });
        $(this).click(function(){
            $("html, body").animate({scrollTop:0},"slow")})
    }
    $.fn.scrollToTopRichpolis=function(){
        if($(window).scrollTop()==($(this).offset().top)){
            $(this).find("ul").animate({'opacity':1},"slow");
        }
        var scrollHeader=$(this);
        $(window).scroll(
            function(){
                var $offset = $(scrollHeader).offset();
                if($(window).scrollTop()>($offset.top-70)){
                    $(scrollHeader).find("ul").animate({'opacity':1},"slow");
                }else if($(window).scrollTop()==0){
                    $(scrollHeader).find("ul").animate({'opacity':0},"slow")
                };
        });
    }
});
$(function(){
    $("#toTo_button").scrollToTop();
    //$("#news,#about,#artistas,#shop,#contact").scrollToTopRichpolis();
    //$("#contact").scrollToTopRichpolis();
});
