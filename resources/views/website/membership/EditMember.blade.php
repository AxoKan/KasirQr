<!DOCTYPE html>
<html lang="en">
<head>
<style>
    .container {
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }
    h4 {
        text-align: center;
        margin-bottom: 30px;
        color: #333;
    }
    button {
        width: 100%;
        margin-top: 10px;
    }
    #qrCodeContainer {
        text-align: center;
        margin-top: 20px;
    }
    #qrCodeImage {
        max-width: 100%;
        height: auto;
    }
</style>
</head>
<body>
<main id="main" class="main">
                        
            <div class="container mt-5">
                <h4>Add Membership Data Page</h4>
                <form method="post" action="{{ url('aksi_EditMember') }}" id="addStudentForm">
                @csrf
                    <div class="form-group">
                        <label for="studentName">Nomor Member</label>
                        <input type="text" name="Nomor" class="form-control" value="{{ $member->NoMember }}" required>
                    </div>
                    <div class="form-group">
                        <label for="studentName">Nama Member</label>
                        <input type="text" name="nama" class="form-control" value="{{ $member->nama }}" required>
                    </div>
                    <input type="hidden" name="id" value="{{ $member->id_member }}">
                    <button type="submit" class="btn btn-primary">Add Member</button>
                </form>




    <script>
      
    </script>
</body>
</html>
