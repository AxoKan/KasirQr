<div class="container-xxl flex-grow-1 container-p-y">

<div class="card mb-4">

  <!-- Account -->
  <div class="card-body">
    <div class="d-flex align-items-start align-items-sm-center gap-4">
  <div style="text-align: center;">

</div>

      <div class="button-wrapper">
     

       
      </div>
    </div>
  </div>
  <hr class="my-0" />
  <div class="card-body">
  <form action="{{ url('aksi_update_user') }}" method="post" enctype="multipart/form-data">
  @csrf
    <div class="container">
<form>
<div class="row mb-3">
<label for="nama" class="col-sm-2 col-form-label">Name</label>
<div class="col-sm-10">
<input type="text" class="form-control" name="nama" id="nama" value="{{ $user->real }}">
</div>
</div>

<div class="row mb-3">
<label for="nama" class="col-sm-2 col-form-label">Username</label>
<div class="col-sm-10">
<input type="text" class="form-control" name="Nik" id="nama" value="{{ $user->user }}">
</div>
</div>
<div class="row mb-3">
<label for="nama" class="col-sm-2 col-form-label"> Password</label>
<div class="col-sm-10">
<input type="password" class="form-control" name="password" id="nama" value="{{ $user->password }}">
</div>
</div>
<div class="row mb-3">
<label for="nama" class="col-sm-2 col-form-label">angkatan </label>
<div class="col-sm-10">
<select name="angkatan" class="form-control">
                        <option value="{{ $user->Level }}">{{ $user->Level }}</option>
                        <option value="admin">admin</option>
                        <option value="petugas">petugas</option>
                    </select>
</div>
</div>

<input type="hidden" name="id" value="<?= $user->id_user ?>">
      <div class="mt-2">
        <button type="submit" class="btn btn-primary me-2">Save changes</button>
      </div>
    </form>
  </div>
  <!-- /Account -->
</div>
