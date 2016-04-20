var TOTAL_USERS = $('#competition_max').data('total');

$('#competition_max').change(function() {
  // Clear the table and get new value
  $('tbody').empty();
  var max = $(this).val();

  // Get new total competitions
  var numOfCompetitions = TOTAL_USERS / max;
  var rows = [];

  // Distribute the people
  var competitionIndex = 0;
  for (var userIndex = 0; userIndex < TOTAL_USERS; userIndex++) {
    if (!rows[competitionIndex]) {
      rows[competitionIndex] = 0;
    }

    rows[competitionIndex]++;
    competitionIndex++;

    if (competitionIndex >= numOfCompetitions) {
      competitionIndex = 0;
    }

  }

  // Add the HTML
  rows.forEach(function(row, index) {
    // Build the HTML row
    var $row = $('<tr class="table__row">');
    $row.append(`<td class="table__cell">${index + 1}</td>`);
    $row.append(`<td class="table__cell">${row}</td>`);
    $('tbody').append($row);
  });

  // Add warning if it wasn't already added
  if (!$('#matchup-flag').length) {
    $('tbody').parent().prepend('<p id="matchup-flag">These are approximate matchups.</p>');
  }
});
