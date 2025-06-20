<div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="inputForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Form Field</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label for="inputType">Input Type</label>
            <select class="form-control" id="inputType" required>
              <option value="text">Text</option>
              <option value="email">Email</option>
              <option value="password">Password</option>
              <option value="number">Number</option>
              <option value="textarea">Textarea</option>
              <option value="select">Select</option>
              <option value="radio">Radio</option>
              <option value="checkbox">Checkbox</option>
            </select>
          </div>

          <div class="form-group">
            <label>Label</label>
            <input type="text" class="form-control" id="inputLabel" required>
          </div>

          <div class="form-group">
            <label>Field Name</label>
            <input type="text" class="form-control" id="inputName" required>
          </div>

          <div class="form-group">
            <label>Placeholder</label>
            <input type="text" class="form-control" id="inputPlaceholder">
          </div>

          <div class="form-group" id="inputOptionsGroup" style="display:none;">
            <label>Options (comma separated)</label>
            <input type="text" class="form-control" id="inputOptions">
          </div>

          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="inputRequired">
            <label class="form-check-label" for="inputRequired">Required</label>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add to Form</button>
        </div>
      </div>
    </form>
  </div>
</div>
