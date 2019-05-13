
jQuery(document).ready(function () {
    
    // $('#modalOrganigram').modal({backdrop: 'static', keyboard: false});    
    // $('#modalOrganigram').modal('show'); // abrir
    loadOrganigram();
});

function loadOrganigram(){

    var items = getData(); 
    var dependences = [];     
    var charges = [];
 
    // verify();
    // $('#modalOrganigram').modal('show'); // abrir
    for (let i = 0; i < items.length; i++) {
                        
        if(items[i]['templateName']=="CursorTemplate"){
            dependences.push(items[i]['title']);         
            charges.push(getValueOrganigram("dependence",items[i]['title'],"groupTitle"));
        }        
    }


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
        +               '</a>'
        +               '<ul class="sub-accordion radius-bottom">';
        
        for (let j = 0; j < charges[i].length; j++) {
                    
            template +='<li class="sub-accordion__item">'
                           + '<div>' + charges[i][j]
                            +   '<div class="cntrCharge" style="">'
                            +       '<label for="chargeCheck-'+ i+'-'+j +'" class="label-cbx">'
                            +           '<input id="chargeCheck-'+ i+'-'+j +'" type="checkbox" class="invisible countCharge'+i+'" onchange="checkedCharges(this)">'
                            +           '<div class="checkbox checkboxIn">'
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
        
        template += '</ul></li>';   
    }
    template += '</ul></nav>';

    var list = document.getElementById("contentList");
    list.innerHTML = template;
    executeList();
}

function getValueOrganigram(field,comparator,add){
    var items = getData();
    var arrayDependences = [];

    for (let index = 0; index < items.length; index++) {
        const element = items[index];
        if(element[field]==comparator){
            arrayDependences.push(element[add]);
        }        
    }
    return arrayDependences;
}

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
                            //console.log('slide up of accordion ' + i + ' is done');
                            
                        }, timer);
                        
                    } else {
                        
                        if(arr.length > 0) {
                            
                            slide(arr[i-1]).up(function() {
                                
                                arr[i-1].classList.remove(activeClass);                  
                                arr[i-1] = e.target;                  
                                //console.log('slide up of accordion ' + i + ' is done');
                                
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