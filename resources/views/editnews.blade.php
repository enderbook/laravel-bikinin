@extends('template')

@section('konten')

<div class="card-box">
    <h4 class="card-title">Edit News</h4>

    <form method="post" action="{{ url('admin/news/update/') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id_news" value="{{ $news->id_news }}">

        <div class="form-group">
            <label>Judul News</label>
            <input type="text" name="judul_news" required class="form-control" 
                value="{{ $news->judul_news }}">
        </div>

        <div class="form-group">
            <label for="poto">Poster (2:1 atau 1536 x 768 piksel)</label><br>
            
            @if($news->img_news)
                <img id="preview" class="popup-image" src="{{ url('imageup/'.$news->img_news) }}" width="100px" style="cursor: pointer;">
            @else
                <img id="preview" class="popup-image" src="" width="100px" style="display: none; cursor: pointer;">
            @endif
            <br>

            <div class="custom-file mt-2">
                <input type="file" class="custom-file-input" name="img_news" id="exampleInputFile" onchange="previewImage(event)">
                <label class="custom-file-label" id="fileLabel" for="exampleInputFile">Pilih Poster Baru (kalau mau ganti)</label>
            </div>
        </div>

        <div class="form-group">
            <label>Link News</label>
            <input type="text" name="link" required class="form-control"
                value="{{ $news->link }}">
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-warning">Update</button>
        </div>
        
    </form>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);

        var fileName = event.target.files[0].name;
        document.getElementById('fileLabel').innerHTML = fileName;
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const preview = document.getElementById('preview');

        if (preview) {
            preview.addEventListener('click', function () {
                if (this.src) {
                    Swal.fire({
                        html: `<img src="${this.src}" style="max-width: 90%; max-height: 80vh; border-radius: 10px;">`,
                        showCloseButton: true,
                        showConfirmButton: false,
                        width: "auto",
                        padding: "1rem"
                    });
                }
            });
        }
    });
</script>

@endsection
