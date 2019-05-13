
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
    //getData retorna un arreglo de objetos 
    options.items = getData();
    //Indicamos que plantillas usará la configuración
    options.templates = [getItemTemplate(options.items),getDepartmentTitleTemplate()];
    //por defecto le asignamos esta plantilla, ya que es la más usada para esta configuración
    options.defaultTemplateName = "ItemTemplate";
    //El item que queremos que al cargar la página este desplegado
    options.cursorItem = 0;
    //Enviamos el contenido
    jQuery("#basicdiagram").orgDiagram(options);
});

var contador = 0;


function getItemTemplate(items) {

    // Configuramos la plantilla, como tamaño, nombre, padding
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "ItemTemplate";
    result.itemSize = new primitives.common.Size(205, 250);
    result.minimizedItemSize = new primitives.common.Size(10, 10);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    
    //Esta plantilla nos mostrará un item con más datos, y un botón que permite ver más información del item

    //El arreglo de competencias lo convertimos en una lista
    var list = items[1]['competences'];
    var code = "";
    if (contador==0) {
        
        code = "<ul>";
        for (let index = 0; index < list.length; index++) {
            code= code + "<li style='text-align:justify'>" +   list[index] + "</li>";               
        }
        code = code + "</ul>";       
        contador=1; 
    }


    document.getElementById("list").innerHTML = code;

    var itemTemplate = jQuery(
        '<div>'
        + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 5px; left: 6px; width: 187px; height: 20px;">'
            + '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 180px; height: 18px; color:white;"></div>'
        + '</div>'
        + '<div class="bp-item bp-photo-frame" style="top: 31px; left: 6px; width: 50px; height: 60px;">'
                + '<img name="photo" style="height: 60px; width:50px; border-style: solid; border-width: 1px; border-color: #232323;" />'
        + '</div>'
        + '<div class="bp-item" style="top: 31px; left: 65px; width: 116px; height: 22px; font-size: 11px; display:flex; flex-direction: column" >'
        + '<div  style="flex:1;"><b>Edad:</b></div>'
        + '<div name="age" class="bp-item" style="flex:1; left: 65px;"></div>'
        + '</div>'
        + '<div class="bp-item" style="top: 47px; left: 65px; width: 116px; height: 22px; font-size: 11px; display:flex; flex-direction: column" >'
        + '<div  style="flex:1;"><b>Antigüedad:</b></div>'
        + '<div name="antiquity" class="bp-item" style="flex:1; left: 65px;"></div>'
        + '</div>'
        + '<div class="bp-item" style="top: 63px; left: 65px; width: 116px; height: 22px; font-size: 11px; display:flex; flex-direction: column" >'
        + '<div  style="flex:1;"><b>Salario:</b></div>'
        + '<div name="salary" class="bp-item" style="flex:1; left: 65px;"></div>'
        + '</div>'
        + '<div class="bp-item" style="top: 79px; left: 65px; width: 116px; height: 22px; font-size: 11px; display:flex; flex-direction: column" >'
        + '<div  style="flex:1;"><b>Contrato:</b></div>'
        + '<div name="contract" class="bp-item" style="flex:1; left: 65px;"></div>'
        + '</div>'
        // + '<div name="antiquity" class="bp-item" style="top: 47px; left: 65px; width: 116px; height: 22px; font-size: 11px;"></div>'
        // + '<div name="salary" class="bp-item" style="top: 63px; left: 65px; width: 116px; height: 22px; font-size: 11px;"></div>'
        // + '<div name="contract" class="bp-item" style="top: 79px; left: 65px; width: 116px; height: 22px; font-size: 11px;"></div>'
        + '<div class="bp-item" style="top: 105px; left: 8px; width: 216px; height: 20px; font-weight:bold; font-size: 11px;">Competencias del cargo</div>'
        + '<div name="nose" class="felipe bp-item" style="top: 127px; left: -19px; width: 210px; height: 78px; font-size: 11px;">'+code+'</div>'
        + '<div class="btn-group btn-group-vertical" style="width:80px; height:20px; position:absolute; left:113px; top:205px; ">'
        + '<button name="btnSeeMore" class="btn btn-primary " style="padding:0px; height:23px; color: white; font-family: "Roboto", sans-serif; font-size:13px " data-buttonname="info" data-toggle="modal" data-target="#user" type="button">Ver más</button>'
        +'</div>'
    +'</div >').css({
    width: (result.itemSize.width+10) + "px",
    height: (result.itemSize.height+10) + "px",
    }).addClass("bp-item bp-corner-all bt-item-frame");    

    result.itemTemplate = itemTemplate.wrap('<div>').parent().html();
    return result;
}

