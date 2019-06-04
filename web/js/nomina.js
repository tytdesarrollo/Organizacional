var countTemplate = 0;
var setTimeOutAlert;
console.log(getempleadosel);

jQuery(document).ready(function () {

     //Configuramos el diagrama
     var options = new primitives.orgdiagram.Config();
     //Deshabilitamos un checkbox que viene por defecto en la plantilla
     options.hasSelectorCheckbox = primitives.common.Enabled.False;
     //Deshabilitamos los botones
     options.hasButtons = primitives.common.Enabled.False;
     //Añadimos una función de click
     options.onMouseClick = onMouseClick;
     //Llamamos la función que se encarga de renderizar y mostrar los datos en la plantilla
     options.onItemRender = onTemplateRender;
     //por defecto le asignamos esta plantilla, ya que es la más usada para esta configuración
     options.defaultTemplateName = "Template";
     //getData retorna un arreglo de objetos 
     options.items = getData();
     //El item que queremos que al cargar la página este desplegado
     options.cursorItem = options.items[1]['id'];
     //Indicamos que plantillas usará la configuración
     options.templates = [getTemplate(options.items), getCursorTemplate(), getDepartmentTitleTemplate()]; 
     //Enviamos el contenido
     jQuery("#basicdiagram").orgDiagram(options); 
    //console.log(searchParentDependence(24));
});

//función que limpia el contenido del div "list"
function closeClean(){
    document.getElementById('list').innerHTML="";
    document.getElementById("disciplinaryProcesses").innerHTML='<h5 class="mrg__top-30 font-gray-dark">El empleado no tiene faltas disciplinarias.</h5>	';
    document.getElementById("curses").innerHTML='<h5 class="mrg__top-30 font-gray-dark">El empleado no se encuentra en ningún curso.</h5>	';
}

// Configuración para enviar los datos del organigrama
function createOrganigram(items) {    
    
    jQuery("#basicdiagram").orgDiagram({
        items: items,
        cursorItem: items[1]['id']
    });
    jQuery("#basicdiagram").orgDiagram("update", /*Refresh: use fast refresh to update chart*/ primitives.orgdiagram.UpdateMode.Refresh);  
}

// Cnofiguración de la plantilla principal de los items
function getTemplate(items){

    // Configuramos la plantilla, como tamaño, nombre, padding
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "Template";

    
    
    //Esta plantilla nos mostrará un item con más datos, y un botón que permite ver más información del item
    //Con el arreglo de competencias lo convertimos en una lista
    var list = items[1]['competences'];
    var code = "";
    if (countTemplate==0) {
        
        code = "<ul>";
        for (let index = 0; index < list.length; index++) {
            code= code + "<li style='text-align:justify'>" +   list[index] + "</li>";               
        }
        code = code + "</ul>";       
        countTemplate=1; 
    }

    document.getElementById("list").innerHTML = code;

    if(getempleadosel=="empshow") {

        //TAMANO DE CUADROS
        result.itemSize = new primitives.common.Size(212, 255);
        result.minimizedItemSize = new primitives.common.Size(10, 10);
        result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
        result.hasSelectorCheckbox = true;

        var itemTemplate = jQuery(
            '<div>'
            + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 5px; left: 12px; width: 187px; height: 20px;">'
            + '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 180px; height: 18px; color:white;"></div>'
            + '</div>'
            + '<div class="bp-item" style="top: 50px; left: 12px; width: 216px; height: 22px; font-weight:bold; font-size: 12px;">Empleados registrados</div>'
            + '<div name="nose" class="felipe bp-item" style="top: 80px; left: -15px; width: 210px; height: 78px; font-size: 11px;">' + code + '</div>'
            + '</div>').css({
            width: (result.itemSize.width + 10) + "px",
            height: (result.itemSize.height + 10) + "px",
        }).addClass("bp-item bp-corner-all bt-item-frame");

    }else{

        //TAMANO DE CUADROS
        result.itemSize = new primitives.common.Size(150, 55);
        result.minimizedItemSize = new primitives.common.Size(10, 10);
        result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
        result.hasSelectorCheckbox = true;

        var itemTemplate = jQuery(
            '<div>'
           // + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 15px; left: 0px; width: 170px; height: 20px;">'
            + '<div name="title" class="bp-item bp-title" style="top: 30%; left: 10%; width: 140px; height: 18px; color:#001072;"></div>'
            + '</div>'
            + '</div>').css({
            width: (result.itemSize.width + 10) + "px",
            height: (result.itemSize.height + 10) + "px",
        }).addClass("bp-item bp-corner-all bt-item-frame");

    }

    result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

    return result;
}

