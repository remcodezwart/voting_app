var elements = document.getElementsByTagName("button");

for (index in elements) {
	if (elements[index] instanceof Element) {
        elements[index].addEventListener('click', answer, false);
    }
}

var statements = ["De rijken moeten meer belasting betalen", "Er moet meer geld naar het mileu", "Er moet meer geld naar onderwijs"];
var partys = [{party: 'sp', statements: [1, 1, 1], score:0}, {party:'d66', statements: [0, 1, 0], score:0}, {party:'vvd', statements:[-1, 0, 0], score:0}, {party: 'cda', statements:[1, 1, 1], score:0 }];
var answers = [];

newStatement();

function newStatement()
{
	var statment = statements[answers.length];

	if (statment === undefined) {
		calulateResult();
		return;
	}

	document.getElementById('statement').innerHTML = statment;
}

function answer() 
{
	answers.push(Number(this.name));
	newStatement();
}

function calulateResult()
{
	var result = [-1000];
	document.getElementById('statement').innerHTML = "";
	document.getElementById('buttons').className  = "none";

	for (key in partys) {
		for (index in partys[key].statements) {
			if (partys[key].statements[index] === answers[index]) {
				partys[key].score++;
			} else {
				partys[key].score--;
			}
		}

		if (partys[key].score > result[0]) {
			result = [];
			result.push(partys[key].score);
			result.push(partys[key]);
		} else if (partys[key].score === result[0]) {
			result.push(partys[key]);
		}
	}

	result.shift();

	for (index in result) {
		document.getElementById('result').innerHTML += result[index].party + "<br>";
	}
}