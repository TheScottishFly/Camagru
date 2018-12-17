(function() {

    var streaming = false,
        video        = document.getElementById('video'),
        canvas       = document.getElementById('canvas'),
        photo        = document.getElementById('photo'),
        takebutton  = document.getElementById('takebutton'),
        width = 320,
        height = 240;

    canvas.style.display = 'none';

    window.addEventListener('DOMContentLoaded', function() {
        'use strict';

        navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
        window.URL = window.URL || window.webkitURL || window.mozURL || window.msURL;

        function successCallback(stream) {
            if (video.mozSrcObject !== undefined) {
                video.mozSrcObject = stream;
            } else {
                video.srcObject = stream;
            }
            video.play();
        }

        function errorCallback(error) {
            console.error('An error occurred: [CODE ' + error.code + ']');
        }

        if (navigator.getUserMedia) {
            navigator.getUserMedia({video: true}, successCallback, errorCallback);
        } else {
            console.log('Native web camera streaming (getUserMedia) not supported in this browser.');
        }
    }, false);

    video.addEventListener('canplay', function(ev){
        if (!streaming) {
            height = video.videoHeight / (video.videoWidth/width);
            video.setAttribute('width', width);
            video.setAttribute('height', height);
            canvas.setAttribute('width', width);
            canvas.setAttribute('height', height);
            streaming = true;
        }
    }, false);

    function takepicture() {
        canvas.width = width;
        canvas.height = height;
        canvas.getContext('2d').drawImage(video, 0, 0, width, height);
        var img = document.querySelector('.alpha:checked').nextSibling;
        canvas.getContext('2d').drawImage(img, 0, 0, width, height);
        photo.value = canvas.toDataURL();
    }

    takebutton.addEventListener('click', function(ev){
        canvas.style.display = '';
        takepicture();
        ev.preventDefault();
    }, false);

})();