//Eventos de los items
function onMouseClick(event, data) {

    //En esta función definimos los eventos que harán los botones
    var target = jQuery(event.originalEvent.target);

    if (target.hasClass("btn") || target.parent(".btn").length > 0) {

        var button = target.hasClass("btn") ? target : target.parent(".btn");

        var buttonname = button.data("buttonname");  
        
        if (buttonname=="infoDependence") {
            //console.log("Cogeeeeeeeeeeeeeee");
            chargeValue("value-dependence-work", 6);
            chargeValue("value-dependence-free", 5);
            chargeValue("value-dependence-required", 7);
            chargeValue("value-dependence-studies",data.context.students);
            // console.log(num + " el num2");
            
            $('#titleDependence').css("color",data.context.itemTitleColor);
            $('.hr-dependence').css("border-top","1px solid "+data.context.itemTitleColor);
            $('.circle-Dependence').css("border","1px solid "+data.context.itemTitleColor);
            $('#close-dependence a').css({
                background: data.context.itemTitleColor,
	            color: '#ffffff'}
               );
            $('.modal-dependence .close').css("color",data.context.itemTitleColor);
            $(".modal-dependence .close").hover(function(){
                $(this).css("color",data.context.itemTitleColor);
                });
            document.getElementById("titleDependence").innerHTML=data.context.title;

            var svgWork = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"'
            +'width="41.667px" height="46.5px" viewBox="0 0 41.667 46.5" enable-background="new 0 0 41.667 46.5" xml:space="preserve">'
            +'<g>'
            +    '<circle fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" cx="20.96" cy="12.384" r="6.244"/>'
            +    '<g>'
            +        '<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M29.732,32.396h3.364l0,0'
            +            'c0-7.606-5.431-13.768-12.136-13.768c-6.705,0-12.138,6.165-12.138,13.768l0,0h3.182"/>'
            +    '</g>'
            +    '<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M29.742,32.216c0,0,0.151,4.023,0.045,9.02H12.155'
            +        'c-0.06-2.701-0.058-7.32-0.058-9.02l0,0c0-1.703,1.119-3.079,2.497-3.079h12.65C28.625,29.135,29.742,30.513,29.742,32.216'
            +        'L29.742,32.216z"/>'
            +    '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="-0.023" y1="32.396" x2="12.051" y2="32.396"/>'
            +    '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="31.109" y1="32.396" x2="41.69" y2="32.396"/>'
            +'</g>'
            +'</svg>';
            
            var svgFree = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"'
                            +    'width="41.667px" height="46.5px" viewBox="0 0 41.667 46.5" enable-background="new 0 0 41.667 46.5" xml:space="preserve">'
                            +    '<g>'
                            +        '<rect x="35.516" y="7.794" fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" width="4.491" height="11.599"/>'
                            +        '<rect x="1.104" y="23.673" fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" width="26.366" height="20.21"/>'
                            +        '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="40.57" y1="23.704" x2="20.789" y2="23.704"/>'
                            +        '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="40.339" y1="22.708" x2="40.339" y2="45.297"/>'
                            +        '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="37.761" y1="20.316" x2="37.761" y2="22.859"/>'
                            +    '</g>'
                            +    '</svg>';
            
            var svgRequired = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"'
                            +    'width="41.667px" height="46.5px" viewBox="0 0 41.667 46.5" enable-background="new 0 0 41.667 46.5" xml:space="preserve">'
                            +       '<rect x="1.255" y="22.823" fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" width="19.218" height="12.91"/>'
                            +       '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="33.386" y1="22.823" x2="15.185" y2="22.823"/>'
                            +       '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="32.378" y1="22.394" x2="32.378" y2="36.529"/>'
                            +       '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="3.437" y1="18.092" x2="37.208" y2="18.092"/>'
                            +       '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="36.208" y1="17.642" x2="36.208" y2="36.492"/>'
                            +       '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="6.335" y1="13.338" x2="41.522" y2="13.338"/>'
                            +       '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="40.569" y1="12.907" x2="40.569" y2="36.492"/>'
                            + '</svg>';

            var svgStudies = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"'
                            +   'width="41.667px" height="46.5px" viewBox="0 0 41.667 46.5" enable-background="new 0 0 41.667 46.5" xml:space="preserve">'
                            +   '<circle fill="#FFFFFF" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" cx="27.346" cy="12.445" r="4.714"/>'
                            +   '<path fill="#FFFFFF" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M34.035,20.903l-1.543-1.385'
                            +   'c-1.443-1.229-3.373-1.982-5.494-1.982c-2.266,0-4.727,0.901-6.32,2.248l-1.029,0.998l-1.283,1.25"/>'
                            +   '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="26.998" y1="23.462" x2="26.998" y2="34.951"/>'
                            +   '<g>'
                            +   '<path fill="#FFFFFF" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M26.181,34.559l1.163,0.576'
                            +       'c0,0,4.771-3.99,11.021-3.314v-2.614c-1.197,0-2.168-0.97-2.168-2.17v-1.833c0-1.2,0.971-2.171,2.168-2.171v-2.658'
                            +       'c0,0-5.099-0.076-11.021,2.861l-0.886,0.432c0,0-1.083,0.677-1.874,1.054"/>'
                            +   '<path fill="#FFFFFF" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M38.367,29.205c1.199,0,2.172-0.971,2.172-2.17'
                            +       'v-1.833c0-1.2-0.973-2.171-2.172-2.171"/>'
                            +   '<path fill="#FFFFFF" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M15.625,23.462"/>'
                            +   '</g>'
                            +   '<path fill="#FFFFFF" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M29.207,25.62c0,0,2.881-1.536,4.828-1.237"/>'
                            +   '<circle fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" cx="14.934" cy="16.718" r="4.714"/>'
                            +   '<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M21.623,25.178l-1.542-1.386'
                            +       'c-1.444-1.23-3.375-1.983-5.493-1.983c-2.268,0-4.316,0.857-5.781,2.236L8.258,24.58l-0.417,0.359"/>'
                            +   '<line fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" x1="14.583" y1="27.734" x2="14.583" y2="39.223"/>'
                            +   '<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M5.47,31.309c0,1.197-0.972,2.172-2.172,2.172l0,0'
                            +       'c-1.2,0-2.17-0.975-2.17-2.172v-1.834c0-1.197,0.97-2.17,2.17-2.17l0,0c1.2,0,2.172,0.973,2.172,2.17V31.309z"/>'
                            +   '<g>'
                            +   '<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M3.298,33.479v2.688c0,0,7.577,0.332,11.058,2.937'
                            +       'l0.577,0.305c0,0,4.77-3.991,11.021-3.314V33.48c-1.201,0-2.172-0.975-2.172-2.172v-1.834c0-1.197,0.971-2.17,2.172-2.17v-2.656'
                            +       'c0,0-5.1-0.078-11.021,2.859l-0.35,0.227c0,0-5.458-3.689-11.285-3.086v2.66"/>'
                            +   '<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M25.955,33.479c1.2,0,2.172-0.974,2.172-2.17'
                            +       'v-1.834c0-1.199-0.972-2.172-2.172-2.172"/>'
                            +   '<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M3.212,27.734"/>'
                            +'</g>'
                            +'<path fill="none" stroke="'+data.context.itemTitleColor+'" stroke-width="2" stroke-miterlimit="10" d="M16.795,35.001c0,0,2.878-1.535,4.826-1.233"/>'
                            +'</svg>';

            //se carga el icono y el valor para este id
            
            document.getElementById("icon-dependence-work").innerHTML=svgWork;
            
            //se carga el icono y el valor para este id
            
            document.getElementById("icon-dependence-free").innerHTML=svgFree;
            
            //se carga el icono y el valor para este id
            
            document.getElementById("icon-dependence-required").innerHTML=svgRequired;
            
            //se carga el icono y el valor para este id
            
            document.getElementById("icon-dependence-studies").innerHTML=svgStudies;
            num=0;

        }
        
        //Si el boton es info, se mostrará un modal con más información del item
        if (buttonname=="info") {
            
            document.getElementById('list').innerHTML=" ";
            document.getElementById("disciplinaryProcesses").innerHTML='<h5 class="mrg__top-30 font-gray-dark">El empleado no tiene faltas disciplinarias.</h5>	';
            document.getElementById("curses").innerHTML='<h5 class="mrg__top-30 font-gray-dark">El empleado no se encuentra en ningún curso.</h5>	';
            document.querySelector('#photo').src=data.context.image;
            document.getElementById("nominaLabel").innerHTML=data.context.title;
            document.getElementById("dependenceUser").innerHTML=data.context.dependence;
            document.getElementById("charge").innerHTML=data.context.groupTitle;
            document.getElementById("contract").innerHTML=data.context.contract;
            document.getElementById("antiquity").innerHTML=data.context.antiquity + " años";
            document.getElementById("salary").innerHTML= "$" + data.context.salary;
            document.getElementById("number").innerHTML=data.context.phone;
            document.getElementById("address").innerHTML=data.context.address;
            document.getElementById("age").innerHTML=data.context.age + " años";
            document.getElementById("civil-status").innerHTML=data.context.civilStatus;
            document.getElementById("working-status").innerHTML=data.context.workingStatus;
            document.getElementById("date-start").innerHTML=data.context.dateStart;
            document.getElementById("date-end").innerHTML=data.context.dateEnd;
            
            //Creamos la lista de competencias para que sean agregadas al modal
            var list = data.context.competences;
            var code = "<ul class='list-group'>";
            
            for (let index = 0; index < list.length; index++) {
                code= code + "<li class='list-group-item iconList mrg__bottom-5'><div class='row align_center list-ie'><span class='col-md-1 fnt__Medium redFont disp-flex-center'>"+(index+1)+"</span> <div class='col-md-9 border-red align_center' style='color:#5d5d5d'>" + list[index] + "</div> <div id='circle"+index+"' class='circles col-md-2 fnt__Bold font-gray-dark leftCircle'></div></li>";               
            }
            code = code + "</ul>";
            
            document.getElementById("list").innerHTML = code;
            
            //Recibimos los porcentajes correspondientes a las competencias del empleado
            var percentage = data.context.percentage;             
            var competencesOfCharge = data.context.competences;
            code = "<ul class='list-group'>";
            for (let index = 0; index < competencesOfCharge.length; index++) {               
                var color= colorCompetence(percentage[index]);
                code = code + "<li class='list-group-item mrg__bottom-5'><div class='row align_center'><i class='col-md-1 redFont fnt__Medium disp-flex-center material-icons'>done</i> <div class='col-md-7 align_center' style='font-size:14px; color:#5d5d5d'>" + competencesOfCharge[index] + "</div> <div class='progress-competence'><div id='bar"+index+"' class='progress-value disp-flex-center' style='width: 1%; background-color:"+color+"'><span id='value"+index+"'></span></div></div></li>";
                // code= code + "<li class='list-group-item mrg__bottom-5'><div class='row align_center'><i class='col-md-1 redFont fnt__Medium disp-flex-center material-icons'>done</i> <div class='col-md-7 align_center' style='font-size:13px;'>" + competencesOfCharge[index] + "</div> <div class='col-md-4'><span id='competenceAnimate" + index+"' class='progress-value' style=' background-color: "+color+ ";'></span></div></li>";
            }
            var valueTotalCompetence = 67;
            var colorTotalCompetence = "";
            colorTotalCompetence = colorCompetence(valueTotalCompetence);
            code = code + "<li class='list-group-item mrg__bottom-5 mrg__top-15'><div class='row align_center'><div class='col-md-7 no-pdg align_center redFont fnt__Bold' style='font-size:18px;'>Total</div> <div class='progress-competence' style='margin-left:30px'><div id='bar"+(competencesOfCharge.length+1)+"' class='progress-value disp-flex-center' style='width: 1%; background-color:"+colorTotalCompetence+"'><span id='value"+(competencesOfCharge.length+1)+"'></span></div></div></li>";
            code = code + "</ul>";
            
            document.getElementById("competencesCharge").innerHTML = code;
            
            selectIcon(data.context.workingStatus);

            var countScrollCircle = 0;
            var countScrollBar = 0;

            $("#user").scroll(function(){
                var scrollTop = $("#user").scrollTop();
                // console.log("scrollTop user"+scrollTop);
                
                //Muestras al otro <div>
                // console.log("$(window).scrollTop(): "+$(window).scrollTop());
                // console.log("$('#competencesCharge').offset().top: "+$("#competencesCharge").offset().top);
                // console.log("$(window).height()"+ $(window).height());
                
                var competences = $("#competences").offset();
                var competenceGraphics = $("#competenceGraphics").offset();
                
                // console.log("Tamaño de la ventana"+$(window).height());
                // console.log($("#competenceGraphics").offset());
                
                if((scrollTop+50) >= competenceGraphics.top  && countScrollBar == 0 ){                   
                    countScrollBar = 1;
                    for (let index = 0; index < percentage.length; index++) {                        
                        chargePercentage(index, percentage[index]);                                 
                    }
                    chargePercentage(percentage.length+1, valueTotalCompetence);
                }
                
                if(scrollTop + 60>= competences.top && countScrollCircle == 0){
                    
                    countScrollCircle = 1;
                    for (let index = 0; index < percentage.length; index++) {
                        //Con la biblioteca circliful creamos los diagramas para representar los porcentajes graficamente
                        $("#circle"+index).circliful({
                            animation: 1,
                            animationStep: 5,
                            percent: percentage[index],
                            textSize: 45,
                            textStyle: 'font-size: 25px;',
                            textColor: '#515151',
                            percentageTextSize: 35,
                            foregroundBorderWidth: 20,
                            backgroundBorderWidth: 15,
                            progressColor: {0: '#d42027', 40: '#f47c42', 60: '#eeb541', 80: '#50b95d'},
                            backgroundColor: '#DBDBDB',
                        });                
                    }                    
                }        
                        
            }); 

            if(data.context.disciplinaryProcesses.length>0){
                var string = "<ul class='list-group mrg__top-30'>";
            
                for (let index = 0; index < data.context.disciplinaryProcesses.length; index++) {
                    string= string + "<li class='list-group-item  mrg__bottom-5' style='color:#5d5d5d; font-size:14px;'> <div class='row'> <i class='material-icons redFont col-md-2'>remove</i><div class='col-md-11'>"+data.context.disciplinaryProcesses[index]+"</div></div></li>";               
                }
                string = string + "</ul>";
        
                document.getElementById("disciplinaryProcesses").innerHTML=string;
            }

            if(data.context.curses.length>0){
                var string = "<ul class='list-group mrg__top-30'>";
            
                for (let index = 0; index < data.context.curses.length; index++) {
                    string= string + "<li class='list-group-item  mrg__bottom-5' style='color:#5d5d5d; font-size:14px;'> <div class='row'><div class='col-md-1 width-5'><img src='../web/img/icon-book.svg' alt=''></div><div class='col-md-11'>"+data.context.curses[index]+"</div></div></li>";               
                }
                string = string + "</ul>";
        
                document.getElementById("curses").innerHTML=string;
            }
        }        
    }
            
}

