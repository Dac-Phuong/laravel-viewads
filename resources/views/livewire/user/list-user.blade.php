<div class="container-xxl flex-grow-1 container-p-y p-0">

    <!-- Responsive Datatable -->
    <div class="card">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-header">Danh sách người dùng</h5>
            <button type="submit" class="btn btn-primary waves-effect waves-light"
                style="height: 40px;margin-right: 25px;" >
                <i class="ti ti-plus mr-4"></i> Tạo mới</button>
        </div>
        <div class="table-responsive text-nowrap p-3 mb-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Họ và tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Quyền</th>
                        <th>Ngày tạo</th>
                        <th style="width:80px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($list_user))
                        @foreach ($list_user as $key => $user)
                            <tr class="odd">
                                <td>{{ ++$key }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td></td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="ti ti-dots-vertical"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ti ti-pencil me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ti ti-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
            </table>
        </div>
    </div>
</div>
