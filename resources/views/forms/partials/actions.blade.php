<a href="{{ route('public.form.show', $forms->slug) }}" class="btn btn-sm btn-info">View</a>
<a href="{{ route('forms.edit', $forms->id) }}" class="btn btn-sm btn-primary">Edit</a>
<a data-href="{{ route('forms.destroy', $forms->id) }}" class="btn btn-sm btn-danger delete-btn">Delete</a>
