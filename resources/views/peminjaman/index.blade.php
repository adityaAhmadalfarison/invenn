<x-layout>
    <x-slot name="title">Peminjaman List</x-slot>
    <x-slot name="page_heading">Daftar Peminjaman</x-slot>

    {{-- <div class="row justify-content-center">
        @foreach ($peminjamans as $peminjaman)
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>{{ $peminjaman->name }}</h4>
                    </div>
                    <div class="card-body">
                        {{ $peminjaman->id_location }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div> --}}

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah_data_modal">
                    <i class="fas fa-fw fa-plus"></i> Tambah Data
                </button>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <x-datatable>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Barang</th>
                                <th scope="col">Asal Ruangan</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Nama Peminjam</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($peminjamans as $peminjaman)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $peminjaman->commodities->name }}</td>
                                <td>{{ $peminjaman->commodity_locations->name }}</td>
                                @if($peminjaman->condition === 1)
								<td>
									<span class="badge badge-pill badge-success" title="Baik">
										<i class="fas fa-fw fa-check-circle"></i>
										Baik
									</span>
								</td>
								@elseif($peminjaman->condition === 2)
								<td>
									<span class="badge badge-pill badge-warning" title="Kurang Baik">
										<i class="fa fa-fw fa-exclamation-circle"></i>
										Kurang Baik
									</span>
								</td>
								@else
								<td>
									<span class="badge badge-pill badge-danger" title="Rusak Berat">
										<i class="fa fa-fw fa-times-circle"></i>
										Rusak Berat</span>
								</td>
								@endif
                                {{-- <td>{{ $peminjaman->user->name }}</td> --}}
                                <td>{{ $peminjaman->user->name }}</td>
                                <td>{{ $peminjaman->created_at }}</td>
                                <td>{{ $peminjaman->updated_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ url('/peminjaman', $peminjaman->id) }}" class="btn btn-sm btn-info text-white mr-2">
                                            <i class="fas fa-fw fa-search"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-success text-white mr-2">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </a>
                                        <form action="{{ url('/peminjaman', $peminjaman->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </x-datatable>
                    {{-- <div class="modal fade" id="tambah_data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Peminjaman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body"> --}}
                                    <!-- Form tambah data di sini -->
                                  
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    {{-- Add modal components here if necessary --}}
    @push('modal')
    {{-- Include modals --}}
    @include('peminjaman.modal.create')
    @endpush

    @push('js')
    {{-- Include additional JavaScript if necessary --}}
    @endpush
</x-layout>
