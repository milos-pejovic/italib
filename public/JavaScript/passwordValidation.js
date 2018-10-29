if (
        document.getElementById('pass1') && 
        document.getElementById('pass2')
    ) {
        var pass1 = document.getElementById('pass1');
        var pass2 = document.getElementById('pass2');
        var diffPass = document.getElementsByClassName('diffPass');
        var shortPass = document.getElementsByClassName('shortPass');

        function validate() {
            if (pass1.value !== '' && pass2.value !== '') {
                if (pass1.value !== pass2.value) {
                    diffPass[0].style.display = 'block';
                    pass1.style.backgroundColor = 'rgb(250, 80, 80)';
                    pass2.style.backgroundColor = 'rgb(250, 80, 80)';
                } else {
                    diffPass[0].style.display = 'none';
                    pass1.style.backgroundColor = 'rgb(250, 250, 250)';
                    pass2.style.backgroundColor = 'rgb(250, 250, 250)';
                }

                if (pass1.value.length < 5)  {
                    shortPass[0].style.display = 'block';
                    pass1.style.backgroundColor = 'rgb(250, 80, 80)';
                    pass2.style.backgroundColor = 'rgb(250, 80, 80)';
                } else {
                    shortPass[0].style.display = 'none';
                    pass1.style.backgroundColor = 'rgb(250, 250, 250)';
                    pass2.style.backgroundColor = 'rgb(250, 250, 250)';
                }
            }


        }

        pass1.addEventListener('blur', validate);
        pass2.addEventListener('blur', validate);
    }