function onMouseClick(event, data) {
    
    //En esta función definimos los eventos que harán los botones
    var target = jQuery(event.originalEvent.target);

    if (target.hasClass("btn") || target.parent(".btn").length > 0) {

        var button = target.hasClass("btn") ? target : target.parent(".btn");

        var buttonname = button.data("buttonname");        
        
        //Si el boton es info, se mostrará un modal con más información del item
        if (buttonname=="info") {
            
            document.querySelector('#photo').src=innerHTML=data.context.image;
            document.getElementById("nominaLabel").innerHTML=data.context.title;
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
            var code = "<ul>";
            
            for (let index = 0; index < list.length; index++) {
                code= code + "<li>" +   list[index] + "</li>";               
            }
            code = code + "</ul>";

            document.getElementById("list").innerHTML = code;
        }
        data.cancel = true;
    }
}


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
    
    // Si la plantilla es Itemplate, es decir la encargada de mostrar algunos datos de los empleados
    if (data.templateName == "ItemTemplate") {

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
                    element.text(itemConfig['antiquity']);
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
                    
                    if (contador==1) {           
                       
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
        //Esta es la plantilla que nos muestra las dependencias de la empresa
    } else if (data.templateName == "DepartmentTitleTemplate") {
        data.element.find("[name=titleBackground]").css({ "background": itemConfig.itemTitleColor });
        
        var fields = ["title"];
        for (var index = 0; index < fields.length; index++) {
            var field = fields[index];
            
            var element = data.element.find("[name=" + field + "]");
            if (element.text() != itemConfig[field]) {
                element.text(itemConfig[field]);
            }
        }
    }
}

function getDepartmentTitleTemplate() {
    //Esta plantilla es la encargada de mostrar una dependencia de la empresa 
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "DepartmentTitleTemplate";
    result.isActive = true;   
    result.itemSize = new primitives.common.Size(200, 30);
    result.minimizedItemSize = new primitives.common.Size(10, 10);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    result.hasSelectorCheckbox = primitives.common.Enabled.False;

    var itemTemplate = jQuery(
      '<div class="bp-item bp-corner-all bt-item-frame">'
        + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 196px; height: 25px;">'
            + '<div name="title" class="bp-item bp-title" style="top: 3px; left: 6px; width: 188px; height: 23px; text-align:center;">'
            + '</div>'
        + '</div>'
    + '</div>'
    ).css({
        width: result.itemSize.width + "px",
        height: result.itemSize.height + "px"
    }).addClass("bp-item");

    result.itemTemplate = itemTemplate.wrap('<div>').parent().html();
    
    return result;
}


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
    var file = 'demo';
    if (typeof stream !== 'undefined') {
        stream.on('finish', function () {
            var string = stream.toBlob('application/pdf');
            window.saveAs(string, file + '.pdf');
        });
    } else {
        alert('Error: Failed to create file stream.');
    }
});

function onTemplateRenderPrint(doc,position, data) {
    
    // Esta es la plantilla que se encarga de dibujar todo el organigrama en el PDF
    var itemConfig = data.context;
    var contentSize = new primitives.common.Size(220, 30);

    contentSize.width -= 2;
    contentSize.height -= 2;

    // la plantilla de las dependencias
    if (data.templateName == "DepartmentTitleTemplate") {
        

        doc.save();

        //Con borde alrededor
        /* item border */
        // doc.roundedRect(position.x, position.y+1, position.width, 29, 3)
        // 	.lineWidth(1)
        //     .stroke('#555555');

        // // group title   
        // doc.lineWidth(20)    
        // doc.lineCap('round')
        // .moveTo(position.x-17+position.width, position.y+15)
        // .lineTo(position.x+15, position.y+15)
        // .stroke(itemConfig.itemTitleColor)

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
        .text(itemConfig.age, position.x + 130, position.y + 38, {
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
         .text(itemConfig.antiquity, position.x + 130, position.y + 51, {
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
         .text(itemConfig.salary, position.x + 130, position.y + 64, {
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
         .text(itemConfig.contract, position.x + 130, position.y + 77, {
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

function getMainTemplatePrint() {
    //Le damos toda la configuración a esta plantilla
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "mainTemplatePrint";
    result.itemTemplate = "Use onItemRener method.";
    result.itemSize = new primitives.common.Size(220, 200);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    return result;
}

function getDepartmentTitleTemplatePrint() {
    //Le damos toda la configuración a esta plantilla
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "DepartmentTitleTemplate";
    result.itemTemplate = "Use onItemRener method.";
    result.itemSize = new primitives.common.Size(220, 27);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    return result;
}

// Le asignamos al boton de búsqueda una función de click
$("#btn-search").click(function (data) {
    // Traemos los datos que se encuentran en el diagrama
    var items = jQuery("#basicdiagram").orgDiagram("option", "items");   
    
    // Encuentra el item 16 y lo despliega
    jQuery("#basicdiagram").orgDiagram({
       items: items,
       cursorItem: items[16].id
    });

    // Actualizamos el diagrama
    jQuery("#orgdiagram").orgDiagram("update", primitives.common.UpdateMode.Refresh);
});




