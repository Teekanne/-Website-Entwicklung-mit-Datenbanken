/**
* Adds up to eight textboxes into a div-element by the onkeydown-event.
* @param {DIV} The div-Container which will add another textbox
* @param {Textbox} Current textbox (id must include a number)
*/
function addTextbox(container, currentTextbox){
    var nextTextboxNumber = parseInt(currentTextbox.id.replace(/^[^\d]+/, ""))+1;
    
    if(isNaN(nextTextboxNumber)){
        return;
    }
    
    if(document.getElementById('answer' + nextTextboxNumber) != null){
        return;
    }

    var input = document.createElement('input');
    input.type = 'text';
    input.name = currentTextbox.name;
    input.id = 'answer' + nextTextboxNumber;
    input.placeholder = 'Antwortmöglichkeit ' + nextTextboxNumber;

    if(nextTextboxNumber<8){
        input.setAttribute("onkeydown", "addTextbox('" + container + "', this)");			
    }
    
    var answers = document.getElementById(container);
    answers.appendChild(input);
    answers.appendChild(document.createElement("br"));
}