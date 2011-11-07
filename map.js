  // �f�t�H���g�̒��S�͓����ߕ�
  lat_def = 35.61;
  lng_def = 139.767372;
  $(function() {
    var marker_list = new google.maps.MVCArray();

    //�n�}��\��
    var latlng = new google.maps.LatLng(lat_def, lng_def);
    var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    //�ړ��t���O
    move = true;

    google.maps.event.addListener(map, 'bounds_changed', function() {
      move = true;
    });

    //�ړ����~�܂������_�ŕ`����J�n
    google.maps.event.addListener(map, 'idle', function() {
      if (move) {
        //��U�폜
        marker_list.forEach(function(marker, idx) {
          marker.setMap(null);
        });

        //���S�̕ӂ�̊ϑ��l���擾
        latlng_c = map.getCenter();

        $.getJSON("get_station_list.php", { lat: latlng_c.lat(), lng: latlng_c.lng() },
        function(data){

          //���S�Ƀ}�[�J�[��`��
          var marker = new google.maps.Marker({
              position: latlng_c, 
              map: map,
              title: "Click here!"
          });

          marker_list.push(marker);

          //�ϑ��n�_�Ƀ}�[�J�[��`��
          $.each(data.stations, function(i, val) {
            var latlng_s = new google.maps.LatLng(val.lat, val.lng);
            var marker_s = new google.maps.Marker({
              position: latlng_s,
              map: map,
              title: val.name
            });

            marker_list.push(marker_s);
          });

          //�}�[�J�[�ɃR�[���o�b�N�֐����Z�b�g
          marker_list.forEach(function(marker, idx) {
            google.maps.event.addListener(marker, 'click', function() {
              //�V�C�\����擾���ĉ�ʏ�ɕ`��
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

