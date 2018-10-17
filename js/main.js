$( document ).ready(function() {
  // get worker's subordinates
  $('.list-group').on('click', '.show_subordinates', function(){
    var worker_id = $(this).data('id');
    
    var subordinates_class = ".subordinates-" + worker_id;
    $.ajax({
        url: '../app/RequestHandler.php?action=show_subordinates',
        data: {worker_id: worker_id},
        type: 'POST',
        success: function(res){
          $(subordinates_class).html(res);
        },
        error: function(){
        }
    });
  });
  // show more workers on the page
  $('.show_more').click(function(){
    $.ajax({
        url: '../app/RequestHandler.php?action=show_more_workers&type=more',
        type: 'POST',
        success: function(res){
          $('.show_more').show();
          res = jQuery.parseJSON(res); 
          if(res[1] == 0){
            $('.show_more').hide();
          }
          $('.all_workers').append(res[0]);
        },
        error: function(){
        }
    });
  });
  
  $('.sort_workers_list').click(function(){
    var sort_type = $('.sort_workers_select').val();
    $.ajax({
        url: '../app/RequestHandler.php?action=sort_workers&type=sort',
        data: {sort_type: sort_type},
        type: 'POST',
        success: function(res){
          $('.show_more').show();
          res = jQuery.parseJSON(res); 
          if(res[1] == 0){
            $('.show_more').hide();
          }
          $('.all_workers').html(res[0]);  
        },
        error: function(){
        }
    });
  });

  $('.search_workers').on('click', function(){
    var search_text = $('.search_input').val();
    var search_field = $('.search_workers_select').val();
    $.ajax({
        url: '../app/RequestHandler.php?action=search&type=search',
        data: {search_text: search_text, search_field: search_field},
        type: 'POST',
        success: function(res){
          $('.show_more').show();
          res = jQuery.parseJSON(res); 
          if(res[1] == 0){
            $('.show_more').hide();
          }
          $('.all_workers').html(res[0]);
        },
        error: function(){
        }
    });
  })
});