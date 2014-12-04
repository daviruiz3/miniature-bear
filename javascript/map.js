function pageLoad() {
  url = GMaps.staticMapURL({
    size: [610, 300],
    lat: -12.043333,
    lng: -77.028333,
    markers: [
      {lat: -12.043333, lng: -77.028333},
      {lat: -12.045333, lng: -77.034,
        size: 'small'},
      {lat: -12.045633, lng: -77.022,
        color: 'blue'}
    ]
  });

  $('<img/>').attr('src', url)
    .appendTo('#map');
}

$(document).ready(pageLoad);