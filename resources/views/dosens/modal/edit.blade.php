<!-- Edit Dosen Modal -->
<div class="modal fade" id="dosen_edit_modal" tabindex="-1" role="dialog" aria-labelledby="dosen_edit_modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dosen_edit_modalLabel">Edit Data Dosen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_dosen_name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="edit_dosen_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_dosen_email">Alamat Email</label>
                        <input type="email" class="form-control" id="edit_dosen_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_role_id">Peran</label>
                        <select id="edit_role_id" class="form-control" name="role_id">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
