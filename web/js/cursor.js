jQuery(document).ready(function () {
    //Configuramos el diagrama
    var options = new primitives.orgdiagram.Config();
     //Deshabilitamos un checkbox que viene por defecto en la plantilla
    options.hasSelectorCheckbox = primitives.common.Enabled.False;
    //Deshabilitamos los botones
    options.hasButtons = primitives.common.Enabled.False;
    //Añadimos una función de click
    options.onMouseClick = onMouseClick;
     //llamamos la función que se encarga de renderizar y mostrar los datos en la plantilla
    options.onItemRender = onTemplateRender;
    //por defecto le asignamos esta plantilla, ya que es la más usada para esta configuración
    options.defaultTemplateName = "CursorTemplate";
    //getData retorna un arreglo de objetos 
    options.items = getData();
    //Indicamos que plantillas usará la configuración
    options.templates = [getCursorTemplate(),getDepartmentTitleTemplate()];
    //El item que queremos que al cargar la página este desplegado
    options.cursorItem = 0;

    jQuery("#basicdiagram").orgDiagram(options);
});

var countCompetence = 0;
var countDependence = 0;

$(function() {
    $( "#sortable-1" ).sortable();
 });
 
function getCursorTemplate() {

    //Configuramos la plantilla 
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "CursorTemplate";
    result.itemSize = new primitives.common.Size(205, 218);
    result.minimizedItemSize = new primitives.common.Size(10, 10);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    result.cursorPadding = new primitives.common.Thickness(3, 3, 50, 8);

    //Esta plantilla nos permite que los itemes del organigrama tengan el panel de botones
    var cursorTemplate = jQuery("<div id='algo'></div>")
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
    }).addClass("bp-item bp-corner-all bp-cursor-frame colorW");
    cursorTemplate.append(cursorBorder);

    var bootStrapVerticalButtonsGroup = jQuery("<div></div>")
    .css({
        position: "absolute",
        overflow: "hidden",
        top: result.cursorPadding.top + "px",
        left: (result.itemSize.width + result.cursorPadding.left + 10) + "px",
        width: "35px",
        height: (result.itemSize.height + 1) + "px"
    }).addClass("btn-group btn-group-vertical");

    //Creamos los botones y les damo un nombre a cada uno
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-success btn-small" style="margin-left:-19px; margin-top:2px; color: white; font-size:15px;" data-buttonname="info" data-toggle="modal" data-target="#user" type="button"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-success btn-small" style="margin-left:-19px; margin-top:2px; color: white; font-size:15px;" data-buttonname="edit" data-toggle="modal" data-target="#edit" type="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-success btn-small" style="margin-left:-19px; margin-top:2px; color: white; font-size:15px;" data-buttonname="add" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-success btn-small" style="margin-left:-19px; margin-top:2px; color: white; font-size:15px;" data-buttonname="remove" type="button"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>');
    // bootStrapVerticalButtonsGroup.append('<button class="btn btn-small" data-buttonname="remove" type="button"><i class="icon-remove"></i></button>');
    
    cursorTemplate.append(bootStrapVerticalButtonsGroup);

    result.cursorTemplate = cursorTemplate.wrap('<div>').parent().html();

    return result;
}


