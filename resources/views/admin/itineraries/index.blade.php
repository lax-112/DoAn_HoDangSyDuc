@extends('layouts.admin')
@section('admin')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">Hành trình</h4>
                <div class="d-flex align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Bảng điều khiển</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tours.index') }}">Tour</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Hành trình</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <form href="{{ route('itineraries.store', $tourId) }}" id="formAddItinerary" method="post">
                        @csrf
                        <div class="form-group">
                            Tiêu đề<span class="text-danger">*</span>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Tiêu đề">
                            <p class="text-danger" id="errorName"></p>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info mb-3">
                                Thêm Hành trình
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Danh sách Hành trình</h4>
                    <table class="table table-striped table-bordered" id="destinationTable">
                        <thead>
                        <tr>
                            <th>Ngày</th>
                            <th>Tên</th>
                            <th>Địa điểm</th>
                            <th>Hành động</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form id="formEditItinerary">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Chỉnh sửa hành trình</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="name" class="col-12">
                                    Tên Hành trình<span class="text-danger">*</span>
                                </label>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="name" id="nameEdit"
                                           placeholder="Tên hành trình">
                                    <p class="text-danger" id="errorNameEdit"></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-info" id="btnSubmitEdit">Lưu thay đổi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            let linkEditItinerary;
            disableSubmitButton('#formAddItinerary');
            disableSubmitButton('#formEditItinerary');

            let datatable = $('#destinationTable').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                searching: false,
                stateSave: true,
                ordering: false,
                ajax: {
                    url: "{!! route('itineraries.data', $tourId) !!}",
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'name', name: 'name'},
                    {data: 'place', name: 'place'},
                    {data: 'action', name: 'action', className: 'align-middle text-center', width: 65},
                ],
            });

            // Xóa Hành trình
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                let link = $(this).attr("href");
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-2',
                        cancelButton: 'btn btn-danger m-2'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: 'Bạn có chắc không?',
                    text: "Bạn sẽ không thể hoàn tác điều này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Vâng, xóa nó!',
                    cancelButtonText: 'Không, hủy!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: link,
                            type: 'delete',
                            success: function (response) {
                                toastr.success('Xóa hành trình thành công');
                                datatable.ajax.reload(null, false);
                            },
                            error: function (response) {
                                toastr.error('Xóa thất bại')
                            }
                        });
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Đã hủy',
                            '',
                            'error'
                        )
                    }
                })
            })

            // Chỉnh sửa
            $(document).on('click', '.edit', function (e) {
                linkEditItinerary = $(this).attr('href');
                let id = $(this).data('id');
                let nameItineray = $('#itinerary-' + id).children().eq(1).text();

                $('#nameEdit').val(nameItineray);
            });

            // Thêm Hành trình mới
            $('#formAddItinerary').submit(function (e) {
                e.preventDefault();

                $('#errorName').text('');

                let link = $(this).attr('action');
                let name = $('#name').val();

                let formData = new FormData();
                formData.append("name", name);

                $.ajax({
                    url: link,
                    method: "POST",
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function (response) {
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.draw();
                            $('#formAddItinerary')[0].reset();
                        }
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Thêm hành trình thất bại');
                        if (response?.errors?.name !== undefined) {
                            $('#errorName').text(response.errors.name[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formAddItinerary', 300);
                    }
                });
            });

            // Chỉnh sửa Hành trình
            $('#formEditItinerary').submit(function (e) {
                e.preventDefault();

                $('#errorNameEdit').text('');
                let name = $('#nameEdit').val();
                $.ajax({
                    url: linkEditItinerary,
                    method: "PUT",
                    dataType: 'json',
                    data: {name: name},
                    success: function (response) {
                        let type = response['alert-type'];
                        let message = response['message'];
                        toastrMessage(type, message);

                        if (type === 'success') {
                            datatable.ajax.reload(null, false);
                            $('#editModal').modal('hide');
                        }
                    },
                    error: function (jqXHR) {
                        let response = jqXHR.responseJSON;
                        toastrMessage('error', 'Chỉnh sửa hành trình thất bại');
                        if (response?.errors?.name !== undefined) {
                            $('#errorNameEdit').text(response.errors.name[0]);
                        }
                    },
                    complete: function () {
                        enableSubmitButton('#formEditItinerary', 300);
                    }
                });
            });
        });
    </script>
@endsection
