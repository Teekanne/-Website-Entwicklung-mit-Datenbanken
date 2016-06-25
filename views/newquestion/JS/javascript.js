/**
* Adds up to eight textboxes into a div-element by the onkeydown-event.
* @param {DIV} The div-Container which will add another textbox
* @param {Textbox} Current textbox (id must include a number)
*/
function addTextbox(container, currentTextbox){
    var currentQuestionNumber = parseInt(container.replace(/^[^\d]+/, ""));
    var nextTextboxNumber = parseInt(currentTextbox.id.split('_')[1])+1;
    
    if(isNaN(nextTextboxNumber)){
        return;
    }
    
    if(document.getElementById('answer' + currentQuestionNumber + "_" + nextTextboxNumber) !== null){
        return;
    }

    var input = document.createElement('input');
    input.type = 'text';
    input.name = currentTextbox.name;
    input.id = 'answer' + currentQuestionNumber + "_" + nextTextboxNumber;
    input.placeholder = 'Antwortmöglichkeit ' + nextTextboxNumber;

    if(nextTextboxNumber<8){
        input.setAttribute("onkeydown", "addTextbox('" + container + "', this)");			
    }
    
    var answers = document.getElementById(container);
    
    answers.appendChild(document.createElement("br"));
    answers.appendChild(input);
    
}

function addNewQuestion(table, currentQuestion){

    var myTable = document.getElementById(table);
    var currentQuestionNumber = findLastQuestionNumber() + 1;
    
    /* Abstand gewinnen */
    for (var i = 0; i < 20; i++) {
        var row = myTable.insertRow(-1);
    }

    /* Creating the DOM */
    var question = document.createElement('input');
    question.type = 'text';
    question.name = "question" + currentQuestionNumber;
    
    var description = document.createElement('textarea');
    description.maxlength = 1000;
    description.type = 'text';
    description.name = "description" + currentQuestionNumber;
   
    var div = document.createElement('div');
    div.id = 'divAnswers' + currentQuestionNumber;
    
    var answer1 = document.createElement('input');
    answer1.type = 'text';
    answer1.id = "answer" + currentQuestionNumber + "_1";
    answer1.placeholder = 'Antwortmöglichkeit 1';
    
    var answer2 = document.createElement('input');
    answer2.type = 'text';
    answer2.id = "answer" + currentQuestionNumber + "_2";
    answer2.placeholder = 'Antwortmöglichkeit 2';
    answer2.setAttribute("onkeydown", "addTextbox('divAnswers" + currentQuestionNumber + "', this)");
    
    var singleChoice = document.createElement('input');
    singleChoice.type = 'radio';
    singleChoice.name = "singlechoice" + currentQuestionNumber;
    singleChoice.checked = true;
    singleChoice.innerHTML = "Single-Choice";
    
    var multipleChoice = document.createElement('input');
    multipleChoice.type = 'radio';
    multipleChoice.name = "multiplechoice" + currentQuestionNumber;
    multipleChoice.id = 'answer';
    multipleChoice.innerHTML  = "Multiple-Choice";
   
    /* Adding the dom */
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = "<label>Frage</label>";
    cell2.appendChild(question);
    
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = "<label>Beschreibung</label>";
    cell2.appendChild(description);
    
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = "<label>Antworten</label>";
    cell2.appendChild(div);
    div.appendChild(answer1);
    div.appendChild(document.createElement('br'));;
    div.appendChild(answer2);
    
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = "<label>Art</label>";
    cell2.appendChild(singleChoice);
    cell2.appendChild(document.createElement('br'));
    cell2.appendChild(multipleChoice);
}

function findLastQuestionNumber(){
    var lastQuestionNumber = 1;
    
    for (var i = 1; i > 0; i++) {
        var element = document.getElementsByName('question' + i)[0];
        if(!document.contains(element)){
            lastQuestionNumber = i-1;
            i=-1;
        }
    }
    
    return lastQuestionNumber;
}

function showPasswordBoxes(currentCheckBox, passwordLbls, currentPasswordTbx, newPasswordTbx){
    var lblPasswords = document.getElementsByName(passwordLbls);

    if(currentCheckBox.checked){
        for (var index = 0; index < lblPasswords.length; ++index) {
            lblPasswords[index].hidden = false;
        }
        document.getElementsByName(currentPasswordTbx)[0].hidden=false;
        document.getElementsByName(newPasswordTbx)[0].hidden=false;
        document.getElementsByName(newPasswordTbx)[1].hidden=false;
    }else{
        for (var index = 0; index < lblPasswords.length; ++index) {
            lblPasswords[index].hidden = true;
        }
        document.getElementsByName(currentPasswordTbx)[0].hidden=true;
        document.getElementsByName(newPasswordTbx)[0].hidden=true;
        document.getElementsByName(newPasswordTbx)[1].hidden=true;
    }
}