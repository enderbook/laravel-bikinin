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
    <h4 class="card-title">Tambah Bidang Baru</h4>
    <!-- Pastikan form memiliki enctype untuk upload file -->
    <form method="post" action="{{url('admin/bidang/submit')}}" enctype="multipart/form-data">
        @csrf
        


        
        
        <div class="form-group">
            <label>Nama Bidang</label>
            <input type="text" name="bidang" required class="form-control">
        </div>



        <div class="text-right">
            <button type="submit" class="btn btn-primary">submit</button>
        </div>
        
    </form>
</div>



@endsection
