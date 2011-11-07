  // デフォルトの中心は東京近辺
  lat_def = 35.61;
  lng_def = 139.767372;
  $(function() {
    var marker_list = new google.maps.MVCArray();

    //地図を表示
    var latlng = new google.maps.LatLng(lat_def, lng_def);
    var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    //移動フラグ
    move = true;

    google.maps.event.addListener(map, 'bounds_changed', function() {
      move = true;
    });

    //移動が止まった時点で描画を開始
    google.maps.event.addListener(map, 'idle', function() {
      if (move) {
        //一旦削除
        marker_list.forEach(function(marker, idx) {
          marker.setMap(null);
        });

        //中心の辺りの観測値を取得
        latlng_c = map.getCenter();

        $.getJSON("get_station_list.php", { lat: latlng_c.lat(), lng: latlng_c.lng() },
        function(data){

          //中心にマーカーを描画
          var marker = new google.maps.Marker({
              position: latlng_c, 
              map: map,
              title: "Click here!"
          });

          marker_list.push(marker);

          //観測地点にマーカーを描画
          $.each(data.stations, function(i, val) {
            var latlng_s = new google.maps.LatLng(val.lat, val.lng);
            var marker_s = new google.maps.Marker({
              position: latlng_s,
              map: map,
              title: val.name
            });

            marker_list.push(marker_s);
          });

          //マーカーにコールバック関数をセット
          marker_list.forEach(function(marker, idx) {
            google.maps.event.addListener(marker, 'click', function() {
              //天気予報を取得して画面上に描画
              $.getJSON("get_forcast.php", { lat: marker.position.lat(), lng: marker.position.lng() },
              function(data_f){
                $("#forcasts table img").css("visibility", "visible");
                $("#location").text(data_f.location);
                $("#forcast1").attr('src', data_f.forcasts[0].icon);
                $("#forcast2").attr('src', data_f.forcasts[1].icon);
                $("#sp1").text(data_f.forcasts[0].sp);
                $("#sp2").text(data_f.forcasts[1].sp);
                $("#day1").text(data_f.forcasts[0].title);
                $("#day2").text(data_f.forcasts[1].title);
              });
            });
          });
        });

        move = false;

      }
    });
  })

