if (document.getElementsByClassName('notEmpty')) {
    var noEmptyInputs = document.getElementsByClassName('notEmpty');
    var mustFillIn = document.getElementsByClassName('emptyFields');
    var length = noEmptyInputs.length;

    for (var i = 0; i < length; i++) {
        noEmptyInputs[i].onblur = function() {
            if (this.value === '') {
                this.style.backgroundColor = 'rgb(250, 80, 80)';
                mustFillIn[0].style.display = 'block';
                return;
            }

            var allFilled = true;
            for (var j = 0; j < length; j++) {
                if (noEmptyInputs[j].value === '') {
                    allFilled = false;
                    break;
                }
            }

            var noRed = true;
            for (var k = 0; k < length; k++) {
                if (noEmptyInputs[k].style.backgroundColor == 'rgb(250, 80, 80)') {
                    noRed = false;
                    break;
                }
            }

            if (allFilled || noRed) {
                mustFillIn[0].style.display = 'none';
            }
        };

        noEmptyInputs[i].oninput = function () {
            var allFilled = true;
            for (var j = 0; j < length; j++) {
                if (noEmptyInputs[j].value === '') {
                    allFilled = false;
                    break;
                }
            }
            if (allFilled) {
                mustFillIn[0].style.display = 'none';
            }
        }

        noEmptyInputs[i].onfocus = function() {
            this.style.backgroundColor = 'rgb(250, 250, 250)';
        };
    }
}

