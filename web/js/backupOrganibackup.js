jQuery(document).ready(function () {
    var options = new primitives.orgdiagram.Config();
    options.hasSelectorCheckbox = primitives.common.Enabled.False;
    options.hasButtons = primitives.common.Enabled.False;
    options.onMouseClick = onMouseClick;
    options.onItemRender = onTemplateRender;
    options.defaultTemplateName = "ButtonTemplate";
    options.selectedItems = [3];
    options.items = getData();
    options.templates = [getButtonTemplate(options.items),getDepartmentTitleTemplate()];
    options.cursorItem = 0;

    jQuery("#basicdiagram").orgDiagram(options);

});


var contador = 0;

function getButtonTemplate(items) {
    var result = new primitives.orgdiagram.TemplateConfig();
    result.name = "ButtonTemplate";

    result.itemSize = new primitives.common.Size(240, 255);
    result.minimizedItemSize = new primitives.common.Size(10, 10);
    result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
    result.cursorPadding = new primitives.common.Thickness(3, 3, 60, 8);

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
        '<div >'
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
        + '<div class="bp-item" style="top: 105px; left: 6px; width: 216px; height: 22px; font-weight:bold; font-size: 12px;">Competencias del cargo</div>'
        + '<div name="nose" class="felipe bp-item" style="top: 130px; left: -19px; width: 210px; height: 78px; font-size: 11px;">'+code+'</div>'
        + '<button name="btnSeeMore" class="btn btn-primary " style="padding:0px; height:23px; color: white; font-family: "Roboto", sans-serif; font-size:13px " data-buttonname="info" data-toggle="modal" data-target="#user" type="button">Ver más</button>'
       +'</div >')
    .css({
        position: "absolute",
        overflow: "hidden",
        width: (result.itemSize.width + result.cursorPadding.left + result.cursorPadding.right) + "px",
        height: (result.itemSize.height + result.cursorPadding.top + result.cursorPadding.bottom) + "px"
    }).addClass("bp-item bp-corner-all bt-item-frame");

    var cursorBorder = jQuery("<div></div>")
    .css({
        width: (result.itemSize.width + result.cursorPadding.left + 1) + "px",
        height: (result.itemSize.height + result.cursorPadding.top + 1) + "px"
    }).addClass("bp-item bp-corner-all bp-cursor-frame");
    itemTemplate.append(cursorBorder);

    var bootStrapVerticalButtonsGroup = jQuery("<div></div>")
    .css({
        position: "absolute",
        overflow: "hidden",
        top: result.cursorPadding.top + "px",
        left: (result.itemSize.width + result.cursorPadding.left + 10) + "px",
        width: "35px",
        height: (result.itemSize.height + 1) + "px"
    }).addClass("btn-group btn-group-vertical");

    bootStrapVerticalButtonsGroup.append('<button class="btn btn-primary btn-small" style="margin-left:-19px; margin-top:-8px; color: white; font-size:110%;" data-buttonname="info" data-toggle="modal" data-target="#user" type="button"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-primary btn-small" style="margin-left:-19px; margin-top:-8px; color: white; font-size:110%;" data-buttonname="edit" type="button"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-primary btn-small" style="margin-left:-19px; margin-top:-8px; color: white; font-size:110%;" data-buttonname="add" type="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>');
    bootStrapVerticalButtonsGroup.append('<button class="btn btn-primary btn-small" style="margin-left:-19px; margin-top:-8px; color: white; font-size:110%;" data-buttonname="remove" type="button"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>');
    // bootStrapVerticalButtonsGroup.append('<button class="btn btn-small" data-buttonname="remove" type="button"><i class="icon-remove"></i></button>');
    
    itemTemplate.append(bootStrapVerticalButtonsGroup);

    result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

    console.log(result);

    return result;
}


