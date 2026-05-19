document.addEventListener("DOMContentLoaded", function () {
    const flash = document.getElementById("flash-message");

    if (flash) {
        const type = flash.dataset.type; // ambil data-type
        const message = flash.dataset.message; // ambil data-message

        Swal.fire({
            icon: type,
            title: type === "success" ? "Berhasil!" : "Gagal!",
            text: message,
            timer: 2500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    }
});
