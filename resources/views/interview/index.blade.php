<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Video</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://vjs.zencdn.net/7.10.1/video-js.min.css" rel="stylesheet">
  <link href="https://unpkg.com/videojs-record/dist/css/videojs.record.min.css" rel="stylesheet">
  <link href="assets/examples.css" rel="stylesheet">


  <style>
  /* change player background color */
  #myVideo {
      background-color: #6df7ab;
  }
  #myPlayer {
      margin-top: 40px;
  }
  </style>
</head>
<body>

<!-- Primary videojs-record instance (video-only) -->
<video id="myVideo" controls autoplay playsinline class="video-js vjs-default-skin"></video>

<!-- Secondary video.js player with MP4 video and no plugins enabled -->
<video id="myPlayer" class="video-js vjs-default-skin"
       data-setup='{"controls": true, "autoplay": false, "preload": "auto"}'>
  <source src="http://vjs.zencdn.net/v/oceans.mp4" type="video/mp4">

</video>
<button id="btn-start-recording">Start Recording</button>
<button id="btn-stop-recording" disabled>Stop Recording</button>

<form method="post">
  @csrf
<div class="col-md-6" id="recorded"  style="display:none">
            <h2>Recording</h2>
            <video id="recording" width="160" height="120" controls></video><br/><br/>
            <!-- <a id="downloadButton" class="btn btn-primary" data-url="{{route('videos.store')}}">save</a> -->
            <a id="downloadLocalButton" class="btn btn-primary">Download</a>
        </div>
  
</form>

  <script src="http://vjs.zencdn.net/7.10.1/video.min.js"></script>
   <script src="http://unpkg.com/recordrtc/RecordRTC.js"></script> 
  <script src="http://unpkg.com/webrtc-adapter/out/adapter.js"></script>

  <script src="http://unpkg.com/videojs-record/dist/videojs.record.min.js"></script>


  <script src="https://collab-project.github.io/videojs-record/demo/browser-workarounds.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/RecordRTC/5.6.1/RecordRTC.js" integrity="sha512-glr08OFPizBs+XVXIpgMVTMdJ+8CRgC1u9GHqUb1fmrmcOkWt7Pe07Gg75dnBjhXMypKlZrHvl9P4kaZWaRLKg==" crossorigin="anonymous"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/videojs-record/4.1.1/videojs.record.min.js" integrity="sha512-DZzoUyCDysKYDMTwkKSJCJGqlrLviqyQQ4lQXBfX4nMCUiLpBB1IVVSqgWVgQb+Wzd7foVmjv7MPlz3Dwpr2PQ==" crossorigin="anonymous"></script>


<script>
var video = document.querySelector('video');

    var myvideo = document.getElementById("myPlayer");
    var recording = document.getElementById("recording");
    var recorded = document.getElementById("recorded");
    var downloadLocalButton = document.getElementById("downloadLocalButton");

function captureCamera(callback) {
    navigator.mediaDevices.getUserMedia({ audio: true, video: true }).then(function(camera) {
        callback(camera);
    }).
    catch(function(error) {
        alert('Unable to capture your camera. Please check console logs.');
        console.error(error);
    });
}
           

function stopRecordingCallback() {
    video.src = video.srcObject ;
    video.muted = false;
    video.volume = 1;

    const blob = recorder.getBlob();
  
    // const bb = recorder.recordedData;

    recording.src = URL.createObjectURL(blob);
    recorded.style.display = "block";
   downloadLocalButton.href = URL.createObjectURL(blob);
   downloadLocalButton.download = "RecordedVideo.webm"; 
    recorder.camera.stop();
    var file = new File([blob], 'filename.webm', {
                 type: 'video/webm'
             });
      console.log(blob);
    // blob.name = 'recording.webm';
     var serverUrl = "{{ url('/videostore') }}";
    var formData = new FormData();
    formData.append('file', file);
    
    console.log(blob.entries());

    console.log('upload recording ' + 'false.webm' + ' to ' + serverUrl);
    //   xhr('/videostore', formData, function(fName)
    //   {
    //     console.log("Video Successfully Uploaded");
    //   });
    // // start upload

$.ajax({
 type: "POST",
method: 'POST',
 url: "{{ url('/videostore') }}",
  processData: false,
cache: false,
 headers : { 
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
       },
data: formData,


 success: function(resp) {

            console.log(resp);


}
                  
                  });
recorder.destroy();
    recorder = null;
    
    // fetch(serverUrl, {
    //     method: 'POST',
    //     body: formData,
    //     headers : { 
    //     'Content-Type': 'application/json',
    //     'Accept': 'application/json',
    //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //    }
    // }).then(
    //     function(response) {
    //   if (response.status !== 200) {
    //     console.log('Looks like there was a problem. Status Code: ' +
    //       response.status);
    //     return;
    //   }
    //   console(response.status);
    //   // Examine the text in the response
    //   // response.json().then(function(data) {
    //   //   console.log(data);
    //   // });
    // }
    // ).catch(
    //     error => console.error('an upload error occurred!')
    // );   

                    

}
// function xhr(url,data,callback)
// {
//   var request = new XMLHttpRequest();

//   request.onreadystatechange = function(){
//     if (request.readyState == 4 && request.status == 200)
//     {
//       callback(location.href + request.responseText);
//     }
//   };
//   var csrfToken = request.getResponseHeader('x-csrf-token');
//   request.open('POST', url, false);
//   request.setRequestHeader("x-csrf-token", csrfToken);    
//   request.setRequestHeader("Accept", "application/json");
//   request.setRequestHeader("Content-Type", "application/json; charset=utf-8");

//   request.send(data);
// }
var recorder; // globally accessible

document.getElementById('btn-start-recording').onclick = function() {
  myvideo.play();
    this.disabled = true;
    captureCamera(function(camera) {
        video.muted = true;
        video.volume = 0;
        video.srcObject = camera;

        recorder = RecordRTC(camera, {
            type: 'video'
        });

        recorder.startRecording();

        // release camera on stopRecording
        recorder.camera = camera;

        document.getElementById('btn-stop-recording').disabled = false;
    });
};
    

document.getElementById('btn-stop-recording').onclick = function() {
  myvideo.pause();
    this.disabled = true;
   
   
     recorder.stopRecording(stopRecordingCallback);
};
</script>

<footer style="margin-top: 20px;"><small id="send-message"></small></footer>
<script src="https://www.webrtc-experiment.com/common.js"></script>

</body>
</html>