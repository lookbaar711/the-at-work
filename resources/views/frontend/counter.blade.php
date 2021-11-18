<!DOCTYPE html>

<?php 
  $username = 'test1';
?>
<html>
  <head>
    <title>Pusher Test</title>
    
    <style type="text/css">
      
      tr{
        text-align: center;
      }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=gvAJ8Vgh"></script>
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>

    <script>
      var username = '{!! $username !!}';
      var user = 'test';

      //if(username == user){
        var counter = $('#counter').val();

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('8f39caacde1f81801fdd', {
          cluster: 'ap1',
          forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
          //JSON.stringify(data)
          //alert(JSON.stringify(data));

          $('.count').text(data.queue);

          $('.queue_'+data.counter).text(data.queue);


          responsiveVoice.speak('เชิญหมายเลข '+data.queue+' ที่ช่อง '+data.counter+' ค่ะ', 'Thai Female', {pitch: 1,rate: 1,volume: 1});

          //responsiveVoice.speak(data.queue, 'Thai Female', {pitch: 1,rate: 1,volume: 1});
        });
      //}

      
    </script>
  </head>
  <body>
    <h1>Pusher Test</h1>
    <p>
      Try publishing an event to channel <code>my-channel</code>
      with event name <code>my-event</code>.
    </p>

    <h1 class="count">0</h1>

    <table border="1">
      <tr>
        <th>หมายเลข</th>
        <th>ช่องบริการ</th>
      </tr>

      <tr>
        <td class="queue_1">1001</td>
        <td class="counter_1">1</td>
      </tr>
      <tr>
        <td class="queue_2">1002</td>
        <td class="counter_2">2</td>
      </tr>
      <tr>
        <td class="queue_3">1003</td>
        <td class="counter_3">3</td>
      </tr>
      <tr>
        <td class="queue_4">1004</td>
        <td class="counter_4">4</td>
      </tr>
      <tr>
        <td class="queue_5">1005</td>
        <td class="counter_5">5</td>
      </tr>
      <tr>
        <td class="queue_6">1006</td>
        <td class="counter_6">6</td>
      </tr>
    </table>

    <input type="hidden" name="counter" id="counter" value="0">
  </body>
</html>