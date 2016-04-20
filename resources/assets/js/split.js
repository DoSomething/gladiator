var TOTAL_USERS = $('#competition_max').data('total');

$('#competition_max').change(function() {
  // Clear the table and get new value
  $('tbody').empty();
  var max = $(this).val();

  // Get new row totals & round up to be safe
  var rows = Math.ceil(TOTAL_USERS / max);
  for (var i = 0; i < rows; i++) {

    var rowTotal = max;
    if (i == rows - 1) {
      rowTotal = TOTAL_USERS - ((rows - 1) * max);
    }

    // Build the HTML row
    var $row = $('<tr class="table__row">');
    $row.append(`<td class="table__cell">${i + 1}</td>`);
    $row.append(`<td class="table__cell">${rowTotal}</td>`);
    $('tbody').append($row);
  }

  // Add warning if it wasn't already added
  if (!$('#matchup-flag').length) {
    $('tbody').parent().prepend('<p id="matchup-flag">These are approximate matchups.</p>');
  }
});
