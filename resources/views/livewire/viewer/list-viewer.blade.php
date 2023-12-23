<div class="container-xxl flex-grow-1 container-p-y p-0">

    <!-- Responsive Datatable -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Danh sách người xem</h5>
            <button type="button" class="btn btn-primary waves-effect waves-light"
                style="height: 40px;margin-right: 25px;" data-bs-toggle="modal" data-bs-target="#kt_modal_add_viewer">
                <i class="ti ti-plus mr-4"></i> Tạo mới</button>
        </div>
        <div class="col-md-2 ml-auto mr-3" style="margin-left:auto;margin-right:25px">
            <div class="input-group input-group-merge">
                <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search..."
                    aria-label="Search..." aria-describedby="basic-addon-search31" fdprocessedid="pjzbzc">
            </div>
        </div>
        <div class="table-responsive text-nowrap p-3 mb-3">
            <table class="table ">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên tài khoản</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Cấp độ</th>
                        <th>Số dư</th>
                        <th>Ngày tạo</th>
                        <th style="width:80px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
              
                    @if (isset($viewers))
                        @foreach ($viewers as $key => $viewer)
                            <tr class="odd">
                                <td>{{ ++$key }}</td>
                                <td>{{ $viewer->username }}</td>
                                <td>{{ $viewer->email }}</td>
                                <td>{{ $viewer->phone }}</td>
                                <td>{{ $viewer->level }}</td>
                                <td>{{ $viewer->created_at }}</td>
                                <td>{{ $viewer->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                        <div class="dropdown-menu">
                                            <button data-kt-action="update_viewer" data-viewer-id={{ $viewer->id }}
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_update_viewer"
                                                class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ti ti-pencil me-1"></i>
                                                Sửa</button>
                                            <button class="dropdown-item" id="kt_modal_delete_viewer"
                                                data-viewer-id={{ $viewer->id }} data-kt-action="delete_row"
                                                href="javascript:void(0);"><i class="ti ti-trash me-1"></i> Xóa</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12"  style="text-align:center; color:red">
                                Không có dữ liệu.
                            </td>
                        </tr>
                    @endif
            </table>
            {{-- {{$viewers->links()}} --}}
        </div>

    </div>
</div>
