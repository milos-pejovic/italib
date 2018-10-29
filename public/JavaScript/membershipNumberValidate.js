if (document.getElementById('memNum')) {
    var memNum = document.getElementById('memNum');
    var badMemNum = document.getElementsByClassName('badMemNum')[0];

    memNum.onblur = function() {
        if (memNum.value.length !== 7) {
            memNum.style.backgroundColor = 'rgb(250, 80, 80)';
            badMemNum.style.display = 'block';
        } else {
            badMemNum.style.display = 'none';
            memNum.style.backgroundColor = 'rgb(250, 250, 250)';
        }
    };
}