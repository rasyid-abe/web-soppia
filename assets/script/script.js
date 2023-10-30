$(window).on('load',function(){
  //Pace.start();
  $('.btn-box-tool[title="No Access"]').remove();
  $('a.btn-box-tool[data-original-title="No Access"]').remove();
});
$(document).ready(function(){
  //Pace.start();
  $('.btn-box-tool[title="No Access"]').remove();
  $('a.btn-box-tool[data-original-title="No Access"]').remove();
  $('[data-toggle="tooltip"]').tooltip();   
  $('[data-toggle="popover"]').popover();   
  $(document).ajaxStart(function() { 
    //Pace.restart();
    $("#modal-default").find(".modal-dialog .modal-content .modal-body").html(" ");
  }); 
  $(document).ajaxComplete(function() {
    $('[data-toggle="tooltip"]').tooltip();
        
      $('.btn-box-tool[title="No Access"]').remove();
      $('a.btn-box-tool[data-original-title="No Access"]').remove();
  });
  
  $(document).on("click",".view-data",function(e){
    e.preventDefault();
    var href = $(this).attr("href");
    $("#modal-default").find(".modal-dialog .modal-content .modal-header .modal-title").html("Melihat Data");
    $("#modal-default").find(".modal-dialog .modal-content .modal-body").load(href);
    $("#modal-default").find(".modal-dialog").addClass("animated bounceIn");
    $("#modal-default").modal("show");
  });
  
  $(document).on("click",".delete-data",function(e){
    e.preventDefault();
    var href = $(this).attr("href");
    $("#modal-default").find(".modal-dialog .modal-content .modal-header .modal-title").html("Konfirmasi Penghapusan Data");
    $("#modal-default").find(".modal-dialog .modal-content .modal-body").load(href);
    $("#modal-default").find(".modal-dialog").addClass("animated bounceIn");
    $("#modal-default").modal("show");
  });

});