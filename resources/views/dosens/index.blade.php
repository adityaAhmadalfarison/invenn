<x-layout>
    <x-slot name="title">Halaman Daftar Dosen</x-slot>
    <x-slot name="page_heading">Daftar Dosen Pengguna</x-slot>

    <div class="row justify-content-center">
        @foreach ($roles as $role)
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total {{ $role->name }}</h4>
                    </div>
                    <div class="card-body">
                        {{ $role->users_count }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="card">
        <div class="card-body">
            @include('utilities.alert')
            <div class="d-flex justify-content-end mb-3">
                @can('tambah dosen')
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="dosen_create_modal">
                    <i class="fas fa-fw fa-plus"></i> Tambah Data
                </button>
                @endcan
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <x-datatable>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Alamat Email</th>
                                <th scope="col">Peran</th>
                                <th scope="col">Tanggal Ditambahkan</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getRoleNames()->first() }}</td>
                                <td>{{ date('m/d/Y H:i A', strtotime($user->created_at)) }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @can('detail dosen')
                                        <a data-id="{{ $user->id }}" class="btn btn-sm btn-info text-white show-modal mr-2"
                                            data-toggle="modal" data-target="#show_dosen">
                                            <i class="fas fa-fw fa-search"></i>
                                        </a>
                                        @endcan
                                        @can('ubah dosen')
                                        <a data-id="{{ $user->id }}" class="btn btn-sm btn-success text-white edit-modal mr-2"
                                            data-toggle="modal" data-target="#dosen_edit_modal" title="Ubah data">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </a>
                                        @endcan
                                        @can('hapus dosen')
                                        <form action="{{ route('dosens.destroy', $user->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white">
                                                <i class="fas fa-fw fa-trash-alt"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </x-datatable>
                </div>
            </div>
        </div>
    </div>

    @push('modal')
    @include('dosens.modal.create')
    @include('dosens.modal.show')
    @include('dosens.modal.edit')
    @endpush

    @push('js')
    @include('dosens.\_script')
    @endpush
</x-layout>
