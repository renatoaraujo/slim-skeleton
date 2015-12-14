$(function() {
  remove_sample = function(sample_id) {
    $.ajax({
      url: '/database/' + sample_id,
      type: 'DELETE',
      statusCode: {
        404: function() {
          alert("Error, try again.");
        },
        200: function() {
          alert("Success! Sample removed!");
        }
      }
    });

    window.location.reload();
  }
});