//Asigna el icono del campo "Estado Laboral" de la información de un item
function selectIcon(valor){
    var img = document.getElementById('icon-status');
    if(valor=="Vacaciones"){
        img.src= "../web/img/icon-status-vacation.svg";
    }else if(valor=="Licencia Materna"){
        img.src= "../web/img/icon-licence-pregnant.svg";
    }else if(valor=="Embarazada"){
        img.src= "../web/img/icon-pregnant.svg";
    }else if(valor=="Trabaja"){
        img.src= "../web/img/icon-work.svg";
    }else if(valor=="Incapacitado"){
        img.src= "../web/img/icon-sick.svg";
    }
}

//Función que de acuerdo al porcentaje recibido devuelve cierto color
function colorCompetence(percentage){
    //Rojo
    var color = '#d42027';
    if(percentage<60 && percentage>=40){
        //Amarillo
        return color = '#f47c42';
    }else if(percentage<80 && percentage>=60){
        //Naranja
        return color = '#eeb541';
    }else if(percentage>=80){
        //Verde
        return color = '#50b95d';                    
    }
    return color;
}

//función que trae de los items, los valores de cierto campo
function getValueOrganigram(field,comparator,add){
    //field, es el campo que queremos comparar
    //comparator, es el valor con el que compararemos el campo
    //add, que campo quiero que me traiga cuando se cumpla la comparación

    //Traemos todos los datos 
    var items = getData();
    var array = [];

    for (let index = 0; index < items.length; index++) {
        const element = items[index];
        if(element[field]==comparator){
            array.push(element[add]);
        }        
    }
    return array;
}

