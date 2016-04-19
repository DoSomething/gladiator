$('#competition_max').change(function() {
  var waitingRoom = window.location.pathname.split('/')[2];
  var max = $(this).val();
  $.get(`/api/v1/split?competitionMax=${max}&waitingRoom=${waitingRoom}`, function(data) {
    $('tbody').empty();

    data.forEach(function(row, index) {
      var $row = $('<tr class="table__row">');
      $row.append(`<td class="table__cell">${index}</td>`);
      $row.append(`<td class="table__cell">${row.length}</td>`);
      $('tbody').append($row);
    });
  });
});
