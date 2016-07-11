function hide(control){
    var control = document.getElementById(control);

    if(!control){
        return;
    }

    if(control.style.visibility !== 'hidden'){
        control.style.visibility = 'hidden';
    }else{
        control.style.visibility = 'visible';
    }
}

function addTextbox(container, currentTextbox){
    var currentQuestionNumber = parseInt(container.replace(/^[^\d]+/, ""));
    var nextTextboxNumber = parseInt(currentTextbox.split('_')[1])+1;
    
    if(isNaN(nextTextboxNumber)){
        return;
    }
    
    if(document.getElementsByName('answer' + currentQuestionNumber + "_" + nextTextboxNumber)[0] != null){
        return;
    }

    var input = document.createElement('input');
    input.type = 'text';
    input.name = 'answer' + currentQuestionNumber + "_" + nextTextboxNumber;
    input.placeholder = 'Antwortmöglichkeit ' + nextTextboxNumber;
    
    if(nextTextboxNumber<8){
        input.setAttribute("onkeydown", "addTextbox('" + container + "', '" + input.name + "')");			
    }
    var answers = document.getElementsByClassName(container)[0];
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
    question.required = true;
    
    var description = document.createElement('textarea');
    description.maxlength = 1000;
    description.type = 'text';
    description.name = "description" + currentQuestionNumber;
   
    var div = document.createElement('div');
    div.className = 'divAnswers' + currentQuestionNumber;
    
    var answer1 = document.createElement('input');
    answer1.type = 'text';
    answer1.name = "answer" + currentQuestionNumber + "_1";
    answer1.placeholder = 'Antwortmöglichkeit 1';
    answer1.required = true;
    
    var answer2 = document.createElement('input');
    answer2.type = 'text';
    answer2.name = "answer" + currentQuestionNumber + "_2";
    answer2.placeholder = 'Antwortmöglichkeit 2';
    answer2.required = true;
    answer2.setAttribute("onkeydown", "addTextbox('" + div.className + "', '" + answer2.name + "')");
    
    var singleChoice = document.createElement('input');
    singleChoice.type = 'radio';
    singleChoice.name = "choice" + currentQuestionNumber;
    singleChoice.value = 'singlechoice';
    singleChoice.checked = true;
    
    var singleChoiceLabel = document.createElement('label');
    singleChoiceLabel.innerHTML = "Single-Choice";
    singleChoiceLabel.className = "radioLabel";
    
    var multipleChoice = document.createElement('input');
    multipleChoice.type = 'radio';
    multipleChoice.name = "choice" + currentQuestionNumber;
    multipleChoice.value = 'multiplechoice';
    multipleChoice.id = 'answer';

    var multipleChoiceLabel = document.createElement('label');
    multipleChoiceLabel.innerHTML = "Multiple-Choice";
    multipleChoiceLabel.className = "radioLabel";
    
    /* Adding the dom */
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    cell1.className = "cells";
    cell1.innerHTML = "<label>Frage</label>";
    var cell2 = row.insertCell(1);
    cell2.appendChild(question);
    
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    cell1.className = "cells";
    var cell2 = row.insertCell(1);
    cell1.innerHTML = "<label>Beschreibung</label>";
    cell2.appendChild(description);
    
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = "<label>Beschreibung</label>";
    cell1.className = "cells";
    cell1.innerHTML = "<label>Antworten</label>";
    var cell2 = row.insertCell(1);
    cell2.appendChild(div);
    div.appendChild(answer1);
    div.appendChild(document.createElement('br'));;
    div.appendChild(answer2);
    
    var row = myTable.insertRow(-1);
    var cell1 = row.insertCell(0);
    cell1.innerHTML = "<label>Art</label>";
    cell1.className = "cells";
    var cell2 = row.insertCell(1);
    cell2.appendChild(singleChoice);
    cell2.appendChild(singleChoiceLabel);
    cell2.appendChild(document.createElement('br'));
    cell2.appendChild(multipleChoice);
    cell2.appendChild(multipleChoiceLabel);
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

function showVoteResults(key){
        function ajaxRequest() {
                //erstellen des requests
                var req = null;

                try {
                    req = new XMLHttpRequest();
                }
                catch (ms) {
                    try {
                        req = new ActiveXObject("Msxml2.XMLHTTP");
                    }
                    catch (nonms) {
                        try {
                            req = new ActiveXObject("Microsoft.XMLHTTP");
                        }
                        catch (failed) {
                            req = null;
                        }
                    }
                }

                if (req == null) {
                        alert("Error creating request object!");
                }
                //anfrage erstellen (GET, url ist localhost,
                //request ist asynchron
                var url = 'views/newquestion/results.php?key=' + key;
                req.open("GET", url, true);

                //Beim abschliessen des request wird diese Funktion ausgeführt
                req.onreadystatechange = function() {
                    switch (req.readyState) {
                        case 4:
                            if (req.status != 200 && req.status != 0) {
                                alert("Fehler:" + req.status);
                            } else {
                                //alert(req.responseText);
                                //schreibe die antwort in den div 
                                //container mit der id content
                                var result = '<strong>'+req.responseText+'</strong>';
                                document.getElementById('eins').innerHTML = result;
                            }
                            break;

                        default:
                            return false;
                            break;
                    }
                };

                req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                req.send(null);
        }

        //Zeitgesteuerter Aufruf von Ajax
        setInterval(ajaxRequest, 500);
}
