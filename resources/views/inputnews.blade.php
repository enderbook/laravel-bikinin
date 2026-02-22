@extends('template')

@section('konten')


<div class="card-box">
    <h4 class="card-title">Input News</h4>
    <form method="post" action="{{url('admin/news/masuk')}}" enctype="multipart/form-data">
        @csrf
    
        <div class="form-group">
            <label>judul news</label>
            <input type="text" name="judul_news"  required class="form-control">
        </div>

        <div class="form-group">
            <label for="poto">Poster (2:1 atau 1536 x 768 piksel)</label><br>
            
                <img id="preview" class="popup-image" src="" width="100px" style="display: none;">
            <br>

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="img_news" id="exampleInputFile"  onchange="previewImage(event)">
                <label class="custom-file-label" id="fileLabel" for="exampleInputFile">Pilih Poster</label>
            </div>
        </div>

        <div class="form-group">
            <label>Link News</label>
            <input type="text" name="link" required class="form-control">
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-danger">Submit</button>
        </div>
        
    </form>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block'; // Pastikan gambar terlihat setelah dipilih
        }
        reader.readAsDataURL(event.target.files[0]);

        // Tampilkan nama file di dalam kolom input
        var fileName = event.target.files[0].name;
        document.getElementById('fileLabel').innerHTML = fileName;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".popup-image").forEach(img => {
        img.addEventListener("click", function () {
            Swal.fire({
                html: `<img src="${this.src}" style="max-width: 90%; max-height: 80vh; border-radius: 10px;">`,
                showCloseButton: true,
                showConfirmButton: false,
                width: "auto", 
                padding: "1rem"
            });
        });
    });
});

</script>
@endsection