//Función que busca la dependencia a la que pertenece el empleado
function searchParentDependence(idEmployee){
    //Traemos tods los datos 
    var items = getData();
    //Contador que nos ayudará a buscar el segundo padre de un item
    var count = 0;
    while (true) {
                              
        for (let index = 0; index < items.length; index++) {
            
            if(items[index]['templateName']=="CursorTemplate" ) {
                /* if(idEmployee==0){                   
                    return items[index]['title']; 
                } else */ if(count==1 && items[index]['id']==idEmployee){                      
                    return items[index]['title'];             
                }else if (items[index]['id']==idEmployee) {
                    count=1;
                    if(idEmployee==0){                   
                        return items[index]['title']; 
                    }
                    idEmployee=items[index]['parent'];
                }
            }else if(items[index]['id']==idEmployee){
               idEmployee=items[index]['parent'];               
            }  
        }
    }   
}

//función que se encarga de animar las competencias vs cargo
function chargePercentage(index,percentage ){
    //Index, es para asignarle el valor del porcentaje
    var width = 1;
    //los div con id "value es donde se va a modificar el ancho"
    var elem = document.getElementById("bar"+index);
    //Se ejecuta la función frame cada 20 milisegundos  
    var id = setInterval(frame, 20);

    function frame() {
        if (width >= percentage) {
            clearInterval(id);
        } else {
            width++; 
            elem.style.width = width + '%'; 
            document.getElementById("value"+index).innerHTML = width  + '%';
        }
    }
}

//función que se encarga de animar los valores de las dependencias
function chargeValue(name, percentage){
    //Index, es para asignarle el valor del porcentaje
    var width = 1;
    //Se ejecuta la función frame cada 20 milisegundos  
    var id = setInterval(secuence, 100);

    function secuence() {
        if (width >= percentage) {
            clearInterval(id);
        } else {
            width++;  
            // document.getElementById(name).innerHTML = width;
            $('#'+name).html(width);
        }
    }
}

// Función que contiene la configuración necesaria para que las plantillas se muestren
function onTemplateRender(event, data) {
    switch (data.renderingMode) {
        case primitives.common.RenderingMode.Create:
            
            break;
        case primitives.common.RenderingMode.Update:
            /* Update widgets here */
            break;
    }

    //En esta función, enviaremos los datos que cada item necesita mostrar
    var itemConfig = data.context;

     //Esta es la plantilla que nos muestra las dependencias de la empresa
    if (data.templateName == "DepartmentTitleTemplate") {
           //Dependiendo de la plantilla que tenga definida el item, serán cargados ciertos datos
        // Se busca en el DOM las etiquetas que tengan ciertos nombres para darle estilo y enviar dato
        data.element.find("[name=titleBackground]").css({ "background": itemConfig.itemTitleColor});
       

        var fields = ["charge"];
        for (var index = 0; index < fields.length; index++) {
            var field = fields[index];

            var element = data.element.find("[name=" + field + "]");
            if (element.text() != itemConfig[field]) {
                element.text(itemConfig[field]);
            }
        }
    
    // Si la plantilla es Itemplate, es decir la encargada de mostrar algunos datos de los empleados
    }else if (data.templateName == "Template") {

         //Dependiendo de la plantilla que tenga definida el item, serán cargados ciertos datos
        // Se busca en el DOM las etiquetas que tengan ciertos nombres para darle estilo y enviar datos
        data.element.find("[name=photo]").attr({ "src": itemConfig.image, "alt": itemConfig.title });
        data.element.find("[name=titleBackground]").css({ "background": itemConfig.itemTitleColor, "text-align": "center" });
        data.element.find("[name=btnSeeMore]").css({ "background": itemConfig.itemTitleColor });
        
        var fields = ["title", "age", "antiquity", "salary", "contract","competences"];
        
        for (var index = 0; index < fields.length; index++) {
            var field = fields[index];
            var element = data.element.find("[name=" + field + "]");
            
            if (element.text() != itemConfig[field]) {
                
                if (field=="age") {
                    element.text(itemConfig['age']+ " años"); 
                }
                if (field=="antiquity") {
                    element.text(itemConfig['antiquity']+ " años");
                }
                if (field=="salary") {
                    element.text("$"+itemConfig['salary']);
                }
                if (field=="contract") {
                    element.text(itemConfig['contract']);
                }
                if (field=="title") {
                    element.text(itemConfig['title']);
                }
                if (field=="competences") {
                    
                    if (countTemplate==1) {           
                       
                        var list = itemConfig['competences'];
                        var code = "<ul>";
                        
                        for (let index = 0; index < list.length; index++) {
                            code= code + "<li style='align:justify'>" +   list[index] + "</li>";               
                        }
                        code = code + "</ul>";
                        
                        data.element.find("[name=nose]").html(code);
                        
                    }
                   
                }
               
            }
        }
    } 
}

