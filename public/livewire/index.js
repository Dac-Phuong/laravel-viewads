// update
const modal = document.querySelector("#kt_modal_update_viewer");
modal.addEventListener("show.bs.modal", (e) => {
    Livewire.dispatch("update_viewer", {
        id: e.relatedTarget.getAttribute("data-viewer-id"),
    });
});

// delete
document
    .querySelectorAll('[data-kt-action="delete_row"]')
    .forEach(function (element) {
        element.addEventListener("click", function (e) {
            swal.fire({
                text: "Bạn có chắc chắn muốn xóa không?",
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Có",
                cancelButtonText: "Không",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch("delete_viewer", {
                        id: this.getAttribute("data-viewer-id"),
                    });
                }
            });
        });
    });
document.addEventListener("livewire:init", function () {
    Livewire.on("success", function (success) {
        $("#kt_modal_add_viewer").modal("hide");
        $("#kt_modal_update_viewer").modal("hide");
        swal.fire({
            title: success,
            icon: "success",
            confirmButtonText: "Xác nhận!",
        });
    });
});

document.addEventListener("livewire:init", function () {
    Livewire.on("error", function (error) {
        swal.fire({
            title: error,
            icon: "error",
            confirmButtonText: "Xác nhận!",
        });
    });
});