function onMouseClick(event, data) {
    
    var target = jQuery(event.originalEvent.target);
    
    if (target.hasClass("btn") || target.parent(".btn").length > 0) {
        
        var button = target.hasClass("btn") ? target : target.parent(".btn");
        
        var buttonname = button.data("buttonname");        
        
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
            
            var list = data.context.competences;
            var code = "<ul>";

            for (let index = 0; index < list.length; index++) {
                code= code + "<li>" +   list[index] + "</li>";               
            }
            code = code + "</ul>";
            
            document.getElementById("list").innerHTML = code;
            
        }
        
        if (buttonname=="edit") {
            
            document.querySelector('#imageEdit').src=innerHTML=data.context.image;
            document.getElementById("name").value=data.context.title;
            document.getElementById("charge1").value=data.context.groupTitle;  
            document.getElementById("contract1").value=data.context.contract;            
            document.getElementById("salary1").value= "$" + data.context.salary;
            document.getElementById("number1").value=data.context.phone;
            document.getElementById("address1").value=data.context.address;
            document.getElementById("age1").value=data.context.age;
            document.getElementById("working-status1").value=data.context.workingStatus;
            document.getElementById("date-start1").value=data.context.dateStart;
            document.getElementById("date-end1").value=data.context.dateEnd;
            document.getElementById("antiquity1").value=data.context.antiquity;

            var divCompetences = document.getElementById('sortable-1');
            var competences =  data.context.competences;
            for (let index = 0; index < competences.length; index++) {                
                
                var templateCompetence = '<li  class="list-group-item column" id="item'+countCompetence+'">'
                +'<div class="row">'
                +   '<div class="col-md-9">'
                +       '<div class="form-group">'
                +           '<input type="text" class="form-control" value="'+competences[index]+'">'
                +       '</div>'
                +   '</div>'
                +   '<div class="col-md-1 iconEdit">'
                +       '<button class="btn btn-success btn-small buttonEdit" type="button" onclick=deleteItem("item'+countCompetence+'")>'
                +           '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
                +       '</button>'
                +   '</div>'
                +'</div>'
                +'</li>';
                divCompetences.innerHTML=divCompetences.innerHTML+templateCompetence;
                countCompetence++;
            }
            
            var divDependences = document.getElementById('listDependences', 'DepartmentTitleTemplate');
            var arrayDependences = getValueOrganigram('templateName','DepartmentTitleTemplate', 'title');
            var templateSelect = '';            
            var count = 0;

            for (let index = 0; index < arrayDependences.length; index++) {                
                var templateDependence = '<li id="depedence'+countDependence+'">'
                +'<div class="row">'
                +   '<div class="col-md-5">'
                +       '<div class="form-group">'
                +           '<input type="text" class="form-control" value="'+arrayDependences[index]+'">'
                +       '</div>'
                +   '</div>'
                +   '<div class="col-md-4">'
                +       '<div class="form-group label-floating">'
                +           '<label class="control-label " for="">Pertenece a</label>'
                +           '<select class="form-control" id=select'+countDependence+' >'
                +               '<option>Selecciona una dependencia</option>';

                for (let index1 = 0; index1 < arrayDependences.length; index1++) {
                    const element = arrayDependences[index1];
                    templateSelect += '<option id="dependence'+element+count+'">'+ element+'</option>';
                }
                templateDependence += templateSelect
                +           '</select>'
                +       '</div>'
                +   '</div>'
                +   '<div class="col-md-1 iconEdit">'
                +       '<button class="btn btn-success btn-small buttonEdit" type="button" onclick=deleteItem("dependence'+countDependence+'")>'
                +           '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
                +       '</button>'
                +   '</div>'
                +'</div>'
                +'</li>';                
                
                divDependences.innerHTML=divDependences.innerHTML+templateDependence;
                countDependence++;
                count++;
                templateSelect = "";
            }
            
            for (let i = 0; i < arrayDependences.length; i++) {

                var select = document.getElementById("select"+i);

                for (let j = 0; j < arrayDependences.length; j++) {                                        
                    
                    var idParent = getValueOrganigram('title',arrayDependences[j],'parent');              
                    
                    if (idParent==null) {                    
                        document.getElementById("dependencePresidencia").selected = "true";
                    }else{
                        var titleParent =  searchParentDependence(idParent);   
                        document.getElementById("dependence"+titleParent+j).selected = "true";
                    }
                    
                }
            }
        }
        if (buttonname=="add") {
             
        }
        if (buttonname=="remove") {
            var items = jQuery("#basicdiagram").orgDiagram("option", "items");
            var newItems = [];
            /* collect all children of deleted items, we are going to delete them as well. */
            var itemsToBeDeleted = getSubItemsForParent(items, /*context: primitives.orgdiagram.ItemConfig*/data.context);
            /* add deleted item to that collection*/
            itemsToBeDeleted[data.context.id] = true;

            /* copy to newItems collection only remaining items */
            for (var index = 0, len = items.length; index < len; index += 1) {
                var item = items[index];
                if (!itemsToBeDeleted.hasOwnProperty(item.id)) {
                    newItems.push(item);
                }
            }
            /* update items list in chart */
            jQuery("#basicdiagram").orgDiagram({
                items: newItems,
                cursorItem: data.parentItem.id
            });
            jQuery("#basicdiagram").orgDiagram("update", /*Refresh: use fast refresh to update chart*/ primitives.orgdiagram.UpdateMode.Refresh);
        }

        data.cancel = true;
        
        
    }
}

function getSubItemsForParent(items, parentItem) {
    var children = {},
        itemsById = {},
        index, len, item;
    for (index = 0, len = items.length; index < len; index += 1) {
        var item = items[index];
        if (children[item.parent] == null) {
            children[item.parent] = [];
        }
        children[item.parent].push(item);
    }
    var newChildren = children[parentItem.id];
    var result = {};
    if (newChildren != null) {
        while (newChildren.length > 0) {
            var tempChildren = [];
            for (var index = 0; index < newChildren.length; index++) {
                var item = newChildren[index];
                result[item.id] = item;
                if (children[item.id] != null) {
                    tempChildren = tempChildren.concat(children[item.id]);
                }
            }
            newChildren = tempChildren;
        }
    }
    return result;
};

function searchParentDependence(idParent){
    var items = jQuery("#basicdiagram").orgDiagram("option", "items");
    var titleDependence = "";
    var cond = true;
    while (cond) {
        
        for (let index = 0; index < items.length; index++) {
          
            if(items[index]['templateName']=="DepartmentTitleTemplate" ) {
               if (items[index]['id']==idParent) {
                    titleDependence = items[index]['title'];
                    console.log("Entro al condicinal "+ titleDependence);           
                    return titleDependence;  
                    cond = false;             
               }
            }else if(items[index]['id']==idParent){
               idParent=items[index]['parent'];
               
            }   
        }
    }   
}

