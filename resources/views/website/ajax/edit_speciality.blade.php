<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Specialty</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ url('specialities/update') }}" method="POST" enctype="multipart/form-data" id="editSpecialtyForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_id" value="{{ $speciality->id ?? '' }}">

                <div class="row form-row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="edit_name">Specialty</label>
                            <input type="text" name="name" id="edit_name" class="form-control" value="{{ $speciality->name ?? '' }}">
                            <span class="text-danger" id="edit_nameError"></span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="edit_image">Image</label>
                            <input type="file" name="image" id="edit_image" class="form-control">
                            <!-- Display image preview if there is an existing image -->
                            <img id="edit_image_preview"
                                 src="{{ $speciality->image ? asset('backend/'.$speciality->image) : '' }}"
                                 style="width: 100px; height: 100px; margin-top: 10px; display: {{ $speciality->image ? 'block' : 'none' }};">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="edit_status">Status</label>
                            <select class="form-control" name="status" id="edit_status">
                                <option value="1" {{ $speciality->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $speciality->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
            </form>
        </div>
    </div>
</div>
