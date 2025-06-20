
$(document).ready(function () {
  $('.input-btn').click(function () {
    $('#saveForm').prop('disabled', false);
    const type = $(this).data('type');
    const id = 'field_' + Math.floor(Math.random() * 1000);
    const html = generateFieldHTML(type, id);
    $('#form-builder').append(html);
  });

  $('#form-builder').sortable({
    placeholder: "ui-state-highlight",
    handle: ".drag-handle"
  }).disableSelection();

  $(document).on('click', '.delete-field', function () {
    $(this).closest('li').remove();
  });
});
function generateFieldHTML(type, id) {
  let html = `
     <li class="list-group-item mb-2 d-flex flex-column" data-type="${type}">
      <div class="d-flex justify-content-between align-items-center">
        <div class="drag-handle" style="cursor:move;">
          <i class="fas fa-grip-vertical mr-2"></i> <strong>${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
        </div>
        <button class="btn btn-sm btn-secondary toggle-edit" type="button"  data-target="#collapse_${id}">
          Settings
        </button>
        <button class="btn btn-sm btn-danger delete-field">Delete</button>
      </div>
      <div class="collapse mt-2" id="collapse_${id}">
        <div class="form-group mt-2">
          <label>Label</label>
          <input type="text" class="form-control field-label" placeholder="Enter label">
        </div>
        <div class="form-group">
          <label>Field Name</label>
          <input type="text" class="form-control field-name" placeholder="Field name">
        </div>
        <div class="form-group">
          <label>Placeholder</label>
          <input type="text" class="form-control field-placeholder" placeholder="Placeholder">
        </div>
        <div class="form-check mb-2">
          <input type="checkbox" class="form-check-input field-required" id="required_${id}">
          <label class="form-check-label" for="required_${id}">Required</label>
        </div>`;

  if (['select', 'radio', 'checkbox'].includes(type)) {
    html += `
      <div class="form-group">
        <label>Options (comma-separated)</label>
        <input type="text" class="form-control field-options" placeholder="Option1, Option2">
      </div>`;
  }
  html += `</div></li>`;
  return html;
}

$(document).on('click', '.toggle-edit', function () {
  const targetId = $(this).data('target');
  $(targetId).collapse('toggle');
});


$(document).on('click', '#saveForm', function (e) {
  e.preventDefault();
  const fields = [];
  $('#form-builder li').each(function () {
    order = $(this).index() + 1
    const field = {
      type: $(this).data('type'),
      label: $(this).find('.field-label').val(),
      name: $(this).find('.field-name').val(),
      placeholder: $(this).find('.field-placeholder').val(),
      required: $(this).find('.field-required').is(':checked'),
      options: $(this).find('.field-options').val(),
      order: order,
    };
    fields.push(field);
  });

  $.ajax({
    url: $('#form-create').attr('action'),
    method: 'POST',
    data: {
      _token: $('meta[name="csrf-token"]').attr('content'),
      form_name: $('#form-create input[name="title"]').val(),
      description: $('#form-create textarea[name="description"]').val(),
      input_fields: JSON.stringify(fields),
    },
    success: function (response) {
      if (!response.success && response.errors) {
        let msg = '';
        for (const key in response.errors) {
          msg += response.errors[key].join(', ') + '\n';
        }
        alert(msg);
      } else if (response.success) {
        window.location.href = response.route;
      } else {
        alert(response.message);
      }
    },
    error: function (xhr) {
      if (xhr.status === 422) {
        let response = xhr.responseJSON;
        let msg = '';
        for (const key in response.errors) {
          msg += response.errors[key].join(', ') + '\n';
        }
        alert(msg);
      } else {
        alert('Error saving form: ' + xhr.responseText);
      }
    }
  });

})