// Función que contiene la plantilla del nombre de la dependencia
function getCursorTemplate() {

    //Configuramos la plantilla 
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "CursorTemplate";
    result.isActive = true;  
    result.itemSize = new primitives.common.Size(220, 35);
    result.minimizedItemSize = new primitives.common.Size(10, 10);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    result.cursorPadding = new primitives.common.Thickness(2, 2, 50, 6);

    //Esta plantilla nos permite que los itemes del organigrama tengan el panel de botones
    var cursorTemplate = jQuery("<div></div>")
    .css({
        position: "absolute",
        overflow: "hidden",
        width: (result.itemSize.width + result.cursorPadding.left + result.cursorPadding.right) + "px",
        height: (result.itemSize.height + result.cursorPadding.top + result.cursorPadding.bottom) + "px"
    });

    var cursorBorder = jQuery("<div></div>")
    .css({
        width: (result.itemSize.width + result.cursorPadding.left + 1) + "px",
        height: (result.itemSize.height + result.cursorPadding.top + 1) + "px"
    }).addClass("bp-item bp-corner-all bp-cursor-frame");
    cursorTemplate.append(cursorBorder);

    var bootStrapVerticalButtonsGroup = jQuery("<div></div>")
    .css({
        position: "absolute",
        overflow: "hidden",
        top: "-3px",
        left: (result.itemSize.width + result.cursorPadding.left + 10) + "px",
        width: "35px",
        height: (result.itemSize.height + 1) + "px"
    }).addClass("btn-group btn-group-vertical");

    //Creamos los botones y les damo un nombre a cada uno

    result.cursorTemplate = cursorTemplate.wrap('<div>').parent().html();

    return result;
}

// Le asignamos al boton de búsqueda una función de click
$("#btn-search").click(function () {     
     
    //Se selecciona el item con id 16
    jQuery("#basicdiagram").orgDiagram({cursorItem: 16});

    // Actualizamos el diagrama
    jQuery("#orgdiagram").orgDiagram("update", primitives.common.UpdateMode.Refresh);
});

//$('#modalOrganigram').data('bs.modal').options.keyboard = true; 

//Función que se encarga de buscar que cargos o dependencias quiere el usuario
function getChargeDepedence() {
    var dependences = getDependences();
    var charges = getCharges();
    var searchDependences = [];
    var searchCharges = [];

    clearTimeout(setTimeOutAlert);

    for (let i = 0; i < dependences.length; i++) {
        var checkDependence = document.getElementById("dependenceCheck"+i);
        if(!checkDependence.checked){   
            var arrayCheckbox = document.getElementsByClassName("countCharge"+i);            
            var array = [];
            for (let j = 0; j < arrayCheckbox.length; j++) {
                if(arrayCheckbox[j].checked){
                    array.push(charges[i][j]);
                    searchDependences.push(dependences[i]);            
                }                
            }
            if(array.length>0){
                searchCharges.push(array);
            }
        }else{
            searchCharges.push(charges[i]);
            searchDependences.push(dependences[i]);
        }
    }   
    searchDependences=searchDependences.unique();
 
    searchData(searchDependences,searchCharges);
}

//Función que se encarga de buscar en los datos, los items que solicita el usuario
function searchData(searchDependences,searchCharges) {

    var data = getData();
    var items = [];
    
    for (let i = 0; i < searchDependences.length; i++) {

        for (let j = 0; j < data.length; j++) {
            
            if(data[j]['title']==searchDependences[i]){               
                items.push(data[j]);                       
            }
            if(data[j]['dependence']==searchDependences[i]){
               
                for (let k = 0; k < searchCharges.length; k++) {

                    for (let l = 0; l < searchCharges[k].length; l++) {

                        if (data[j]['groupTitle']==searchCharges[k][l]) {
                            items.push(data[j]);                        
                        }

                    }

                }

            }
            
        }
       
    }

    //console.log(items);
    
    createOrganigram(deleteChildren(items));  
    differentDependence(items);
    var string = $('#textAlert').html();

    if(string.length==0){
        $('#textAlert').html("Se han cargado los datos.");
    }else{
        $('#textAlert').html(string+".");
    }
    
    setTimeout(function() {              
        $("#success-alert").fadeIn(500);      
    }, 800);

    setTimeOutAlert = setTimeout(function() {              
        $("#success-alert").fadeOut(1000);             
    }, 30000);

    
        
   
}

// Función que verifica si se estan cargando dependencias no asociadas
function differentDependence(items){
    var cond = false;
    var countCondition = 0;
    var dependences = getDependences();
    var countDependences = countDependence(items);
    
    // console.log(countDependences);
   
    if(countDependences>1){

        for (let i = 0; i < dependences.length; i++) {           
           
            for (let j = 0; j < items.length; j++) {

                if(items[j]['dependence']==dependences[i]){
                    
                    var titleDependence = searchParentDependence(items[j]['id']);
                   
                    for (let j = 0; j < items.length; j++) {
                
                        if(items[j]['title']==titleDependence){
                            cond = true;                            
                            j=items.length;
                            //console.log("es igual");  
                        }

                    }
                    
                    if(cond==false){
                        countCondition++;
                    }
                }
                
            }
        }

    }else if(countDependences==1){
        cond = true;
    }

    if(cond==false || countCondition>0){
        
        var string = $('#textAlert').html();
        if(string.length>0){
            string += ", algunos de los items no están asociados";           
        }else{
            string = "Algunos de los items no están asociados";
        }
        $('#textAlert').html(string);
    }
}

//función que permite que al cerrar el alert y al cerrarla, cuando vuelva a cargar un organigrama salga está notificación de nuevo
function closeAlert() {
    var alert = '<div class="alert alert-warning alert-dismissible alert-gray" id="success-alert" style="display:none">'
                +    '<a href="#" class="close" data-dismiss="alert" aria-label="close" onclick="closeAlert()">&times;</a>'
                +    '<div id="textAlert"></div>'
                +'</div>;';

    document.getElementById("alertContent").innerHTML= alert;
    
    clearTimeout(setTimeOutAlert);
    //console.log(setTimeOutAlert);
}

//Se encarga de mostrar los hijos directos de un item
function verifyChild(items) {

    var all = getData();
    var items2 = items.slice();

    for (let i = 0; i < items2.length; i++) {  

        var array = [];

        for (let h = 0; h < all.length; h++) {
           
            if(items2[i]['id']==all[h]['parent'] && items2[i]['templateName']!="DepartmentTitleTemplate" && items2[i]['templateName']!="CursorTemplate"){
                array.push(all[h]);                
            }
        
        }
            
        for (let l = 0; l < items2.length; l++) {            
            
            for (let j = 0; j < array.length; j++) {
                
                if(array[j]['id']==items2[l]['id'] && items2[i]['templateName']!="DepartmentTitleTemplate" && items2[i]['templateName']!="CursorTemplate"){
                    array.splice(j,1);
                }
                
            }
        }
       
        if(array.length>0){

            for (let k = 0; k < array.length; k++) {          
              
                if(array[k]['templateName']!="CursorTemplate"){
                    items.push(array[k]);                                    
                }                    
                
            }
        }      
        
    }
    
}


