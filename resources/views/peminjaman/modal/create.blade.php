
<div class="modal fade" id="tambah_data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form tambah data di sini -->
                <form method="POST" action="{{ route('peminjaman.store') }}">
                    @csrf
                    <div class="col-lg-10">
                        <div class="form-group">
                            <label for="nama barang">Kode Barang</label>
                            <select class="form-control @error('commodity', 'store') is-invalid @enderror"
                                name="commodity" id="commodity" style="width: 100%;">
                                <option value="" selected>Pilih..</option>
                                @foreach ($query as $query)
                                <option value="{{ $query->item_code }}"
                                    @selected(old('commodity')==$query->item_code)>{{ $query->item_code }}
                                </option>
                                @endforeach
                            </select>
                            @error('commodity', 'store')
                            <div class="d-block invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="form-group">
                            <label for="commodity_location_id">Lokasi Barang</label>
                            <select class="form-control @error('commodity_location_id', 'store') is-invalid @enderror"
                                name="commodity_location_id" id="commodity_location_id" style="width: 100%;">
                                <option value="" selected>Pilih..</option>
                                @foreach ($commodity_locations as $commodity_location)
                                <option value="{{ $commodity_location->id }}"
                                    @selected(old('commodity_location_id')==$commodity_location->id)>{{ $commodity_location->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('commodity_location_id', 'store')
                            <div class="d-block invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="condition">Kondisi</label>
                        
                    </div>
                    <div class="form-group">
                        <label for="id_user">Nama Peminjam</label>
                        <input type="text" class="form-control" id="id_user" name="" required value="{{ Auth::user()->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="id_barang">ID Barang</label>
                        <input type="text" class="form-control" id="id_barang" name="id_barang" required>
                    </div>
                    <!-- Tambahkan input untuk atribut lainnya jika diperlukan -->
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
        </div>
    </div>
</div>