function pageLoad() {
  url = GMaps.staticMapURL({
    size: [610, 300],
    lat: 46.235000, 
    lng: -119.223301,
    markers: [
      {lat: 46.235000, lng: -119.223301,
        color: 'green'}
    ]
  });

  $('<img/>').attr('src', url).appendTo('#map');
}

$(document).ready(pageLoad);