//Plantilla de mostrar un cargo cuando selecciona un item y no el padre
function getDepartmentTitleTemplate() {
    //Esta plantilla es la encargada de mostrar una dependencia de la empresa 
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "DepartmentTitleTemplate";
    result.isActive = true;
    result.selectedItems = [1];   
    result.itemSize = new primitives.common.Size(200, 35);
    result.minimizedItemSize = new primitives.common.Size(10, 10);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);

    var itemTemplate = jQuery(
      '<div class="bp-item bp-corner-all bt-item-frame">'
        + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 196px; height: 30px;">'
            + '<div name="charge" class="bp-item bp-title" style="top: 6px; left: 6px; width: 188px; height: 23px; text-align:center;">'
            + '</div>'
        + '</div>'
        // + '<div name="students" class="bp-item" style="top: 31px; left: 12px; width: 180px; height: 10px;"></div>'
    + '</div>'
    ).css({
        width: result.itemSize.width + "px",
        height: result.itemSize.height + "px"
    }).addClass("bp-item");
    result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

    return result;
}

//Función que se encarga de eliminar los hijos de las items que no se van
//a mostrar
function deleteChildren(items) {

    var conditionW = true;     
    var valueDependence = countDependence(items);
    var string = "";
    while (conditionW) {
              
        var count = 0;

        for (let i = 0; i < items.length; i++) { 

            var length = items.length;
            
            if(items[i]['parent']!=null && items[i]['templateName']!='CursorTemplate'){
               
                var parent = items[i]['parent'];            
                condition = findParent(items,parent); 

                if(!condition){
                    
                    var idParent = findIdParent(items[i]['id']);
                    var cond = findChild(items, idParent)
                    if(!cond){
                        items.splice(i,1);
                        string = "";
                    }
                    var all = getData();
                    for (let j = 0; j < all.length; j++) {
                        
                       if(all[j]['id']==idParent && cond){
                           all[j]['templateName']="DepartmentTitleTemplate";
                           all[j]['groupTitle']="";
                           items.push(all[j]);
                           string = "Uno de los items del organigrama tiene un padre y no lo ha seleccionado, por esto se muestra el cargo del padre del item";
                       }
                        
                    }
                    
                }

                if(condition){
                    count++;                    
                }
                
                if(count==(length-valueDependence)){
                    conditionW = false;                    
                    verifyChild(items);
                    $('#textAlert').html(string);
                    break;
                }          
                            
            }
    
        }        
        
    }
    
    return items;        
    
}

//Función que busca devuelve el id padre de un id hijo que entre
function findIdParent(idChildren) {
    
    var dates = getData();
    var id = 0;

    for (let j = 0; j < dates.length; j++) {
        if(dates[j]['id']==idChildren){
           id = dates[j]['parent'];
        }        
    }
    return id;
}

//Busca en el arreglo items, los hijos 
function findChild(items, id) {
    //items, arreglo que se va a recorrer
    //id del item del que se quiere verificar los hijos
    var condition = false;
    for (let i = 0; i < items.length; i++) {
        if(items[i]['parent']==id){
            condition = true;
        }
        
    }
    return condition;
}
//Función que cuenta las dependencias que hay en un arreglo de items
function countDependence(items) {
    var countDependence = 0;

    for (let i = 0; i < items.length; i++) {

        if(items[i]['templateName']=='CursorTemplate'){
            countDependence++;
        }
        
    }
    return countDependence;
}

//Función que verifica si el id que entra, existe en el arreglo que entra
function findParent(items,idChildren) {

    var data = false;   

    for (let i = 0; i < items.length; i++) {  
        if(items[i]['id']==idChildren){            
            data=true;
            return data;
        }        
    }    
    return data;
}

//Función para eliminar los valores repetidos de un arreglo
Array.prototype.unique=function(a){
    return function(){
        return this.filter(a)}
    }(function(a,b,c){
        return c.indexOf(a,b+1)<0
  });

//Trae las dependencias
function getDependences() {

    var items = getData(); 
    var dependences = []; 

    for (let i = 0; i < items.length; i++) {
                        
        if(items[i]['templateName']=="CursorTemplate"){
            dependences.push(items[i]['title']);  
        }        
    }
    return dependences;
}

//Devuelve todos los cargos de todas las dependencias 
function getCharges() {
    var items = getData(); 
    var array = [];   
    var charges = [];  
 
    for (let i = 0; i < items.length; i++) {
                        
        if(items[i]['templateName']=="CursorTemplate"){
            array.push(getValueOrganigram("dependence",items[i]['title'],"groupTitle"));        
        }        
    }
    for (let j = 0; j < array.length; j++) {        
        charges.push(array[j].unique());      
    }
    return charges;
}

//Función que carga las dependencias y cargos para que el usuario elija
function loadOrganigram(){

    var dependences = getDependences();
    var charges = getCharges();

    $('#modalOrganigram').modal('show');

    var template = '<nav class="navigation"><ul class="accordion">';
    for (let i = 0; i < dependences.length; i++) {

        template +=  '<li class="accordion__item">'
        +               '<a href="#" class="accordion__link">' + dependences[i]
        +                   '<div class="cntr">'
        +                       '<label for="dependenceCheck'+ i +'" class="label-cbx">'
        +                           '<input id="dependenceCheck'+ i +'" type="checkbox" class="invisible" onchange="checkedDependence(this)">'
        +                           '<div class="checkbox">'
        +                               '<svg width="20px" height="20px" viewBox="0 0 20 20">'
        +                                   '<path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>'
        +                                   '<polyline points="4 11 8 15 16 6"></polyline>'
        +                               '</svg>'
        +                           '</div>'
        +                       '</label>'
        +                   ' </div>'
        +               '</a>';

      /*  for (let j = 0; j < charges[i].length; j++) {

            template +='<li class="sub-accordion__item">'
                           + '<div>' + charges[i][j]
                            +   '<div class="cntrCharge" style="">'
                            +       '<label for="chargeCheck-'+ i+'-'+j +'" class="label-cbx">'
                            +           '<input id="chargeCheck-'+ i+'-'+j +'" type="checkbox" class="invisible countCharge'+i+'" onchange="checkedCharges(this)">'
                            +           '<div class="checkbox">'
                            +               '<svg width="20px" height="20px" viewBox="0 0 20 20">'
                            +                   '<path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>'
                            +                   '<polyline points="4 11 8 15 16 6"></polyline>'
                            +               '</svg>'
                            +           '</div>'
                            +       '</label>'
                            +   '</div>'
                            +'</div>'
                        +'</li>';

        }

        template += '</ul></li>';*/
    }
    template += '</ul></nav>';

    var list = document.getElementById("contentList");
    list.innerHTML = template;
    executeList();
}

