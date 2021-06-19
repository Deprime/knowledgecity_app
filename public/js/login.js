document.addEventListener("DOMContentLoaded", function(e) {
  let auth = new Auth();

  /**
   * Method description
   * @returns
   */
  $('#login').on('click', function(e) {

    $('.form-error-message').html('');
    $('.form-error-message').hide();

    $('#username').prop('disabled', true);
    $('#password').prop('disabled', true);

    e.preventDefault();
    const data = {
      login: $('#username').val(),
      password: $('#password').val(),
      remember_me: $('#remember_me').is(':checked') ? true : false,
    }

    axios({
      method: 'post',
      url: '/auth',
      data: data
    })
    .then(response => {
      const data = response.data;
      auth.set(data);
      auth.redirect('list');
    })
    .catch(err => {
      if (err?.response?.data) {
        // console.log(err.response.data);
        const msg = err.response.data;
        let error_string = '';
        if (msg?.errors && Array.isArray([msg.errors])) {
          msg.errors.forEach((error) => {
            error_string += `<p>${error}</p>`;
          });
          $('.form-error-message').html(error_string);
        }
        else {
          error_string = msg;
        }
        $('.form-error-message').html(error_string);
        $('.form-error-message').show();
      }
    })
    .finally(() => {
      $('#username').prop('disabled', false);
      $('#password').prop('disabled', false);
    });
  })
});
