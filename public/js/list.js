/**
 * Render student list table
 */
function renderTable(student_list) {
  var source   = $("#row-template").html();
  var template = Handlebars.compile(source);
  var context  = { student: student_list };
  var html     = template(context);
  $("#table-body").html(html);
}

/**
 * Render pagination
 */
function renderPagination(page_list) {
  var source   = $("#pagination-template").html();
  var template = Handlebars.compile(source);
  var context  = {page: page_list};
  var html     = template(context);
  $("#pagination").html(html);
}


/**
 * Logout
 */
function logout() {
  axios({method: 'delete', url: `/auth`})
  .then(response => {
    auth.logout();
  })
  .catch(err => {
    console.log(err);
  });
}


/**
 * Fetch data
 */
function fetch(page = 1) {
  axios({method: 'get', url: `/users?page=${page}`})
  .then(response => {
    const data = response.data;
    student_list = data.student_list;
    renderTable(student_list);

    page_list = data.page_list;
    renderPagination(page_list);
  })
  .catch(err => {
    console.log(err);
    const status = err?.response?.status;
    if (!!status && status === 401) {
      logout();
    }
  });
}


/**
 * Method description
 * @returns
 */
$('#logout').on('click', function(e) {
  logout();
});

$(document).on('click', '.page', function(e) {
  const page = $(this).prop('id');
  fetch(page)
});


/**
 * Page created
 */
document.addEventListener("DOMContentLoaded", function(e) {
  // let auth = new Auth();
  fetch();
});