function onMouseClick(event, data) {

    var target = jQuery(event.originalEvent.target);

    if (target.hasClass("btn") || target.parent(".btn").length > 0) {

        var button = target.hasClass("btn") ? target : target.parent(".btn");

        var buttonname = button.data("buttonname");        
        
        if (buttonname=="info") {

            var image= document.querySelector('#photo');
            image.src=innerHTML=data.context.image;
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
            console.log("edit");
        }
        if (buttonname=="add") {
            console.log("edit");    
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
    }else if (data.templateName == "ButtonTemplate") {

        //Dependiendo de la plantilla que tenga definida el item, serán cargados ciertos datos
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


$(".download-pdf").click(function () {
    // create a document and pipe to a blob
    var sample3 = primitives.pdf.orgdiagram.Plugin({
        hasButtons: primitives.common.Enabled.False,
        /* onMouseClick: onMouseClick, */
        onItemRender: onTemplateRender,
        
        templates: [getCursorTemplate(),getDepartmentTitleTemplate()],
        defaultTemplateName: "CursorTemplate",
       
       
        hasSelectorCheckbox: primitives.common.Enabled.False,
        items:[
            new primitives.orgdiagram.ItemConfig({
                id: 0,
                parent: null,
                hasSelectorCheckbox: false,
                title: "Presidencia",
                itemTitleColor: "#555555",           
                templateName: "DepartmentTitleTemplate",
                itemTitleColor: "#559E4A" 
            }),
            
            new primitives.orgdiagram.ItemConfig({ 
                id: 1, 
                parent: 0, 
                hasSelectorCheckbox: false,
                title: "Fritz Stüger",
                description: "VP, Human Resources",
                image: photos.b,
                groupTitle: "Institucional",
                templateName: "CursorTemplate",
                groupTitleColor: "#559E4A",
                itemTitleColor: "#559E4A",            
                     
            }),
            //Para crear un item principal
            new primitives.orgdiagram.ItemConfig({ 
                id: 2, 
                parent: 1, 
                hasSelectorCheckbox: true,
                templateName: "DepartmentTitleTemplate", 
                title: "Gerencia", 
                itemTitleColor: "#F94141",
                
            }),
            new primitives.orgdiagram.ItemConfig({ 
                id: 6, 
                parent: 2, 
                isVisible: true, 
                description: "GM, Core Operating System Test", 
                email: "vadaduho@name.com", 
                groupTitleColor: "#F94141", 
                image: photos.b, 
                itemTitleColor: "#F94141", 
                phone: "303-333-9215", 
                title: "Vada Duhon", 
                groupTitle: "Presidente", 
                contract: "Indefinido",
                antiquity: 15,
                salary: 1500000,          
                address: "Calle 3 # 12- 34",
                age: 54,
                civilStatus: "soltero",
                workingStatus: "Vacaciones",
                dateStart: "Junio 22 2018 ",
                dateEnd: "Julio 9 2018" , 
                competences: ["Conocimientos en excel","Lectura y escritura en inglés","Actitud de lider"], 
                
            }),
                   
            new primitives.orgdiagram.ItemConfig({
                id: 7,
                parent: 2,
                title: "Ted Whitt 2",
                description: "VP, Human Resources",
                image: photos.h,
                itemTitleColor: "#F94141",
                groupTitle: "Mecánico",
                groupTitleColor: "#F94141",            
                email: "vadaduho@name.com", 
                phone: "303-333-9215",
                contract: "Indefinido",
                antiquity: 15,
                salary: 1500000,          
                address: "Calle 3 # 12- 34",
                age: 54,
                civilStatus: "soltero",
                workingStatus: "Vacaciones",
                dateStart: "Junio 22 2018 ",
                dateEnd: "Julio 9 2018" ,  
                competences: ["Conocimientos en excel","Lectura y escritura en inglés"], 
            }),
            new primitives.orgdiagram.ItemConfig({
                id: 8,
                parent: 3,
                title: "Ted Whitt 2",
                description: "VP, Human Resources",
                image: photos.b,
                itemTitleColor: "#3B5FD1",
                groupTitle: "Mecánico",
                groupTitleColor: "#3B5FD1",            
                email: "vadaduho@name.com", 
                phone: "303-333-9215", 
                contract: "Indefinido",
                antiquity: 15,
                salary: 1500000,          
                address: "Calle 3 # 12- 34",
                age: 54,
                civilStatus: "soltero",
                workingStatus: "Vacaciones",
                dateStart: "Junio 22 2018 ",
                dateEnd: "Julio 9 2018" , 
                competences: ["Conocimientos en excel","Lectura y escritura en inglés"], 
            }),
           
            new primitives.orgdiagram.ItemConfig({ 
                id: 9, 
                parent: 8, 
                isVisible: true, 
                description: "VP & CFO, NAME", 
                email: "barblang@name.com", 
                groupTitleColor: "#3B5FD1", 
                image: photos.o, 
                itemTitleColor: "#3B5FD1", 
                phone: "618-822-7345", 
                title: "Barbara Lang" ,
                groupTitle: "Presidente", 
                contract: "Indefinido",
                antiquity: 15,
                salary: 1500000,          
                address: "Calle 3 # 12- 34",
                age: 54,
                civilStatus: "soltero",
                workingStatus: "Vacaciones",
                dateStart: "Junio 22 2018 ",
                dateEnd: "Julio 9 2018" , 
                competences: ["Facilidad para hablar","Lectura y escritura en inglés"], 
            }),
    
            new primitives.orgdiagram.ItemConfig({ 
                id: 10, 
                parent: 8, 
                isVisible: true, 
                description: "VP, NAME Operations", 
                email: "barbfaul@name.com", 
                groupTitleColor: "#3B5FD1", 
                image: photos.d, 
                itemTitleColor: "#3B5FD1", 
                phone: "641-678-7646", 
                title: "Barbara Faulk" , 
                groupTitle: "Presidente",
                contract: "Indefinido",
                antiquity: 15,
                salary: 1500000,          
                address: "Calle 3 # 12- 34",
                age: 54,
                civilStatus: "soltero",
                workingStatus: "Vacaciones",
                dateStart: "Junio 22 2018 ",
                dateEnd: "Julio 9 2018" , 
                competences: ["Altos conocimientos en datos financieros","Lectura y escritura en inglés"],   
            }),
    
        ],
        cursorItem: null,
        hasSelectorCheckbox: primitives.common.Enabled.False
    });
    
    var sample3size = sample3.getSize();
    
    var doc = new PDFDocument({ size: [sample3size.width + 100, sample3size.height + 150] });
    var stream = doc.pipe(blobStream());
    
    doc.save();
    
    // draw some text
    doc.fontSize(25)
        .text('Autosized page containing Organizational Chart ...', 25, 25);
    
    sample3.draw(doc, 50, 100);
    
    doc.restore();
    
    doc.end();
    
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

