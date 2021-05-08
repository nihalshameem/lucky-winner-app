$(document).ready(function(){
    $('#clearInputs').on('click',() => {
        $('input[type="text"]').val('');
        $('input[type="number"]').val(0);
        $('input[type="file"]').val('');
        $("select").val($("select option:first").val());
    }),
    $('#deleteBtn').on('click',() => {
        if(confirm('Do you want to detele?')){
          $('#deleteForm').trigger('submit');
        }
    }),
    $(".notification").fadeIn(),
    $(".notification").delay(6e3).fadeOut(),
    $('#profileform').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
          e.preventDefault();
          return false;
        }
      }),
      $('#profileEdit').on('click',() => {
        $('input').attr('disabled',false);
        $('button[type="submit"]').attr('hidden',false);
        $('#profileCancel').attr('hidden',false);
        $('#password').attr('hidden',false);
        $('#profileEdit').attr('hidden',true);
      }),
      $('#profileCancel').on('click',() => {
        $('input').attr('disabled',true);
        $('button[type="submit"]').attr('hidden',true);
        $('#profileCancel').attr('hidden',true);
        $('#password').attr('hidden',true);
        $('#profileEdit').attr('hidden',false);
      })
      if(window.location.href == window.location.origin+'/profile#update'){
        $('#profileEdit').trigger('click');
      }
      $(".nav-item.dropdown").mouseenter(function(){
        $(".dropdown-menu").show(); 
      });
    
      $(".dropdown-menu, .nav-item.dropdown").mouseleave(function(){
        $(".dropdown-menu").hide(); 
      });
      $('#navbarDropdown').on('click',()=>{$('.dropdown-menu').show()}),
      $(window).on('click',()=>{$('.dropdown-menu').hide()}),
      $('form').on('submit', () => {
        $('button[type="submit"]').attr('disabled',true)
        $('.pre-loader').show();
      }),
      $('[data-toggle="tooltip"]').tooltip()
})
window.onload = function() {
  $('.pre-loader').hide();
}