// Función selecciona todos los cargos de la dependencia seleccionada
function checkedDependence(element){
   
    var regex = /(\d+)/g;
    var idDependence = element.id.match(regex)[0] ;        
    var arrayCheckbox = document.getElementsByClassName("countCharge"+idDependence);        
   
    for (let i = 0; i < arrayCheckbox.length; i++) {
        if(!element.checked){
            arrayCheckbox[i].checked=false;
        }else {
            arrayCheckbox[i].checked=true;     
        }           
    }
        
}

// Función que al seleccionar todos los cargos, se selecciona toda la dependencia
function checkedCharges(element){
   
    var number = 0;
    var idDependence = element.id.split("-")[1];
    var arrayCheckbox = document.getElementsByClassName("countCharge"+idDependence);  
    var checkDependence = document.getElementById("dependenceCheck"+idDependence);

    for (let i = 0; i < arrayCheckbox.length; i++) {
        if(arrayCheckbox[i].checked){
            number++;
        }else if((!arrayCheckbox[i].checked) && number>0){
            number--;
        }          
    }

    if(number==arrayCheckbox.length){
        checkDependence.checked = true;
    }else{
        checkDependence.checked = false;
    }

}

// Función que configura el archivo pdf para descargar el pdf
$(".download-pdf").click(function () {
    // Usamos el plugin que trae la biblioteca Basic Primitives para PDF
    var sample3 = primitives.pdf.orgdiagram.Plugin({
        //La plantilla que tendrá por defecto
        defaultTemplateName: "mainTemplatePrint",
        //Desactivamos los checkbox        
        hasSelectorCheckbox: primitives.common.Enabled.False,
        //Obtenemos los datos, la imagen tienen que estar en base64
        items:getDataBlob(),
        //También debe tener unas plantillas especiales para el PDF
        templates: [getMainTemplatePrint(), getDepartmentTitleTemplatePrint()],
        //Le decimos que no seleccione ningún item
        cursorItem: null,
        //La plantilla que se encarga de renderizar
        onItemRender: onTemplateRenderPrint,
    });
    
    var sample3size = sample3.getSize();
    //creamos el lienzo donde empezaremos a dibujar
    var doc = new PDFDocument({ size: [sample3size.width + 100, sample3size.height + 150] });
    var stream = doc.pipe(blobStream());
    
    doc.save();
    
    // De esta manera se escribe un titulo
    doc.fontSize(25)
        .text('Organigrama empresarial', 25, 25,{
            ellipsis: true,
            height: 10,
            align: 'center'
        });
    
    sample3.draw(doc, 50, 100);    
    doc.restore();
    
    //Termina el documento
    doc.end();
    
    //El nombre que tendrá el PDF
    var file = 'organigrama';
    if (typeof stream !== 'undefined') {
        stream.on('finish', function () {
            var string = stream.toBlob('application/pdf');
            window.saveAs(string, file + '.pdf');
        });
    } else {
        alert('Error: Failed to create file stream.');
    }
});

// Función que tiene la plantilla para exportar el pdf del organigrama
function onTemplateRenderPrint(doc,position, data) {
    
    // Esta es la plantilla que se encarga de dibujar todo el organigrama en el PDF
    var itemConfig = data.context;
    var contentSize = new primitives.common.Size(220, 30);

    contentSize.width -= 2;
    contentSize.height -= 2;

    // la plantilla de las dependencias
    if (data.templateName == "DepartmentTitleTemplate") {
        
        doc.save();

        // group title   
        doc.lineWidth(27)    
        doc.lineCap('round')
        .moveTo(position.x-2+position.width, position.y+15)
        .lineTo(position.x+5, position.y+15)
        .stroke(itemConfig.itemTitleColor)

        /* title */
        doc.fillColor('#ffffff')
            .font('Helvetica', 14)
            .text(itemConfig.title, position.x , position.y + 10, {
                ellipsis: true,
                width: (contentSize.width+10 ),
                height: 22,
                align: 'center'
            });
        doc.fillColor('#ffffff')
            .font('Helvetica', 14)
            .text(itemConfig.title, position.x , position.y + 10, {
                ellipsis: true,
                width: (contentSize.width+10 ),
                height: 22,
                align: 'center'
            });

        doc.restore();
    }

    // plantilla donde se cargan los datos de los empleados
    if (data.templateName == "mainTemplatePrint") {
        
        doc.save();

        /* item border */
        doc.roundedRect(position.x, position.y, position.width, position.height, 3)
            .lineWidth(1)
            .stroke('#555566');

        /* photo */
        if (itemConfig.image != null) {
            doc.image(itemConfig.image, position.x + 10, position.y + 25,{
                width: 55,
                height: 65
            });
        }
        
        // group title       

        doc.lineWidth(20)    
        doc.lineCap('round')
        .moveTo(position.x-17+position.width, position.y+16)
        .lineTo(position.x+15, position.y+16)
        .stroke(itemConfig.itemTitleColor)

        
        /* Nombre */
        doc.fillColor('#ffffff')
            .font('Helvetica', 12)
            .text(itemConfig.title, position.x + 5, position.y + 12, {
                ellipsis: true,
                width: (contentSize.width ),
                height: 16,
                align: 'center'
            });
        doc.fillColor('#ffffff')
            .font('Helvetica', 12)
            .text(itemConfig.title, position.x + 5, position.y + 12, {
                ellipsis: true,
                width: (contentSize.width ),
                height: 16,
                align: 'center'
            });

        /* Edad */
        doc.fillColor('black')
        .font('Helvetica', 10)
        .text("Edad: ", position.x + 73, position.y + 38, {
            ellipsis: true,
            width: (contentSize.width -70 ),
            height: 10,
            align: 'left'
        });

        doc.fillColor('black')
        .font('Helvetica', 10)
        .text("Edad: ", position.x + 73, position.y + 38, {
            ellipsis: true,
            width: (contentSize.width -70 ),
            height: 10,
            align: 'left'
        });
           
        doc.fillColor('black')
        .font('Helvetica', 10)
        .text(itemConfig.age, position.x + 135, position.y + 38, {
            ellipsis: true,
            width: (contentSize.width -70 ),
            height: 10,
            align: 'left'
        });   

       /* Antigüedad */
        doc.fillColor('black')
        .font('Helvetica', 10)
        .text("Antigüedad: ", position.x + 73, position.y + 51, {
            ellipsis: true,
            width: (contentSize.width -70 ),
            height: 10,
            align: 'left'
        });
        doc.fillColor('black')
        .font('Helvetica', 10)
        .text("Antigüedad: ", position.x + 73, position.y + 51, {
            ellipsis: true,
            width: (contentSize.width -70 ),
            height: 10,
            align: 'left'
        });

        doc.fillColor('black')
         .font('Helvetica', 10)
         .text(itemConfig.antiquity, position.x + 135, position.y + 51, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });

        
        /* Salario */
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Salario: ", position.x + 73, position.y + 64, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Salario: ", position.x + 73, position.y + 64, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text(itemConfig.salary, position.x + 135, position.y + 64, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });

        /* Contrato */
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Contrato: ", position.x + 73, position.y + 77, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Contrato: ", position.x + 73, position.y + 77, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });
        
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text(itemConfig.contract, position.x + 135, position.y + 77, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });
        
         /* Competencias */

         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Competencias del cargo", position.x + 15, position.y + 100, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });
         
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Competencias del cargo", position.x + 15, position.y + 100, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });
         
         /* Items competencias */
         var list = itemConfig.competences;
         var space = 15;
         for (let index = 0; index < 3; index++) {
             const element = list[index];
             
            doc.circle(position.x+20,  position.y + 104 + space, 2)
             .fill("#555566");

            doc.fillColor('black')
            .font('Helvetica', 10)
            .text( element, position.x + 30, position.y + 100 + space, {
                ellipsis: true,
                width: (contentSize.width -10 ),
                height: 20,
                align: 'left'
            });
            space+= 15;
        }
         
        doc.restore();
    }
    
}

