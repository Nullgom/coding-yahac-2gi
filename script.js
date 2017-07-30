target = document.getElementById('target');

wbtn = document.getElementById('white_btn');
wbtn.addEventListener('click', function(){
    target.className = 'white';
});

bbtn = document.getElementById('black_btn');
bbtn.addEventListener('click', function(){
    target.className = 'black';
});
