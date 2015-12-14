$(function() {
  remove_sample = function(sample_id) {
    $.ajax({
      url: '/database/' + sample_id,
      type: 'DELETE',
      success: function() {
        alert("Success! Sample removed!");
      },
      error: function() {
          alert("Error, try again.");
      }
    });

    window.location.reload();
  }
});
