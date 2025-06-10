document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("fileToUpload");
  const previewWrapper = document.getElementById("previewWrapper");
  const previewImg = document.getElementById("previewImg");
  const previewText = document.getElementById("previewText");

  input.addEventListener("change", function () {
    const file = this.files[0];

    if (file) {
      const fileType = file.type;
      const validImageTypes = [
        "image/jpeg",
        "image/png",
        "image/gif",
        "image/webp"
      ];

      // Reset preview
      previewImg.style.display = "none";
      previewText.style.display = "none";

      if (validImageTypes.includes(fileType)) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
          previewImg.style.display = "block";
        };
        reader.readAsDataURL(file);
      } else if (fileType === "application/pdf") {
        previewText.textContent = "File PDF terdeteksi: " + file.name;
        previewText.style.display = "block";
      } else {
        alert("File yang dipilih tidak didukung! Harus gambar atau PDF.");
        input.value = ""; // reset input
      }
    } else {
      previewImg.style.display = "none";
      previewText.style.display = "none";
    }
  });
});
