@extends('template')

@section('konten')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    td:first-child {
        width: 100px; /* Kolom label (Freelancer, Client) */
        font-weight: bold;
        vertical-align: top;
    }

    td:nth-child(2) {
        width: 10px; /* Kolom titik dua */
        text-align: center;
    }

    td:nth-child(3) {
        width: auto; /* Kolom isi data */
    }
</style>
<div class="card-box">
    <h4 class="card-title">Transfer</h4>
    <!-- Pastikan form memiliki enctype untuk upload file -->
    <form method="post" action="{{url('admin/pay/doneaction')}}" enctype="multipart/form-data">
        @csrf
        @if($pay->status == 2)
        <p>Uang bisa ditransfer jika barang/hasil telah diterima client</p>
        <div class="text-right">
            <a href="{{url('admin/pay')}}"><button type="button" class="btn btn-danger">Back</button></a>
        </div>
        @else
        <input type="hidden" value="{{$pay->id_pay}}" name="id_pay">
        <input type="hidden" value="{{$pay->id_client}}" name="id_client">
        <input type="hidden" value="{{$pay->id_free}}" name="id_free">
        <input type="hidden" value="{{$pay->judul}}" name="judul">

        <input type="hidden" value="{{$kontrak->id_kontrak}}" name="id_kontrak">


        <div class="form-group">
           <table>
                <tr>
                    <td>Freelancer</td>
                    <td>:</td>
                    <td>{{$pay->freelancer_name}} <a href="{{ url('https://wa.me/'.$pay->wa_free) }}"
                                target="_blank"
                                class="btn btn-success btn-sm ms-4"
                                style="margin-left: 20px; white-space: nowrap;">
                                <i class="fa fa-whatsapp me-1"></i> 
                                </a></td>
                </tr>
                <tr>
                    <td>Client</td>
                    <td>:</td>
                    <td>{{$pay->client_name}} <a href="{{ url('https://wa.me/'.$pay->wa_client) }}"
                                target="_blank"
                                class="btn btn-success btn-sm ms-4"
                                style="margin-left: 20px; white-space: nowrap;">
                                <i class="fa fa-whatsapp me-1"></i> 
                                </a></td>
                </tr>
            </table>
        </div>

        
        <div class="form-group">
            <label>Nama Rekening Freelancer</label>
            <input type="text" name="nm_rek" value="{{$pay->nm_rek_free}}" readonly class="form-control">
        </div>

        <div class="form-group">
            <label>Nomor Rekening Freelancer</label>
            <input type="text" name="no_rek" value="{{$pay->no_rek_free}}" readonly class="form-control">
        </div>

        <div class="form-group">
            <label>Foto Bukti Tranfer Client</label>
            <br>
            <img  class="popup-image" src="{{ url('imageup/'.$pay->poto_client) }}" width="100px">
        </div>
        <br>

        <div class="form-group">
            <label for="poto">Foto Bukti Transfer Admin</label><br>
     
                <img id="preview" class="popup-image" src="" width="100px" style="display: none;">
            <br>


            @if($pay->status != 4)
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="poto" id="exampleInputFile" {{ $pay->poto ? '' : 'required' }} onchange="previewImage(event)">
                <label class="custom-file-label" id="fileLabel" for="exampleInputFile">Pilih Foto</label>
            </div><br><br>
            
            @endif
            
            <p><b>Potongan Komisi : 8%</b></p>

        </div>


        @endif

        @if($pay->status == 1)
        <div class="text-right">
            <button type="submit" class="btn btn-danger">Transfer</button>
        </div>
        
        @endif
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
                width: "auto", // Biarkan ukuran sesuai gambar
                padding: "1rem"
            });
        });
    });
});

</script>

@endsection
