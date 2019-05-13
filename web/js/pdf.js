$(".download-pdf").click(function () {
    // create a document and pipe to a blob
    var sample3 = primitives.pdf.orgdiagram.Plugin({
        hasButtons: primitives.common.Enabled.False,
        /* onMouseClick: onMouseClick, */
        defaultTemplateName: "mainTemplatePrint",       
        hasSelectorCheckbox: primitives.common.Enabled.False,
        items:getDataBlob(),
        templates: [getMainTemplatePrint(), getDepartmentTitleTemplatePrint()],
        cursorItem: null,
        hasSelectorCheckbox: primitives.common.Enabled.False,
        onItemRender: onTemplateRenderPrint,
    });
    
    var sample3size = sample3.getSize();
    
    var doc = new PDFDocument({ size: [sample3size.width + 100, sample3size.height + 150] });
    var stream = doc.pipe(blobStream());
    
    doc.save();
    
    // draw some text
    doc.fontSize(25)
        .text('Organigrama empresarial', 25, 25,{
            ellipsis: true,
            height: 10,
            align: 'center'
        });
    
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


function onTemplateRenderPrint(doc,position, data) {
    
    var itemConfig = data.context;
    var contentSize = new primitives.common.Size(220, 30);

    contentSize.width -= 2;
    contentSize.height -= 2;
    if (data.templateName == "DepartmentTitleTemplatePrint") {
		

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
			.font('Helvetica', 12)
			.text(itemConfig.title, position.x , position.y + 10, {
				ellipsis: true,
				width: (contentSize.width ),
				height: 16,
				align: 'center'
			});

        doc.restore();
	}

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

		/* Edad */
		doc.fillColor('black')
			.font('Helvetica', 10)
			.text("Edad: "+itemConfig.age, position.x + 73, position.y + 38, {
				ellipsis: true,
				width: (contentSize.width -70 ),
				height: 10,
				align: 'left'
			});

	   /* Antigüedad */
		doc.fillColor('black')
        .font('Helvetica', 10)
        .text("Antigüedad: "+itemConfig.antiquity, position.x + 73, position.y + 51, {
            ellipsis: true,
            width: (contentSize.width -70 ),
            height: 10,
            align: 'left'
        });
        
        /* Salario */
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Salario: "+itemConfig.salary, position.x + 73, position.y + 64, {
             ellipsis: true,
             width: (contentSize.width -70 ),
             height: 10,
             align: 'left'
         });

        /* Contrato */
         doc.fillColor('black')
         .font('Helvetica', 10)
         .text("Contrato: "+itemConfig.contract, position.x + 73, position.y + 77, {
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
         for (let index = 0; index < list.length; index++) {
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

    var result = new primitives.orgdiagram.TemplateConfig();
	result.name = "mainTemplatePrint";
	result.itemTemplate = "Use onItemRener method.";
	result.itemSize = new primitives.common.Size(220, 200);
	result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
	return result;
}
function getDepartmentTitleTemplatePrint() {

    var result = new primitives.orgdiagram.TemplateConfig();
	result.name = "DepartmentTitleTemplatePrint";
	result.itemTemplate = "Use onItemRener method.";
	result.itemSize = new primitives.common.Size(220, 27);
	result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);
	return result;
}