// Configuración de la plantilla del item principal
function getMainTemplatePrint() {
    //Le damos toda la configuración a esta plantilla
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "mainTemplatePrint";
    result.itemTemplate = "Use onItemRener method.";
    result.itemSize = new primitives.common.Size(220, 200);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    return result;
}

// COnfiguración de la plantilla de las dependencias
function getDepartmentTitleTemplatePrint() {
    //Le damos toda la configuración a esta plantilla
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "DepartmentTitleTemplate";
    result.itemTemplate = "Use onItemRener method.";
    result.itemSize = new primitives.common.Size(220, 27);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    return result;
}

// Función que se encarga de la animación de la lista de dependencias y cargos
function executeList(){

    function slide(link) {
        
        var down = function (callback, time) {
            var subMenu = link.nextElementSibling;
            var height = subMenu.clientHeight; 
            var part = height / 100;      
            var paddingTop = parseInt(window.getComputedStyle(subMenu, null).getPropertyValue('padding-top'));
            var paddingBottom = parseInt(window.getComputedStyle(subMenu, null).getPropertyValue('padding-bottom'));
            var paddingTopPart = parseInt(paddingTop) / 50;
            var paddingBottomPart = parseInt(paddingBottom) / 30;
            
            (function innerFunc(i, t, b) {  
                subMenu.style.height = i + 'px';        
                i += part;        
                if(t < paddingTop) {        
                    t += paddingTopPart;
                    subMenu.style.paddingTop = t + 'px';
                    
                } else if(b < paddingBottom) {  
                    b += paddingBottomPart;
                    subMenu.style.paddingBottom = b + 'px';
                }
                
                if(i < height) {         
                    setTimeout(function() {              
                        innerFunc(i, t, b);              
                    }, time / 100);
                    
                } else {             
                    subMenu.removeAttribute('style');
                    callback();
                }          
            })(0, 0, 0);
        },
        
        up = function (callback, time) {
            
            var subMenu = link.nextElementSibling;
            var height = subMenu.clientHeight; 
            var part = subMenu.clientHeight / 100;
            var paddingTop = parseInt(window.getComputedStyle(subMenu).paddingTop);
            var paddingBottom = parseInt(window.getComputedStyle(subMenu).paddingBottom);
            var paddingTopPart = parseInt(paddingTop) / 30;
            var paddingBottomPart = parseInt(paddingBottom) / 50;
            
            (function innerFunc(i, t, b) {
                
                subMenu.style.height = i + 'px';        
                i -= part;
                i = i.toFixed(2);  
                if(b > 0) {  
                    
                    b -= paddingBottomPart;
                    b = b.toFixed(1);                
                    subMenu.style.paddingBottom = b + 'px'; 
                    
                } else if(t > 0) {
                    
                    t -= paddingTopPart;
                    t = t.toFixed(1); 
                    subMenu.style.paddingTop = t + 'px';
                }
                
                if(i > 0) { 
                    
                    setTimeout(function() {              
                        innerFunc(i, t, b);              
                    }, time / 100);
                    
                } else {
                    
                    subMenu.removeAttribute('style');
                    callback(); 
                }
                
            })(height, paddingTop, paddingBottom);
        }
        
        return {
            down: down,
            up: up
        }
    } 
    
    var accordion = (function() {
        
        var menu = document.querySelectorAll('.accordion');
        var activeClass = 'accordion__link_active';
        var arr = [];
        var timer = 100;

        for(let i = 0; i < menu.length; i++) {
            
            for(let p = 0; p < menu[i].children.length; p++) {
                
                var link = menu[i].children[p].firstElementChild;
                
                if(link.classList.contains(activeClass)) {
                    arr[i] = link;
                }
            }
        }
        
        function accordionInner(i) {
            
            var clicked = false;
            
            menu[i].addEventListener('click', function(e) {
                
                if(e.target.tagName === 'A' && !clicked) {
                    
                    clicked = true;
                    
                    if(e.target.classList.contains(activeClass)) {
                        
                        slide(e.target).up(function() {
                            
                            clicked = false;                
                            e.target.classList.remove(activeClass);                
                            // console.log('slide up of accordion ' + i + ' is done');
                            
                        }, timer);
                        
                    } else {
                        
                        if(arr.length > 0) {
                            
                            slide(arr[i-1]).up(function() {
                                
                                arr[i-1].classList.remove(activeClass);                  
                                arr[i-1] = e.target;                  
                                // console.log('slide up of accordion ' + i + ' is done');
                                
                            }, timer);
                        }
                        
                        e.target.classList.add(activeClass);
                        
                        slide(e.target).down(function() {
                            
                            clicked = false;                
                            arr[i-1] = e.target;                
                            //console.log('slide down of accordion ' + i + ' is done');
                            
                        }, timer);
                    }
                }
            });
            
            i++;
            
            if(i < menu.length) { accordionInner(i); }
            
        } accordionInner(0);
    })();
}