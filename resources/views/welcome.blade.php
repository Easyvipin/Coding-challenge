<!doctype html>
<html>
<head>
  <meta charset="utf-8">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <link href="{{ asset('css/video-js.min.css') }}" rel="stylesheet">
  <link href="{{ asset('css/videojs.record.css')}}" rel="stylesheet">
  <link href="/css/examples.css" rel="stylesheet">

  <script src="{{asset('js/video.min.js')}}"></script>
  <script src="{{ asset('js/RecordRTC.js')}}"></script>
  <script src="{{asset('js/adapter.js')}}"></script>

  <script src="{{ asset('js/videojs.record.js')}}"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
  <style>
      body {
          background-color: #fff;
      }
  /* change player background color */
  #myVideo {
      background-color: #fff;
  }
  /* .vjs-control-bar {
      background-color: #9ab87a;
  }
  .vjs-record-button, .vjs-control, .vjs-button, .vjs-icon-record-start {
      background-color: red;
      color: black; */
  }
  </style>
</head>
<body onload="myFunction()">

    <div class="col-md-8 m-auto my-5">
        <video id="myVideo" class="video-js vjs-default-skin">
        </video>
    </div>

    {{-- <iframe width="420" height="315" autoplay
        src="https://www.youtube.com/embed/tgbNymZ7vqY">
    </iframe> --}}

{{-- <div class="col-md-7 m-auto">
    <form role="form" method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <input type="file" name="video" class="form-control">
        </div>
        <button type="submit" class="btn btn-lg w-100">Submit</button>
    </form>
</div> --}}

<script>

    

function myFunction() {
    this.isStartRecording = true;
    this.player.record().getDevice();
}


/* eslint-disable */
var options = {
    controls: true,
    bigPlayButton: false,
    width: 800,
    height: 500,
    fluid: false,
    plugins: {
        record: {
            audio: true,
            video: true,
            maxLength: 360,
            displayMilliseconds: false,
            debug: true,
        }
    }
};

var player = videojs('myVideo', options, function() {
    // print version information at startup
    var msg = 'Using video.js ' + videojs.VERSION +
        ' with videojs-record ' + videojs.getPluginVersion('record') +
        ' and recordrtc ' + RecordRTC.version;
    videojs.log(msg);
});

// error handling
player.on('deviceError', function() {
    console.log('device error:', player.deviceErrorCode);
});

player.on('error', function(element, error) {
    console.error(error);
});

// user clicked the record button and started recording
player.on('startRecord', function() {
    console.log('started recording!');
});

// user completed recording and stream is available
player.on('finishRecord', function() {
    // the blob object contains the recorded data that
    // can be downloaded by the user, stored on server etc.
    console.log('finished recording:', player.recordedData);

    // upload recorded data
    upload(player.recordedData);
});

function startRecord() {
// let start = document.getElementById('btnStart');
    this.player.on('startRecord', function() {
        console.log('started recording!');
    });
}

function upload(blob) {
    // this upload handler is served using webpack-dev-server for
    // this example, see build-config/fragments/dev.js
    var serverUrl = '/uploads';
    var formData = new FormData();
    formData.append('video', blob, blob.name);
    console.log(serverUrl);

    console.log('upload recording ' + blob.name + ' to ' + serverUrl);

    // start upload
    fetch(serverUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).then(
        success => console.log('upload recording complete.')
    ).catch(
        error => console.error('an upload error occurred!')
    );
}
</script>

</body>
</html>
