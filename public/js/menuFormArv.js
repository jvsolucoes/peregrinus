$(document).ready(function(){	
    // first example
    $("#browser").treeview();
    
    $('.empresa').click(function(){
        $('.escritorios').hide();
	$('.salas').hide();
	$('.portaContainers').hide();
	$('.containers').hide();
	$('.volumes').hide();
        $('.empresas').show();
    });
    
    $('.escritorio').click(function(){
	$('.empresas').hide();
	$('.salas').hide();
	$('.portaContainers').hide();
	$('.containers').hide();
	$('.volumes').hide();        
	$('.escritorios').slideToggle();
    });
    
    $('.sala').click(function(){
	$('.empresas').hide();
	$('.escritorios').hide();
	$('.portaContainers').hide();
	$('.containers').hide();
	$('.volumes').hide();        
	$('.salas').slideToggle();
    });
    
    $('.portaContainer').click(function(){
	$('.empresas').hide();
	$('.escritorios').hide();
	$('.salas').hide();
	$('.containers').hide();
	$('.volumes').hide();                
	$('.portaContainers').slideToggle();
    });
    
    $('.container').click(function(){
	$('.empresas').hide();
	$('.escritorios').hide();
	$('.salas').hide();
	$('.portaContainers').hide();
	$('.volumes').hide();          
	$('.containers').slideToggle();
    });
    
    $('.volume').click(function(){
	$('.empresas').hide();
	$('.escritorios').hide();
	$('.salas').hide();
	$('.portaContainers').hide();
	$('.containers').hide();               
	$('.volumes').slideToggle();
    });
    
    $('.dadosEmpresa').click(function(){
       $('.detalhesEscritorio') .hide();
       $('.detalhesSala') .hide();
       $('.detalhesPc') .hide();
       $('.detalhesContainer') .hide();
       $('.detalhesVolume') .hide();
       $('.detalhesEmpresa').slideToggle();
    });
    
    $('.dadosEscritorio').click(function(){
       $('.detalhesEmpresa') .hide();
       $('.detalhesSala') .hide();
       $('.detalhesPc') .hide();
       $('.detalhesContainer') .hide();
       $('.detalhesVolume') .hide();
       $('.detalhesEscritorio').slideToggle();
    });
    
    $('.dadosSala').click(function(){
       $('.detalhesEmpresa') .hide();
       $('.detalhesEscritorio') .hide();
       $('.detalhesPc') .hide();
       $('.detalhesContainer') .hide();
       $('.detalhesVolume') .hide();
       $('.detalhesSala').slideToggle();
    });
    
    $('.dadosPc').click(function(){
       $('.detalhesEmpresa') .hide();
       $('.detalhesEscritorio') .hide();
       $('.detalhesSala') .hide();
       $('.detalhesContainer') .hide();
       $('.detalhesVolume') .hide();
       $('.detalhesPc').slideToggle();
    });
    
    $('.dadosContainer').click(function(){
       $('.detalhesEmpresa') .hide();
       $('.detalhesEscritorio') .hide();
       $('.detalhesSala') .hide();
       $('.detalhesPc') .hide();
       $('.detalhesVolume') .hide();
       $('.detalhesContainer').slideToggle();
    });
    
    $('.dadosVolume').click(function(){
       $('.detalhesEmpresa') .hide();
       $('.detalhesEscritorio') .hide();
       $('.detalhesSala') .hide();
       $('.detalhesPc') .hide();
       $('.detalhesContainer') .hide();
       $('.detalhesVolume').slideToggle();
    });
    
    $('.escondeDiv').click(function(){
       $('.detalhesEmpresa') .hide();
       $('.detalhesEscritorio') .hide();
       $('.detalhesSala') .hide();
       $('.detalhesPc') .hide();       
       $('.detalhesContainer') .hide();
       $('.detalhesVolume') .hide();
    });
});
