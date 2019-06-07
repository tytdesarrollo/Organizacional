//console.log(datosgrap["AREA"].length);
console.log(datosgrap);
console.log(datosemp);

function getData() {
    var items = [];

    for (var i = 0; i < datosgrap["AREA"].length; i++) {
/*
       var itemspre = new primitives.orgdiagram.ItemConfig({
            id: datosgrap["CODIGO"][i]+'123456789',
            parent: datosgrap["DEPENDENCIA"][i],
            hasSelectorCheckbox: false,
            templateName: "CursorTemplate",
            title: datosgrap["AREA"][i],
            itemTitleColor: "#3B5FD1",
            students: 8
        });
            items.push(itemspre);
            */
var itemsdos = [];

if(getempleadosel=="empshow"){
        for (var u = 0; u < datosemp["CARGO"].length; u++) {

            if(datosemp["CARGO"][u]==datosgrap["CODIGO"][i]){

                itemsdos.push(datosemp["NOMBRES"][u]);

            }
        }
}
       // console.log(itemsdos);
                var itemspre2 = new primitives.orgdiagram.ItemConfig({
                        id: datosgrap["CODIGO"][i],
                        parent: datosgrap["DEPENDENCIA"][i],
                        hasSelectorCheckbox: false,
                        title: datosgrap["AREA"][i],
                        description: "",
                        groupTitle: "NIVEL " + datosgrap["NIVEL"][i],
                        groupTitleColor: "#1c254b",
                        itemTitleColor: "#37589e",
                        email: "",
                        phone: "",
                        contract: "",
                        antiquity: 0,
                        salary: 0,
                        address: "",
                        age: 0,
                        civilStatus: "",
                        workingStatus: "",
                        dateStart: "",
                        dateEnd: "",
                        competences: [itemsdos.join(', ')],
                        percentage: [0, 0, 0],
                        dependence: datosgrap["AREA"][i],
                        disciplinaryProcesses: [],
                        charge: datosgrap["AREA"][i]
                    });

                items.push(itemspre2);
            }
   // console.log(itemsdos);
           // console.log(items);
            return items;
        }



function getDataBlob(){
    var items = [];

    for (var i = 0; i < datosgrap["AREA"].length; i++) {
        /*
               var itemspre = new primitives.orgdiagram.ItemConfig({
                    id: datosgrap["CODIGO"][i]+'123456789',
                    parent: datosgrap["DEPENDENCIA"][i],
                    hasSelectorCheckbox: false,
                    templateName: "CursorTemplate",
                    title: datosgrap["AREA"][i],
                    itemTitleColor: "#3B5FD1",
                    students: 8
                });
                    items.push(itemspre);
                    */
        var itemsdos = [];

        if(getempleadosel=="empshow"){
            for (var u = 0; u < datosemp["CARGO"].length; u++) {

                if(datosemp["CARGO"][u]==datosgrap["CODIGO"][i]){

                    itemsdos.push(datosemp["NOMBRES"][u]);

                }
            }
        }
        // console.log(itemsdos);
        var itemspre2 = new primitives.orgdiagram.ItemConfig({
            id: datosgrap["CODIGO"][i],
            parent: datosgrap["DEPENDENCIA"][i],
            hasSelectorCheckbox: false,
            title: datosgrap["AREA"][i],
            description: "",
            groupTitle: "NIVEL " + datosgrap["NIVEL"][i],
            groupTitleColor: "#1c254b",
            itemTitleColor: "#37589e",
            email: "",
            phone: "",
            contract: "",
            antiquity: 0,
            salary: 0,
            address: "",
            age: 0,
            civilStatus: "",
            workingStatus: "",
            dateStart: "",
            dateEnd: "",
            competences: [itemsdos.join(', ')],
            percentage: [0, 0, 0],
            dependence: datosgrap["AREA"][i],
            disciplinaryProcesses: [],
            charge: datosgrap["AREA"][i]
        });

        items.push(itemspre2);
    }
    // console.log(itemsdos);
    // console.log(items);
    return items;
}