function getValueOrganigram(field,comparator,add){
    var items = jQuery("#basicdiagram").orgDiagram("option", "items");
    var arrayDependences = [];

    for (let index = 0; index < items.length; index++) {
        const element = items[index];
        if(element[field]==comparator){
            arrayDependences.push(element[add]);
        }
        
    }

    return arrayDependences;
}
function resetCount(){
    countCompetence = 0;
    countDependence = 0;
    document.getElementById('sortable-1').innerHTML="";
    document.getElementById('listDependences').innerHTML="";
    

}


function addItem(){
    
 
    var divCompetences = document.getElementById('sortable-1');
    var templateCompetence = '<li  class="list-group-item column" id="item'+countCompetence+'">'
            +'<div class="row">'
            +   '<div class="col-md-9">'
            +       '<div class="form-group">'
            +           '<input type="text" class="form-control" placeholder="Ingresa una nueva competencia" value="&nbsp;">'
            +       '</div>'
            +   '</div>'
            +   '<div class="col-md-1 iconEdit">'
            +       '<button class="btn btn-success btn-small buttonEdit" type="button" onclick=deleteItem("item'+countCompetence+'")>'
            +           '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
            +       '</button>'
            +   '</div>'
            +'</div>'
            +'</li>';
            divCompetences.innerHTML=divCompetences.innerHTML+templateCompetence;
    
           
    countCompetence++;
}

function deleteItem(id){
    
    $("#"+id).remove();

    console.log("antes"+document.getElementById('sortable-1').innerHTML+"despues");
    if (document.getElementById('sortable-1').innerHTML=="") {
        console.log("Entro al condicional");
        countCompetence = 0;
        var divCompetences = document.getElementById('sortable-1');
        var templateCompetence = '<li  class="list-group-item column" id="item'+countCompetence+'">'
                +'<div class="row">'
                +   '<div class="col-md-9">'
                +       '<div class="form-group">'
                +           '<input type="text" class="form-control" placeholder="Ingresa una nueva competencia">'
                +       '</div>'
                +   '</div>'
                +   '<div class="col-md-1 iconEdit">'
                +       '<button class="btn btn-success btn-small buttonEdit" type="button" onclick=deleteItem("item'+countCompetence+'")>'
                +           '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
                +       '</button>'
                +   '</div>'
                +'</div>'
                +'</li>';
                divCompetences.innerHTML=divCompetences.innerHTML+templateCompetence;
        countCompetence++;
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

        var itemConfig = data.context;
        
        if (data.templateName == "DepartmentTitleTemplate") {
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
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "DepartmentTitleTemplate";
    result.isActive = true;
    result.selectedItems = [1];

    
    result.itemSize = new primitives.common.Size(200, 30);
    result.minimizedItemSize = new primitives.common.Size(10, 10);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    
    
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


$("#btn-search").click(function () {
    // Recibimos los items que actualmente tenga el diagrama
   var items = jQuery("#basicdiagram").orgDiagram("option", "items");   
     
   //Se selecciona el item con id 16
      jQuery("#basicdiagram").orgDiagram({
          items: items,
          cursorItem: 16
      });

    // Actualizamos el diagrama
    jQuery("#orgdiagram").orgDiagram("update", primitives.common.UpdateMode.Refresh);
});

function actualiza (){
    // Recibimos los items que actualmente tenga el diagrama
   var items = jQuery("#basicdiagram").orgDiagram("option", "items");
   //    Creamos los nuevos items
      var newItem =new primitives.orgdiagram.ItemConfig({
       id: 22,
       parent: 0,
       hasSelectorCheckbox: false,
       title: "Pueba",                       
       templateName: "DepartmentTitleTemplate",
       itemTitleColor: "#559E4A" 
      });
      var newOtherItem = new primitives.orgdiagram.ItemConfig({ 
       id: 23, 
       parent: 22, 
       isVisible: true, 
       description: "VP, NAME Global Sales & Marketing", 
       groupTitleColor: "#559E4A", 
       image: "./img/photos/z.png", 
       itemTitleColor: "#559E4A", 
       title: "Stewart Williams" , 
       groupTitle: "Presidente", 
       email: "robelemi@name.com",
       phone: "425-590-4308",
       contract: "Indefinido",
       antiquity: 10,
       salary: 1500000,          
       address: "Calle 3 # 12- 34",
       age: 41,
       civilStatus: "soltero",
       workingStatus: "Vacaciones",
       dateStart: "Junio 22 2018 ",
       dateEnd: "Julio 9 2018" ,
       competences: ["Facilidad para hablar","Lectura y escritura en inglés"], 
   })
   
   // Agrega los nuevos item al arreglo
      items.push(newItem);
      items.push(newOtherItem);
   
   // Cuando se actualiza queda seleccionado el item 
      jQuery("#basicdiagram").orgDiagram({
          items: items,
          cursorItem: newOtherItem.id
      });

    // Actualizamos el diagrama
    jQuery("#orgdiagram").orgDiagram("update", primitives.common.UpdateMode.Refresh);
}