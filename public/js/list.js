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
 * Toggle create form
 * @returns
 */
$('#toggle-form').on('click', function(e) {
  $('#create-form').toggle();
});


/**
 * Store new student
 */
$('#store').on('click', function(e) {
  const input_list =  $('#create-form .input-control');
  const select_list =  $('#create-form .select-control');
  let new_student  = {};

  input_list.forEach((input) => {
    const value = $(input).val().replace(/ /g, "");
    if (value.length > 1) {
      const name = $(input).attr("name");
      new_student[name] = value;
    }
  });

  select_list.forEach((select) => {
    const value = $(select).val().replace(/ /g, "");
    if (value > 0) {
      const name = $(select).attr("name");
      new_student[name] = value;
    }
  });

  store(new_student);
});


function toggleWarning(visible) {
  if (visible) {
    $("#warning").show();
  }
  else {
    $("#warning").hide();
  }
}


/**
 * Store request
 * @param {*} student
 */
function store(student) {
  axios({method: 'post', url: `/users`, data: {student: student}})
  .then(response => {
    const data = response.data;
    toggleWarning(false);
    clearCreateForm();
    fetch();
  })
  .catch(err => {
    toggleWarning(true);
    console.log(err);
  });
}

/**
 * Clear create form
 * @returns {void}
 */
function clearCreateForm() {
  $('#create-form .input-control').val('');
  $('#create-form .select-control').val(0);
}

/**
 * Get section list
 */
function getSectionList() {
  axios({method: 'get', url: `/sections`})
  .then(response => {
    const data = response.data;
    const section_list = data.section_list;
    section_list.forEach((section) => {
      $('#section-selection').append( `<option value="${section.id}">${section.title}</option>` );
    })
  })
  .catch(err => {
    console.log(err);
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
  getSectionList();
});
