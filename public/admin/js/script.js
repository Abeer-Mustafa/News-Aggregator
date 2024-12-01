$(document).ready(function () {
   $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
   
   // select2
   $('.select2').select2({
      selectOnClose: true,
   });

   // today date
   var today = new Date();
   var formattedDate = today.toISOString().split('T')[0];
   $('input[type=date]').val(formattedDate);

   // submit form
   $(document).on('submit', '.news-api-form', function (e) {
      e.preventDefault()
      let form = $(this);
      let url_form = form.attr('action');
      let btn = form.find('.news-api-submit');
      let spinner = form.find('.spinner');
      $.ajax({
         url: url_form,
         method: 'POST',
         data: form.serialize(),
         beforeSend: function () {
            btn.hide();
            spinner.show()
         },
         complete: function () {
            spinner.hide()
            btn.show()
         },
         success: function(data) {
            if (data.errors) {
               let errorMsg = errorRes(data.errors);
               toast_error(errorMsg);
            }
            if (data.success) {
               toast_success(data.success);
            }
         },
         error: function(jqXHR, textStatus, errorThrown){
            btn.html('Fetch News')
            jqXHR_error(jqXHR, textStatus, errorThrown)
         }
      });
   })
});

// show error toast
function toast_error(errorMsg){
   $('#toastDanger').find('.toast_message').html(errorMsg);
   var toastElement = document.getElementById('toastDanger');
   var toast = new bootstrap.Toast(toastElement, {
      animation: true,
      autohide: true,
   });
   toast.show();

}

// show success toast
function toast_success(successMsg){
   $('#toastSuccess').find('.toast_message').html(successMsg);
   var toastElement = document.getElementById('toastSuccess');
   var toast = new bootstrap.Toast(toastElement, {
      animation: true,
      autohide: true,
   });
   toast.show();
}

// show warning toast
function toast_warning(WarningMsg){
   $('#toastWarning').find('.toast_message').html(WarningMsg);
   var toastElement = document.getElementById('toastWarning');
   var toast = new bootstrap.Toast(toastElement, {
      animation: true,
      autohide: true,
   });
   toast.show();
}

function jqXHR_error(jqXHR, textStatus, errorThrown) {
   console.log(jqXHR)
   console.log(textStatus);
   console.log(errorThrown);

   let errorMsg = '';

   if(jqXHR.status == 422){
      errorMsg = jqXHR.responseJSON.errors[0];
      toast_error(errorMsg);
   }
   else{
      if(jqXHR.responseJSON.errors && jqXHR.responseJSON.errors.length > 0){
         errorMsg = jqXHR.responseJSON.errors
      }
      else if(jqXHR.responseJSON.message){
         errorMsg = jqXHR.status + " " + jqXHR.responseJSON.message;
      }
      else{
         errorMsg = jqXHR.status + " " + jqXHR.statusText;
      }

      if(jqXHR.status == 404){
         toast_warning(errorMsg);
      }
      else{
         toast_error(errorMsg);
      }
   }
}

function ajax_toast(url, data = {}) {
   $.ajax({
      url: url,
      method: 'POST',
      contentType: 'application/json',
      data: data,
      success: function(data) {
         if (data.errors) {
            let errorMsg = errorRes(data.errors);
            toast_error(errorMsg);
         }
         if (data.success) {
            toast_success(data.success);
         }
      },
      error: function(jqXHR, textStatus, errorThrown){
         jqXHR_error(jqXHR, textStatus, errorThrown)
      }
   });
}