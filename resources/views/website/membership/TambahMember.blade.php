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
                <form method="post" action="{{ url('aksi_add_member') }}" id="addStudentForm">
                @csrf
                    <div class="form-group">
                        <label for="studentName">Nomor Member</label>
                        <input type="text" name="Nomor" class="form-control" placeholder="Enter Nomor Meja" required>
                    </div>
                    <div class="form-group">
                        <label for="studentName">Nama Member</label>
                        <input type="text" name="nama" class="form-control" placeholder="Enter Nama Pelanggan" required>
                    </div>
                    <div class="form-group">
                    <label for="studentName">Time</label>
            <select name="time" class="form-control" id="kategory">
              <option value="">Pilih</option>
              <option value="1">1 Month</option>
              <option value="2">5 Month</option>
              <option value="3">1 Year</option>
            </select>
          </div>

  
                    <button type="submit" class="btn btn-primary">Add Member</button>
                </form>




    <script>
      
    </script>
</body>
</html>
